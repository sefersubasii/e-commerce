<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Categori;
use App\Pages;
use App\Products;
use App\Services\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Roumen\Sitemap\Sitemap;

class SitemapController extends Controller
{
    protected $sitemap;

    public function __construct(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    public function create()
    {
        // Create category sitemap
        $this->createCategorySitemap();

        // Create product sitemap
        $this->createProductSitemap();

        // Create brand sitemap
        $this->createBrandSitemap();

        // Create page sitemap
        $this->createPageSitemap();

        // Create brand+category sitemap
        $this->createBrandCategorySitemap();

        // Create main sitemap file
        $this->sitemap->store('sitemapindex', 'sitemap', public_path());

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Create category sitemap
     *
     * @return void
     */
    private function createCategorySitemap()
    {
        $counter = 1;

        // Add main url to sitemap
        $this->sitemap->add(url('/'), Carbon::now(), 1.0, 'daily');

        Categori::select('slug', 'id')
            ->whereStatus(1)
            ->orderBy('id', 'DESC')
            ->chunk(2000, function ($items) use (&$counter) {
                foreach ($items as $item) {
                    $this->sitemap->add(url($item->slug . '-c-' . $item->id), Carbon::now(), 0.5, 'daily');
                }

                $this->sitemap->store('xml', 'sitemap-category-' . $counter, public_path('sitemaps'));
                $this->sitemap->addSitemap(secure_url('sitemaps/sitemap-category-' . $counter . '.xml'));
                $this->sitemap->model->resetItems();

                $counter++;
            });
    }

    /**
     * Create product sitemap
     *
     * @return void
     */
    private function createProductSitemap()
    {
        $myProduct = new Product();
        $counter   = 1;

        Products::select('slug', 'id')
            ->whereStatus(1)
            ->orderBy('created_at', 'DESC')
            ->with('images')
            ->chunk(2000, function ($items) use (&$counter, $myProduct) {
                foreach ($items as $item) {
                    $this->sitemap->add(url($item->slug . '-p-' . $item->id), Carbon::now(), 0.7, 'weekly', [
                        "images" => [
                            "url" => $myProduct->baseImg($item->images, $item->id),
                        ],
                    ]);
                }

                $this->sitemap->store('xml', 'sitemap-product-' . $counter, public_path('sitemaps'));
                $this->sitemap->addSitemap(secure_url('sitemaps/sitemap-product-' . $counter . '.xml'));
                $this->sitemap->model->resetItems();

                $counter++;
            });
    }

    /**
     * Create brand sitemap
     *
     * @return void
     */
    private function createBrandSitemap()
    {
        $counter = 1;

        Brand::select('slug')
            ->orderBy('id', 'DESC')
            ->chunk(2000, function ($items) use (&$counter) {
                foreach ($items as $item) {
                    $this->sitemap->add(url($item->slug), Carbon::now(), 0.5, 'daily');
                }

                $this->sitemap->store('xml', 'sitemap-brand-' . $counter, public_path('sitemaps'));
                $this->sitemap->addSitemap(secure_url('sitemaps/sitemap-brand-' . $counter . '.xml'));
                $this->sitemap->model->resetItems();

                $counter++;
            });
    }

    /**
     * Create page sitemap
     *
     * @return void
     */
    private function createPageSitemap()
    {
        $counter = 1;

        // Add static pages
        $this->sitemap->add(url('mesafeli-satis-sozlesmesi'), Carbon::now(), 0.5, 'monthly');
        $this->sitemap->add(url('odeme-ve-teslimat'), Carbon::now(), 0.5, 'monthly');
        $this->sitemap->add(url('gizlilik-ve-guvenlik'), Carbon::now(), 0.5, 'monthly');
        $this->sitemap->add(url('iade-sartlari'), Carbon::now(), 0.5, 'monthly');

        Pages::select('slug')
            ->where('isStatic', 0)
            ->orderBy('id', 'DESC')
            ->chunk(2000, function ($items) use (&$counter) {
                foreach ($items as $item) {
                    $this->sitemap->add(url('sayfa/' . $item->slug), Carbon::now(), 0.5, 'monthly');
                }

                $this->sitemap->store('xml', 'sitemap-page-' . $counter, public_path('sitemaps'));
                $this->sitemap->addSitemap(secure_url('sitemaps/sitemap-page-' . $counter . '.xml'));
                $this->sitemap->model->resetItems();

                $counter++;
            });
    }

    /**
     * Create brand and category page sitemap
     *
     * @return void
     */
    private function createBrandCategorySitemap()
    {
        $chunk   = 1;
        $counter = 1;

        $categories = Categori::select('slug', 'id')
            ->whereStatus(1)
            ->orderBy('id', 'ASC')
            ->cursor();

        foreach ($categories as $category) {
            $products = $category->products()
                ->select('products.brand_id', 'brands.slug', DB::raw('COUNT(*) as count'))
                ->where('products.status', '1')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->groupBy('brand_id')
                ->orderBy('count', 'DESC')
                ->cursor();

            foreach ($products as $product) {
                $url = url($product->slug . "/" . $category->slug . "-c-" . $category->id);
                $this->sitemap->add($url, Carbon::now(), 0.8, 'weekly');
                $chunk++;
            }

            if ($chunk >= 2000) {
                $this->sitemap->store('xml', 'sitemap-brandCategory-' . $counter, public_path('sitemaps'));
                $this->sitemap->addSitemap(secure_url('sitemaps/sitemap-brandCategory-' . $counter . '.xml'));
                $this->sitemap->model->resetItems();

                $chunk = 0;
                $counter++;
            }
        }
    }
}
