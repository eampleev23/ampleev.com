<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class MakeOwnerDeviceLink extends Command
{
    protected $signature = 'owner:device-link {label : Device label, for example macbook or iphone-1} {--days=30 : Link lifetime in days}';

    protected $description = 'Generate a signed link that marks a browser as an owner device.';

    public function handle(): int
    {
        $label = trim((string) $this->argument('label'));
        if ($label === '') {
            $this->error('Device label is required.');
            return self::FAILURE;
        }

        $days = max(1, min(365, (int) $this->option('days')));
        $rootUrl = rtrim((string) config('app.url'), '/');
        if ($rootUrl === 'http://ampleev.com') {
            $rootUrl = 'https://ampleev.com';
        }
        if ($rootUrl !== '') {
            URL::forceRootUrl($rootUrl);
            URL::forceScheme(parse_url($rootUrl, PHP_URL_SCHEME) ?: 'https');
        }

        $url = URL::temporarySignedRoute('owner_devices.claim', now()->addDays($days), [
            'key' => (string) Str::uuid(),
            'label' => mb_substr($label, 0, 120),
        ]);

        $this->line($url);

        return self::SUCCESS;
    }
}
