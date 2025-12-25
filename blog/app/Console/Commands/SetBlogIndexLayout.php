<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetBlogIndexLayout extends Command
{
    protected $signature = 'blog:index-layout
                            {layout : classic|masonry}
                            {--no-clear : Do not clear config/cache after update}';

    protected $description = 'Устанавливает layout главной страницы /blog через переменную BLOG_INDEX_LAYOUT в .env';

    public function handle(): int
    {
        $layout = strtolower(trim((string) $this->argument('layout')));
        if (!in_array($layout, ['classic', 'masonry'], true)) {
            $this->error('Недопустимое значение. Разрешено: classic|masonry');
            return 1;
        }

        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            $this->error('.env не найден: ' . $envPath);
            return 1;
        }

        $contents = file_get_contents($envPath);
        if ($contents === false) {
            $this->error('Не удалось прочитать .env');
            return 1;
        }

        $key = 'BLOG_INDEX_LAYOUT';
        $line = $key . '=' . $layout;

        if (preg_match('/^' . preg_quote($key, '/') . '=.*/m', $contents)) {
            $contents = preg_replace('/^' . preg_quote($key, '/') . '=.*/m', $line, $contents);
        } else {
            $contents = rtrim($contents) . PHP_EOL . $line . PHP_EOL;
        }

        if (file_put_contents($envPath, $contents) === false) {
            $this->error('Не удалось записать .env');
            return 1;
        }

        $this->info("OK: {$key}={$layout}");

        if (!$this->option('no-clear')) {
            // Если конфиг закеширован (на проде часто так), нужно очистить, иначе env не применится
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            $this->info('config:clear + cache:clear выполнены');
        }

        $this->info('Проверь: /blog');
        return 0;
    }
}


