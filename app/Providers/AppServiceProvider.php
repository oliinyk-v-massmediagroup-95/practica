<?php

namespace App\Providers;

use App\Helper\FileUploader\FileUploaderInterface;
use App\Helper\FileUploader\SimpleFileUploader;
use App\Helper\Form;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
