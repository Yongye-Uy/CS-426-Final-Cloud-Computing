<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use App\Services\ApiClient;
use App\Services\FileUploadService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register API Client as singleton
        $this->app->singleton(ApiClient::class, function ($app) {
            return new ApiClient();
        });

        // Register File Upload Service as singleton
        $this->app->singleton(FileUploadService::class, function ($app) {
            return new FileUploadService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mail::extend('brevo', function (array $config) {
            $factory = new BrevoTransportFactory();

            return $factory->create(new Dsn(
                'brevo+api',
                'default',
                $config['key']
            ));
        });
    }
}
