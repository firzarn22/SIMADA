<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

      View::composer('layouts.app', function ($view) {
            $view->with('menus', Menu::whereNull('parent_id')->with('submenus')->get());
        });

    }
}

