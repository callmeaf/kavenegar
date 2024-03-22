<?php

namespace Callmeaf\Kavenegar;

use Illuminate\Support\ServiceProvider;

class CallmeafKavenegarServiceProvider extends ServiceProvider
{
    private const CONFIGS_DIR = __DIR__ . '/../config';
    private const CONFIGS_KEY = 'callmeaf-kavenegar';
    private const CONFIG_GROUP = 'callmeaf-kavenegar-config';

    private const ROUTES_DIR = __DIR__ . '/../routes';

    private const RESOURCES_DIR = __DIR__ . '/../resources';
    private const VIEWS_NAMESPACE = 'callmeaf-kavenegar';
    private const VIEWS_GROUP = 'callmeaf-kavenegar-views';

    private const LANG_DIR = __DIR__ . '/../lang';
    private const LANG_NAMESPACE = 'callmeaf-kavenegar';
    private const LANG_GROUP = 'callmeaf-kavenegar-lang';

    public function boot(): void
    {
        $this->registerConfig();
        $this->registerLang();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-kavenegar.php',self::CONFIGS_KEY);
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-kavenegar.php' => config_path('callmeaf-kavenegar.php'),
        ],self::CONFIG_GROUP);
    }

    private function registerLang(): void
    {
        $langPathFromVendor = lang_path('vendor/callmeaf/kavenegar');
        if(is_dir($langPathFromVendor)) {
            $this->loadTranslationsFrom($langPathFromVendor,self::LANG_NAMESPACE);
        } else {
            $this->loadTranslationsFrom(self::LANG_DIR,self::LANG_NAMESPACE);
        }
        $this->publishes([
            self::LANG_DIR => $langPathFromVendor,
        ],self::LANG_GROUP);
    }
}
