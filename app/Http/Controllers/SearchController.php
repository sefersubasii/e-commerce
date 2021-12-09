<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __construct()
    {
        ini_set('memory_limit', '2048M');

        $this->q     = trim(request()->get('q'));
        $this->query = str_replace(' ', '%', tr2en($this->q));
        // $this->query = str_replace(['ı'], ['i'], mb_convert_case($this->q, MB_CASE_LOWER));

        $this->page     = trim(request()->get('page')) ?: 1;
        $this->category = request()->get('kategori');

        $this->brandsText = request()->get('marka');
        $this->brands     = array_filter(explode('-', $this->brandsText));

        $this->filterOptionsText = request()->get('filtreler');
        $this->filterOptions     = array_filter(explode('-', $this->filterOptionsText));

        $this->order = request()->get('siralama');

        $this->cacheName = ($this->q . $this->page . $this->category . $this->brandsText . $this->filterOptionsText . $this->order);
    }

    public function index()
    {
        if (strlen($this->q) < 3) {
            return redirect()->back();
        }

        $allResults = Cache::remember('search.result_by_get.' . $this->cacheName, 60, function () {
            return $this->searchByLike()->get();
        });

        $results = Cache::remember('search.result_by_paginate.' . $this->cacheName, 60, function () {
            return $this->searchByLike()->paginate(16);
        });

        $results->appends([
            'q'         => $this->q,
            'filtreler' => $this->filterOptionsText,
            'siralama'  => $this->order,
        ])->render();

        $q               = $this->q;
        $link            = str_replace(' ', '+', $this->q);
        $count           = $results->total();
        $newcategories   = $this->getCategoriesBySearch($allResults);
        $brandsProdCount = $this->getBrandsBySearch($allResults);
        $filtreler       = $this->filterOptions;

        return view('frontEnd.blades.searchDefault', compact(
            'results', 'q', 'count', 'newcategories', 'brandsProdCount', 'link', 'filtreler', 'testdrv'
        ));
    }

    private function searchByLike()
    {
        $products = Products::select('id', 'name', 'slug', 'price', 'stock', 'stock_type', 'barcode', 'brand_id', 'relevance', 'discount', 'discount_type', 'tax', 'tax_status')
            ->with('categori', 'brand', 'images')
            ->where('products.status', 1)
            ->where(function ($query) {
                if ($this->category) {
                    $query->whereHas('categori', function ($query) {
                        return $query->where('categories.id', $this->category);
                    });
                }

                if (count($this->brands)) {
                    $query->whereIn('brand_id', $this->brands);
                }

                if (!in_array('stokhepsi', $this->filterOptions)) {
                    $query->where('stock', '>', 0);
                }
            })
            ->search($this->query, 10)
            ->orderByRaw(DB::raw('FIELD(stock, 0) ASC'))
            ->orderBy('relevance', 'DESC');

        if (request()->get("siralama")) {
            if (request()->get("siralama") == "artanfiyat") {
                $products->orderBy('final_price', 'asc');
            } elseif (request()->get("siralama") == "azalanfiyat") {
                $products->orderBy('final_price', 'desc');
            }
        }

        return $products;
    }

    private function getCategoriesBySearch($searchProducts)
    {
        return Cache::remember('search.categories.' . $this->cacheName, 30, function () use ($searchProducts) {
            $productIds = $searchProducts->pluck('id')->toArray();

            $lastChildCategorIds = ProductCategory::select(DB::raw('MAX(cid) AS cid'))
                ->whereIn('pid', $productIds)
                ->groupBy('pid')
                ->pluck('cid');

            return ProductCategory::with('category')
                ->select(DB::raw('MAX(cid) as cid'), DB::raw('COUNT(*) as total'))
                ->whereIn('pid', $productIds)
                ->whereIn('cid', $lastChildCategorIds)
                ->groupBy('cid')
                ->orderBy('total', 'DESC')
                ->get()
                ->map(function ($item) {
                    return [
                        'title' => $item->category->title,
                        'slug'  => $item->category->slug,
                        'count' => $item->total,
                    ];
                })
                ->toArray();
        });
    }

    private function getBrandsBySearch($searchProducts)
    {
        return Cache::remember('search.brands.' . $this->cacheName, 60, function () use ($searchProducts) {
            return $searchProducts
                ->pluck('brand')
                ->filter()
                ->groupBy('slug')
                ->map(function ($item) {
                    if (!$firstItem = $item->first()) {
                        return;
                    }

                    return [
                        'name'  => $firstItem->name,
                        'slug'  => $firstItem->slug,
                        'count' => $item->count(),
                    ];
                })
                ->sortByDesc('count')
                ->toArray();
        });
    }

    public function searchByBrand($brandsText)
    {
        $brandsText = str_replace('c-', '', $brandsText);
        $brands     = array_filter(explode('-', $brandsText));

        $this->cacheName = $this->cacheName . '.' . $brandsText;

        $allResults = Cache::remember('search_by_brand.result_by_get.' . $this->cacheName, 60, function () use ($brands) {
            return $this->searchByLike()->get();
        });

        $results = Cache::remember('search_by_brand.result_by_paginate.' . $this->cacheName, 60, function () use ($brands) {
            return $this->searchByLike()->whereHas('brand', function ($query) use ($brands) {
                $query->whereIn('slug', $brands);
            })->paginate(16);
        });

        $results->appends([
            'q'         => $this->q,
            'filtreler' => $this->filterOptionsText,
            'siralama'  => $this->order,
        ])->render();

        $q               = $this->q;
        $link            = str_replace(' ', '+', $this->q);
        $count           = $results->total();
        $newcategories   = $this->getCategoriesBySearch($allResults);
        $brandsProdCount = $this->getBrandsBySearch($allResults);
        $filtreler       = $this->filterOptions;

        return view('frontEnd.blades.searchDefault', compact(
            'results', 'q', 'count', 'newcategories', 'link', 'brandsProdCount', 'brands', 'filtreler')
        );
    }

    public function searchByCategory($categorySlug)
    {
        if(strlen($this->q) < 3){
            return redirect('/');
        }

        $this->cacheName = $this->cacheName . '.' . $categorySlug;

        $allResults = Cache::remember('search_by_category.result_by_get.' . $this->cacheName, 60, function () use ($categorySlug) {
            return $this->searchByLike()->get();
        });

        $results = Cache::remember('search_by_category.result_by_paginate.' . $this->cacheName, 60, function () use ($categorySlug) {
            return $this->searchByLike()->whereHas('categori', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })->paginate(16);
        });

        $results->appends([
            'q'         => $this->q,
            'filtreler' => $this->filterOptionsText,
            'siralama'  => $this->order,
        ])->render();

        $q               = $this->q;
        $link            = str_replace(' ', '+', $this->q);
        $count           = $results->total();
        $newcategories   = $this->getCategoriesBySearch($allResults);
        $brandsProdCount = $this->getBrandsBySearch($allResults);
        $filtreler       = $this->filterOptions;

        return view('frontEnd.blades.searchDefault', compact(
            'results', 'q', 'count', 'newcategories', 'link', 'brandsProdCount', 'categories', 'filtreler')
        );
    }
}
