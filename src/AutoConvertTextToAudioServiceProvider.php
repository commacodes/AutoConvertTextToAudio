<?php

namespace commacodes\AutoConvertTextToAudio;

use Illuminate\Support\ServiceProvider;

class AutoConvertTextToAudioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // نشر ملف التكوين config/tts.php
        $this->publishes([
            __DIR__ . '/../config/tts.php' => config_path('tts.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // دمج ملف التكوين مع إعدادات التطبيق
        $this->mergeConfigFrom(__DIR__ . '/../config/tts.php', 'tts');
    }
}
