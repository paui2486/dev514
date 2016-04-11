<?php

namespace App\Providers;

use App\Library;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $slideCategory = Library::getSlideCategory();
        View()->share('slideCategory', $slideCategory);

        view()->share('copyright', '2016 &copy; 514 活動頻道.');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
