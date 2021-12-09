<?php

namespace App\Providers;

use App\Bank;
use Nestable;
use App\Popup;
use App\Banner;
use App\Article;
use App\Comment;
use App\Categori;
use App\Products;
use App\SliderItem;
use App\Services\Price;
use App\Settings_basic;
use App\Services\Product;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            $url->forceSchema('https');
        }

        view()->composer([
            'frontEnd.include.header',
            'frontEnd.include.footer',
            'frontEnd.blades.search',
            'frontEnd.blades.searchDefault',
            'frontEnd.blades.searchCategory',
            'frontEnd.blades.home',
        ], function ($view) {
            $categories = Cache::remember('categories', 10, function () {
                $data = Categori::where('status', '1')
                    ->select('id', 'parent_id', 'title', 'slug', 'imageCover')
                    ->orderBy('sort')
                    ->get();

                return Nestable::make($data)->renderAsArray();
            });

            $view->with('categories', $categories);
        });

        view()->composer('frontEnd.blades.home', function ($view) {
            $newProducts = Cache::remember('newProducts', 10, function () {
                return Products::Join('new_sorts', function ($join) {
                    $join->on('products.id', '=', 'new_sorts.product_id');
                })->has('newSort')->with('images')->select('products.*', 'new_sorts.sort')->where('stock', '>=', '1')->where('status', '1')->orderBy('new_sorts.sort')->limit(15)->get();
            });

            $homeProducts = Cache::remember('homeProducts', 10, function () {
                return Products::Join('home_sorts', function ($join) {
                    $join->on('products.id', '=', 'home_sorts.product_id');
                })->has('showcase')->with('images')->select('products.*', 'home_sorts.sort')->where('stock', '>=', '1')->where('status', '1')->orderBy('home_sorts.sort')->limit(15)->get();
            });

            $discountProducts = Cache::remember('discountProducts', 10, function () {
                return Products::Join('discount_sorts', function ($join) {
                    $join->on('products.id', '=', 'discount_sorts.product_id');
                })->has('discountSort')->with('images', 'brand')->select('products.*', 'discount_sorts.sort')->where('stock', '>=', '1')->where('status', '1')->orderBy('discount_sorts.sort', 'asc')->limit(15)->get();
            });

            //günün fırsatı => sponsor ürün
            $sponsorProducts = Cache::remember('sponsorProducts', 10, function () {
                return Products::Join('sponsor_sorts', function ($join) {
                    $join->on('products.id', '=', 'sponsor_sorts.product_id');
                })->has('sponsorSort')->with('images', 'brand')->select('products.*', 'sponsor_sorts.sort')->where('stock', '>=', '1')->where('status', '1')->orderBy('sponsor_sorts.sort')->limit(1)->get();
            });

            $view->with([
                'newProducts'      => $newProducts,
                'homeProducts'     => $homeProducts,
                'discountProducts' => $discountProducts,
                // 'popularProducts' => $popularProducts,
                // 'homeArticles' => $homeArticles,
                'sponsorProducts'  => $sponsorProducts,
            ]);
        });

        view()->composer([
            'frontEnd.blades.category',
            'frontEnd.blades.home',
        ], function ($view) {
            // Avantaj paketi
            $popularProducts = Cache::remember('popularProducts', 10, function () {
                return Products::Join('popular_sorts', function ($join) {
                    $join->on('products.id', '=', 'popular_sorts.product_id');
                })->has('popularSort')->with('images', 'brand')->select('products.*', 'popular_sorts.sort')->where('stock', '>=', '1')->where('status', '1')->orderBy('popular_sorts.sort')->limit(5)->get();
            });

            $homeArticles = Cache::remember('homeArticles', 5, function () {
                return Article::where("status", 1)->orderBy('created_at')->limit(3)->get();
            });

            $view->with([
                'homeArticles'    => $homeArticles,
                'popularProducts' => $popularProducts,
            ]);
        });

        // HomePage Popups
        view()->composer('frontEnd.blades.home', function ($view) {
            $homePopups = Cache::rememberForever('home.popups', function () {
                return Popup::whereStatus(1)
                    ->where('homeStatus', 1)
                    ->orderBy('id', 'DESC')
                    ->first();
            });

            $view->with(compact('homePopups'));
        });

        // CategoryPage Popups
        view()->composer('frontEnd.blades.category', function ($view) {
            if (request()->has('category_id')) {
                $categoryPopups = Cache::rememberForever('category.popups', function () {
                    return Popup::whereStatus(1)
                        ->whereNotNull('categories')
                        ->orderBy('id', 'DESC')
                        ->get();
                });

                $categoryPopups = $categoryPopups->filter(function ($popup) {
                    return in_array(request('category_id'), $popup->categories);
                })->first();

                $view->with(compact('categoryPopups'));
            }
        });

        view()->composer('*', function ($view) {
            $settings = Cache::remember('settings', 10, function () {
                $banners      = Banner::get();
                $slider       = SliderItem::where('slider_id', 1)->orderBy('sort')->limit(9)->get();
                $mobil_slider = SliderItem::where('slider_id', 2)->orderBy('sort')->limit(9)->get();
                $basic        = Settings_basic::first();
                $banks        = Bank::get();
                return [
                    "banners"     => $banners,
                    "social"      => @json_decode($basic->social),
                    "slider"      => $slider,
                    "mobilSlider" => $mobil_slider,
                    "company"     => @json_decode($basic->company),
                    "banks"       => $banks,
                    "seo"         => @json_decode($basic->seo),
                    "constants"   => @json_decode($basic->constants),
                    "basic"       => @json_decode($basic->basic),
                ];
            });

            $myProduct = new Product();
            $myPrice   = new Price();

            $comments = Cache::remember('comments', 60, function () {
                return Comment::orderBy('id', 'DESC')->get();
            });

            $globalPopups = Cache::rememberForever('global.popups', function () {
                return Popup::whereStatus(1)
                    ->where('homeStatus', '!=', 1)
                    ->whereNull('categories')
                    ->orderBy('id', 'DESC')
                    ->first();
            });

            $view->with([
                'settings'     => $settings,
                'myProduct'    => $myProduct,
                'myPrice'      => $myPrice,
                'comments'     => $comments,
                'globalPopups' => $globalPopups,
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::directive('dd', function ($value) {
            return "<?php dd($value) ?>";
        });

        Blade::directive('dump', function ($value) {
            return "<?php dump($value) ?>";
        });
    }
}
