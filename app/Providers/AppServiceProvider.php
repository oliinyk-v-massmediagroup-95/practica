<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper\FileUploader\SimpleFileUploader;
use App\Helper\FileUploader\FileUploaderInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileUploaderInterface::class, function () {
            return new SimpleFileUploader();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
