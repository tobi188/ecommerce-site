<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Category;
use App\Brand;
use App\Product;
use App\Cart;
use App\Navbar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $cate = Category::all();
        $brand = Brand::all();
        $nav = Navbar::all();
        $product = Product::all();
        View::share(compact('cate','brand','product','nav'));
    }
}
