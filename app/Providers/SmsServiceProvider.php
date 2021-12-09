<?php

namespace App\Providers;

use App\Settings_basic;
use Exception;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected $config;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $smsConfig = json_decode(optional(Settings_basic::first())->sms);

        if ($smsConfig) {
            config([
                'sms.driver'   => $smsConfig->sms_platform,
                'sms.enabled'  => boolval($smsConfig->sms_status),
                'sms.sender'   => $smsConfig->sms_sender,
                'sms.username' => $smsConfig->sms_username,
                'sms.password' => $smsConfig->sms_password,
            ]);
        }

        $driverClass = "App\Services\Sms\\" . config('sms.driver');

        // Check SMS Driver
        if (!config('sms.driver') || !class_exists($driverClass)) {
            throw new Exception('[' . config('sms.driver') . '] SMS Sürücüsü bulunamadı!');
        }

        $this->app->singleton('App\Contracts\Sms', $driverClass);
    }

    public function provides()
    {
        return ['App\Contracts\Sms'];
    }
}
