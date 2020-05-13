<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper\FileUploader\SimpleFileUploader;
use App\Helper\FileUploader\FileUploaderInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(FileUploaderInterface::class, function () {
            return new SimpleFileUploader();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
