<?php

namespace App;

use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Products extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'categories.title'    => 30,
            'products.name'       => 50,
            'products.stock_code' => 5,
            'products.barcode'    => 5,
        ],
        'joins'   => [
            'product_to_cat' => ['products.id', 'product_to_cat.pid'],
            'categories'     => ['categories.id', 'product_to_cat.cid'],
        ],
        'groupBy' => [
            'products.id',
        ],
    ];

    protected $guarded = ['updated_at'];
    protected $appends = array('stockTypeString', 'img');

    public function getimgAttribute()
    {
        $pathToImage = "";

        if (count($this->images) > 0) {
            @$decode     = json_decode($this->images->images, true);
            $pathToImage = public_path() . '/src/uploads/products/' . $this->attributes["id"] . '/' . @$decode[1];
        }

        if (!empty($decode) && @$decode[1] !== null) {
            return '<img width="60px" src="' . "https://data.tekkilavuz.com.tr/marketpaketi/products/min/" . $this->attributes["id"] . '/' . $decode[1] . '">';
        }

        return '<img width="30px" src="' . url("src/uploads/no-image/no-image.png") . '">';
    }

    public function getstockTypeStringAttribute()
    {
        switch ($this->attributes["stock_type"]) {
            case 1:
                return "Adet";
                break;
            case 2:
                return "Cm";
                break;
            case 3:
                return "Düzine";
                break;
            case 4:
                return "Gram";
                break;
            case 5:
                return "Kg";
                break;
            case 6:
                return "Kişi";
                break;
            case 7:
                return "Paket";
                break;
            case 8:
                return "Metre";
                break;
            case 9:
                return "m2";
                break;
            case 10:
                return "Çift";
                break;
        }
    }

    public function buttons()
    {
        return $this->hasMany('App\ProductButon', 'product_id');
        //return $this->hasMany('App\Product_variant','pid');
    }

    public function geteditAttribute()
    {
        return '<a href="' . url("admin/products/edit/{$this->attributes["id"]}") . '" data-toggle="tooltip" title="Düzenle" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i></a>';
    }

    public function getdeleteAttribute()
    {
        return '<a href="' . url("admin/products/delete/{$this->attributes["id"]}") . '" data-toggle="tooltip" title="Sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i></a>';
    }

    public function getshortEditAttribute()
    {
        return '<a href="" data-id="' . $this->attributes["id"] . '" data-toggle="tooltip" title="Hızlı Düzenle" class="btn btn-xs btn-success btn-rounded shortEditBtn"><i class="fa fa-pencil"></i></a>';
    }

    public function getcopyAttribute()
    {
        return '<a href="' . url("admin/products/copy/{$this->attributes["id"]}") . '" data-toggle="tooltip" title="Kopyala" onclick="return confirm(\'Kopyalamak İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="fa fa-files-o"></i></a>';
    }

    public function showcase()
    {
        return $this->hasOne('App\HomeSort', 'product_id', 'id')->select(["sort", "product_id"]);
    }

    public function newSort()
    {
        return $this->hasOne('App\NewSort', 'product_id', 'id')->select(["sort", "product_id"]);
    }

    public function campaignSort()
    {
        return $this->hasOne('App\CampaignSort', 'product_id', 'id')->select(["sort", "product_id"]);
    }

    public function discountSort()
    {
        return $this->hasOne('App\DiscountSort', 'product_id', 'id')->select(["sort", "product_id"]);
    }

    public function sponsorSort()
    {
        return $this->hasOne('App\SponsorSort', 'product_id', 'id')->select(["sort", "product_id"]);
    }

    public function popularSort()
    {
        return $this->hasOne('App\PopularSort', 'product_id', 'id')->select(["sort", "product_id"]);
    }

    public function categorySort()
    {
        return $this->hasMany('App\CategorySort', 'product_id')->select(["sort", "product_id"]);
    }

    public function brandSort()
    {
        return $this->hasOne('App\BrandSort', 'product_id');
    }

    public function brand()
    {
        //dd( $this->hasOne('App\Brand','id')->select(['name']));
        return $this->hasOne('App\Brand', 'id', 'brand_id')->select(['name', 'id', 'code', 'slug']);
    }

    public function brandName()
    {
        //dd( $this->hasOne('App\Brand','id')->select(['name']));
        return $this->hasOne('App\Brand', 'id', 'brand_id')->select(["name", "id"]);
    }

    public function images()
    {
        //dd( $this->hasOne('App\Brand','id')->select(['name']));
        return $this->hasOne('App\productImage', 'pid', 'id')->select(['images', 'id', 'pid']);
    }

    public function categori()
    {
        return $this->belongsToMany('App\Categori', 'product_to_cat', 'pid', 'cid')->select(['categories.id', 'title']);
    }

    public function categorisearch()
    {
        return $this->belongsToMany('App\Categori', 'product_to_cat', 'pid', 'cid')->select(['categories.id', 'title', 'slug']);
    }

    public function relateds()
    {
        return $this->belongsToMany('App\Products', 'product_to_relateds', 'product_id', 'related_id');
    }

    public function sixRelatedInStock()
    {
        return $this->belongsToMany('App\Products', 'product_to_relateds', 'product_id', 'related_id')
            ->where('stock', '>', '0')->take(6);
    }

    public function variant()
    {
        return $this->hasMany('App\Product_variant', 'pid');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\AttributeValue', 'product_attributes', 'product_id', 'attribute_values_id');
    }

    public function shippings()
    {
        return $this->hasOne('App\Products_shipping', 'pid');
    }

    public function reviews()
    {
        return $this->hasMany('App\ProductReview', 'product_id');
    }

    public function activeReviews()
    {
        return $this->hasMany('App\ProductReview', 'product_id')->where('status', '1');
    }

    /*
    public function filterCategory($cid)
    {
    return   $this->whereHas('categori', function($q) use($cid) {
    $q->whereIn('cid', $cid);
    });
    }

    public function filterCategory($cid)
    {
    return $this->belongsToMany(\App\Categori::class)->wherePivot('cid', $cid);
    }
     */

    public function scopeFilterByAddedDateTime($query)
    {
        if (request()->has('added_date1') && request()->has('added_date2') && request()->has('time1') && request()->has('time2')) {
            $query->where('created_at', '>=', sprintf('%s %s:00', request()->get('added_date1'), request()->get('time1')));
            $query->where('created_at', '<=', sprintf('%s %s:59', request()->get('added_date2'), request()->get('time2')));
        } else if (request()->has('added_date1') && request()->has('added_date2')) {
            $query->whereDate('created_at', '>=', request()->get('added_date1'));
            $query->whereDate('created_at', '<=', request()->get('added_date2'));
        } else if (request()->has('time1') && request()->has('time2')) {
            $query->where('created_at', '>=', sprintf('%s:00', request()->get('time1')));
            $query->where('created_at', '<=', sprintf('%s:59', request()->get('time2')));
        }
    }

    public function scopeFilterByRequest($query, Request $request)
    {

        if ($request->has('category_id')) {
            $cid = $request->get('category_id');

            $query->whereHas('categori', function ($query) use ($cid) {
                $query->where('product_to_cat.cid', $cid);
            });
        }

        if ($request->has('category_ids')) {
            $cids = $request->get('category_ids');

            $query->whereHas('categori', function ($query) use ($cids) {
                $query->whereIn('product_to_cat.cid', $cids);
            });
        }

        if ($request->has('brand_ids')) {
            $brands = $request->get('brand_ids');
            $query->whereIn('brand_id', $brands);
        }

        if ($request->has('status')) {
            $query->where('products.status', '=', $request->get('status'));
        }
        if ($request->has('barcode')) {
            $query->where('products.barcode', 'like', "%{$request->get('barcode')}%");
        }
        if ($request->has('discount_type')) {
            $query->where('products.discount_type', '=', $request->get('discount_type'));
        }
        if ($request->has('discount1') && $request->has('discount2')) {
            $query->whereBetween('discount', [$request->get('discount1'), $request->get('discount2')]);
        }
        if ($request->has('stock_type')) {
            $query->where('products.stock_type', '=', $request->get('stock_type'));
        }
        if ($request->has('stock_code')) {
            $query->Where('products.stock_code', 'like', "%{$request->get('stock_code')}%");
        }
        /*
        if ($request->has('stock1') && $request->has('stock2')){
        $query->whereBetween('discount', [$request->get('stock1'),$request->get('stock2')]);
        }
         */
        if ($request->has('brand_id')) {
            $query->where('products.brand_id', '=', $request->get('brand_id'));
        }
        if ($request->has('p_id')) {
            $query->where('products.id', '=', $request->get('p_id'));
        }

        if ($request->has('name')) {
            $namete = ltrim(mb_convert_case(str_replace(array(' I', ' ı', ' İ', ' i'), array(' I', ' I', ' İ', ' İ'), ' ' . $request->get('name')), MB_CASE_TITLE, "UTF-8"));

            $searchValues = preg_split('/\s+/', $namete, -1, PREG_SPLIT_NO_EMPTY);
            $query->where(function ($query) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $query->Where('name', 'like', "%{$value}%");
                }
            });

            //$query->where('name', 'LIKE', "%{$request->get('name')}%");
        }
        if ($request->has('price1') && $request->has('price2')) {
            $query->whereBetween('price', [$request->get('price1'), $request->get('price2')]);
        }
        if ($request->has('stock1') && $request->has('stock2')) {
            $query->whereBetween('stock', [$request->get('stock1'), $request->get('stock2')]);
        }

        if ($request->has('added_date1') && $request->has('added_date2')) {
            $query->whereDate('created_at', '>=', $request->get('added_date1'));
            $query->whereDate('created_at', '<=', $request->get('added_date2'));
        }

        if ($request->has('tax_id')) {
            $query->where('tax', '=', $request->get('tax_id'));
        }

        if ($request->has('onlyStock')) {
            $query->where('stock', '>', 0);
        }

        if ($request->has('hasNotCat')) {
            $query->doesnthave('categori');
        }

        // And so on

        return $query;
    }
}
