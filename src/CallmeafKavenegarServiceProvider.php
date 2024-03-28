<?php

namespace Callmeaf\Kavenegar;

use Illuminate\Support\ServiceProvider;

class CallmeafKavenegarServiceProvider extends ServiceProvider
{
    private const CONFIGS_DIR = __DIR__ . '/../config';
    private const CONFIGS_KEY = 'callmeaf-kavenegar';
    private const CONFIG_GROUP = 'callmeaf-kavenegar-config';

    public function boot(): void
    {
        $this->registerConfig();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-kavenegar.php',self::CONFIGS_KEY);
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-kavenegar.php' => config_path('callmeaf-kavenegar.php'),
        ],self::CONFIG_GROUP);
    }

}
