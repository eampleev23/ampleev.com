<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabaseLocal extends Command
{
    protected $signature = 'db:backup-local
        {--keep=30 : Number of newest backups to keep}
        {--path= : Backup directory, defaults to storage/app/backups/database}';

    protected $description = 'Create a local compressed database backup and prune older local backups.';

    public function handle(): int
    {
        $connectionName = config('database.default');
        $connection = config("database.connections.{$connectionName}");

        if (!is_array($connection)) {
            $this->error("Database connection [{$connectionName}] is not configured.");
            return self::FAILURE;
        }

        $backupDirectory = (string) ($this->option('path') ?: storage_path('app/backups/database'));
        File::ensureDirectoryExists($backupDirectory, 0750, true);

        $driver = (string) ($connection['driver'] ?? '');
        $timestamp = now()->format('Ymd_His');
        $database = basename((string) ($connection['database'] ?? 'database'));
        $targetPath = $backupDirectory . DIRECTORY_SEPARATOR . "{$database}_{$driver}_{$timestamp}.sql.gz";

        $exitCode = match ($driver) {
            'mysql' => $this->backupMysql($connection, $targetPath),
            'pgsql' => $this->backupPgsql($connection, $targetPath),
            'sqlite' => $this->backupSqlite($connection, $targetPath),
            default => $this->unsupportedDriver($driver),
        };

        if ($exitCode !== self::SUCCESS) {
            if (is_file($targetPath)) {
                @unlink($targetPath);
            }

            return $exitCode;
        }

        $this->pruneBackups($backupDirectory, max(1, (int) $this->option('keep')));
        $this->info('Database backup created: ' . $targetPath);

        return self::SUCCESS;
    }

    private function backupMysql(array $connection, string $targetPath): int
    {
        $database = (string) ($connection['database'] ?? '');
        if ($database === '') {
            $this->error('MySQL database name is empty.');
            return self::FAILURE;
        }

        $mysqldump = $this->resolveExecutable('mysqldump');

        if (!$mysqldump) {
            $this->error('mysqldump was not found. Install a MySQL/MariaDB client on the server to enable local backups.');
            return self::FAILURE;
        }

        $arguments = [
            $mysqldump,
            '--single-transaction',
            '--quick',
            '--skip-lock-tables',
            '--default-character-set=' . ($connection['charset'] ?? 'utf8mb4'),
            '--host=' . ($connection['host'] ?? '127.0.0.1'),
            '--port=' . ($connection['port'] ?? '3306'),
            '--user=' . ($connection['username'] ?? ''),
        ];

        if (!empty($connection['unix_socket'])) {
            $arguments[] = '--socket=' . $connection['unix_socket'];
        }

        $arguments[] = $database;
        $environment = [];

        if (($connection['password'] ?? '') !== '') {
            $environment['MYSQL_PWD'] = (string) $connection['password'];
        }

        return $this->runCommandToGzip($arguments, $environment, $targetPath);
    }

    private function backupPgsql(array $connection, string $targetPath): int
    {
        $database = (string) ($connection['database'] ?? '');
        if ($database === '') {
            $this->error('PostgreSQL database name is empty.');
            return self::FAILURE;
        }

        $pgDump = $this->resolveExecutable('pg_dump');

        if (!$pgDump) {
            $this->error('pg_dump was not found. Install a PostgreSQL client on the server to enable local backups.');
            return self::FAILURE;
        }

        $arguments = [
            $pgDump,
            '--format=plain',
            '--no-owner',
            '--no-acl',
            '--host=' . ($connection['host'] ?? '127.0.0.1'),
            '--port=' . ($connection['port'] ?? '5432'),
            '--username=' . ($connection['username'] ?? ''),
            $database,
        ];

        $environment = [];

        if (($connection['password'] ?? '') !== '') {
            $environment['PGPASSWORD'] = (string) $connection['password'];
        }

        return $this->runCommandToGzip($arguments, $environment, $targetPath);
    }

    private function backupSqlite(array $connection, string $targetPath): int
    {
        $databasePath = (string) ($connection['database'] ?? '');
        if (!is_file($databasePath)) {
            $this->error('SQLite database file was not found.');
            return self::FAILURE;
        }

        $source = fopen($databasePath, 'rb');
        $target = gzopen($targetPath, 'wb9');

        if (!$source || !$target) {
            $this->error('Unable to open SQLite database or backup file.');
            return self::FAILURE;
        }

        while (!feof($source)) {
            gzwrite($target, (string) fread($source, 1024 * 1024));
        }

        fclose($source);
        gzclose($target);

        return self::SUCCESS;
    }

    private function unsupportedDriver(string $driver): int
    {
        $this->error("Database backup is not supported for driver [{$driver}].");

        return self::FAILURE;
    }

    private function resolveExecutable(string $binary): ?string
    {
        $path = getenv('PATH') ?: '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin';

        foreach (explode(PATH_SEPARATOR, $path) as $directory) {
            $candidate = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $binary;

            if (is_executable($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    private function runCommandToGzip(array $arguments, array $environment, string $targetPath): int
    {
        $errorPath = $targetPath . '.err';
        $descriptorSpec = [
            1 => ['pipe', 'w'],
            2 => ['file', $errorPath, 'w'],
        ];

        $processEnvironment = array_merge([
            'PATH' => getenv('PATH') ?: '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
        ], $environment);

        $process = proc_open($arguments, $descriptorSpec, $pipes, base_path(), $processEnvironment);

        if (!is_resource($process)) {
            $this->error('Unable to start database backup process.');
            return self::FAILURE;
        }

        $target = gzopen($targetPath, 'wb9');

        if (!$target) {
            fclose($pipes[1]);
            proc_terminate($process);
            proc_close($process);
            @unlink($errorPath);

            $this->error('Unable to open database backup file.');
            return self::FAILURE;
        }

        while (!feof($pipes[1])) {
            $chunk = fread($pipes[1], 1024 * 1024);

            if ($chunk !== false && $chunk !== '') {
                gzwrite($target, $chunk);
            }
        }

        fclose($pipes[1]);
        gzclose($target);

        $status = proc_close($process);
        $stderr = is_file($errorPath) ? file_get_contents($errorPath) : '';
        @unlink($errorPath);

        if ($status !== 0 && is_file($targetPath)) {
            @unlink($targetPath);
        }

        if ($stderr) {
            $this->line(trim($stderr));
        }

        return $status === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function pruneBackups(string $backupDirectory, int $keep): void
    {
        $backups = collect(File::files($backupDirectory))
            ->filter(static fn ($file) => str_ends_with($file->getFilename(), '.sql.gz'))
            ->sortByDesc(static fn ($file) => $file->getMTime())
            ->values();

        $backups->slice($keep)->each(static function ($file): void {
            @unlink($file->getPathname());
        });
    }
}
