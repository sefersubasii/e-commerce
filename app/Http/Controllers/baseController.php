<?php

namespace App\Http\Controllers;

use App\BillingAddress;
use App\Brand;
use App\BrandCategory;
use App\Categori;
use App\Cities;
use App\Member;
use App\Order;
use App\Products;
use App\Services\Cart;
use App\Services\Cart\CartShipping;
use App\Services\Est3dModel;
use App\Services\Finansbank;
use App\Services\n11;
use App\Services\Price;
use App\Services\Pro;
use App\Services\Product;
use App\Services\Shipment;
use App\Services\SuratKargo;
use App\Services\YurticiKargo;
use App\Shipping;
use App\ShippingAddress;
use Carbon\Carbon;
use DateTime;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

//use Spatie\LaravelAnalytics\LaravelAnalytics;
//use Spatie\LaravelAnalytics\Period;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Image;
use Maatwebsite\Excel\Facades\Excel;
use Nathanmac\Utilities\Parser\Parser;
use Nestable;
use Redirect;
use Spatie\LaravelAnalytics\LaravelAnalyticsFacade;
use Throwable;
use Validator;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->est3dModel = new Est3dModel();

        $this->yurticiKargo = new YurticiKargo([
            'username' => 'OZKORUGO',
            'password' => '3BA99D4304874F',
        ]);
    }

    public function importExcel()
    {
        $address = 'marketpaketixml.xls';
        Excel::load($address, function ($reader) {
            $results = $reader->toArray();
            $say     = 0;
            return dd($results[1]);
            die();
            exit();

            foreach ($results[1] as $key => $v) {
                $url = \App\Url::where('old', $v['com'])->first();

                if ($url) {
                    $say++;
                    $data = array(
                        "new"   => $v['com.tr'],
                        "count" => 1,
                    );
                    \App\Url::where('old', $v['com'])->update($data);
                } else {
                    //echo "**".$v['com'].$v['com.tr']."</br>";
                    $data = array(
                        "old"   => $v['com'],
                        "new"   => $v['com.tr'],
                        "count" => 1,
                    );
                    \App\Url::create($data);
                }
            }
            echo $say;
        });
    }

    public function importExcelBrand()
    {
        $address = public_path('brand.xls');
        Excel::load($address, function ($reader) {
            $results = $reader->toArray();
            foreach ($results[0] as $key => $v) {
                $data = array(
                    "code"          => "",
                    "name"          => $v['kucukharf'],
                    "slug"          => str_slug($v['kucukharf']),
                    "sort"          => 999,
                    "filter_status" => 1,
                );
                $create = \App\Brand::create($data);
            }
        });
    }

    public function urlList()
    {

        //$qq = \App\Url::where('count',1)->get();
        //return response()->json($qq);
        //die();
        //exit();

        $payload    = file_get_contents(url('sitemapBrands.xml'));
        $parser     = new Parser();
        $parsedData = $parser->xml($payload);

        //return $parsedData;

        //return $parsedData['url'];
        //return $parsedData['url'][0]['loc'];

        foreach ($parsedData['url'] as $key => $value) {
            $data  = [];
            $brand = str_replace("https://www.marketpaketi.com/marka/", "", $value['loc']); //  strchr($value['loc'],',LA_')."</br>";

            $data["old"] = $value['loc'];

            $data["new"]   = "https://www.marketpaketi.com.tr/" . str_slug($brand);
            $data["count"] = 1;
            //echo "https://www.marketpaketi.com.tr/".str_slug($brand)."--".$value['loc']."</br>";

            //$data = ['old'=>$value['loc']];
            //echo "<pre>";
            //print_r($data);
            //echo "</pre>";
            //\App\Url::create($data);
        }

        /*

    foreach ($parsedData['url'] as $key => $value) {
    $data=[];
    $id  =  str_replace(".html", "", substr(strrchr($value['loc'], ",PR-"),4));//  strchr($value['loc'],',LA_')."</br>";
    $new = \App\Products::select('slug','id')->where('id',$id)->first();

    $data["old"]=$value['loc'];
    if ($new) {
    $data["new"]="https://www.marketpaketi.com.tr/".$new->slug."-p-".$new->id;
    $data["count"]=1;
    echo "https://www.marketpaketi.com.tr/".$new->slug."-p-".$new->id."</br>";
    }else{
    $data["count"]=0;
    echo $id."-Yok"."</br>";
    }
    //$data = ['old'=>$value['loc']];
    //echo "<pre>";
    //print_r($data);
    //echo "</pre>";
    //\App\Url::create($data);
    }
     */
    }

    public function QueryShipmentYk()
    {
        $data   = ['username' => 'OZKORUGO', 'password' => '3BA99D4304874F'];
        $result = new YurticiKargo($data);
        $params = ["ORDER-18197OhjB07022903"];
        return response()->json($result->QueryShipment($params));
    }

    public function yurticiKargo()
    {
        $data   = ['username' => 'OZKORUGO', 'password' => '3BA99D4304874F'];
        $result = new YurticiKargo($data);

        $params = [
            "cargoKey"         => "ORDER-18183MgGI07012446",
            "invoiceKey"       => "ORDER-18183MgGI07012446",
            "receiverCustName" => "Zeynel Baltalı",
            "taxOfficeId"      => "",
            "cargoCount"       => "",
            "ttDocumentId"     => "",
            "dcSelectedCredit" => "",
            "dcCreditRule"     => "",
            "receiverAddress"  => "Nişancıpaşa mah Seyfettin bey cad no 9/C Manisa Manisa",
            "receiverPhone1"   => "+90 (531) 571 96 76",
            //"ttCollectionType"=>"0",
            //"ttInvoiceAmount"=>"0.0"

        ];

        return response()->json($result->CreateShipment($params));
    }

    public function suratKargo()
    {
        //return dd("süratKargo");
        $data   = ['username' => 'test', 'password' => '1234'];
        $result = new SuratKargo($data);
        $params = [
            "IrsaliyeSeriNo"           => "75899",
            "IrsaliyeSiraNo"           => "4158589",
            "KisiKurum"                => "idris",
            "Il"                       => "GAZİANTEP",
            "Ilce"                     => "Nizip",
            "KisiKurum"                => "Mustafa Öztürk",
            "AliciAdresi"              => "Api testtir dikkate almayınız.",
            "TelefonCep"               => "+90 (544) 537 19 93",
            "AliciKodu"                => "47585",
            "KargoTuru"                => "2",
            "Odemetipi"                => "1",
            "TeslimSekli"              => "1",
            "TasimaSekli"              => "1",
            "ReferansNo"               => "54585896",
            "OzelKargoTakipNo"         => "748858969",
            "Adet"                     => "1",
            "BirimDesi"                => "1",
            "BirimKg"                  => "1",
            "KargoIcerigi"             => "ilac",
            "KapidanOdemeTahsilatTipi" => 1,
            "KapidanOdemeTutari"       => 65,
            //"ttCollectionType"=>"0",
            //"ttInvoiceAmount"=>"0.0"

        ];
        return response()->json($result->CreateShipment($params));
    }

    public function n11()
    {
        $data = ['app_key' => '39bb4d9e-3324-4274-a86c-1885d3259c7f', 'app_secret' => '8LdgdX9qSGG82StI'];
        $n11  = new N11($data);
        return response()->json($n11->GetTopLevelCategories());
    }

    public function analytics()
    {
        //$client = '\Spatie\LaravelAnalytics\GoogleApiHelper';
        //$siteId = '164667279';
        //$laravelAnalytics = new LaravelAnalytics($client, $siteId);
        //dd($laravelAnalytics);
        $analyticsData = LaravelAnalyticsFacade::getVisitorsAndPageViews(7);
        return response()->json($analyticsData);
        //$analyticsData = LaravelAnalytics::setSiteId('ga:164667279')->getVisitorsAndPageViews();
        /// $analyticsData = LaravelAnalytics::fetchMostVisitedPages(Period::days(7));
    }

    public function categoryTest()
    {
        // $titles     = DB::table('Titles')->pluck('title');
        $categories = \App\Categori::select('title')->pluck('title')->toArray();
        dd(array_count_values($categories));
        // dd($titles);

        //$dizi1 = $titles;
        //$dizi2 = array("b" => "green", "yellow", "red");

        //$result = array_udiff($categories,$titles,'strcasecmp');

        $arr1 = $categories; //array("hElLo", "WoRlD", "abasckd");
        $arr2 = []; //array("HeLLo", "wORLD");

        $diff = $arr1;
        $temp = array_map('strtolower', $arr2);

        foreach ($diff as $key => $value) {
            if (in_array(strtolower($value), $temp)) {
                unset($diff[$key]);
            }
        }

        $diff = array_values($diff);

        echo "<pre>";
        print_r($diff);
        echo "</pre>";

        //dd($result);
    }

    public function convertImg()
    {
        $pros = \App\Products::select('id')->limit(200)->offset(16600)->get();
        //$pros = \App\Products::select('id')->where('id','542226')->get();

        //return dd($pros);

        foreach ($pros as $k => $v) {
            $bigimage = @json_decode(@$v->images->images, true)[1];
            if ($bigimage) {
                $img = Image::make(url('src/uploads/products/' . $v->id . '/' . $bigimage . ''));
                $img->resize(null, 360, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if (!File::exists(public_path() . '/src/uploads/products/min/' . $v->id)) {
                    mkdir(public_path() . '/src/uploads/products/min/' . $v->id, 0777, true);
                }

                $img->save(public_path() . '/src/uploads/products/min/' . $v->id . '/' . str_replace(".jpg", ".png", $bigimage), 100);

                $input_file  = url() . "/src/uploads/products/min/" . $v->id . "/" . str_replace(".jpg", ".png", $bigimage);
                $output_file = public_path() . '/src/uploads/products/min/' . $v->id . '/' . $bigimage;

                $input                = imagecreatefrompng($input_file);
                list($width, $height) = getimagesize($input_file);
                $output               = imagecreatetruecolor($width, $height);
                $white                = imagecolorallocate($output, 255, 255, 255);
                imagefilledrectangle($output, 0, 0, $width, $height, $white);
                imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
                imagejpeg($output, $output_file, 100);

                @unlink(public_path() . '/src/uploads/products/min/' . $v->id . '/' . str_replace(".jpg", ".png", $bigimage));
            }
        }
    }

    public function resizeImg()
    {
        $say  = 0;
        $pros = \App\Products::select('id')->where('id', '>', '542182')->get(); //limit(500)->offset(16500)->get();
        //return dd($pros);
        foreach ($pros as $k => $v) {
            //return dd($v->id);
            // dd($v->images->images);
            $bigimage = json_decode(@$v->images->images, true)[1];
            if ($bigimage) {
                //echo $v->id."/".$bigimage."--".$k."</br>";
                //$bigimage = base64_decode($bigimage);
                //echo strlen($bigimage)."</br>";

                $img = Image::make(url('src/uploads/products/' . $v->id . '/' . $bigimage . ''));
                if ($img) {
                    //$img = base64_decode($img);
                    //dd($img);
                    $img->resize(null, 360, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    if (!File::exists(public_path() . '/src/uploads/products/min/' . $v->id)) {
                        mkdir(public_path() . '/src/uploads/products/min/' . $v->id, 0777, true);
                    }

                    //mkdir(public_path().'/src/uploads/products/min/'.$v->id, 0777, true);
                    if (!File::exists(public_path() . '/src/uploads/products/min/' . $v->id . '/' . $bigimage)) {
                        $img->save(public_path() . '/src/uploads/products/min/' . $v->id . '/' . $bigimage, 100);
                        $say++;
                    }
                }
            }
        }
        return $say . " adet resim eklendi.";
        //dd('ok');

        //$img = Image::make(url('src/uploads/products/prianha-6940-silver-1.jpg'));
        //$img->resize(360, null);
        //$img->orientate();
        //$img->resize(null, 360, function ($constraint) {
        //  $constraint->aspectRatio();
        //});
        //return $img->response('jpg');
    }

    public function parseXmlBrands()
    {
        $payload    = file_get_contents(url('brands.xml'));
        $parser     = new Parser();
        $parsedData = $parser->xml($payload);

        $say = 0;
        foreach ($parsedData['item'] as $k => $v) {
            $data = [
                "id"            => $v['brandId'],
                "code"          => $v['brandDistCode'],
                "name"          => $v['brand'],
                "slug"          => str_slug($v['brand'], ''),
                "sort"          => 999,
                "filter_status" => 1,
            ];
            $create = \App\Brand::create($data);
            $say++;
        }

        echo $say . " tane marka eklendi.";
    }

    public function parseXmlCategories()
    {
        $payload    = file_get_contents(url('category-kamp.xml'));
        $parser     = new Parser();
        $parsedData = $parser->xml($payload);
        return $parsedData;
        $say = 0;
        foreach ($parsedData['item'] as $k => $v) {
            $seo = [
                "seo_title"       => "",
                "seo_keywords"    => "",
                "seo_description" => "",
            ];
            $data = array(
                "id"        => $v['catId'],
                "title"     => $v['label'],
                "slug"      => str_slug($v['label']),
                "parent_id" => $v['parentId'] == null ? 0 : $v['parentId'],
                "sort"      => $v['sortOrder'],
                "seo"       => json_encode($seo),
                "status"    => $v['status'],
            );
            $create = \App\Categori::create($data);
            $say++;
        }

        echo $say . " tane kategori eklendi.";
    }

    public function downloadRemoteXml()
    {
        file_put_contents("downloaded.xml", fopen("http://www.marketpaketi.com/index.php?do=catalog/output&pCode=4356836254", 'r'));
        $this->updateStokAndAmount();
    }

    public function updateStokAndAmount()
    {
        $payload    = file_get_contents(url('/downloaded.xml'));
        $parser     = new Parser();
        $parsedData = $parser->xml($payload);

        //return $parsedData;
        $say = 0;
        foreach ($parsedData['item'] as $k => $v) {
            $urunVarMi = \App\Products::where('id', $v['id'])->first();
            if (count($urunVarMi) > 0) {
                $urunVarMi->stock = $v["stockAmount"];
                if ($v['rebate'] > 0) {
                    if ($v['rebateType'] == 1) {
                        $rebate        = $v['rebate'];
                        $discount_type = 1;
                        $finalPrice    = round($v['priceWithTax'] - (($v['priceWithTax'] * $v['rebate']) / 100), 3);
                    } else {
                        $finalPrice    = round($v['rebate'] * (1 + ($v['tax'] / 100)), 3);
                        $rebate        = $finalPrice;
                        $discount_type = 2;
                    }
                } else {
                    $discount_type = 0;
                    $finalPrice    = $v['priceWithTax'];
                    $rebate        = $v['rebate'];
                }

                $urunVarMi->discount      = $rebate;
                $urunVarMi->final_price   = $finalPrice;
                $urunVarMi->discount_type = $discount_type;
                $urunVarMi->price         = $v['priceWithTax'];
                $urunVarMi->save();
                /*
                if($v['id']=='201087'){
                dd($urunVarMi);
                }
                 */
                $say++;
            }
        }
        echo $say . " adet güncellendi.";
    }

    public function parseXmlProducts()
    {

        //dd(number_format(46.9994,2,',','.'));
        //die();
        //dd(round(39.82203*(1+(18/100)),2));
        //die();
        $payload    = file_get_contents(url('products-last-ek.xml'));
        $parser     = new Parser();
        $parsedData = $parser->xml($payload);

        return $parsedData;

        $say = 0;
        foreach ($parsedData['item'] as $k => $v) {
            //ürün varsa başka kategoride eklenmiş olabilir attach yapalım
            $urunVarMi = \App\Products::where('id', $v['id'])->first();

            if (count($urunVarMi) > 0) {
                //if(!empty($v['mainCategoryId'])){
                //    $urunVarMi->categori()->attach([$v['mainCategoryId']]);
                //}
                //if(!empty($v['categoryId'])){
                //    $urunVarMi->categori()->attach([$v['categoryId']]);
                //}
                //if(!empty($v['subCategoryId'])){
                //    $urunVarMi->categori()->attach([$v['subCategoryId']]);
                //}
                $seo = [
                    "seo_title"       => $v['title'][0],
                    "seo_keywords"    => $v['keywords'][0],
                    "seo_description" => $v['description'][0],
                ];

                $urunVarMi->seo = json_encode($seo);

                $urunVarMi->save();
                //dd($urunVarMi);
                //die();
                //exit();
                $say++;
            } else {
                $seo = [
                    "seo_title"       => $v['title'],
                    "seo_keywords"    => $v['keywords'],
                    "seo_description" => $v['description'],
                ];
                //indirim varsa
                if ($v['rebate'] > 0) {
                    $finalPrice    = round($v['rebate'] * (1 + ($v['tax'] / 100)), 3);
                    $rebate        = $finalPrice;
                    $discount_type = 2;
                } else {
                    $discount_type = 0;
                    $finalPrice    = $v['priceWithTax'];
                    $rebate        = $v['rebate'];
                }

                if (strlen($v['details']) > 65000) {
                    $detailsText = "";
                } else {
                    $detailsText = $v['details'];
                }

                $data = array(
                    "id"            => $v['id'],
                    "name"          => $v['label'],
                    "slug"          => str_slug($v['label']),
                    "brand_id"      => $v['brandId'],
                    "stock_code"    => $v['stockCode'],
                    "stock_type"    => 1,
                    "stock"         => $v["stockAmount"],
                    "barcode"       => $v['barcode'],
                    "price"         => $v['priceWithTax'],
                    "final_price"   => $finalPrice,
                    "tax_status"    => 1,
                    "tax"           => $v['tax'],
                    "discount_type" => $discount_type,
                    "discount"      => $rebate,
                    "content"       => $v['details'],
                    "seo"           => json_encode($seo),
                    "status"        => $v['status'],
                );
                $create = \App\Products::create($data);

                if (!empty($v['mainCategoryId'])) {
                    if (\App\Categori::find($v['mainCategoryId'])) {
                        $create->categori()->attach([$v['mainCategoryId']]);
                    }
                }
                if (!empty($v['categoryId'])) {
                    if (\App\Categori::find($v['categoryId'])) {
                        $create->categori()->attach([$v['categoryId']]);
                    }
                }
                if (!empty($v['subCategoryId'])) {
                    if (\App\Categori::find($v['subCategoryId'])) {
                        $create->categori()->attach([$v['subCategoryId']]);
                    }
                }

                //ürün kargo-desi bilgileri
                $shippingData = [
                    "pid"            => $create->id,
                    "desi"           => $v['dm3'],
                    "shipping_price" => 0,
                    "use_system"     => 1,
                ];
                \App\Products_shipping::create($shippingData);

                //image
                $images = [];

                if (!empty($v['picture1Path'])) {
                    $url       = $v['picture1Path'];
                    $microtime = explode(' ', str_replace('0.', null, microtime()));
                    $filename  = $create->slug . '-' . $microtime[0] . $microtime[1] . ".jpg";
                    $path      = public_path() . '/src/uploads/products/' . $create->id . "/" . $filename;
                    if (!file_exists(public_path() . '/src/uploads/products/' . $create->id)) {
                        mkdir(public_path() . '/src/uploads/products/' . $create->id, 0777, true);
                    }
                    file_put_contents($path, file_get_contents($url));
                    $images[1] = $filename;
                }
                if (!empty($v['picture2Path'])) {
                    $url       = $v['picture2Path'];
                    $microtime = explode(' ', str_replace('0.', null, microtime()));
                    $filename  = $create->slug . '-' . $microtime[0] . $microtime[1] . '2' . ".jpg";
                    $path      = public_path() . '/src/uploads/products/' . $create->id . "/" . $filename;
                    if (!file_exists(public_path() . '/src/uploads/products/' . $create->id)) {
                        mkdir(public_path() . '/src/uploads/products/' . $create->id, 0777, true);
                    }
                    file_put_contents($path, file_get_contents($url));
                    $images[2] = $filename;
                }
                if (!empty($v['picture3Path'])) {
                    $url       = $v['picture3Path'];
                    $microtime = explode(' ', str_replace('0.', null, microtime()));
                    $filename  = $create->slug . '-' . $microtime[0] . $microtime[1] . '3' . ".jpg";
                    $path      = public_path() . '/src/uploads/products/' . $create->id . "/" . $filename;
                    if (!file_exists(public_path() . '/src/uploads/products/' . $create->id)) {
                        mkdir(public_path() . '/src/uploads/products/' . $create->id, 0777, true);
                    }
                    file_put_contents($path, file_get_contents($url));
                    $images[3] = $filename;
                }
                if (!empty($v['picture4Path'])) {
                    $url       = $v['picture4Path'];
                    $microtime = explode(' ', str_replace('0.', null, microtime()));
                    $filename  = $create->slug . '-' . $microtime[0] . $microtime[1] . '4' . ".jpg";
                    $path      = public_path() . '/src/uploads/products/' . $create->id . "/" . $filename;
                    if (!file_exists(public_path() . '/src/uploads/products/' . $create->id)) {
                        mkdir(public_path() . '/src/uploads/products/' . $create->id, 0777, true);
                    }
                    file_put_contents($path, file_get_contents($url));
                    $images[4] = $filename;
                }
                if (!empty($v['picture5Path'])) {
                    $url       = $v['picture5Path'];
                    $microtime = explode(' ', str_replace('0.', null, microtime()));
                    $filename  = $create->slug . '-' . $microtime[0] . $microtime[1] . '5' . ".jpg";
                    $path      = public_path() . '/src/uploads/products/' . $create->id . "/" . $filename;
                    if (!file_exists(public_path() . '/src/uploads/products/' . $create->id)) {
                        mkdir(public_path() . '/src/uploads/products/' . $create->id, 0777, true);
                    }
                    file_put_contents($path, file_get_contents($url));
                    $images[5] = $filename;
                }
                /*
                if (!empty($v['picture6Path'])) {

                $url  = $v['picture6Path'];
                $microtime = explode(' ', str_replace('0.', null, microtime()));
                $filename = $create->slug.'-'.$microtime[0].$microtime[1].'6'.".jpg";
                $path = public_path().'/src/uploads/products/'.$create->id."/".$filename;
                if (!file_exists(public_path().'/src/uploads/products/'.$create->id)) {
                mkdir(public_path().'/src/uploads/products/'.$create->id, 0777, true);
                }
                file_put_contents($path, file_get_contents($url));
                $images[6]=$filename;

                }
                if (!empty($v['picture7Path'])) {

                $url  = $v['picture7Path'];
                $microtime = explode(' ', str_replace('0.', null, microtime()));
                $filename = $create->slug.'-'.$microtime[0].$microtime[1].'7'.".jpg";
                $path = public_path().'/src/uploads/products/'.$create->id."/".$filename;
                if (!file_exists(public_path().'/src/uploads/products/'.$create->id)) {
                mkdir(public_path().'/src/uploads/products/'.$create->id, 0777, true);
                }
                file_put_contents($path, file_get_contents($url));
                $images[7]=$filename;

                }
                if (!empty($v['picture8Path'])) {

                $url  = $v['picture8Path'];
                $microtime = explode(' ', str_replace('0.', null, microtime()));
                $filename = $create->slug.'-'.$microtime[0].$microtime[1].'8'.".jpg";
                $path = public_path().'/src/uploads/products/'.$create->id."/".$filename;
                if (!file_exists(public_path().'/src/uploads/products/'.$create->id)) {
                mkdir(public_path().'/src/uploads/products/'.$create->id, 0777, true);
                }
                file_put_contents($path, file_get_contents($url));
                $images[8]=$filename;

                }
                 */

                if (!empty($images)) {
                    $dataImg = ["pid" => $create->id, "images" => json_encode($images)];
                    $arr     = \App\productImage::create($dataImg);
                }

                $say++;
            }
            //dd($urunVarMi);
            //die();
            /*if () {
        # code...
        }*/
        }

        echo $say . " tane ürün eklendi.";
    }

    public function parseXmlMembers(Request $request)
    {
        $payload    = file_get_contents(url('members.xml'));
        $parser     = new Parser();
        $parsedData = $parser->xml($payload);
        //return $parsedData;
        $say = 0;

        foreach ($parsedData['item'] as $k => $v) {
            $uyeVarMi = \App\Member::where('id', $v['id'])->first();

            if (count($uyeVarMi) < 1) {
                $data = array(
                    "id"              => $v['id'],
                    "email"           => $v['email'],
                    "name"            => $v['firstname'],
                    "surname"         => $v['surname'],
                    "gender"          => $v['gender'] == 'Bay' ? 1 : 2,
                    "bday"            => $v['birthDate'],
                    "phone"           => $v['phone'],
                    "phoneGsm"        => $v['cell'],
                    "company"         => $v['cName'],
                    "tax_office"      => $v['taxPlace'],
                    "tax_number"      => $v['taxId'],
                    "group_id"        => $v['membergroup'] == 'Üyeler' ? 1 : 2,
                    "allowed_to_mail" => 1,
                    "status"          => 1,
                    "created_at"      => $v['regDate'],
                    "points"          => $v['currentPoints'],
                    "password"        => bcrypt(123456),
                );

                $create = \App\Member::create($data);

                if ($create) {
                    $dataAddress = [
                        "member_id"    => $create->id,
                        "countries_id" => 1,
                        "cities_id"    => $v["city"] == "Ankara" ? 6 : 34,
                        "districts_id" => null,
                        "address"      => $v["address"],
                        "postal_code"  => $v["zipcode"],
                    ];
                    \App\MemberAddress::create($dataAddress);
                }
                $say++;
            }
        }

        echo $say . " tane üye eklendi.";
    }

    // ı karakteri için türkçe karakter sorununu giderir.
    // $newSearchValues = [];
    // collect($searchValues)->map(function ($item) use (&$newSearchValues, $searchValues) {
    //     $replaced          = str_replace('ı', '_', mb_substr($item, 0, 1, "UTF-8")) . mb_substr($item, 1, strlen($item), "UTF-8");
    //     $newSearchValues[] = mb_substr($replaced, 0, 1, "UTF-8") . str_replace(['I', 'İ', 'i'], ['_', '_', '_'], mb_substr($replaced, 1, strlen($item), "UTF-8"));
    // });

    public function defaultSearch(Request $request)
    {

        $term = str_replace(['ı', 'i'], ['_', '_'], mb_convert_case($request->get('q'), MB_CASE_LOWER));

        $products = Products::where('status', 1);

        $products->search($term, 5);

        // $searchValues = preg_split('/\s+/', $request->get('q'), -1, PREG_SPLIT_NO_EMPTY);

        // $searchValues = collect($searchValues)->map(function ($item){
        //     return str_replace(['ı', 'i'], ['_', '_'], mb_convert_case($item, MB_CASE_LOWER));
        // });

        // $products->where(function ($query) use ($searchValues, $request) {
        //     foreach ($searchValues as $value) {
        //         $query->WhereRaw("lower(name) LIKE ?", ["%" . $value . "%"]);
        //     }
        //     $query->orWhere('barcode', '=', $request->get('q'));
        //     $query->orWhere('stock_code', 'like', "%{$request->get('q')}%");
        // });

        //$products->orWhere('barcode', '=', $request->get('q'));
        //$products->orWhere('stock_code', 'like', "%{$request->get('q')}%");

        $products->orderByRaw("FIELD(stock , '0') asc");

        if ($request->get("siralama")) {
            if ($request->get("siralama") == "artanfiyat") {
                $products->orderBy('final_price', 'asc');
            } elseif ($request->get("siralama") == "azalanfiyat") {
                $products->orderBy('final_price', 'desc');
            }
        } else {
            $products->orderBy('created_at', 'desc');
        }

        $products->where('status', "=", 1);

        $categories = array();
        $brands     = array();

        foreach ($products->where('status', "=", 1)->take(3000)->get() as $value) {

            if (strstr($request->get('filtreler'), 'stokhepsi')) {
                array_push($categories, array('id' => $value->categorisearch[0]->id, 'title' => $value->categorisearch[0]->title, 'slug' => $value->categorisearch[0]->slug));
                if (!empty($value->brand)) {
                    array_push($brands, array('id' => $value->brand->id, 'name' => $value->brand->name, 'slug' => $value->brand->slug, 'code' => $value->brand->code));
                }
            } else {
                if ($value->stock != 0) {
                    array_push($categories, array('id' => $value->categorisearch[0]->id, 'title' => $value->categorisearch[0]->title, 'slug' => $value->categorisearch[0]->slug));
                    if (!empty($value->brand)) {
                        array_push($brands, array('id' => $value->brand->id, 'name' => $value->brand->name, 'slug' => $value->brand->slug, 'code' => $value->brand->code));
                    }
                }
            }
        }

        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $filtreler = 'stokhepsi';
            $products->where('stock', ">=", 0);
        } else {
            $filtreler = '';
            $products->where('stock', "!=", 0);
        }

        $results = $products->paginate(16);

        if ($request->get("siralama")) {
            $results->appends(['siralama' => $request->get("siralama")])->render();
        }
        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $results->appends(['filtreler' => strstr($request->get('filtreler'), 'stokhepsi')])->render();
        } else {
            $filtreler = '';
        }

        $results->appends(['q' => $request->get("q")])->render();
        $q               = $request->get("q");
        $link            = str_replace(' ', '+', $request->get('q'));
        $count           = $results->total();
        $newcategories   = self::unique_multidim_array($categories, 'id');
        $brandsProdCount = self::unique_multidim_array($brands, 'id');

        return view('frontEnd.blades.searchDefault', compact('results', 'q', 'count', 'newcategories', 'brandsProdCount', 'link', 'filtreler', 'testdrv'));
    }

    public function testDefaultSearch(Request $request)
    {
        $products = \App\Products::where('status', 1);

        $searchValues = preg_split('/\s+/', $request->get('q'), -1, PREG_SPLIT_NO_EMPTY);

        // ı karakteri için türkçe karakter sorununu giderir.
        $newSearchValues = [];
        collect($searchValues)->map(function ($item) use (&$newSearchValues, $searchValues) {
            $replaced          = str_replace('ı', '_', mb_substr($item, 0, 1, "UTF-8")) . mb_substr($item, 1, strlen($item), "UTF-8");
            $newSearchValues[] = mb_substr($replaced, 0, 1, "UTF-8") . str_replace(['I', 'İ', 'i'], ['_', '_', '_'], mb_substr($replaced, 1, strlen($item), "UTF-8"));
        });

        $searchValues = $newSearchValues;

        $products->where(function ($query) use ($searchValues, $request) {
            foreach ($searchValues as $value) {
                $query->WhereRaw("lower(name) LIKE ?", ["%" . $value . "%"]);
                // $query->Where('name', 'like', "%{$value}%");
            }
            $query->orWhere('barcode', '=', $request->get('q'));
            $query->orWhere('stock_code', 'like', "%{$request->get('q')}%");
        });

        //$products->orWhere('barcode', '=', $request->get('q'));
        //$products->orWhere('stock_code', 'like', "%{$request->get('q')}%");

        $products->orderByRaw("FIELD(stock , '0') asc");

        if ($request->get("siralama")) {
            if ($request->get("siralama") == "artanfiyat") {
                $products->orderBy('final_price', 'asc');
            } elseif ($request->get("siralama") == "azalanfiyat") {
                $products->orderBy('final_price', 'desc');
            }
        } else {
            $products->orderBy('created_at', 'desc');
        }

        $products->where('status', "=", 1);

        $categories = array();
        $brands     = array();

        foreach ($products->where('status', "=", 1)->take(3000)->get() as $value) {

            if (strstr($request->get('filtreler'), 'stokhepsi')) {
                array_push($categories, array('id' => $value->categorisearch[0]->id, 'title' => $value->categorisearch[0]->title, 'slug' => $value->categorisearch[0]->slug));
                if (!empty($value->brand)) {
                    array_push($brands, array('id' => $value->brand->id, 'name' => $value->brand->name, 'slug' => $value->brand->slug, 'code' => $value->brand->code));
                }
            } else {
                if ($value->stock != 0) {
                    array_push($categories, array('id' => $value->categorisearch[0]->id, 'title' => $value->categorisearch[0]->title, 'slug' => $value->categorisearch[0]->slug));
                    if (!empty($value->brand)) {
                        array_push($brands, array('id' => $value->brand->id, 'name' => $value->brand->name, 'slug' => $value->brand->slug, 'code' => $value->brand->code));
                    }
                }
            }
        }

        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $filtreler = 'stokhepsi';
            $products->where('stock', ">=", 0);
        } else {
            $filtreler = '';
            $products->where('stock', "!=", 0);
        }

        $results = $products->paginate(16);

        if ($request->get("siralama")) {
            $results->appends(['siralama' => $request->get("siralama")])->render();
        }
        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $results->appends(['filtreler' => strstr($request->get('filtreler'), 'stokhepsi')])->render();
        } else {
            $filtreler = '';
        }

        $results->appends(['q' => $request->get("q")])->render();
        $q               = $request->get("q");
        $link            = str_replace(' ', '+', $request->get('q'));
        $count           = $results->total();
        $newcategories   = self::unique_multidim_array($categories, 'id');
        $brandsProdCount = self::unique_multidim_array($brands, 'id');

        return view('frontEnd.blades.searchTest', compact('results', 'q', 'count', 'newcategories', 'brandsProdCount', 'link', 'filtreler', 'testdrv'));
    }

    public function testsearchbrand($brand, Request $request)
    {

        $products = \App\Products::where('status', 1);

        $searchValues = preg_split('/\s+/', $request->get('q'), -1, PREG_SPLIT_NO_EMPTY);
        $brands       = explode('+', $brand);
        $brands       = str_replace('c-', '', $brands);
        // ı karakteri için türkçe karakter sorununu giderir.
        $newSearchValues = [];
        collect($searchValues)->map(function ($item) use (&$newSearchValues, $searchValues) {
            $replaced          = str_replace('ı', '_', mb_substr($item, 0, 1, "UTF-8")) . mb_substr($item, 1, strlen($item), "UTF-8");
            $newSearchValues[] = mb_substr($replaced, 0, 1, "UTF-8") . str_replace(['I', 'İ', 'i'], ['_', '_', '_'], mb_substr($replaced, 1, strlen($item), "UTF-8"));
        });

        $searchValues = $newSearchValues;

        $products->where(function ($query) use ($searchValues, $request) {
            foreach ($searchValues as $value) {
                $query->WhereRaw("lower(name) LIKE ?", ["%" . $value . "%"]);
                // $query->Where('name', 'like', "%{$value}%");
            }
            $query->orWhere('barcode', '=', $request->get('q'));
            $query->orWhere('stock_code', 'like', "%{$request->get('q')}%");
        });

        //$products->orWhere('barcode', '=', $request->get('q'));
        //$products->orWhere('stock_code', 'like', "%{$request->get('q')}%");

        $products->orderByRaw("FIELD(stock , '0') asc");

        if ($request->get("siralama")) {
            if ($request->get("siralama") == "artanfiyat") {
                $products->orderBy('final_price', 'asc');
            } elseif ($request->get("siralama") == "azalanfiyat") {
                $products->orderBy('final_price', 'desc');
            }
        } else {
            $products->orderBy('created_at', 'desc');
        }

        $products->where(function ($query) use ($brands, $request) {
            foreach ($brands as $value) {
                $brand = \App\Brand::where('slug', '=', $value)->first();

                $query->where('brand_id', '=', $brand->id);
            }
        });

        $products->where('status', "=", 1);

        $categories      = array();
        $childcategories = array();
        $brands          = array();
        foreach ($products->where('status', "=", 1)->take(3000)->get() as $value) {
            array_push($categories, array('id' => $value->categorisearch[0]->id, 'title' => $value->categorisearch[0]->title, 'slug' => $value->categorisearch[0]->slug));
            if (!empty($value->brand)) {
                array_push($brands, array('id' => $value->brand->id, 'name' => $value->brand->name, 'slug' => $value->brand->slug, 'code' => $value->brand->code));
            }
        }

        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $filtreler = 'stokhepsi';
            $products->where('stock', ">=", 0);
        } else {
            $filtreler = '';
            $products->where('stock', "!=", 0);
        }

        $results = $products->paginate(16);

        if ($request->get("siralama")) {
            $results->appends(['siralama' => $request->get("siralama")])->render();
        }

        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $results->appends(['filtreler' => strstr($request->get('filtreler'), 'stokhepsi')])->render();
        } else {
            $filtreler = '';
        }

        $results->appends(['q' => $request->get("q")])->render();

        $q               = $request->get("q");
        $link            = str_replace(' ', '+', $request->get('q'));
        $count           = $results->total();
        $newcategories   = self::unique_multidim_array($categories, 'id');
        $brandsProdCount = self::unique_multidim_array($brands, 'id');
        return view('frontEnd.blades.searchDefault', compact('results', 'q', 'count', 'newcategories', 'link', 'brandsProdCount', 'filtreler'));
    }
    public function testsearchcategory($category, Request $request)
    {
        $products = \App\Products::where('status', 1);

        $searchValues = preg_split('/\s+/', $request->get('q'), -1, PREG_SPLIT_NO_EMPTY);

        // ı karakteri için türkçe karakter sorununu giderir.
        $newSearchValues = [];
        collect($searchValues)->map(function ($item) use (&$newSearchValues, $searchValues) {
            $replaced          = str_replace('ı', '_', mb_substr($item, 0, 1, "UTF-8")) . mb_substr($item, 1, strlen($item), "UTF-8");
            $newSearchValues[] = mb_substr($replaced, 0, 1, "UTF-8") . str_replace(['I', 'İ', 'i'], ['_', '_', '_'], mb_substr($replaced, 1, strlen($item), "UTF-8"));
        });

        $searchValues = $newSearchValues;

        $products->where(function ($query) use ($searchValues, $request) {
            foreach ($searchValues as $value) {
                $query->WhereRaw("lower(name) LIKE ?", ["%" . $value . "%"]);
                // $query->Where('name', 'like', "%{$value}%");
            }
            $query->orWhere('barcode', '=', $request->get('q'));
            $query->orWhere('stock_code', 'like', "%{$request->get('q')}%");
        });

        //$products->orWhere('barcode', '=', $request->get('q'));
        //$products->orWhere('stock_code', 'like', "%{$request->get('q')}%");

        $products->orderByRaw("FIELD(stock , '0') asc");

        if ($request->get("siralama")) {
            if ($request->get("siralama") == "artanfiyat") {
                $products->orderBy('final_price', 'asc');
            } elseif ($request->get("siralama") == "azalanfiyat") {
                $products->orderBy('final_price', 'desc');
            }
        } else {
            $products->orderBy('created_at', 'desc');
        }

        $products->whereHas('categorisearch', function ($q) use ($category) {
            $q->where('slug', $category);
        });

        $products->where('status', "=", 1);

        $categories      = array();
        $childcategories = array();
        $brands          = array();
        foreach ($products->get() as $value) {
            if (strstr($request->get('filtreler'), 'stokhepsi')) {
                array_push($categories, array('id' => $value->categorisearch[0]->id, 'title' => $value->categorisearch[0]->title, 'slug' => $value->categorisearch[0]->slug));
                if (!empty($value->categorisearch[1])) {
                    array_push($childcategories, array('id' => $value->categorisearch[1]->id, 'title' => $value->categorisearch[1]->title, 'slug' => $value->categorisearch[1]->slug));
                }
                if (!empty($value->brand)) {
                    array_push($brands, array('id' => $value->brand->id, 'name' => $value->brand->name, 'slug' => $value->brand->slug, 'code' => $value->brand->code));
                }
            } else {
                if ($value->stock != 0) {
                    array_push($categories, array('id' => $value->categorisearch[0]->id, 'title' => $value->categorisearch[0]->title, 'slug' => $value->categorisearch[0]->slug));
                    if (!empty($value->categorisearch[1])) {
                        array_push($childcategories, array('id' => $value->categorisearch[1]->id, 'title' => $value->categorisearch[1]->title, 'slug' => $value->categorisearch[1]->slug));
                    }
                    if (!empty($value->brand)) {
                        array_push($brands, array('id' => $value->brand->id, 'name' => $value->brand->name, 'slug' => $value->brand->slug, 'code' => $value->brand->code));
                    }
                }
            }
        }
        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $filtreler = 'stokhepsi';
            $products->where('stock', ">=", 0);
        } else {
            $filtreler = '';
            $products->where('stock', "!=", 0);
        }

        $results = $products->paginate(16);

        if ($request->get("siralama")) {
            $results->appends(['siralama' => $request->get("siralama")])->render();
        }

        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $results->appends(['filtreler' => strstr($request->get('filtreler'), 'stokhepsi')])->render();
        } else {
            $filtreler = '';
        }
        $results->appends(['q' => $request->get("q")])->render();

        $q               = $request->get("q");
        $link            = str_replace(' ', '+', $request->get('q'));
        $count           = $results->total();
        $newcategories   = self::unique_multidim_array($childcategories, 'id');
        $brandsProdCount = self::unique_multidim_array($brands, 'id');
        $catname         = \App\Categori::where('slug', '=', $category)->first();
        return view('frontEnd.blades.searchDefault', compact(
            'results', 'q', 'count', 'newcategories', 'link', 'catname', 'filtreler', 'brandsProdCount'
        ));
    }

    public function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i          = 0;
        $key_array  = array();
        $temp_test  = $array;
        if (!empty($array)) {
            foreach ($array as $val) {

                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i]           = $val[$key];
                    $temp_array[$i]          = $val;
                    $temp_array[$i]['count'] = array_count_values(array_column($temp_test, 'id'))[$val[$key]];
                }

                $i++;
            }
        }
        return $temp_array;
    }
    public function elasticSearch(Request $request)
    {
        //dd($request->all());
        $client = ClientBuilder::create()->build();

        $per_page = 24;

        $currentPage = $request->get('page', 1);

        $from = ($request->get('page', 1) - 1) * $per_page;

        $params = [
            'index' => 'catalogeko',
            'type'  => 'products',
            'size'  => $per_page,
            'from'  => $from,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query'    => $request->get('q'),
                        'type'     => 'cross_fields',
                        'fields'   => ['name', 'barcode'],
                        'operator' => 'and',
                        //'fuzziness'=>1
                    ],
                ],
                'sort'  => [
                    ["stock" => ["order" => "desc"]],
                    ["discount_type" => ["order" => "asc"]],
                ],
            ],
        ];

        $results = $client->search($params);

        $count = $results["hits"]["total"];

        $results = new LengthAwarePaginator($results["hits"]["hits"], $results["hits"]["total"], $per_page, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath()]);

        $results->appends(['q' => $request->get("q")])->render();

        $q = $request->get('q');

        return view('frontEnd.blades.search', compact('results', 'q', 'count'));

        dd($results);
    }

    public function elasticTest()
    {
        $client = ClientBuilder::create()->build();

        $total = \App\Products::count(); //15417;//\App\Products::count();//411;//
        //dd($total);

        $products = \App\Products::select(['id', 'barcode', 'name', 'slug', 'discount', 'discount_type', 'stock', 'stock_type', 'price', 'final_price'])->limit($total)->offset(0)->get();

        //dd($products);

        //dd($total);

        $params = ['body' => []];
        /*
        $myTypeMapping = [
        'properties' => [
        'final_price' => [
        'type' => 'long',
        'analyzer' => 'standard'
        ]
        ]
        ];
         */
        //$params['body']['mappings']['products'] = $myTypeMapping;

        for ($i = 0; $i < $total; $i++) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'catalogeko',
                    '_type'  => 'products',
                    '_id'    => $products[$i]->id,
                ],
            ];

            $params['body'][] = $products[$i]->toArray();

            // Every 1000 documents stop and send the bulk request
            if ($i % 10 == 0) {
                $responses = $client->bulk($params);

                // erase the old bulk request
                $params = ['body' => []];

                // unset the bulk response when you are done to save memory
                unset($responses);
            }
        }

        if (!empty($params['body'])) {
            $responses = $client->bulk($params);
        }

        return $responses;

        /*
    $params = [
    'index' => 'catalog',
    'type' => 'products',
    'id' => 'my_id',
    'body' => ['testField' => 'abc']
    ];

    $response = $client->index($params);
    print_r($response);

    echo "<pre>";

    var_dump($responses);

    echo "</pre>";
     */
    }

    public function elasticDelete()
    {
        $client   = ClientBuilder::create()->build();
        $params   = ['index' => 'catalogeko'];
        $response = $client->indices()->delete($params);
        dd($response);
    }

    public function categoryStatusCheck($categoryId)
    {
        $categories = Cache::remember('category_status_check.' . $categoryId, 10, function () use ($categoryId) {
            return collect($this->recursiveCategoryStatusCheck($categoryId));
        });

        $check = true;

        foreach ($categories as $category) {
            if (!$category) {
                $check = false;
            }
        }

        return $check;
    }

    public function recursiveCategoryStatusCheck($categoryId)
    {
        $category = \App\Categori::find($categoryId);

        if (!$category) {
            return array(false);
        }

        $status    = boolval($category->status);
        $allStatus = array($category->slug => $status);

        if ($category->parent_id != 0) {
            $parentStatus = $this->recursiveCategoryStatusCheck($category->parent_id);
            $allStatus    = array_merge($allStatus, $parentStatus);
        }

        return $allStatus;
    }

    public function index(Request $request)
    {
        //dd(Auth::guard('members'));
        // DB::connection()->enableQueryLog();

        //dd($request->slug);
        //$url   = parse_url($request->slug, PHP_URL_PATH);

        if (substr_count($request->slug, '-c-') > 0 && substr_count($request->slug, '-p-')) {
            if (strripos($request->slug, '-c-') > strripos($request->slug, '-p-')) {
                //slug içerisinde geçen son -c- mi buyuk -p- mi yani ürün mü kategori mi
                //kategori büyükse
                @$exUrl = explode("-", $request->slug);
                @$id    = substr(strrchr($request->slug, "-c-"), 1);
                @$route = "c";
                @$slug  = str_replace($exUrl[count($exUrl) - 1], "", str_replace("-c-", "", $request->slug));
            } else {
                @$exUrl = explode("-", $request->slug);
                @$id    = substr(strrchr($request->slug, "-p-"), 1);
                @$route = "p";
                @$slug  = str_replace($exUrl[count($exUrl) - 1], "", str_replace("-p-", "", $request->slug));
            }
        } elseif (substr_count($request->slug, '-c-') > 0) {
            @$exUrl = explode("-", $request->slug);
            @$id    = $exUrl[count($exUrl) - 1];
            @$route = $exUrl[count($exUrl) - 2];
            @$slug  = str_replace($exUrl[count($exUrl) - 1], "", str_replace("-c-", "", $request->slug));
        } elseif (substr_count($request->slug, '-p-') > 0) {
            @$exUrl = explode("-", $request->slug);
            @$id    = substr(strrchr($request->slug, "-p-"), 1); //$exUrl[count($exUrl)-1];
            @$route = "p"; //$exUrl[count($exUrl)-2];
            @$pos   = strripos($request->slug, "-p-");
            @$slug  = str_replace($exUrl[count($exUrl) - 1], "", substr_replace($request->slug, "", $pos, strlen("-p-")));
        } else {
            $id     = null;
            @$route = 'b';
        }

        if (!is_numeric($id) && $route != "b") {
            return abort(404);
        }

        switch ($route) {
            case 'b':
                $brandSlug = $request->slug;
                $brand     = Cache::remember('brand-' . $request->slug, 1, function () use ($brandSlug) {
                    return \App\Brand::where('slug', $brandSlug)->first();
                });
                if ($brand) {
                    $currentFilters = [];
                    //dd($brand->allProducts);
                    if ($request->get('filtreler')) {
                        $filtreler    = explode(",", $request->get('filtreler'));
                        $filterText   = $request->get('filtreler');
                        $allfilterIds = [];
                    } else {
                        $filtreler    = [];
                        $allfilterIds = [];
                        $filterText   = "";
                    }

                    $priceFilterCounts = [];
                    if ($request->get('fiyat')) {
                        $filterPrice = $request->get('fiyat');
                    } else {
                        $filterPrice = "";
                    }

                    if ($request->get('siralama')) {
                        $sort = $request->get('siralama');
                    } else {
                        $sort = "";
                    }
                    $page = $request->input('page', '1');
                    if (strstr($request->get('filtreler'), 'stokhepsi')) {
                        $pro = Cache::remember('pro' . $brandSlug . '_' . $filterText . $filterPrice . $sort . $page, 1, function () use ($brand, $filtreler, $allfilterIds, $request) {
                            $aaa = \App\Products::where('products.brand_id', '=', $brand->id)->with('images', 'brand');

                            $allfilterIds = $this->allfilterIds($filtreler);

                            if (!empty($allfilterIds)) {
                                //$aaa->whereIn('id',$allfilterIds);
                                $aaa->where(function ($query) use ($allfilterIds, $filtreler) {
                                    $query->whereIn('products.id', $allfilterIds);
                                    if (in_array("indirimli", $filtreler)) {
                                        $query->orWhere('discount_type', '>', 0);
                                    }
                                });
                            } else {
                                if (in_array("indirimli", $filtreler)) {
                                    $aaa->Where('discount_type', '>', 0);
                                }
                            }

                            if ($request->get('fiyat')) {
                                $expPriceFilter = explode("-", $request->get('fiyat'));
                                $aaa->whereBetween('final_price', [$expPriceFilter[0], $expPriceFilter[1]]);
                            }

                            $aaa->leftJoin('brand_sorts', function ($join) use ($brand) {
                                $join->on('brand_sorts.product_id', '=', 'products.id')->where('brand_sorts.brand_id', '=', $brand->id);
                            });

                            $aaa->select('products.*', DB::raw('IF(`sort` IS NOT NULL, `sort`, 1000000) `sort`'), 'brand_sorts.sort', 'brand_sorts.product_id', 'brand_sorts.brand_id');

                            if ($request->get("siralama")) {
                                if ($request->get("siralama") == "artanfiyat") {
                                    $aaa->orderBy('final_price', 'asc');
                                } elseif ($request->get("siralama") == "azalanfiyat") {
                                    $aaa->orderBy('final_price', 'desc');
                                }
                            } else {
                                $aaa->orderByRaw("FIELD(stock , '0') asc");
                                $aaa->orderBy('sort', 'asc');
                                $aaa->orderBy('created_at', 'desc');
                            }

                            return $aaa->where('status', 1)->paginate(24);
                        });
                    } else {
                        $pro = Cache::remember('pro' . $brandSlug . '_' . $filterText . $filterPrice . $sort . $page, 1, function () use ($brand, $filtreler, $allfilterIds, $request) {
                            $aaa = \App\Products::where('products.brand_id', '=', $brand->id)->where('products.stock', '!=', '0')->with('images', 'brand');

                            $allfilterIds = $this->allfilterIds($filtreler);

                            if (!empty($allfilterIds)) {
                                //$aaa->whereIn('id',$allfilterIds);
                                $aaa->where(function ($query) use ($allfilterIds, $filtreler) {
                                    $query->whereIn('products.id', $allfilterIds);
                                    if (in_array("indirimli", $filtreler)) {
                                        $query->orWhere('discount_type', '>', 0);
                                    }
                                });
                            } else {
                                if (in_array("indirimli", $filtreler)) {
                                    $aaa->Where('discount_type', '>', 0);
                                }
                            }

                            if ($request->get('fiyat')) {
                                $expPriceFilter = explode("-", $request->get('fiyat'));
                                $aaa->whereBetween('final_price', [$expPriceFilter[0], $expPriceFilter[1]]);
                            }

                            $aaa->leftJoin('brand_sorts', function ($join) use ($brand) {
                                $join->on('brand_sorts.product_id', '=', 'products.id')->where('brand_sorts.brand_id', '=', $brand->id);
                            });

                            $aaa->select('products.*', DB::raw('IF(`sort` IS NOT NULL, `sort`, 1000000) `sort`'), 'brand_sorts.sort', 'brand_sorts.product_id', 'brand_sorts.brand_id');

                            if ($request->get("siralama")) {
                                if ($request->get("siralama") == "artanfiyat") {
                                    $aaa->orderBy('final_price', 'asc');
                                } elseif ($request->get("siralama") == "azalanfiyat") {
                                    $aaa->orderBy('final_price', 'desc');
                                }
                            } else {
                                $aaa->orderByRaw("FIELD(stock , '0') asc");
                                $aaa->orderBy('sort', 'asc');
                                $aaa->orderBy('created_at', 'desc');
                            }

                            return $aaa->where('status', 1)->paginate(24);
                        });
                    }

                    //price filter counts
                    if (!$request->get('fiyat')) {
                        $arr          = ["0.0", "10.0", "20.0", "40.0", "100.0", "200.0", "500.0", "1000.0"];
                        $allfilterIds = $this->allfilterIds($filtreler);
                        for ($i = 0; $i < count($arr) - 2; $i++) {
                            $ttl = \App\Products::where('brand_id', $brand->id)
                                ->where('final_price', '>', $arr[$i])
                                ->where('final_price', '<', $arr[$i + 1]);

                            if (!empty($allfilterIds)) {
                                $ttl->where(function ($query) use ($allfilterIds, $filtreler) {
                                    $query->whereIn('id', $allfilterIds);
                                    if (in_array("indirimli", $filtreler)) {
                                        $query->orWhere('discount_type', '>', 0);
                                    }
                                });
                            } else {
                                if (in_array("indirimli", $filtreler)) {
                                    $ttl->Where('discount_type', '>', 0);
                                }
                            }

                            $ttl = $ttl->count();

                            if ($ttl > 0) {
                                $priceFilterCounts[] = [
                                    "k1" => $arr[$i] . "-" . $arr[$i + 1],
                                    "k2" => $ttl,
                                    "k3" => $i == 6 ? "500 TL üzerinde" : intval($arr[$i]) . " TL - " . intval($arr[$i + 1]) . " TL",
                                ];
                            }
                        }
                    }

                    $myProduct = new Product();
                    $myPrice   = new Price();

                    if (!empty($filterText)) {
                        $pro->appends(['filtreler' => $filterText])->render();
                    }
                    if ($request->get('siralama')) {
                        $pro->appends(['siralama' => $sort])->render();
                    }
                    if (!empty($filterPrice)) {
                        $pro->appends(['fiyat' => $filterPrice])->render();
                        $currentFilters["Fiyat"] = intval(explode("-", $filterPrice)[0]) . " TL - " . intval(explode("-", $filterPrice)[1]) . " TL";
                    }

                    $breadCrump = $brand;
                    return view('frontEnd.blades.brandProducts', ['brand' => $brand, 'pro' => $pro, 'myProduct' => $myProduct, 'myPrice' => $myPrice, "filtreler" => $filtreler, "currentFilters" => $currentFilters, "priceFilterCounts" => $priceFilterCounts]);
                    break;
                } else {
                    return abort(404);
                    break;
                }
                break;
            case "c":
                // DB::connection()->enableQueryLog();

                $cat = $this->getCategori($id);

                // if (isOffice()) {
                //     dump($cat);
                // }

                if ($cat) {

                    $parentStatusCheck = $this->categoryStatusCheck($id);

                    // Eğer üst kategorilerinden herhangi birisi PASİF ise anasayfaya yönlendir.
                    if (!$parentStatusCheck) {
                        return redirect('/');
                    }

                    //kategori urli doğru mu?
                    if ($cat->slug != $slug) {
                        return Redirect::to('/' . $cat->slug . '-c-' . $cat->id, 301);
                    }

                    $currentFilters = [];
                    if ($request->get('filtreler')) {
                        $filtreler    = explode(",", $request->get('filtreler'));
                        $filterText   = $request->get('filtreler');
                        $allfilterIds = [];
                    } else {
                        $filtreler    = [];
                        $allfilterIds = [];
                        $filterText   = "";
                    }
                    $priceFilterCounts = [];
                    if ($request->get('fiyat')) {
                        $filterPrice = $request->get('fiyat');
                    } else {
                        $filterPrice = "";
                    }

                    if ($request->get('siralama')) {
                        $sort = $request->get('siralama');
                    } else {
                        $sort = "";
                    }

                    $request->request->add(['category_id' => $id]);
                    /* Markaların ürün countları */

                    $brandsProdCount = \App\Products::select('products.brand_id', 'brands.name', 'brands.slug', DB::raw('count(*) as count'))
                        ->where('products.status', '1')
                        ->whereHas('categori', function ($query) use ($id) {
                            $query->where('product_to_cat.cid', $id);
                        })
                        ->join('brands', 'products.brand_id', '=', 'brands.id')
                        ->groupBy('brand_id')
                        ->orderBy('count', 'desc')->get();

                    $breadCrump = $this->categoryBreadCrump($cat->parent_id);

                    $page = $request->input('page', '1');
                    if (strstr($request->get('filtreler'), 'stokhepsi')) {
                        $pro = Cache::remember('pro' . $id . '_' . $filterText . $filterPrice . $sort . $page, 1, function () use ($cat, $filtreler, $allfilterIds, $request) {
                            $aaa = \App\Products::where('products.status', '1')->whereHas('categori', function ($query) use ($cat) {
                                $query->where('product_to_cat.cid', $cat->id);
                            })->with('images', 'brand');

                            $allfilterIds = $this->allfilterIds($filtreler);

                            if (!empty($allfilterIds)) {
                                //$aaa->whereIn('id',$allfilterIds);
                                $aaa->where(function ($query) use ($allfilterIds, $filtreler) {
                                    $query->whereIn('products.id', $allfilterIds);
                                    if (in_array("indirimli", $filtreler)) {
                                        $query->orWhere('discount_type', '>', 0);
                                    }
                                });
                            } else {
                                if (in_array("indirimli", $filtreler)) {
                                    $aaa->Where('discount_type', '>', 0);
                                }
                            }

                            if ($request->get('fiyat')) {
                                $expPriceFilter = explode("-", $request->get('fiyat'));
                                $aaa->whereBetween('final_price', [$expPriceFilter[0], $expPriceFilter[1]]);
                            }

                            $aaa->leftJoin('category_sorts', function ($join) use ($cat) {
                                $join->on('category_sorts.product_id', '=', 'products.id')->where('category_sorts.category_id', '=', $cat->id);
                            });

                            $aaa->select('products.*', DB::raw('IF(`sort` IS NOT NULL, `sort`, 1000000) `sort`'), 'category_sorts.sort', 'category_sorts.product_id', 'category_sorts.category_id');

                            if ($request->get("siralama")) {
                                if ($request->get("siralama") == "artanfiyat") {
                                    $aaa->orderBy('final_price', 'asc');
                                } elseif ($request->get("siralama") == "azalanfiyat") {
                                    $aaa->orderBy('final_price', 'desc');
                                }
                            } else {
                                $aaa->orderByRaw("FIELD(stock , '0') asc");
                                $aaa->orderBy('sort', 'asc');
                                $aaa->orderBy('created_at', 'desc');
                            }
                            return $aaa->paginate(24);
                        });
                    } else {
                        $pro = Cache::remember('pro' . $id . '_' . $filterText . $filterPrice . $sort . $page, 1, function () use ($cat, $filtreler, $allfilterIds, $request) {
                            $aaa = \App\Products::where('products.status', '1')->where('products.stock', '!=', '0')->whereHas('categori', function ($query) use ($cat) {
                                $query->where('product_to_cat.cid', $cat->id);
                            })->with('images', 'brand');

                            $allfilterIds = $this->allfilterIds($filtreler);

                            if (!empty($allfilterIds)) {
                                //$aaa->whereIn('id',$allfilterIds);
                                $aaa->where(function ($query) use ($allfilterIds, $filtreler) {
                                    $query->whereIn('products.id', $allfilterIds);
                                    if (in_array("indirimli", $filtreler)) {
                                        $query->orWhere('discount_type', '>', 0);
                                    }
                                });
                            } else {
                                if (in_array("indirimli", $filtreler)) {
                                    $aaa->Where('discount_type', '>', 0);
                                }
                            }

                            if ($request->get('fiyat')) {
                                $expPriceFilter = explode("-", $request->get('fiyat'));
                                $aaa->whereBetween('final_price', [$expPriceFilter[0], $expPriceFilter[1]]);
                            }

                            $aaa->leftJoin('category_sorts', function ($join) use ($cat) {
                                $join->on('category_sorts.product_id', '=', 'products.id')->where('category_sorts.category_id', '=', $cat->id);
                            });

                            $aaa->select('products.*', DB::raw('IF(`sort` IS NOT NULL, `sort`, 1000000) `sort`'), 'category_sorts.sort', 'category_sorts.product_id', 'category_sorts.category_id');

                            if ($request->get("siralama")) {
                                if ($request->get("siralama") == "artanfiyat") {
                                    $aaa->orderBy('final_price', 'asc');
                                } elseif ($request->get("siralama") == "azalanfiyat") {
                                    $aaa->orderBy('final_price', 'desc');
                                }
                            } else {
                                $aaa->orderByRaw("FIELD(stock , '0') asc");
                                $aaa->orderBy('sort', 'asc');
                                $aaa->orderBy('created_at', 'desc');
                            }
                            return $aaa->paginate(24);
                        });
                    }

                    if ($request->get('fiyat')) {
                        $allProIds = $cat->pros->filter(function ($value, $key) use ($request) {
                            return $value->final_price > explode("-", $request->get('fiyat'))[0] && $value->final_price < explode("-", $request->get('fiyat'))[1];
                        })->pluck("id")->toArray();
                    } else {
                        $allProIds = $cat->pros()->pluck("id")->toArray();
                    }
                    // filtreye göre gelen ürünlerin idleri alınması lazım $pro->pluck('id') ancak oda paginate
                    //$allProIds = $pro->pluck("id")->toArray();

                    $filterCounts = Cache::remember('filterCounts_' . $filterPrice . $id, 1, function () use ($allProIds, $cat, $request) {
                        $newCount      = \App\NewSort::whereIn("product_id", $allProIds)->count();
                        $sponsorCount  = \App\SponsorSort::whereIn("product_id", $allProIds)->count();
                        $campaignCount = \App\CampaignSort::whereIn("product_id", $allProIds)->count();

                        if (!$request->get('fiyat')) {
                            $discountCount = $cat->pros->filter(function ($value, $key) {
                                return $value->discount_type > 0;
                            });
                        } else {
                            $discountCount = $cat->pros->filter(function ($item) use ($request) {
                                if ($item->final_price > explode("-", $request->get('fiyat'))[0] && $item->final_price < explode("-", $request->get('fiyat'))[1] && $item->discount_type > 0) {
                                    return $item;
                                }
                            });
                        }

                        $arr = ["new" => $newCount, "sponsor" => $sponsorCount, "campaign" => $campaignCount, "discounted" => count($discountCount)];
                        arsort($arr);
                        return $arr;
                    });

                    //price filter counts
                    if (!$request->get('fiyat')) {
                        $arr          = ["0.0", "10.0", "20.0", "40.0", "100.0", "200.0", "500.0", "1000.0"];
                        $allfilterIds = $this->allfilterIds($filtreler);
                        for ($i = 0; $i < count($arr) - 2; $i++) {
                            $ttl = \App\Products::whereHas('categori', function ($query) use ($cat, $arr, $i) {
                                $query->where('product_to_cat.cid', $cat->id);
                                $query->where('final_price', '>', $arr[$i]);
                                $query->where('final_price', '<', $arr[$i + 1]);
                            });

                            if (!empty($allfilterIds)) {
                                $ttl->where(function ($query) use ($allfilterIds, $filtreler) {
                                    $query->whereIn('id', $allfilterIds);
                                    if (in_array("indirimli", $filtreler)) {
                                        $query->orWhere('discount_type', '>', 0);
                                    }
                                });
                            } else {
                                if (in_array("indirimli", $filtreler)) {
                                    $ttl->Where('discount_type', '>', 0);
                                }
                            }
                            $ttl = $ttl->count();
                            if ($ttl > 0) {
                                $priceFilterCounts[] = [
                                    "k1" => $arr[$i] . "-" . $arr[$i + 1],
                                    "k2" => $ttl,
                                    "k3" => $i == 6 ? "500 TL üzerinde" : intval($arr[$i]) . " TL - " . intval($arr[$i + 1]) . " TL",
                                ];
                            }
                        }
                    }

                    $myProduct = new Product();
                    $myPrice   = new Price();

                    if (!empty($filterText)) {
                        $pro->appends(['filtreler' => $filterText])->render();
                    }
                    if (!empty($filterPrice)) {
                        $pro->appends(['fiyat' => $filterPrice])->render();
                        $currentFilters["Fiyat"] = intval(explode("-", $filterPrice)[0]) . " TL - " . intval(explode("-", $filterPrice)[1]) . " TL";
                    }
                    if ($request->get('siralama')) {
                        $pro->appends(['siralama' => $sort])->render();
                    }
                    $pro->sortByDesc('updated_at');

                    $stockstatus = true;
                    return view('frontEnd.blades.category', ['stockstatus' => $stockstatus, 'breadCrump' => $breadCrump, 'pro' => $pro, 'cat' => $cat, 'cat_id' => $id, 'myProduct' => $myProduct, 'myPrice' => $myPrice, 'brandsProdCount' => $brandsProdCount, "filterCounts" => $filterCounts, "filteredBrandIds" => [], "filtreler" => $filtreler, "priceFilterCounts" => $priceFilterCounts, "currentFilters" => $currentFilters]);
                    break;
                } else {
                    return abort(404);
                    break;
                }

            // no break
            case "p":
                $p = Cache::remember('product' . $id, 1, function () use ($id) {
                    return Products::where('status', 1)->with([
                        'brand', 'categori', 'activeReviews', 'sixRelatedInStock',
                    ])->where('id', $id)->firstOrFail();
                });

                // ürün urli doğru mu?
                if ($p->slug != $slug) {
                    return redirect('/' . $p->slug . '-p-' . $p->id, 301);
                }

                $lastCategory = $p->categori->last();

                $breadCrump = $this->categoryBreadCrump($lastCategory->id);

                // benzer ürünler
                // $request->request->add(['category_ids'=>$p->categori->pluck("id")]);
                $request->request->add([
                    'category_ids' => [$lastCategory->id],
                ]);

                $similar = Products::filterByRequest($request)
                    ->where("id", "!=", $id)->limit(6)->get();

                $similarProds = [];

                foreach ($similar as $spro) {
                    $similarProds[] = new Pro($spro);
                }

                $p = new Pro($p);

                $relatedProds = [];

                foreach ($p->relateds as $pro) {
                    $relatedProds[] = new Pro($pro);
                }

                $myProduct         = new Product();
                $myPrice           = new Price();
                $shippingCountDown = Carbon::now()
                    ->setTime(12, 00, 00)
                    ->format('Y/m/d H:i:s');

                //dd($shippingCountDown);
                //description
                if (!empty(json_decode($p->p->seo, true)['seo_description']) && !is_array(json_decode(@$p->p->seo, true)['seo_title'])) {
                    $description = json_decode($p->p->seo, true)['seo_description'];
                } else {
                    $description = @$p->p->brand->name . ' markasının ' . $p->p->name . ' ürününü ' . $myPrice->currencyFormat($p->p->final_price) . ' TL fiyatla ' . @end($breadCrump)["title"] . ' kategorisinden satın alabilirsiniz. | www.marketpaketi.com.tr!';
                }

                if (!empty(@json_decode(@$p->p->seo, true)['seo_title']) && !is_array(json_decode(@$p->p->seo, true)['seo_title'])) {
                    $title = @json_decode(@$p->p->seo, true)['seo_title'] . ' - Marketpaketi';
                } else {
                    $title = $p->name . ' - Marketpaketi';
                }

                $activeButtons = [];
                if (count($p->p->buttons)) {
                    $butonDescriptions = \App\ButonDescriptions::select('id', 'buton', 'image')->get()->keyBy('buton');
                    $buttons           = json_decode($p->p->buttons[0], true);
                    foreach ($butonDescriptions as $key => $value) {
                        if ($buttons[$value->buton] == 1) {
                            $activeButtons[] = $value->image;
                        }
                    }
                    //return dd(json_decode($p->p->buttons[0],true));
                }

                //ücretsiz kargo baremi
                $freeShippingLimit = \App\Shipping::select('free_shipping')->where('status', '=', '1')->where('shippings.id', '!=', '4');
                $freeShippingLimit->leftJoin('shipping_roles', function ($join) {
                    $join->on('shippings.id', '=', 'shipping_roles.shipping_id');
                });
                $freeShippingLimit->orderBy('free_shipping', 'asc');
                $freeShippingLimit = $freeShippingLimit->first();

                return view("frontEnd.blades.product", ['freeShippingLimit' => $freeShippingLimit->free_shipping, 'activeButtons' => $activeButtons, 'description' => $description, 'title' => $title, 'breadCrump' => $breadCrump, 'p' => $p, 'myProduct' => $myProduct, 'myPrice' => $myPrice, 'relatedProds' => $relatedProds, 'similarProds' => $similarProds, 'shippingCountDown' => $shippingCountDown]);
                break;
            default:
                abort(404);
                break;
        }
    }

    public function brandCatogory(Request $request)
    {
        $id           = "";
        $filtreler    = [];
        $allfilterIds = [];
        $filterText   = "";

        if ($request->get('filtreler')) {
            $filtreler    = explode(",", $request->get('filtreler'));
            $filterText   = $request->get('filtreler');
            $allfilterIds = [];
        }

        $priceFilterCounts = [];
        $currentFilters    = [];
        if ($request->get('fiyat')) {
            $filterPrice = $request->get('fiyat');
        } else {
            $filterPrice = "";
        }

        if ($request->get('siralama')) {
            $sort = $request->get('siralama');
        } else {
            $sort = "";
        }

        $isValid = substr_count($request->category, '-');

        if ($isValid > 0) {
            $exUrl = explode("-", $request->category);
            $id    = $exUrl[count($exUrl) - 1];
            $route = $exUrl[count($exUrl) - 2];
        }

        $brandSlugs = $request->brand;
        if (strpos($brandSlugs, '-') !== false) {
            $exBrand  = explode("-", $brandSlugs);
            $brandIds = Brand::whereIn('slug', $exBrand)->select('id')->get()->pluck('id')->toArray();
        } else {
            $brandIds = Brand::where('slug', $brandSlugs)->select('id')->get()->pluck('id')->toArray();
        }

        $cat = $this->getCategori($id);

        if (empty($brandIds) || empty($cat)) {
            return abort(404);
        }

        $brandCat = "";
        if (count($brandIds) == 1) {
            $brandCat = Cache::remember('bc' . $id . '_' . $brandIds[0], 0, function () use ($brandIds, $id) {
                return BrandCategory::where('category_id', $id)
                    ->where('brand_id', '=', $brandIds[0])
                    ->first();
            });

            $br                 = $this->getBrand($brandIds[0]);
            $breadCrumpBrandCat = [
                "slug"  => $br->slug . "/" . $cat->slug . "-c-" . $cat->id,
                "title" => $br->name . " " . $cat->title,
            ];

            if ($brandCat) {
                $cat->content = $brandCat->content;
            }else {
                $cat->content       = '';

                $branCatName = ($br->name . ' ' . $cat->title);

                $brandCat = (object) [
                    'title' => sprintf('%s Fiyatları ve Çeşitleri', $branCatName),
                    'description' => sprintf(
                        '%s ürünleri en uygun fiyat avantajı ile seni bekliyor! En ucuz %s çeşitleri Marketpaketi kampanyaları ile tek tıkla kapına gelsin.',
                        $branCatName,
                        $branCatName
                    )
                ];
            }
        } else {
            $cat->content       = '';
            $breadCrumpBrandCat = '';
        }

        $ids = ["cid" => $id, "brandids" => $brandIds];

        $breadCrump = $this->categoryBreadCrump($cat->parent_id);

        $page = $request->input('page', '1');

        if (strstr($request->get('filtreler'), 'stokhepsi')) {
            $pro = Cache::remember('pro' . $id . '_' . $request->brand . '_' . $filterText . $filterPrice . $sort . $page, 1, function () use ($ids, $filtreler, $allfilterIds, $request) {
                //return \App\Products::all();
                //return $cat->pros()->with('images','brand')->paginate(2);
                $aaa = \App\Products::whereHas('categori', function ($query) use ($ids) {
                    $query->where('product_to_cat.cid', $ids["cid"]);
                })->where('status', 1)->whereIn('brand_id', $ids["brandids"])->with('images', 'brand');

                $allfilterIds = $this->allfilterIds($filtreler);

                if (!empty($allfilterIds)) {
                    //$aaa->whereIn('id',$allfilterIds);
                    $aaa->where(function ($query) use ($allfilterIds, $filtreler) {
                        $query->whereIn('products.id', $allfilterIds);
                        if (in_array("indirimli", $filtreler)) {
                            $query->orWhere('discount_type', '>', 0);
                        }
                    });
                } else {
                    if (in_array("indirimli", $filtreler)) {
                        $aaa->Where('discount_type', '>', 0);
                    }
                }

                if ($request->get('fiyat')) {
                    $expPriceFilter = explode("-", $request->get('fiyat'));
                    $aaa->whereBetween('final_price', [$expPriceFilter[0], $expPriceFilter[1]]);
                }
                /*
                if (in_array("indirimli",$filtreler )){
                //$campaignIds  = \App\DiscountSort::select("product_id")->get("product_id");
                //$aaa->orWhere('discount_type','>',0);
                $aaa->where(function ($query){
                $query->orWhere('discount_type','>',0);
                });
                }

                 */
                $aaa->leftJoin('category_sorts', function ($join) use ($ids) {
                    $join->on('category_sorts.product_id', '=', 'products.id')->where('category_sorts.category_id', '=', $ids["cid"]);
                });

                $aaa->select('products.*', DB::raw('IF(`sort` IS NOT NULL, `sort`, 1000000) `sort`'), 'category_sorts.sort', 'category_sorts.product_id', 'category_sorts.category_id');

                //$aaa->orderBy('sort','asc');
                //$aaa->orderBy('created_at','desc');

                if ($request->get("siralama")) {
                    if ($request->get("siralama") == "artanfiyat") {
                        $aaa->orderBy('final_price', 'asc');
                    } elseif ($request->get("siralama") == "azalanfiyat") {
                        $aaa->orderBy('final_price', 'desc');
                    }
                } else {
                    $aaa->orderBy('sort', 'asc');
                    $aaa->orderByRaw("FIELD(stock , '0') asc");
                    $aaa->orderBy('created_at', 'desc');
                }

                return $aaa->paginate(32);
            });
        } else {
            $pro = Cache::remember('pro' . $id . '_' . $request->brand . '_' . $filterText . $filterPrice . $sort . $page, 1, function () use ($ids, $filtreler, $allfilterIds, $request) {
                //return \App\Products::all();
                //return $cat->pros()->with('images','brand')->paginate(2);
                $aaa = \App\Products::whereHas('categori', function ($query) use ($ids) {
                    $query->where('product_to_cat.cid', $ids["cid"]);
                })->where('status', 1)->where('stock', '!=', '0')->whereIn('brand_id', $ids["brandids"])->with('images', 'brand');

                $allfilterIds = $this->allfilterIds($filtreler);

                if (!empty($allfilterIds)) {
                    //$aaa->whereIn('id',$allfilterIds);
                    $aaa->where(function ($query) use ($allfilterIds, $filtreler) {
                        $query->whereIn('products.id', $allfilterIds);
                        if (in_array("indirimli", $filtreler)) {
                            $query->orWhere('discount_type', '>', 0);
                        }
                    });
                } else {
                    if (in_array("indirimli", $filtreler)) {
                        $aaa->Where('discount_type', '>', 0);
                    }
                }

                if ($request->get('fiyat')) {
                    $expPriceFilter = explode("-", $request->get('fiyat'));
                    $aaa->whereBetween('final_price', [$expPriceFilter[0], $expPriceFilter[1]]);
                }
                /*
                if (in_array("indirimli",$filtreler )){
                //$campaignIds  = \App\DiscountSort::select("product_id")->get("product_id");
                //$aaa->orWhere('discount_type','>',0);
                $aaa->where(function ($query){
                $query->orWhere('discount_type','>',0);
                });
                }

                 */
                $aaa->leftJoin('category_sorts', function ($join) use ($ids) {
                    $join->on('category_sorts.product_id', '=', 'products.id')->where('category_sorts.category_id', '=', $ids["cid"]);
                });

                $aaa->select('products.*', DB::raw('IF(`sort` IS NOT NULL, `sort`, 1000000) `sort`'), 'category_sorts.sort', 'category_sorts.product_id', 'category_sorts.category_id');

                //$aaa->orderBy('sort','asc');
                //$aaa->orderBy('created_at','desc');

                if ($request->get("siralama")) {
                    if ($request->get("siralama") == "artanfiyat") {
                        $aaa->orderBy('final_price', 'asc');
                    } elseif ($request->get("siralama") == "azalanfiyat") {
                        $aaa->orderBy('final_price', 'desc');
                    }
                } else {
                    $aaa->orderBy('sort', 'asc');
                    $aaa->orderByRaw("FIELD(stock , '0') asc");
                    $aaa->orderBy('created_at', 'desc');
                }

                return $aaa->paginate(32);
            });
        }

        $brands = $this->getBrands();
        $request->request->add(['category_id' => $id]);
        //$request->request->add(['brand_ids'=>$brandIds]);

        $brandsProdCount = Products::select('products.brand_id', 'brands.name', 'brands.slug', DB::raw('count(*) as count'))
            ->where('products.status', '1')
            ->whereHas('categori', function ($query) use ($id) {
                $query->where('product_to_cat.cid', $id);
            })
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->groupBy('brand_id')
            ->orderBy('count', 'desc')
            ->get();

        //$allProIds = $cat->pros()->pluck("id")->toArray();

        $arr = ["0.0", "10.0", "20.0", "40.0", "100.0", "200.0", "500.0", "1000.0"];

        //allproids marka filttresine göre
        $allProIds = Products::select('id')->whereHas('categori', function ($query) use ($cat, $arr, $ids, $request) {
            $query->where('product_to_cat.cid', $cat->id);
            if ($request->get('fiyat')) {
                $expPriceFilter = explode("-", $request->get('fiyat'));
                $query->whereBetween('final_price', [$expPriceFilter[0], $expPriceFilter[1]]);
            }
            $query->whereIn('brand_id', $ids["brandids"]);
        });
        $allProIds = $allProIds->pluck('id')->toArray();
        ///////////////////////////////////////////

        $filterCounts = Cache::remember('filterCounts_' . $id . '_' . $request->brand, 1, function () use ($allProIds, $cat, $ids, $request) {
            $newCount      = \App\NewSort::whereIn("product_id", $allProIds)->count();
            $sponsorCount  = \App\SponsorSort::whereIn("product_id", $allProIds)->count();
            $campaignCount = \App\CampaignSort::whereIn("product_id", $allProIds)->count();
            $discountCount = \App\Products::select('id')->whereHas('categori', function ($query) use ($cat, $ids, $request) {
                $query->where('product_to_cat.cid', $cat->id);
                if ($request->get('fiyat')) {
                    $expPriceFilter = explode("-", $request->get('fiyat'));
                    $query->whereBetween('final_price', [$expPriceFilter[0], $expPriceFilter[1]]);
                }
                $query->whereIn('brand_id', $ids["brandids"]);
                $query->where('discount_type', '>', 0);
                $query->where('status', '=', 1);
            });
            $arr = ["new" => $newCount, "sponsor" => $sponsorCount, "campaign" => $campaignCount, "discounted" => $discountCount->count()];
            arsort($arr);
            return $arr;
        });

        //price filter counts
        if (!$request->get('fiyat')) {
            $allfilterIds = $this->allfilterIds($filtreler);
            for ($i = 0; $i < count($arr) - 2; $i++) {
                $ttl = \App\Products::whereHas('categori', function ($query) use ($cat, $arr, $i) {
                    $query->where('product_to_cat.cid', $cat->id);
                    $query->where('final_price', '>', $arr[$i]);
                    $query->where('final_price', '<', $arr[$i + 1]);
                });

                $ttl->whereIn('brand_id', $ids["brandids"]);

                if (!empty($allfilterIds)) {
                    //$aaa->whereIn('id',$allfilterIds);
                    $ttl->where(function ($query) use ($allfilterIds, $filtreler) {
                        $query->whereIn('id', $allfilterIds);
                        if (in_array("indirimli", $filtreler)) {
                            $query->orWhere('discount_type', '>', 0);
                        }
                    });
                } else {
                    if (in_array("indirimli", $filtreler)) {
                        $ttl->Where('discount_type', '>', 0);
                    }
                }

                $ttl = $ttl->count();

                if ($ttl > 0) {
                    $priceFilterCounts[] = [
                        "k1" => $arr[$i] . "-" . $arr[$i + 1],
                        "k2" => $ttl,
                        "k3" => $i == 6 ? "500 TL üzerinde" : intval($arr[$i]) . " TL - " . intval($arr[$i + 1]) . " TL",
                    ];
                }
            }
        }

        if (!$cat) {
            return abort(404);
        }

        $myProduct = new Product();
        $myPrice   = new Price();

        $categories = $this->getCategories();

        if (!empty($filterText)) {
            $pro->appends(['filtreler' => $filterText])->render();
        }
        if (!empty($filterPrice)) {
            $pro->appends(['fiyat' => $filterPrice])->render();
            $currentFilters["Fiyat"] = intval(explode("-", $filterPrice)[0]) . " TL - " . intval(explode("-", $filterPrice)[1]) . " TL";
        }
        if ($request->get('siralama')) {
            $pro->appends(['siralama' => $sort])->render();
        }

        return view('frontEnd.blades.category', compact(
            'breadCrump','pro','cat','myProduct','myPrice','categories','brandsProdCount',
            'filterCounts','filtreler','priceFilterCounts','currentFilters',
            'brandCat','breadCrumpBrandCat'
        ))->with('filteredBrandIds', $brandIds);
    }

    public function allfilterIds($filtreler)
    {
        $allfilterIds = [];
        if (in_array("sponsor", $filtreler)) {
            $sponsorIds   = \App\SponsorSort::select("product_id")->get("product_id");
            $allfilterIds = array_unique(array_merge($allfilterIds, $sponsorIds->pluck("product_id")->toArray()));
        }
        if (in_array("yeni", $filtreler)) {
            $newIds = \App\NewSort::select("product_id")->get("product_id");
            //$aaa->whereIn('id',$newIds->pluck("product_id"));
            $allfilterIds = array_unique(array_merge($allfilterIds, $newIds->pluck("product_id")->toArray()));
        }

        if (in_array("kampanyali", $filtreler)) {
            $campaignIds = \App\CampaignSort::select("product_id")->get("product_id");
            //$aaa->whereIn('id',$campaignIds->pluck("product_id"));
            $allfilterIds = array_unique(array_merge($allfilterIds, $campaignIds->pluck("product_id")->toArray()));
        }

        return $allfilterIds;
    }

    public function bultenRegister(Request $request)
    {
        $this->validate($request, [
            'emailbulten' => 'required|email|',
        ], [
            'emailbulten.required' => 'Lütfen mail adresi giriniz.',
            'emailbulten.email'    => 'Geçerli bir mail adresi giriniz.',
            'emailbulten.unique'   => 'Girdiğiniz mail adresi zaten kayıtlı.',
        ]);

        $data = [
            "email"   => $request->get("emailbulten"),
            "groupId" => 5,
        ];

        if (Auth::guard("members")->check() == true) {
            $data["name"] = Auth::guard('members')->user()->name . " " . Auth::guard('members')->user()->surname;
        }

        if (\App\MailList::create($data)) {
            return redirect()->back()->with('messageBulten', 'Haber listemize kayıt oldunuz, tesekkurler!');
        } else {
            return redirect()->back()->with('messageBulten', 'Hata oluştu.');
        }
    }

    public function postReview(Request $request)
    {
        $validateArray = [
            //'email'  => 'required|email',
            'name'   => 'required|',
            'review' => 'required|',
        ];

        $validateMessageArray = [
            //'email.required'=>'Lütfen mail adresi giriniz.',
            //'email.email'=> 'Geçerli bir mail adresi giriniz.',
            'review.required' => 'Lütfen mesaj kısmını boş bırakmayınız.',
        ];

        $validator = Validator::make($request->all(), $validateArray, $validateMessageArray);

        if ($validator->passes()) {
            $data = [
                "product_id" => $request->get("pid"),
                "author"     => $request->get("name"),
                //"email" =>$request->get("email"),
                "text"       => $request->get("review"),
                "rating"     => $request->get("rating"),
                "status"     => 0,
            ];

            if (Auth::guard("members")->check() == true) {
                $data["member_id"] = Auth::guard('members')->user()->id;
            }

            $create = \App\ProductReview::create($data);

            return response()->json(['success' => 'Yorumunuz tarafımıza ulaşmıştır.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function stockNotification(Request $request)
    {
        if (Auth::guard("members")->check() != true) {
            $response = ["error" => "Stok durumundan haberdar olabilmek için üye girişi yapmalısınız"];
        } else {
            $data = [
                "product_id" => $request->get('pId'),
                "member_id"  => Auth::guard('members')->user()->id,
            ];
            if (\App\StockWarning::updateOrCreate($data)) {
                $response = ["success" => "Email adresiniz ile stok bilgisi güncellendiğinde haberdar olacaksınız."];
            }
        }
        return response()->json($response);
    }

    public function postSuggestion(Request $request)
    {
        $validateArray = [
            'email'        => 'required|email',
            'name'         => 'required|',
            'body_message' => 'required|',
        ];

        $validateMessageArray = [
            'email.required'        => 'Lütfen mail adresi giriniz.',
            'email.email'           => 'Geçerli bir mail adresi giriniz.',
            'body_message.required' => 'Lütfen mesaj kısmını boş bırakmayınız.',
            'name.required'         => 'Lütfen ad soyad kısmını boş bırakmayınız.',
        ];

        $validator = Validator::make($request->all(), $validateArray, $validateMessageArray);

        if ($validator->passes()) {
            //send email

            \Mail::send(
                'mailTemplates.suggestion',
                array(
                    'name'         => $request->get('name'),
                    'email'        => $request->get('email'),
                    'body_message' => $request->get('body_message'),
                    'product'      => $request->get('product'),
                    'ip'           => \Request::ip(),
                ),
                function ($message) {
                    $message->from('consumer@marketpaketi.com.tr', 'marketpaketi.com.tr');
                    $message->to('consumer@marketpaketi.com.tr')->subject('Öneri Formu');
                }
            );

            if (count(\Mail::failures()) > 0) {
                $response = ["error" => "Hata oluştu."];
            } else {
                $response = ["success" => "Öneriniz tarafımıza ulaşmıştır."];
            }

            return response()->json($response);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function signOrGuest()
    {
        if (Auth::guard("members")->check() == true) {
            return redirect()->to('/');
        } else {
            return view('frontEnd.blades.signInOrguest');
        }
    }

    public function signIn(Request $request)
    {
        if (Auth::guard("members")->check() == true) {
            return redirect()->to('/');
        } else {
            if ($request->get('returnUrl')) {
                $guest = true;
            } else {
                $guest = false;
            }
            return view('frontEnd.blades.signIn', compact('guest'));
        }
    }

    public function signUp()
    {
        if (Auth::guard("members")->check() == true) {
            return redirect()->to('/');
        } else {
            return view('frontEnd.blades.signUp');
        }
    }

    public function signUpPost(Request $request)
    {
        $this->validate($request, [
            'name'             => 'required|',
            'surname'          => 'required|',
            'email'            => 'required|unique:members|email',
            'phone'            => 'required|',
            'password'         => 'required|min:4|max:16|regex:/^[\w-]*$/|',
            'password_confirm' => 'required|same:password',
            'userAgreement'    => 'required',
            'kvkAgreement'     => 'required',
            'captcha'          => 'required|captcha',
        ], [
            'name.required'             => 'Ad alanı boş geçilemez.',
            'surname.required'          => 'Soyad alanı boş geçilemez',
            'email.required'            => ' E mail alanı boş geçilemez.',
            'email.unique'              => 'Bu mail adresi ile daha önce kayıt olunmuştur.',
            'email.email'               => 'Lütfen geçerli bir mail adresi giriniz.',
            'phone.required'            => 'Lütfen geçerli bir telefon numarası giriniz.',
            'password.min'              => 'Şifre 4 karakterden az olamaz.',
            'password.max'              => 'Şifre 16 karakterden fazla olamaz.',
            'password.required'         => ' Şifre alanı boş geçilemez.',
            'password.regex'            => 'Şifre sadece alfanumerik karaterler içerebilir,Türkçe karakter ve boşluk içeremez.',
            'password_confirm.same'     => 'Şifreler uyuşmuyor.',
            'password_confirm.required' => 'Şifre Tekrar alanı boş geçilemez.',
            'userAgreement.required'    => 'Lütfen üyelik sözleşmesi alanını boş bırakmayınız.',
            'kvkAgreement.required'     => 'Kişisel Verilerin Korunması Kanunu sözleşmesini kabul etmelisiniz.',
            'captcha.required'          => 'Güvenlik kodu alanı boş geçilemez',
            'captcha.captcha'           => 'Güvenlik kodunu kontrol ediniz.',
        ]);

        $data = [
            "name"            => $request->get("name"),
            "surname"         => $request->get("surname"),
            "email"           => $request->get("email"),
            "phoneGsm"        => $request->get("phone"),
            "password"        => bcrypt($request->get("password")),
            "group_id"        => 1,
            "status"          => 1,
            "allowed_to_mail" => $request->has("allowed_to_mail") ? 1 : 0,
        ];

        $userCreate = Member::create($data);

        Auth::guard('members')->login($userCreate, true);

        $mmbr = \App\Member::where('email', $request->get('email'))->select('id', 'name')->first();
        Session::put("member", $mmbr);

        if ($request->get('returnUrl')) {
            if ($request->get('returnUrl') == "fatura-teslimat") {
                return redirect('sepet/fatura-teslimat');
            } else {
                return redirect()->intended();
            }
        } else {
            return redirect('/');
        }
    }

    public function signInPost(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:3|max:20',
        ], [
            'password.required' => ' Şifre alanı boş geçilemez.',
            'email.required'    => ' E mail alanı boş geçilemez.',
            'email.email'       => 'Geçerli bir mail adresi giriniz.',
        ]);

        $member   = Auth()->guard('members');
        $remember = false;
        if ($member->attempt(["email" => $request->input('email'), "password" => $request->input('password'), 'status' => 1], $remember)) {
            //$mmbr = \App\Member::where('email',$request->input('email'))->select('id','name')->first();
            //Session::put("member",$mmbr);
            if ($request->get('returnUrl')) {
                if ($request->get('returnUrl') == "fatura-teslimat") {
                    return redirect('sepet/fatura-teslimat');
                } else {
                    return redirect()->intended();
                }
            } else {
                return redirect()->intended();
            }
        } else {
            return redirect()->back()->with('messageLogin', 'Email veya şifre yanlış. Lütfen tekrar deneyiniz.');
            //return redirect()->back();
        }
    }

    public function memberLogout()
    {
        Session::forget('member');
        Session()->forget('cart');
        Auth::guard('members')->logout();
        return redirect('/');
    }

    public function forgotPassword()
    {
        if (Auth::guard("members")->check() == true) {
            return redirect()->to('/');
        } else {
            return view('frontEnd.blades.forgotPassword');
        }
    }

    public function forgotPasswordPost(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email|exists:members,email',
            'captcha' => 'required|captcha',
        ], [
            'email.required'   => ' E mail alanı boş geçilemez.',
            'email.email'      => 'Geçerli bir mail adresi giriniz.',
            'email.exists'     => 'Böyle bir üye bulunamadı!',
            'captcha.required' => 'Güvenlik kodu alanı boş geçilemez',
            'captcha.captcha'  => 'Güvenlik kodunu kontrol ediniz.',
        ]);

        $uniq = uniqid();

        $data = ["email" => $request->get("email"), "token" => $uniq];

        $createForgot = \App\MemberPasswordReset::create($data);

        $user = \App\Member::where("email", $request->get('email'))->first();

        if ($createForgot && $user) {
            ///send mail
            \Mail::send(
                'mailTemplates.passChangeLink',
                array(
                    'name'  => $user->name . " " . $user->surname,
                    'token' => $uniq,
                ),
                function ($message) use ($request) {
                    $message->from('consumer@marketpaketi.com.tr', 'marketpaketi.com.tr');
                    $message->to($request->get('email'))->subject('Şifre Yenileme Talebi');
                }
            );

            if (count(\Mail::failures()) > 0) {
                return redirect()->back()->with("error", "Hata oluştu.");
            } else {
                return redirect('sifremi-unuttum')->with("success", "Onay maili mail adresinize gönderildi lütfen mail hesabınızı kontrol ediniz.");
            }
        } else {
            return redirect('sifremi-unuttum')->with("error", "Hata Oluştu.");
        }
    }

    public function forgotPasswordToken($token)
    {
        if (\App\MemberPasswordReset::where('token', $token)->count() > 0) {
            return view('frontEnd.blades.resetPassword', compact('token'));
        } else {
            return redirect('./');
        }
    }

    public function resetMemberPassword(Request $request, $token)
    {
        $this->validate($request, [
            'password'        => 'required|min:4|max:16|regex:/^[\w-]*$/|',
            'password-repeat' => 'required|same:password',
        ], [
            'password.min'             => 'Şifre 4 karakterden az olamaz.',
            'password.max'             => 'Şifre 16 karakterden fazla olamaz.',
            'password.required'        => ' Şifre alanı boş geçilemez.',
            'password.regex'           => 'Şifre sadece alfanumerik karaterler içerebilir,Türkçe karakter ve boşluk içeremez.',
            'password-repeat.same'     => 'Şifreler uyuşmuyor.',
            'password-repeat.required' => 'Şifre Tekrar alanı boş geçilemez.',
        ]);

        if (\App\MemberPasswordReset::where(['token' => $token])->count() > 0) {
            $reset = \App\MemberPasswordReset::where(['token' => $token])->first();
            //return view('frontEnd.blades.resetPassword',compact('token'));
            $newPass = $request->get('password');
            //$newPass = "12345678";
            $user           = \App\Member::where("email", $reset->email)->first();
            $user->password = bcrypt($newPass);
            $user->save();

            //send mail new passs
            \Mail::send(
                'mailTemplates.newPass',
                array(
                    'name'    => $user->name . " " . $user->surname,
                    'newpass' => $newPass,
                ),
                function ($message) use ($request, $reset) {
                    $message->from('consumer@marketpaketi.com.tr', 'marketpaketi.com.tr');
                    $message->to($reset->email)->subject('Şifre Değişikliği Bilgilendirmesi');
                }
            );

            if (count(\Mail::failures()) > 0) {
                return redirect()->back()->with("error", "Hata oluştu.");
            } else {
                return redirect()->back()->with("success", "Şifreniz başarıyla güncellendi.");
            }
        } else {
            return redirect()->back()->with("error", "Hata oluştu");
        }
    }

    public function getAddToCart(Request $request)
    {
        $p       = new Product();
        $myPrice = new Price();
        $product = $p->getProduct($request->get('product_id'));
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart    = new Cart($oldCart);

        $pro = new Pro($product);

        if (!empty($request->get('quantity')) && $request->get('quantity') > 0) {
            $qty = $request->get('quantity');
        } else {
            $qty = 1;
        }

        //dd($cart);

        if (isset($cart->items[$request->get("product_id")])) {
            $requestQty = $cart->items[$request->get("product_id")]["qty"] + $qty;
        } else {
            $requestQty = $qty;
        }

        //dd($pro->p->stock);

        if ($pro->p->stock >= $requestQty) {
            if ($pro->p->maximum != null && $requestQty > $pro->p->maximum) {
                $response = ["status" => 0, "count" => $cart->totalQty, "total" => $myPrice->currencyFormat($cart->totalPrice), "message" => "Bu üründen en fazla " . $pro->p->maximum . " adet alabilirsiniz.", "max_stock" => $pro->p->maximum];
            } else {
                $cart->add($pro, $request->get("product_id"), $qty);

                //kupon tanımlıysa
                if (!empty($cart->coupon)) {
                    $code = $cart->coupon;
                    $this->deleteCode($code);
                    $codeUse = $this->useCode($code);
                    /*
                if ($codeUse->getData('data')['status']==0) {
                $this->deleteCode($cart->coupon);
                }*/
                }

                //sepette promosyonlu ürün varsa fiyata yansıtalım
                if (count($cart->chosenPromotion) > 0) {
                    $promotion         = \App\Promotion::where('id', $cart->chosenPromotion['id'])->first();
                    $promotionProducts = \App\Products::select('id')->whereIn('id', json_decode($promotion->affectedProducts));
                    //sepette promosyona dahil ürün varsa sepete yansıtalım
                    if (in_array($request->get("product_id"), $promotionProducts->pluck('id')->toArray()) && $requestQty <= $promotion->affectedCount) {
                        $cart->promotionDiscount += $qty * $promotion->promotionValue;
                    }
                }

                $request->session()->put('cart', $cart);

                $response = ["status" => 200, "count" => $cart->totalQty, "total" => $myPrice->currencyFormat($cart->totalPrice), "message" => "success"];
            }
        } else {
            if (isset($cart->items[$request->get("product_id")])) {
                if ($cart->items[$request->get("product_id")]["qty"] < $pro->p->stock) {
                    $warning = "Bu üründen en fazla " . (intval($pro->p->stock) - intval($cart->items[$request->get("product_id")]["qty"])) . " adet daha ekleyebilirsiniz.";
                } else {
                    $warning = "Stoklarımızda bulunan son ürünü sepete eklediniz.";
                }
            } else {
                $warning = "Stoklarımızda bu üründen " . $pro->p->stock . " adet kalmıştır.";
            }
            $response = ["status" => 0, "count" => $cart->totalQty, "total" => $myPrice->currencyFormat($cart->totalPrice), "message" => $warning, "max_stock" => $pro->p->stock];
        }

        return response()->json($response);
    }

    public function addPromotionProduct($id)
    {
        if (!Session::has('cart')) {
            return view('frontEnd.blades.cart');
        }

        $cart    = new Cart(Session::get('cart'));
        $p       = new Product();
        $product = $p->getProduct($id);
        $pro     = new Pro($product);

        if ($cart && (count($cart->items) > 0) && (count($cart->chosenPromotion) > 0) && $cart->coupon == null) {
            $promotion = \App\Promotion::where('id', $cart->chosenPromotion['id'])->first();

            if (isset($cart->items[$id])) {
                $requestQty = $cart->items[$id]["qty"] + 1;
            } else {
                $requestQty = 1;
            }

            if ($pro->p->stock >= $requestQty) {
                $cart->add($pro, $id, 1);
                /*
                if ($requestQty <= $promotion->affectedCount) {
                //indirim turune göre
                //todo
                //indirim tipine göre uygulaalım
                if ($promotion->promotionDiscountType=="rebateProduct") {
                $cart->promotionDiscount = $requestQty * $promotion->promotionValue;
                }elseif ($promotion->promotionDiscountType=="rebatePercentProduct") {
                $cart->promotionDiscount = $requestQty * (($promotion->promotionValue*$cart->items[$id]['price'])/100);
                }elseif ($promotion->promotionDiscountType=="free") {
                $cart->promotionDiscount = $requestQty * $cart->items[$id]['price'];
                }
                //$cart->promotionDiscount = $requestQty * $promotion->promotionValue;
                }
                 */

                Session::put('cart', $cart);
            }
        }
        return redirect('sepet');
    }

    public function getCart(Request $request)
    {
        //Session()->forget('cart');
        if (!Session::has('cart')) {
            return view('frontEnd.blades.cart');
        }

        $oldCart = Session::get('cart');
        $cart    = new Cart($oldCart);

        if (empty($cart->shipping)) {
            $shipping = Shipping::with('roles')->where(["status" => 1])->orderBy('sort')->first();
            $cart->setShipping($shipping);
            $request->request->add([
                "shipping" => @$shipping->id,
            ]);

            if ($cartShipping = $this->getCartShipping()) {
                $resdata             = $cartShipping->getData("ttl");
                $cart->shippingPrice = $resdata["ttl"];
            }
        }

        $cart->guest = false;

        $promotions = $this->getPromotions();

        if (empty($promotions)) {
            $cart->promotionDiscount = 0;
            $cart->chosenPromotion   = [];
        }

        $choosenPromotionPros = [];

        if (count($promotions) > 0 && $cart->coupon == null && $cart->chosenPromotion == null) {
            $cart->chosenPromotion = [
                "id"           => $promotions[0]['promotion']->id,
                "label"        => $promotions[0]['promotion']->name,
                "discount"     => $promotions[0]['promotion']->promotionValue,
                "discountType" => $promotions[0]['promotion']->promotionDiscountType,
            ];
            $choosenPromotionPros = $promotions[0]['products'];

            $this->usePromotion($promotions[0]['promotion']->id, $cart);
        } elseif (count($cart->chosenPromotion) > 0) {
            $v = \App\Promotion::where('id', $cart->chosenPromotion['id'])->first();
            //dd($v);
            $choosenPromotionPros = \App\Products::select('id', 'name', 'slug', 'final_price', 'stock_type', 'price', 'tax', 'tax_status', 'discount', 'discount_type')->with('images')->whereIn('id', json_decode($v->affectedProducts))->get();
            //todo
            $this->usePromotion($v->id, $cart);
        }

        //$oldCart = Session::get('cart');
        //$cart = new Cart($oldCart);

        //seçilen promosyonun sepette ürünü var ve fiyattan düşülmemişse düşelim
        /*
        if (count($cart->chosenPromotion)>0 && $cart->promotionDiscount==0) {
        $promotion = \App\Promotion::where('id',$cart->chosenPromotion['id'])->first();
        $promotionProducts = \App\Products::select('id')->whereIn('id',json_decode($promotion->affectedProducts));
        //sepette promosyona dahil ürün varsa sepete yansıtalım
        foreach ($cart->items as $key => $value) {
        if (in_array($value['item']->id, $promotionProducts->pluck('id')->toArray())) {

        $count = $value['qty'];
        $cart->promotionDiscount += $count * $promotion->promotionValue;

        }
        }

        }
         */

        Session::put('cart', $cart);
        //dd($cart);

        return view('frontEnd.blades.cart', ["products" => $cart->items, "cart" => $cart, 'promotions' => $promotions, "choosenPromotionPros" => $choosenPromotionPros]);
    }

    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart    = new Cart($oldCart);

        //sepette promosyonlu ürün varsa fiyata yansıtalım
        if (count($cart->chosenPromotion) > 0) {
            $promotion         = \App\Promotion::where('id', $cart->chosenPromotion['id'])->first();
            $promotionProducts = \App\Products::select('id')->whereIn('id', json_decode($promotion->affectedProducts));
            //sepette promosyona dahil ürün varsa sepete yansıtalım
            if (in_array($id, $promotionProducts->pluck('id')->toArray())) {
                $count = $cart->items[$id]['qty'];
                //todo ürün silindiğinde ürüne ait promosyonu silerken indirim türüne göre silelim
                if ($promotion->promotionDiscountType == "rebateProduct") {
                    $cart->promotionDiscount -= $count * $promotion->promotionValue;
                } elseif ($promotion->promotionDiscountType == "rebatePercentProduct") {
                    $cart->promotionDiscount -= $count * (($promotion->promotionValue * $cart->items[$id]['price']) / 100);
                } elseif ($promotion->promotionDiscountType == "free") {
                    $cart->promotionDiscount -= $count * $promotion->promotionValue * $cart->items[$id]['price'];
                }
                //$cart->promotionDiscount -= $count * $promotion->promotionValue;
            }
        }

        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
            if (!empty($cart->coupon)) {
                $code = $cart->coupon;
                $this->deleteCode($code);
                $codeUse = $this->useCode($code);
                /*
            if ($codeUse->getData('data')['status']==0) {
            $this->deleteCode($cart->coupon);
            }*/
            }
        } else {
            session()->forget('cart');
        }

        return redirect('sepet');
    }

    public function getUpdateCart(Request $request)
    {
        if (!Session::has('cart')) {
            return false;
        } else {
            $cart = new Cart(Session::get('cart'));

            if (count($cart->chosenPromotion) > 0) {
                $promotion         = \App\Promotion::where('id', $cart->chosenPromotion['id'])->first();
                $promotionProducts = \App\Products::select('id')->whereIn('id', json_decode($promotion->affectedProducts));
            }

            /*
            if (count($cart->chosenPromotion)>0 && $cart->promotionDiscount==0) {
            $firstTime=1;
            }
             */
            foreach ($request->get("qty") as $key => $qty) {
                $p       = new Product();
                $product = $p->getProduct($key);
                $pro     = new Pro($product);

                if ($pro->p->stock >= $qty) {
                    if ($pro->p->maximum == null || $qty < $pro->p->maximum) {
                        //sepette promosyonlu ürün varsa fiyata yansıtalım
                        if (count($cart->chosenPromotion) > 0) {
                            //sepette promosyona dahil ürün varsa sepete yansıtalım
                            //dd($promotionProducts->pluck('id')->toArray());

                            if (in_array($key, $promotionProducts->pluck('id')->toArray())) {
                                $count = $cart->items[$key]['qty'];
                                if ($qty > $promotion->affectedCount) {
                                    //sepette promosyonlu ürün promosyon adet sınırından fazla varsa izin verilen kadar uygulayalım
                                    $cart->promotionDiscount += ($promotion->affectedCount - $count) * $promotion->promotionValue;
                                } else {
                                    //depilse sepetteki adet kadar uygulayalım
                                    if ($count > $qty) {
                                        $cart->promotionDiscount = $cart->promotionDiscount - (($count - $qty) * $promotion->promotionValue);
                                    } elseif ($count < $qty) {
                                        //sepetteki adet ve update adet eşit olsada indirim ilk kez uygulanıyorsa sepetteki adetin tamamı kadar indirim uygulayalım
                                        $cart->promotionDiscount = $cart->promotionDiscount + (($qty - $count) * $promotion->promotionValue);
                                    }
                                }
                            }
                        }

                        $cart->updateItem($key, $qty);
                    }
                }
            }

            Session::put('cart', $cart);
            /*
            //sepet güncellendiğinde daha önceden sepette promosyon yoksa ve şuan sepet promosyona uygunsa ve promosyonlu ürünler varsa sepette
            if(count($cart->chosenPromotion)<1){
            $promotions = $this->getPromotions();
            if (empty($promotions)) {
            $cart->promotionDiscount=0;
            $cart->chosenPromotion=[];
            }else{
            $firstTime=0;
            }
            }
             */

            if (!empty($cart->coupon)) {
                $code = $cart->coupon;
                $this->deleteCode($code);
                $codeUse = $this->useCode($code);
                /*
            if ($codeUse->getData('data')['status']==0) {
            $this->deleteCode($cart->coupon);
            }*/
            }
            return response()->json($cart);
        }
    }

    public function setCode(Request $request)
    {
        return $this->useCode($request->get('code'));
    }

    public function useCode($code)
    {
        if (!Session::has('cart')) {
            $response = ["status" => 0, "message" => "Hediye çekini kullanabilmeniz için sepetinizde ürün olması gerekmektedir."];
        } else {
            if (Auth::guard("members")->check() != true) {
                $response = ["status" => 0, "message" => "Hediye çekini kullanabilmeniz için üye girişi yapmanız gerekmektedir."];
            } else {
                $code = \App\Campaign::where('code', $code)->first();
                if (count($code) < 1) {
                    $response = ["status" => 0, "message" => "Hediye çeki bulunamadı!"];
                } else {
                    $start = new Carbon($code->startDate);
                    $stop  = new Carbon($code->stopDate);
                    $now   = Carbon::now();
                    if ($start > $now || $stop < $now) {
                        $response = ["status" => 0, "message" => "Hediye çeki kullanım süresi dışında."];
                    } else {
                        if ($code->maxUse <= count($code->used)) {
                            $response = ["status" => 0, "message" => "Bu hediye çekinin kullanım hakkı bitmiş."];
                        } else {
                            $userUsed = \App\CampaignUsed::where("member_id", "=", Auth::guard('members')->user()->id)->where("campaign_id", "=", $code->id)->count();
                            if ($userUsed >= $code->PersonUseLimit) {
                                $response = ["status" => 0, "message" => "Bu hediye çekinin size tanımlanan kullanım hakkı bitmiş."];
                            } else {
                                $cart = new Cart(Session::get('cart'));
                                if ($cart->subTotal < $code->usageLimit) {
                                    $response = ["status" => 0, "message" => "Bu hediye çekini kullanmak için en düşük alışveriş miktarını aşmanız gerekmektedir. (Kdv Hariç : " . $code->usageLimit . " TL )"];
                                } else {
                                    // dd($cart->items[1]["item"]->p->categori->pluck('id'));
                                    //$merge = array_merge($cart->items[1]["item"]->p->categori->pluck('id')->toArray(),json_decode($code->specialValues));
                                    //$uniqueArr = array_unique($merge);
                                    //$duplicates = count($merge)!==count($uniqueArr) ? "Geçerli" : "Geçersiz";
                                    //var_dump($duplicates);
                                    //die();
                                    $appropriatePro = [];
                                    $availableQty   = 0;
                                    switch ($code->special) {
                                        //herkes kullanabilir
                                        case 1:
                                            foreach ($cart->items as $key => $value) {
                                                if ($code->discounted == 0) {
                                                    if ($value["item"]->p->discount_type == 0) {
                                                        $appropriatePro[] = $cart->items[$key];
                                                        $availableQty += $value["qty"];
                                                    }
                                                } else {
                                                    $appropriatePro[] = $cart->items[$key];
                                                    $availableQty += $value["qty"];
                                                }
                                            }
                                            //$appropriatePro=$cart->items;
                                            break;
                                        //belirli kategorilerde kullanabilir
                                        case '4':
                                            foreach ($cart->items as $key => $value) {
                                                $cids      = $value["item"]->p->categori->pluck('id')->toArray();
                                                $merge     = array_merge(json_decode($code->specialValues), $cids);
                                                $uniqueArr = array_unique($merge);
                                                if (count($merge) !== count($uniqueArr)) {
                                                    //indirimli ürünlerde geçerli değilse dahil etmeyelim
                                                    if ($code->discounted == 0) {
                                                        if ($value["item"]->p->discount_type == 0) {
                                                            $appropriatePro[] = $cart->items[$key];
                                                            $availableQty += $value["qty"];
                                                        }
                                                    } else {
                                                        $appropriatePro[] = $cart->items[$key];
                                                        $availableQty += $value["qty"];
                                                    }
                                                }
                                            }
                                            break;
                                        //belirli ürünlerde kullanılabilir
                                        case 5:
                                            foreach ($cart->items as $key => $value) {
                                                if (in_array($value["item"]->p->id, json_decode($code->specialValues))) {
                                                    //indirimli ürünlerde geçerli değilse dahil etmeyelim
                                                    if ($code->discounted == 0) {
                                                        if ($value["item"]->p->discount_type == 0) {
                                                            $appropriatePro[] = $cart->items[$key];
                                                            $availableQty += $value["qty"];
                                                        }
                                                    } else {
                                                        $appropriatePro[] = $cart->items[$key];
                                                        $availableQty += $value["qty"];
                                                    }
                                                }
                                            }
                                            break;
                                        //belirli markalarda kullanılabilir
                                        case 6:
                                            foreach ($cart->items as $key => $value) {
                                                if (in_array($value["item"]->p->brand_id, json_decode($code->specialValues))) {
                                                    //indirimli ürünlerde geçerli değilse dahil etmeyelim
                                                    if ($code->discounted == 0) {
                                                        if ($value["item"]->p->discount_type == 0) {
                                                            $appropriatePro[] = $cart->items[$key];
                                                            $availableQty += $value["qty"];
                                                        }
                                                    } else {
                                                        $appropriatePro[] = $cart->items[$key];
                                                        $availableQty += $value["qty"];
                                                    }
                                                }
                                            }
                                            break;
                                        default:
                                            # code...
                                            break;
                                    }
                                    //echo "<pre>";
                                    //print_r($cart);
                                    //echo "</pre>";
                                    //die();
                                    //dd(count($appropriatePro));

                                    if (count($appropriatePro) < 1) {
                                        $response = ["status" => 0, "message" => "Hediye çeki sepetteki hiç bir ürün için geçerli değil!"];
                                    } else {
                                        //ücretsiz kargo tanımlanmışsa kargo ücretini sıfırlayalım
                                        if ($code->freeShip == 1) {
                                            $cart->freeShipping = 1;
                                        } else {
                                            $code->freeShipping = 0;
                                        }

                                        //hediye çeki yüzde kullanım
                                        if ($code->value_type == 2) {
                                            //$oran   = (100-(((($cart->subTotal/100)*$code->value)/($cart->subTotal-(($cart->subTotal/100)*$code->value)))*100))/100;
                                            //$oran   = $oran/100;
                                            //$addTax = ($cart->taxTotal*$oran);
                                            //$newTax = $cart->taxTotal - $addTax;

                                            //$newTax = $cart->taxTotal - ($cart->taxTotal*($code->value/100));
                                            $code->value = round(($cart->subTotal / 100) * $code->value, 2);

                                            $discountedSub = $cart->subTotal - $code->value;
                                            $oran          = 100 - (($discountedSub / $cart->subTotal) * 100);
                                            $oran          = $oran / 100;
                                            $newTax        = $cart->taxTotal - ($cart->taxTotal * $oran);

                                            $cart->coupon         = $code->code;
                                            $cart->couponDiscount = $code->value;
                                            $cart->taxTotal       = $newTax;
                                            $cart->couponSubtotal = $cart->subTotal - $code->value;
                                            $cart->totalPrice     = $cart->couponSubtotal + $cart->taxTotal;
                                        } elseif ($code->value_type == 1) {
                                            //dd($cart);
                                            $discountedSub = $cart->subTotal - $code->value;
                                            $oran          = 100 - (($discountedSub / $cart->subTotal) * 100);
                                            $oran          = $oran / 100;
                                            $newTax        = $cart->taxTotal - ($cart->taxTotal * $oran);
                                            //dd($newTax);

                                            $cart->coupon         = $code->code;
                                            $cart->couponDiscount = $code->value;
                                            $cart->taxTotal       = $newTax;
                                            $cart->couponSubtotal = $cart->subTotal - $code->value;
                                            $cart->totalPrice     = $cart->couponSubtotal + $cart->taxTotal;
                                        }

                                        $cart->chosenPromotion = [];

                                        Session::put('cart', $cart);

                                        $response = ["status" => 200, "message" => "devam!"];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json($response);
    }

    public function deleteCode($code)
    {
        if (!Session::has('cart')) {
            return false;
        } else {
            $code = \App\Campaign::where('code', $code)->first();
            $cart = new Cart(Session::get('cart'));
            if ($cart && $code) {
                if ($code->value_type == 1) {
                    $oran   = ((($cart->subTotal / ($cart->subTotal - $code->value)) * 100) - 100);
                    $oran   = $oran / 100;
                    $addTax = ($cart->taxTotal * $oran);
                } else {
                    $code->value = round(($cart->subTotal / 100) * $code->value, 2);
                    $oran        = ((($cart->subTotal / ($cart->subTotal - $code->value)) * 100) - 100);
                    $oran        = $oran / 100;
                    $addTax      = ($cart->taxTotal * $oran);
                    //$oran = (100-(($cart->couponDiscount/$cart->couponSubtotal)*100))/100;
                    //$addTax = $cart->taxTotal-($cart->taxTotal*$oran);
                }

                $cart->coupon         = null;
                $cart->couponDiscount = 0;
                $cart->couponSubtotal = 0;
                $cart->freeShipping   = 0;
                $cart->taxTotal       = $cart->taxTotal + $addTax;
                $cart->totalPrice     = $cart->subTotal + $cart->taxTotal;
                Session::put('cart', $cart);
            } else {
                Session()->forget('cart');
            }
        }
    }

    public function usePromotion($id, $cart = null)
    {
        if ($cart == null) {
            $cart = new Cart(Session::get('cart'));
        } else {
            $cart = $cart;
        }

        //if ($cart->chosenPromotion) {
        $cart->promotionDiscount = 0;
        $cart->promotionProducts = [];
        //}

        $promotion         = \App\Promotion::where('id', $id)->first();
        $promotionProducts = \App\Products::select('id')->whereIn('id', json_decode($promotion->affectedProducts))->get();

        $cart->chosenPromotion = [
            "id"           => $promotion->id,
            "label"        => $promotion->name,
            "discount"     => $promotion->promotionValue,
            "discountType" => $promotion->promotionDiscountType,
        ];
        $cart->coupon         = null;
        $cart->couponDiscount = 0;
        $cart->couponSubtotal = 0;

        if (count($promotionProducts)) {
            //sepette promosyona dahil ürün varsa indirin uygulayalım
            foreach ($promotionProducts as $k => $v) {
                if (isset($cart->items[$v->id])) {
                    $count = $cart->items[$v->id]['qty'];
                    //sepette promosyonlu ürün promosyon adet sınırından fazla varsa izin verilen kadar uygulayalım
                    if ($count > $promotion->affectedCount) {
                        $count = $promotion->affectedCount;
                        //$cart->promotionDiscount = $promotion->affectedCount * $promotion->promotionValue;
                    }

                    //promosyonun geçerli olması için minumum urun miktarı sağlıyor mu?
                    if ($cart->items[$v->id]['qty'] < $promotion->baseCount) {
                        $count = 0;
                    }

                    //indirim tipine göre uygulaalım
                    if ($promotion->promotionDiscountType == "rebateProduct") {
                        $cart->promotionDiscount += $count * $promotion->promotionValue;
                    } elseif ($promotion->promotionDiscountType == "rebatePercentProduct") {
                        //dd($cart->items[$v->id]);
                        $cart->promotionDiscount += $count * (($promotion->promotionValue * $cart->items[$v->id]['item']->realPrice) / 100);
                    } elseif ($promotion->promotionDiscountType == "free") {
                        $cart->promotionDiscount += $count * $cart->items[$v->id]['item']->realPrice;
                    }

                    $cpp                     = $cart->promotionProducts;
                    $cpp[$v->id]             = $cart->promotionDiscount;
                    $cart->promotionProducts = $cpp;
                }
            }
        } else {
            //dd($promotion->promotionDiscountType);
            //exit();
            //ayrıca promosyonlu ürün tanımlanmamışsa sepet indirimi
            if ($promotion->promotionDiscountType == "rebateProduct") {
                $cart->promotionDiscount = $promotion->promotionValue;
            } elseif ($promotion->promotionDiscountType == "rebatePercentProduct") {
                $cart->promotionDiscount = ($cart->totalPrice * $promotion->promotionValue) / 100;
            }
        }

        //dd($cart->promotionDiscount);

        Session::put('cart', $cart);

        return redirect('sepet');
    }

    public function getPromotions()
    {
        $promotions = \App\Promotion::where('status', '1')->orderBy('sort')->get();
        $usable     = [];
        $cart       = new Cart(Session::get('cart'));

        if (count($cart->items) > 0) {
            foreach ($promotions as $key => $v) {
                $time = 1;
                if ($v->selectedDate == 1) {
                    $start = new Carbon($v->startDate);
                    $stop  = new Carbon($v->stopDate);
                    $now   = Carbon::now();
                    if ($start > $now || $stop < $now) {
                        $response = ["status" => 0, "message" => "Promosyon kullanım süresi dışında."];
                        $time     = 0;
                    } else {
                        $time = 1;
                    }
                }

                if ($time == 1) {
                    //$start   = new Carbon($v->startDate);
                    //$stop    = new Carbon($v->stopDate);
                    //$now = Carbon::now();
                    if ($v->maxUsage <= count($v->totalUsage)) {
                        $response = ["status" => 0, "message" => "Bu promosyonun kullanım hakkı bitmiş."];
                    } else {
                        if ($cart->subTotal < $v->basePriceLimit) {
                            $response = ["status" => 0, "message" => "Bu promosyonu kullanmak için en düşük alışveriş miktarını aşmanız gerekmektedir. (Kdv Hariç : " . $v->basePriceLimit . " TL )"];
                        } else {
                            switch ($v->type) {
                                //sepet bazlı promosyon
                                case 0:
                                    $pros = \App\Products::select('id', 'name', 'slug', 'final_price', 'stock_type', 'price', 'tax', 'tax_status', 'discount', 'discount_type')->whereIn('id', json_decode($v->affectedProducts))->get();
                                    //if (count($pros)>0) {
                                    $usable[] = [
                                        "promotion" => $promotions[$key],
                                        "products"  => $pros,
                                    ];
                                    //}
                                    break;
                                //urun bazlı promosyon
                                case 1:
                                    $check = 0;
                                    if ($v->baseProductsOperator == 1) {
                                        //ana ürünlerin herhangi birinin alınması zorunlu
                                        foreach (json_decode($v->baseProducts) as $pk => $p) {
                                            if (array_key_exists($p, $cart->items)) {
                                                $check = 1;
                                                break;
                                            }
                                        }
                                    } else {
                                        //ana ürünlerin birlikte alınması zorunlu
                                        foreach (json_decode($v->baseProducts) as $pk => $p) {
                                            if (array_key_exists($p, $cart->items)) {
                                                $check = 1;
                                            } else {
                                                $check = 0;
                                                break;
                                            }
                                        }
                                    }

                                    if ($check == 0) {
                                        $response = ["status" => 0, "message" => "Promosyonunlu ürünler sepette bulunmuyor."];
                                    } else {
                                        //$usable[]=$promotions[$key];
                                        $pros = \App\Products::select('id', 'name', 'slug', 'final_price', 'stock_type', 'price', 'tax', 'tax_status', 'discount', 'discount_type')->with('images')->whereIn('id', json_decode($v->affectedProducts))->get();
                                        if (count($pros) > 0) {
                                            $usable[] = [
                                                "promotion" => $promotions[$key],
                                                "products"  => $pros,
                                            ];
                                        }
                                    }

                                    break;

                                default:
                                    $response = ["status" => 0, "message" => "Promosyonun tanımı belirsiz."];
                                    break;
                            }
                        }
                    }
                }
            }
        } else {
            $response = ["status" => 0, "message" => "Promosyon kullanmak için sepette ürün bulunması gerekmektedir."];
        }

        return $usable;
    }

    public function categoryPage(Request $request)
    {
        dd($request);
    }

    public function getCategori($id)
    {
        $cat = Cache::remember('category' . $id, 10, function () use ($id) {
            return \App\Categori::where('id', $id)->where('status', 1)->with('childs')->first();
        });

        return $cat;
    }

    public function getCategories()
    {
        return Cache::remember('categories', 10, function () {
            $data = Categori::where('status', '1')
                ->orderBy('sort')
                ->get();

            return Nestable::make($data)->renderAsArray();
            // return Categori::where('status', '1')->orderBy('sort')->renderAsArray();
        });
    }

    public function getBrand($id)
    {
        $brands = Cache::remember('brand-' . $id, 22 * 60, function () use ($id) {
            return Brand::where('id', $id)->first();
        });
        return $brands;
    }

    public function getBrands()
    {
        $brands = Cache::remember('brands', 22 * 60, function () {
            return Brand::orderBy('sort')->get();
        });
        return $brands;
    }

    public function getCities()
    {
        $cities = Cache::remember('cities', 22 * 60, function () {
            return \App\Cities::where('status', 1)->orderBy('name')->get();
        });
        return $cities;
    }

    public function districtsRequest(Request $request)
    {
        return response()->json($this->getDistricts($request->get("id")));
    }

    public function getDistricts($id)
    {
        $state = Cache::remember('districts_' . $id, 22 * 60, function () use ($id) {
            return \App\Districts::select(["id", "name", "cities_id"])->where('cities_id', $id)->get();
        });
        return $state;
    }

    public function checkout(Request $request)
    {
        if (!Session::has('cart') || Session::get('cart')->totalQty <= 0) {
            return redirect('sepet');
        }

        //shipping companies
        $cart = new Cart(Session::get('cart'));

        if (!Auth::guard("members")->check() && !$cart->guest) {
            $cart->guest = true;
            Session::put('cart', $cart);
            return redirect('uye-girisi?returnUrl=fatura-teslimat');
        }

        // Teslimat Bilgileri
        $shippingInfos = (object) ($cart->others);

        $cities            = $this->getCities();
        $shippingCompanies = Cache::remember('shippingCompanies', 22 * 60, function () {
            return \App\Shipping::where('status', 1)->orderBy('sort')->get();
        });

        $slots = [];
        if (isset($cart->shipping) && !empty($cart->shipping->id)) {
            $request->request->add(['shipping' => $cart->shipping->id]);
            $gcsResp = $this->getCartShipping();
            $slots   = $gcsResp->getData('cart')['slot'];
        }

        return view('frontEnd.blades.checkout', compact('shippingCompanies', 'cities', 'slots', 'shippingInfos'));
    }

    public function getCartShipping()
    {
        $cartShipping = app(CartShipping::class)->calculate();

        return response()->json($cartShipping);
    }

    // public function getCartShipping()
    // {
    //     $arr['ttl']          = 0;
    //     $arr['cartTtl']      = 0;
    //     $arr['slot']         = 0;
    //     $arr['freeShipping'] = "";
    //     $totalShipPrice      = 0;
    //     $totalDesi           = 0;
    //     $freeShipProdCount   = 0;
    //     $cartFreeShip        = false;
    //     $id                  = $request->get("shipping");
    //     $shippingCompany     = $this->getShippingCompany($id);

    //     if (!$shippingCompany || !Session::has('cart') || Session::get('cart')->totalQty <= 0) {
    //         return false;
    //     }

    //     $cart    = new Cart(Session::get('cart'));
    //     $arr     = ["cart" => $cart, "company" => $shippingCompany];
    //     $myPrice = new Price();

    //     // Kargo Fiyatını Hesapla
    //     foreach ($cart->items as $item) {
    //         // desi değerleri girlmmeiş ürün hataya düşebilir kontrolünü yap
    //         if (isset($item['item']->p->shippings->use_system)) {
    //             if ($item['item']->p->shippings->use_system == 0) {
    //                 $totalShipPrice += $item['item']->p->shippings->shipping_price;

    //                 // ürün ücretsiz kargo ise
    //                 if ($item['item']->p->shippings->shipping_price == 0) {
    //                     $freeShipProdCount++;
    //                 }
    //             } else {
    //                 $totalDesi += $item['item']->p->shippings->desi * $item['qty'];
    //             }
    //         }
    //     }

    //     $totalDesi = intval(floor($totalDesi));

    //     $companyDesiValues = json_decode($shippingCompany->roles->desi);

    //     if (isset($companyDesiValues[$totalDesi]) && is_numeric($companyDesiValues[$totalDesi])) {
    //         $totalShipPrice += $companyDesiValues[$totalDesi];
    //     } elseif ($totalDesi > 50) {
    //         $desiDiff      = $totalDesi - 50;
    //         $desiDiffTotal = $desiDiff * floatval($shippingCompany->roles->weight_price);
    //         if (!empty($companyDesiValues[50])) {
    //             $totalShipPrice += $companyDesiValues[50] + $desiDiffTotal;
    //         }
    //     }

    //     // ücretsiz kargo kontrolü ?
    //     if ($shippingCompany->roles->free_shipping == 0) {
    //         $totalShipPrice += $shippingCompany->roles->fixed_price;
    //         $arr["freeShipping"] = "";
    //     } else {
    //         $arr["freeShipping"] = $shippingCompany->roles->free_shipping . " TL üzeri siparişlerinizde kargo ücretsizdir!";
    //         $cartTotalPrice = floatval($cart->totalPrice) - floatval($cart->promotionDiscount);

    //         // Sepet tutarı ücretsiz kargo minimum tutarından küçük ise sabit kargo fiyatını ekle
    //         if ($cartTotalPrice < floatval($shippingCompany->roles->free_shipping)) {
    //             $totalShipPrice += $shippingCompany->roles->fixed_price;
    //         } else {
    //             // toplam desi ücretsiz kargo desi limitinden buyuk mü?
    //             if ($totalDesi > $shippingCompany->roles->weight_limit) {
    //                 $diffWeightlimit = $totalDesi - $shippingCompany->roles->weight_limit;

    //                 if ($diffWeightlimit > 50) {
    //                     $desiDiff      = $diffWeightlimit - 50;
    //                     $desiDiffTotal = $desiDiff * $shippingCompany->roles->weight_price;
    //                     $totalShipPrice += $companyDesiValues[50] + $desiDiffTotal;
    //                 }else {
    //                     $cartFreeShip = true;
    //                 }
    //             }else {
    //                 $cartFreeShip = true;
    //             }
    //         }
    //     }

    //     $slots = array();
    //     if (count($shippingCompany->slots) > 0) {
    //         foreach ($shippingCompany->slots as $key => $value) {
    //             $records = DB::table('order_slots')
    //                 ->where('shipping_slot_id', '=', $value->id)
    //                 ->whereRaw('Date(created_at) = CURDATE()')
    //                 ->count();

    //             if ($records < $value->max) {
    //                 $slots[] = $shippingCompany->slots[$key];
    //             }
    //         }
    //     }

    //     $arr["slot"] = $slots;

    //     // Eğer sepette bulunan tüm ürünlerin kargo ücreti 0 olarak girildiyse
    //     if (count($cart->items) == $freeShipProdCount) {
    //         $totalShipPrice = 0;
    //     }

    //     // Eğer ücretsiz kargo atanmışsa kargo ücretini sıfırlayalım
    //     if ($cart->freeShipping == 1) {
    //         $totalShipPrice = 0;
    //     }

    //     // Eğer özel bir fiyat tanımlanmış ise hesaplanan fiyatı kargo ücreti olarak ayarla
    //     if (!$cartFreeShip && isset($cart->shipping->roles->custom_prices) && is_array($cart->shipping->roles->custom_prices)) {
    //         $customPrices = $cart->shipping->roles->custom_prices;

    //         // Tanımlanan Tüm Özel Fiyatları Hesapla
    //         foreach ($customPrices['conditions'] as $customPriceIndex => $customPriceCondition) {
    //             $shippingPrice = floatval($customPrices['shippingPrice'][$customPriceIndex]);

    //             // Sepet Tutarına Göre Koşulları Uygula
    //             if ($customPriceCondition == 'between') {
    //                 $cartAmountStart = floatval($customPrices['cartAmountStart'][$customPriceIndex]);
    //                 $cartAmountEnd   = floatval($customPrices['cartAmountEnd'][$customPriceIndex]);

    //                 if ($cart->totalPrice >= $cartAmountStart && $cart->totalPrice <= $cartAmountEnd) {
    //                     $totalShipPrice = $shippingPrice;
    //                 }
    //             }
    //         }
    //     }

    //     $arr["cartTtl"] = $myPrice->currencyFormat($totalShipPrice + $cart->totalPrice);
    //     $arr["ttl"]     = $myPrice->currencyFormat($totalShipPrice);

    //     $cart->setShippingPrice($totalShipPrice);
    //     $cart->setShipping($shippingCompany);

    //     Session::put('cart', $cart);

    //     //return $shippingCompany;
    //     return response()->json($arr);
    // }

    public function getShippingCompany($id)
    {
        $shippingCompany = Cache::remember('shippingCompany_' . $id, 22 * 60, function () use ($id) {
            return \App\Shipping::with('roles', 'slots')->where(["status" => 1, "id" => $id])->first();
        });
        return $shippingCompany;
    }

    public function createDeliveryAddress(Request $request)
    {
        $validateArray        = [];
        $validateMessageArray = [];
        $response             = [];

        $validateArray[] = [
            'address_name' => 'required|',
            'name'         => 'required|',
            'surname'      => 'required|',
            'phone'        => 'required|',
            // 'phoneGsm'     => 'required|',
            'city'         => 'required|',
            'state'        => 'required|',
        ];
        $validateMessageArray[] = [
            'address_name.required' => 'Adres adı alanı boş geçilemez.',
            'name.required'         => 'Ad alanı boş geçilemez.',
            'surname.required'      => 'Soyad alanı boş geçilemez.',
            'phone.required'        => 'Telefon alanı boş geçilemez.',
            //'phone.numeric'=>'Telefon alanı rakam içermelidir.',
            // 'phoneGsm.required'     => 'Cep telefonu alanı boş geçilemez.',
            'city.required'         => 'Şehir alanı boş geçilemez.',
            'state.required'        => 'İlçe alanı boş geçilemez.',
        ];

        $validator = Validator::make($request->all(), $validateArray[0], $validateMessageArray[0]);

        if ($validator->passes()) {
            if (Auth::guard("members")->check() == true) {
                //Kayıt işlemi (teslimat adresi)
                $data = [
                    "address_name" => trim($request->get("address_name")),
                    "name"         => trim($request->get("name")),
                    "surname"      => trim($request->get("surname")),
                    "phone"        => $request->get("phone"),
                    "phoneGsm"     => $request->get("phone"),
                    "address"      => $request->get("address"),
                    "member_id"    => Auth::guard('members')->user()->id,
                    "city"         => $request->get("city"),
                    "state"        => $request->get("state"),
                ];
                $add = \App\ShippingAddress::create($data);

                if ($request->get("chooseBilling") == 1) {
                    $addBilling       = \App\BillingAddress::create($data);
                    $addBillingStatus = true;
                    $addBillingId     = $addBilling->id;
                } else {
                    $addBillingStatus = false;
                    $addBillingId     = 0;
                }

                $countBilling = count(Auth::guard('members')->user()->getBillingAddress);

                $response = ["status" => 200, "message" => "success.", "option" => $request->get("address_name"), "optionId" => $add->id, "same" => $addBillingStatus, "countBilling" => $countBilling, "addBillingId" => $addBillingId];
            } else {
                $response = ["status" => 0, "message" => "Kullanıcı girişi yapılmamış."];
            }
        } else {
            $response = ["status" => 0, "message" => "error.", "validator" => $validator->errors()->all()];
        }

        return response()->json($response);
    }

    public function changeDeliveryAddress(Request $request)
    {
        return \App\ShippingAddress::select(["id", "address_name", "name", "surname", "phone", "phoneGsm", "address", "city", "state"])->where('id', $request->get('id'))->first();
    }

    public function createBillingAddress(Request $request)
    {
        $validateArray        = [];
        $validateMessageArray = [];
        $response             = [];

        $validateArray[] = [
            'address_name' => 'required|',
            'name'         => 'required|',
            //'surname'   => 'required|',
            'phone'        => 'required|',
            // 'phoneGsm'     => 'required|',
            'city'         => 'required|',
            'state'        => 'required|',
        ];
        $validateMessageArray[] = [
            'address_name.required' => 'Adres adı alanı boş geçilemez.',
            //'name.required'=> 'Ad alanı boş geçilemez.',
            'surname.required'      => 'Soyad alanı boş geçilemez.',
            'phone.required'        => 'Telefon alanı boş geçilemez.',
            //'phone.numeric'=>'Telefon alanı rakam içermelidir.',
            // 'phoneGsm.required'     => 'Cep telefonu alanı boş geçilemez.',
            'city.required'         => 'Şehir alanı boş geçilemez.',
            'state.required'        => 'İlçe alanı boş geçilemez.',
        ];

        if ($request->get("billingType") == 2) {
            $validateArray["taxOffice"] = "required|";
            $validateArray["taxNo"]     = "required|";

            $validateMessageArray["taxOffice.required"] = "Vergi dairesi alanı boş geçilemez.";
            $validateMessageArray["taxNo.required"]     = "Vergi numarası alanı boş geçilemez.";
            $validateMessageArray["name.required"]      = "Ticari unvan alanı boş geçilemez.";
        } else {
            $validateArray["surname"]                 = "required|";
            $validateMessageArray["surname.required"] = "Soyad alanı boş geçilemez.";
            $validateMessageArray["name.required"]    = "Ad unvan alanı boş geçilemez.";
        }

        $validator = Validator::make($request->all(), $validateArray[0], $validateMessageArray[0]);

        if ($validator->passes()) {
            if (Auth::guard("members")->check() == true) {
                //Kayıt işlemi (teslimat adresi)
                $data = [
                    "address_name" => trim($request->get("address_name")),
                    "name"         => trim($request->get("name")),
                    "surname"      => trim($request->get("surname")),
                    "phone"        => $request->get("phone"),
                    "phoneGsm"     => $request->get("phone"),
                    "address"      => $request->get("address"),
                    "member_id"    => Auth::guard('members')->user()->id,
                    "city"         => $request->get("city"),
                    "state"        => $request->get("state"),
                    "type"         => $request->get("billingType"),
                ];
                if ($request->get("billingType") == 2) {
                    $data["tax_place"] = $request->get("taxOffice");
                    $data["tax_no"]    = $request->get("taxNo");
                }
                $add = \App\BillingAddress::create($data);

                $countDelivery = count(Auth::guard('members')->user()->getShippingAddress);

                $response = ["status" => 200, "message" => "success.", "option" => $request->get("address_name"), "optionId" => $add->id, "countDelivery" => $countDelivery];
            } else {
                $response = ["status" => 0, "message" => "Kullanıcı girişi yapılmamış."];
            }
        } else {
            $response = ["status" => 0, "message" => "error.", "validator" => $validator->errors()->all()];
        }

        return response()->json($response);
    }

    public function changeBillingAddress(Request $request)
    {
        return \App\BillingAddress::select(["id", "address_name", "name", "surname", "phone", "phoneGsm", "address", "city", "state", "tax_place", "tax_no"])->where('id', $request->get('id'))->first();
    }

    public function setBilling(Request $request)
    {
        $validateArray        = [];
        $validateMessageArray = [];

        if (Auth::guard("members")->check() == false) {
            //ziyaretçi
            $validateArray[] = [
                'guest_name'             => 'required|',
                'guest_surname'          => 'required|',
                'guest_email'            => 'required|email|unique:users,email|',
                'guest_email_comfirm'    => 'required|same:guest_email|',
                'newDeliveryAddressName' => 'required|',
                'newDeliveryName'        => 'required|',
                'newDeliverySurname'     => 'required|',
                'newDeliveryPhone'       => 'required|',
                // 'newDeliveryPhoneGsm'    => 'required|',
                //'newDeliveryIdentity' => 'required|',
                'newDeliveryAddress'     => 'required|',
                'newDeliveryCity'        => 'required|',
                'newDeliveryState'       => 'required|',
            ];
            $validateMessageArray[] = [
                'guest_name.required'             => 'Ad alanı boş geçilemez.',
                'guest_surname.required'          => 'Soyad alanı boş geçilemez.',
                'guest_email.required'            => 'Email alanı boş geçilemez.',
                'guest_email.unique'              => "Email adresi sistemde kayıtlıdır. Giriş yaparak alışverişe devam edebilirsiniz.",
                'guest_email.email'               => 'Lütfen geçerli bir email adresi giriniz.',
                'guest_email_comfirm.required'    => 'Email tekrar alanı boş geçilemez.',
                'guest_email_comfirm.same'        => 'Email adresleri eşleşmiyor.',
                'newDeliveryAddressName.required' => 'Teslimat adres adı boş geçilemez.',
                'newDeliveryName.required'        => 'Ad alanı boş geçilemez.',
                'newDeliverySurname.required'     => 'Soyad alanı boş geçilemez.',
                'newDeliveryPhone.required'       => 'Telefon alanı boş geçilemez.',
                // 'newDeliveryPhoneGsm.required'    => 'Cep telefonu alanı boş geçilemez.',
                'newDeliveryAddress.required'     => 'Adres alanı boş geçilemez.',
                'newDeliveryCity.required'        => 'İl seçimi yapmadınız.',
                'newDeliveryState.required'       => 'İlçe seçimi yapmadınız.',
            ];
        }

        //dd($request->get("chooseBilling"));

        if (Auth::guard("members")->check() == false && $request->get("chooseBilling") == null) {
            //ziyaretçi farklı fatura
            if ($request->get('billingType') == 2) {
                //kurumsal
                $addArr = [
                    'newBillingTaxOffice' => 'required|',
                    'newBillingTaxNo'     => 'required|',
                ];
                $addArrMess = [
                    'newBillingTaxOffice.required' => 'Vergi dairesi alanı boş geçilemez.',
                    'newBillingTaxNo.required'     => 'Vergi numarası alanı boş geçilemez.',
                    'newBillingName.required'      => 'Ticari Ünvanı alanı boş geçilemez.',
                ];
                $validateArray[0]        = array_merge($validateArray[0], $addArr);
                $validateMessageArray[0] = array_merge($validateMessageArray[0], $addArrMess);
            } else {
                //bireysel
                $addArr = [
                    'newBillingSurname' => 'required|',
                ];
                $addArrMess = [
                    'newBillingSurname.required' => 'Soyad alanı boş geçilemez.',
                    'newBillingName.required'    => 'Ad alanı boş geçilemez.',
                ];
                $validateArray[0]        = array_merge($validateArray[0], $addArr);
                $validateMessageArray[0] = array_merge($validateMessageArray[0], $addArrMess);
            }

            $validateArray2 = [
                'newBillingAddressName' => 'required|',
                'newBillingName'        => 'required|',
                'newBillingPhone'       => 'required|',
                // 'newBillingPhoneGsm'    => 'required|',
                'newBillingAddress'     => 'required|',
                'newBillingCity'        => 'required|',
                'newBillingState'       => 'required|',
            ];
            $validateArray[0]      = array_merge($validateArray[0], $validateArray2);
            $validateMessageArray2 = [
                'newBillingAddressName.required' => 'Fatura adres adı boş geçilemez.',
                'newBillingPhone.required'       => 'Telefon alanı boş geçilemez.',
                // 'newBillingPhoneGsm.required'    => 'Cep telefonu alanı boş geçilemez.',
                'newBillingAddress.required'     => 'Adres alanı boş geçilemez.',
                'newBillingCity.required'        => 'İl seçimi yapmadınız.',
                'newBillingState.required'       => 'İlçe seçimi yapmadınız.',
            ];
            $validateMessageArray[0] = array_merge($validateMessageArray[0], $validateMessageArray2);
        }

        if (Auth::guard('members')->check() == true) {
            $validateArray[0]['deliveryAdress']                 = 'required|';
            $validateMessageArray[0]['deliveryAdress.required'] = "Lütfen bir adres bilgisi tanımlayınız!";
        }

        $validateArray[0]['shipping']                 = 'required|numeric';
        $validateMessageArray[0]['shipping.required'] = "Kargo seçimi yapmadınız.";

        $shipping = $this->getShippingCompany($request->get("shipping"));

        if (count(@$shipping->slots) > 0) {
            $validateArray[0]['shippingSlot']                 = 'required|numeric';
            $validateMessageArray[0]['shippingSlot.required'] = "Teslimat saati seçmediniz.";
        }

        /**
         * Kargo Rol Kullanım Tipini Kontrol Et
         */
        $deliveryCity = $request->get('newDeliveryCity');

        if (Auth::guard('members')->check()) {
            $deliveryCity = ShippingAddress::where('id', $request->get('deliveryAdress'))->first(['city']);
            $deliveryCity = optional($deliveryCity)->city;
        }

        // Kullanım Tipi Şehir ise teslimat adresini kontrol et
        if (!$shipping->roles->checkDeliveryCity($deliveryCity)) {
            $validateArray[0]['shipping_role_type']                 = 'required|';
            $validateMessageArray[0]['shipping_role_type.required'] = "Seçilen kargo firması sadece {$shipping->roles->getShippingCities()} il(ler)ine teslimat yapmaktadır!";
        }

        $this->validate($request, $validateArray[0], $validateMessageArray[0]);

        if (Session::has('cart')) {
            $requestData = $request->all();

            if ($request->has("chooseBilling") && $request->get("chooseBilling") == 1) {
                $requestData["newBillingAddressName"] = $request->get('newDeliveryAddressName');
                $requestData["newBillingName"]        = $request->get('newDeliveryName');
                $requestData["newBillingSurname"]     = $request->get('newDeliverySurname');
                $requestData["newBillingPhone"]       = $request->get('newDeliveryPhone');
                // $requestData["newBillingPhoneGsm"]    = $request->get('newDeliveryPhoneGsm');
                $requestData["newBillingAddress"] = $request->get('newDeliveryAddress');
                $requestData["newBillingCity"]    = $request->get('newDeliveryCity');
                $requestData["newBillingState"]   = $request->get('newDeliveryState');
                if ($request->get("billingType") == 1) {
                    $requestData["newBillingTaxOffice"] = $request->get('newBillingTaxOffice');
                    $requestData["newBillingTaxNo"]     = $request->get('newBillingTaxNo');
                }
            } else {
                $requestData["chooseBilling"] = 0;
            }

            if (Auth::guard('members')->check() == true) {
                $requestData['memberDelivery'] = ShippingAddress::where('id', $request->get('deliveryAdress'))->first();
                $requestData['memberBilling']  = BillingAddress::where('id', $request->get('billingAddress'))->first();
            }

            $cart = new Cart(Session::get('cart'));
            $cart->setOthers($requestData);
            $shipping = $this->getShippingCompany($cart->others["shipping"]);
            $cart->setShipping($shipping);

            Session::put('cart', $cart);
            //dd($cart);

            return redirect('sepet/odeme');
        }
    }

    public function odeme()
    {
        $cart    = new Cart(Session::get('cart'));
        $myPrice = new Price();

        if (empty($cart->items)) {
            return redirect('sepet');
        }

        //$shipping = $this->getShippingCompany($cart->others["shipping"]);
        //dd($cart);

        $prromotionInfo = "";

        if ($cart->promotionDiscount > 0) {
            $prromotionInfo = '<tr>
                    <td width="40%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">Promosyon Avantajı&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">' . $myPrice->currencyFormat($cart->promotionDiscount) . ' TL&nbsp;</span></td>
                </tr>';
        }

        $urunler = "";

        foreach ($cart->items as $p) {
            $urunler .= '<tr>
                    <td width="40%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">' . $p["item"]->p->name . '&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">' . $p["qty"] . '&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">1&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">' . $myPrice->currencyFormat($p["item"]->realPrice * $p["qty"]) . ' TL&nbsp;</span></td>
                </tr>';
        }

        $urunbilgileri = '<table id="agrementproduct" border="0" cellpadding="0" cellspacing="0" width="80%">
                <tbody><tr>
                    <td width="40%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">Ürün Adı</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">Adet</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">Taksit Sayısı</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">Taksitli Fiyatı</span></td>
                </tr>

                ' . $urunler . '
                <tr>
                    <td width="40%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">Kdv Tutarı</span></td>
                    <td width="10%" style="padding: 5px; float:left;"><span style="font-family: Arial; font-size: 8pt;"></span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">' . $myPrice->currencyFormat($cart->taxTotal) . ' TL&nbsp;</span></td>
                </tr>
                <tr>
                    <td width="40%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt; ">Kargo Ücreti</span></td>
                    <td width="10%" style="padding: 5px; float:left;"><span style="font-family: Arial; font-size: 8pt;"></span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt; ">' . $myPrice->currencyFormat($cart->shippingPrice) . ' TL&nbsp;</span></td>
                </tr>
                ' . $prromotionInfo . '
                <tr>
                    <td colspan="6"><hr></td>
                </tr>
                <tr>
                    <td width="40%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">Genel Toplam</span></td>
                    <td width="10%" style="padding: 5px; float:left;"><span style="font-family: Arial; font-size: 8pt;">&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">&nbsp;</span></td>
                    <td width="10%" style="padding: 5px;"><span style="font-family: Arial; font-size: 8pt;">' . $myPrice->currencyFormat(($cart->totalPrice + $cart->shippingPrice) - $cart->promotionDiscount) . ' TL&nbsp;</span></td>
                </tr>
            </tbody></table>';

        $aliciSearch = [
            "{aliciad}",
            "{alicisoyad}",
            "{teslimatadresi}",
            "{alicitelefon}",
            "{alicimail}",
            "{urunbilgileri}",
            "{kargo}",
            "{odemesekli}",
            "{odemetablosu}",
            "{faturaadresi}",
            "{tarih}",
        ];
        $aliciReplace = [

            Auth::guard('members')->check() == true ? $cart->others["memberDelivery"]->name : $cart->others["newDeliveryName"],
            Auth::guard('members')->check() == true ? $cart->others["memberDelivery"]->surname : $cart->others["newDeliverySurname"],
            Auth::guard('members')->check() == true ? $cart->others["memberDelivery"]->address . " " . $cart->others["memberDelivery"]->city . " / " . $cart->others["memberDelivery"]->state : $cart->others["newDeliveryAddress"] . " " . $cart->others["newDeliveryCity"] . " / " . $cart->others["newDeliveryState"],
            Auth::guard('members')->check() == true ? $cart->others["memberDelivery"]->phone : $cart->others["newDeliveryPhone"],
            Auth::guard('members')->check() == true ? Auth::guard('members')->user()->email : $cart->others["guest_email"],
            $urunbilgileri,
            $myPrice->currencyFormat($cart->shippingPrice) . " TL",
            "<span id='payType'>Kredi Kartı</span>",
            "<span id='payTable'>Kredi Kartı Tek Çekim Toplam :" . $myPrice->currencyFormat(($cart->totalPrice + $cart->shippingPrice) - $cart->promotionDiscount) . " TL</span>",
            Auth::guard('members')->check() == true ? $cart->others["memberBilling"]->address . " " . $cart->others["memberBilling"]->city . " / " . $cart->others["memberBilling"]->state : $cart->others["newBillingAddress"] . " " . $cart->others["newBillingCity"] . " / " . $cart->others["newBillingState"],
            Carbon::now()->format('d.m.Y'),
        ];

        //dd($aliciReplace);

        return view('frontEnd.blades.pay', compact('cart', 'aliciSearch', 'aliciReplace'));
    }

    public function account()
    {
        $user = Auth::guard('members')->user();
        return view('frontEnd.blades.account', compact('user'));
    }

    public function accountUpdate(Request $request)
    {
        $validateArray[] = [
            'name'     => 'required|',
            'surname'  => 'required|',
            'captcha'  => 'required|captcha',
            'phone'    => 'required|',
            'phoneGsm' => 'required|',
        ];
        $validateMessageArray[] = [
            'name.required'    => 'Ad alanı boş geçilemez.',
            'surname.required' => 'Soyad alanı boş geçilemez.',
            'captcha.required' => 'Güvenlik kodu boş geçilemez.',
            'captcha.captcha'  => 'Güvenlik kodunu kontrol ediniz.',
        ];

        $this->validate($request, $validateArray[0], $validateMessageArray[0]);

        $data = [
            "name"            => $request->get('name'),
            "surname"         => $request->get('surname'),
            "phone"           => $request->get('phone'),
            "phoneGsm"        => $request->get('phoneGsm'),
            "bday"            => DateTime::createFromFormat('Y-m-d', $request->get('year') . '-' . $request->get('month') . '-' . $request->get('day')),
            "gender"          => $request->get('gender'),
            "allowed_to_mail" => $request->has('allowed_to_mail') ? 1 : 0,
        ];

        $user = Auth::guard('members')->user();

        \App\Member::where("id", "=", $user->id)->update($data);

        return redirect('hesabim');

        //dd($request->all());
    }

    public function changePass()
    {
        return view('frontEnd.blades.changePass');
    }

    public function updatePass(Request $request)
    {
        $validateArray[] = [
            'password'         => 'required|min:4|max:16|regex:/^[\w-]*$/|',
            'password_confirm' => 'required|same:password',
        ];
        $validateMessageArray[] = [
            'password.min'              => 'Şifre 4 karakterden az olamaz.',
            'password.max'              => 'Şifre 16 karakterden fazla olamaz.',
            'password.required'         => ' Şifre alanı boş geçilemez.',
            'password.regex'            => 'Şifre sadece alfanumerik karaterler içerebilir,Türkçe karakter ve boşluk içeremez.',
            'password_confirm.same'     => 'Şifreler uyuşmuyor.',
            'password_confirm.required' => 'Şifre Tekrar alanı boş geçilemez.',
        ];

        $data = ["password" => bcrypt($request->get("password"))];

        $this->validate($request, $validateArray[0], $validateMessageArray[0]);

        $user = Auth::guard('members')->user();

        \App\Member::where("id", "=", $user->id)->update($data);

        return redirect('hesabim/sifre-degistir')->with('message', 'Şifre başarılı bir şekilde değiştirildi.');
    }

    public function approveOrder(Request $request)
    {
        if (Session::has('cart')) {
            $data         = [];
            $cart         = new Cart(Session::get('cart'));
            $data["cart"] = $cart;

            //stok kontrol
            $noStock      = [];
            $onlyStockPro = DB::table('products')
                ->whereIn('id', array_keys($cart->items))
                ->select('stock', 'id')
                ->get();

            //dd($onlyStockPro);

            foreach ($onlyStockPro as $key => $value) {
                if ($cart->items[$value->id]["qty"] > $value->stock) {
                    $noStock[] = [
                        "id"        => $value->id,
                        "available" => $value->stock,
                    ];

                    //sepetteki ürünün adetini var olan kadar değiştirim yoksa silelim
                    if ($value->stock > 0) {
                        $cart->updateItem($value->id, $value->stock);
                    } else {
                        $cart->removeItem($value->id);
                    }
                }
            }

            Session::put('cart', $cart);

            $emptyCheck = array_filter($noStock);

            if (empty($emptyCheck)) {
                switch ($request->get('po')) {
                    case 'havale':
                        $data["payment_type"] = 1;
                        $data["bank_id"]      = $request->get('bank_id');

                        if ($this->createOrder($data)) {
                            $result = ["status" => 200, "po" => "havale", "message" => "Sipariş Alındı"];
                        } else {
                            $result = ["status" => 0, "message" => "Hata"];
                        }
                        return response()->json($result);
                        break;
                    case 'kk':
                        $price                   = ($cart->totalPrice - $cart->promotionDiscount) + $cart->shippingPrice;
                        $orders_no               = "";
                        $webpos_bank['cc_owner'] = $request->get("firstname"); //"emre";
                        // $webpos_bank['cc_number']            = $request->get('card1') . $request->get('card2') . $request->get('card3') . $request->get('card4'); //"4508034508034509";
                        $webpos_bank['cc_number']            = str_replace(' ', '', $request->get('card_number'));
                        $webpos_bank['cc_cvv2']              = $request->get("cvc"); //"000";
                        $webpos_bank['cc_expire_date_month'] = $request->get("month"); //12;
                        $webpos_bank['cc_expire_date_year']  = $request->get("year"); //18;
                        $webpos_bank['cc_type']              = $request->get("type"); //card_type;
                        //$webpos_bank["bank_id"] = $request->webpos_bank_id;
                        //$webpos_bank['customer_ip'] = ip();
                        //$webpos_bank['instalment'] = $request->installment;
                        $webpos_bank['success_url'] = url('threedmodel/callback'); //bank will return here if payment successfully finishes
                        $webpos_bank['fail_url']    = url('threedmodel/callback'); //bank will return here if payment fails;
                        $webpos_bank['order_id']    = $orders_no;
                        $webpos_bank['total']       = $price;
                        $webpos_bank['mode']        = "live";
                        $webpos_bank['order_info']  = "";
                        $webpos_bank['products']    = "";

                        $method_response = $this->est3dModel->methodResponse($webpos_bank);

                        if (isset($method_response['form'])) {
                            $json['form']   = $method_response['form'];
                            $json["status"] = 200;
                        } elseif (isset($method_response['error'])) {
                            $message        = (isset($method_response['message'])) ? $method_response['message'] : '';
                            $json["status"] = 200;
                            $json['error']  = $method_response['error'] . $message;
                        } else {
                            $json["message"] = "Kart bilgilerini kontrol ediniz.";
                        }
                        $json["po"] = "kk";
                        return response()->json($json);
                        break;

                    case 'ko':
                        if ($request->get('pdo') == 'pdCash') {
                            $price                = $cart->totalPrice + $cart->shippingPrice + $cart->shipping->pdCash_price;
                            $data["payment_type"] = 2;
                            $data["pdAmount"]     = $cart->shipping->pdCash_price;

                            if ($this->createOrder($data)) {
                                $result = ["status" => 200, "po" => "ko", "message" => "Sipariş Alındı"];
                            } else {
                                $result = ["status" => 0, "message" => "Sipariş oluşturulurken bir hata oluştu."];
                            }
                        } elseif ($request->get('pdo') == 'pdCard') {
                            $price                = $cart->totalPrice + $cart->shippingPrice + $cart->shipping->pdCard_price;
                            $data["payment_type"] = 4;
                            $data["pdAmount"]     = $cart->shipping->pdCard_price;

                            if ($this->createOrder($data)) {
                                $result = ["status" => 200, "po" => "ko", "message" => "Sipariş Alındı"];
                            } else {
                                $result = ["status" => 0, "message" => "Sipariş oluşturulurken bir hata oluştu."];
                            }
                        } else {
                            $result = ["status" => 0, "message" => "Geçersiz ödeme yöntemi."];
                        }
                        return response()->json($result);
                        break;

                    default:
                        return response()->json(["status" => 0, "message" => "Geçersiz ödeme yöntemi."]);
                        break;
                }
            } else {
                return response()->json(["status" => 0, "message" => "Talep edilen miktar stokta bulunmuyor.", "detail" => $noStock]);
            }
        } else {
            return response()->json(["status" => 0, "message" => "hata"]);
        }
    }

    public function approveOrder2(Request $request)
    {
        if (session()->has('cart')) {
            // Ödeme Yöntemi
            $paymentMethod = $request->get('po');

            // Sipariş Bilgileri
            $orderData = array();

            // Sepet
            $cart = new Cart(session('cart'));

            // Sipariş bilgilerine sepet bilgisini aktar
            $orderData['cart'] = $cart;

            // Ürünlerin Stoklarını Kontrol Edelim
            $productStocks = Products::whereIn('id', array_keys($cart->items))->select('stock', 'id')->get();

            // Sepetteki ürünlerin stoklarını kontrol et
            $noStock = $productStocks->map(function ($product) use ($cart) {
                // Sepet stok bilgisi ürün stok bilgisinden küçük veya eşitse işlem yapma
                if ($cart->items[$product->id]['qty'] <= $product->stock) {
                    return null;
                }

                // Sepetteki ürünün adetini var olan kadar değiştirim yoksa silelim
                if ($product->stock > 0) {
                    $cart->updateItem($product->id, $product->stock);
                } else {
                    $cart->removeItem($product->id);
                }

                return [
                    'id'        => $product->id,
                    'available' => $product->stock,
                ];
            })->filter();

            // Sepet stoklarında bir değiliklik varsa kaydedelim
            $cart->save();

            // Sepet stok sayılarında bir problem yok işe işleme devam edelim
            if ($noStock->isEmpty()) {
                switch ($paymentMethod) {
                    case 'havale':
                        $orderData = [
                            'payment_type' => 1,
                            'bank_id'      => $request->get('bank_id'),
                        ];

                        // Siparişi Oluştur
                        if ($this->createOrder($orderData)) {
                            return response()->json([
                                'status'  => 200,
                                'po'      => 'havale',
                                'message' => 'Sipariş Alındı',
                            ]);
                        } else {
                            return response()->json([
                                'status'  => 0,
                                'message' => 'Hata',
                            ]);
                        }
                        break;
                    case 'kk':
                        $price = floatval($cart->totalPrice - $cart->promotionDiscount) + $cart->shippingPrice;

                        // Kullanıcı bilgileri
                        $user = auth()->guard('members')->user();

                        // Sipariş Bilgileri
                        $order = [
                            'id'          => '',
                            'name'        => $user->name . ' ' . $user->surname, // zorunlu değil
                            'email'       => (filter_var($user->email) ?? ''), // zorunlu değil
                            'user_id'     => $user->id, // zorunlu değil
                            'amount'      => $price, // Sipariş tutarı
                            'currency'    => 'TRY',
                            'ip'          => $request->ip(),
                            'transaction' => 'pay', // pay => Auth, pre PreAuth (Direkt satış için pay, ön provizyon için pre)
                        ];

                        // Sipariş bilgilerini kaydet
                        session()->put('order', $order);

                        // Kredi kartı bilgieri
                        $cardNumber = $request->get('card1') . $request->get('card2') . $request->get('card3') . $request->get('card4');
                        $card       = [
                            'name'   => $request->get('firstname'),
                            'number' => $cardNumber, // Kredi kartı numarası
                            'month'  => $request->get('month'), // SKT ay
                            'year'   => $request->get('year'), // SKT yıl, son iki hane
                            'cvv'    => $request->get('cvc'), // Güvenlik kodu, son üç hane
                            'type'   => $request->get('type'), // visa, master
                        ];

                        $finansbank = new Finansbank();

                        $finansbank->prepare($order, $card);

                        $formData = $finansbank->get3dFormData();

                        if (isset($formData['inputs']) && count($formData['inputs'])) {
                            $formInputs = '<form id="webpos_form" name="webpos_form" action="' . $formData['gateway'] . '" method="POST">';
                            foreach ($formData['inputs'] as $name => $value) {
                                $formInputs .= '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
                            }

                            return response()->json([
                                'status' => 200,
                                'po'     => 'kk',
                                'form'   => $formInputs,
                            ]);
                        } else {
                            return response()->json([
                                'status'  => 0,
                                'po'      => 'kk',
                                'message' => 'Lütfen kredi kartı bilgilerini kontrol ediniz.',
                            ]);
                        }
                        break;
                    case 'ko':
                        // Geçerli bir ödeme yöntemi var mı kontrol et
                        if ($request->get('pdo') != 'pdCash' && $request->get('pdo') == 'pdCard') {
                            return response()->json([
                                'status'  => 0,
                                'message' => 'Geçersiz ödeme yöntemi.',
                            ]);
                        }

                        // $price = ($cart->totalPrice + $cart->shippingPrice + $cart->shipping->pdCash_price);

                        $pdType        = $request->get('pdo');
                        $pdPaymentType = ($pdType == 'pdCash' ? 2 : 4);
                        $pdAmount      = ($pdType == 'pdCash' ? $cart->shipping->pdCash_price : $cart->shipping->pdCard_price);

                        // Siparişi Oluştur
                        $createOrderResult = $this->createOrder([
                            'payment_type' => $pdPaymentType,
                            'pdAmount'     => $pdAmount,
                        ]);

                        if ($createOrderResult) {
                            return response()->json([
                                'status'  => 200,
                                'po'      => 'ko',
                                'message' => 'Sipariş Alındı',
                            ]);
                        } else {
                            return response()->json([
                                'status'  => 0,
                                'message' => 'Sipariş oluşturulurken bir hata oluştu.',
                            ]);
                        }
                        break;

                    default:
                        return response()->json([
                            'status'  => 0,
                            'message' => 'Geçersiz ödeme yöntemi.',
                        ]);
                        break;
                }
            } else {
                return response()->json([
                    'status'  => 0,
                    'message' => 'Talep edilen ürün miktarı stokta bulunmuyor.',
                    'detail'  => $noStock,
                ]);
            }
        } else {
            return response()->json([
                'status'  => 0,
                'message' => 'hata',
            ]);
        }
    }

    public function finansbankCallback(Request $request)
    {
        $finansbank = new Finansbank();

        // Sipariş Bilgileri
        $order = session('order');

        // Ödeme İşlemini Tamamla
        $finansbank->prepare($order)->payment();

        // Sepet boş ise işlemi durdur
        if (!session()->has('cart')) {
            return redirect('sepet/tesekkurler')->with('message', 'İşlemler sırasında bir hata oluştu! Lütfen tekrar deneyin.');
        }

        $cart      = new Cart(session()->get('cart'));
        $orderId   = ($finansbank->isSuccess() ? $finansbank->response->order_id : uniqid(mt_rand()));
        $orderData = [
            'cart'         => $cart,
            'payment_type' => 3,
        ];
        $orderStatus  = ($finansbank->isSuccess() ? 1 : 9); // 1 = İşlem Onaylandı, 9 = İşlem Onaylanmadı
        $orderMessage = json_encode($finansbank->response, JSON_UNESCAPED_UNICODE);

        // İşlem onaylamaz ise hata mesajını gönder
        if ($finansbank->isError()) {
            session()->flash('message', 'Ödeme Başarısız. ' . $finansbank->response->error_message . '(' . $finansbank->response->status . ')');
        }

        // İşlem durumuna göre sepet durumunu güncelle
        $cart->status = boolval($finansbank->isSuccess());
        $cart->save();

        //  Siparişi Kaydet
        $this->createOrder($orderData, $orderId, $orderStatus, $orderMessage);

        // Sonuç sayfasına yönlendir
        return redirect('sepet/tesekkurler');
    }

    public function threedmodelcallback(Request $req)
    {
        $bank_response = $req->all();

        $webpos_bank = ["bolum" => 4]; //Ekstra değer göndermek için

        //Para aktarımını başlatıyoruz
        $method_response = $this->est3dModel->bankResponse($bank_response, $webpos_bank);
        $orders_no       = $bank_response["oid"];
        if (isset($bank_response["taksit"]) and !empty($bank_response["taksit"])) {
            $instalment = $bank_response["taksit"];
            $instalment = ($instalment == "") ? 0 : $instalment;
        } else {
            $instalment = 0;
        }
        if ($method_response['result'] == 1) {
            $message = $method_response['message']; //. $banka;
            $price   = $bank_response["amount"]; //Çekilen tutar- Kontrol için kullanılabilir

            $data['continue'] = url('test/success/' . $orders_no);
            $data['message']  = $method_response['message'];
            $data['response'] = $method_response['response'];
            //dd($data['response']['Orderid']);

            //Siparişi kaydet
            if (Session::has('cart')) {
                $data2                 = [];
                $cart                  = new Cart(Session::get('cart'));
                $data2["cart"]         = $cart;
                $data2["payment_type"] = 3;

                $this->createOrder($data2, $data['response']['Orderid'], 1);
            }
            //sparil Mail gönder
            //Sepeti boşalt
            return redirect('sepet/tesekkurler');

            //return Redirect::to("test/success/" . $orders_no)->with("data", $data);
        } else {
            $message = $method_response['message'];
            $price   = $bank_response["amount"]; //Log için tutulabilir

            $data['continue'] = url('test/success/' . $orders_no);
            $data['message']  = $method_response['message'];
            //$data['response'] = $method_response['response'];

            if (Session::has('cart')) {
                $data2        = [];
                $cart         = new Cart(Session::get('cart'));
                $cart->status = false;
                Session::put('cart', $cart);
                $data2["cart"]         = $cart;
                $data2["payment_type"] = 3;

                $this->createOrder($data2, $orders_no, 9, $message);
            }
            //$cart = new cart(Session::get('cart'));
            //$cart->status  = false;
            //Session::put('cart',$cart);
            $req->session()->flash('message', $message);

            //dd($message);
            return redirect('sepet/tesekkurler');
            //return response()->redirect("kart-sayfasi-buraya")->with("error", $message);
        }
    }

    public function createOrder($data, $oid = null, $status = 0, $statusMessage = null)
    {
        $myPrice  = new Price();
        $pdAmount = isset($data['pdAmount']) ? $data['pdAmount'] : 0;

        $order = [
            'order_no'          => (empty($oid) ? uniqid() : $oid),
            'status'            => $status,
            'customer_note'     => $data['cart']->others['giftNote'],
            'payment_type'      => $data["payment_type"],
            'bank_id'           => isset($data['bank_id']) ? $data['bank_id'] : null,
            'shipping_id'       => $data['cart']->shipping->id,
            'shipping_no'       => null,
            'subtotal'          => $data['cart']->subTotal,
            'grand_total'       => ($data['cart']->totalPrice + $data['cart']->shippingPrice + $pdAmount),
            'tax_amount'        => $data['cart']->taxTotal,
            'shipping_amount'   => $data['cart']->shippingPrice,
            'pdAmount'          => $pdAmount,
            'discount_amount'   => $data['cart']->promotionDiscount + $data['cart']->couponDiscount,
            'promotionProducts' => json_encode($data['cart']->promotionProducts),
            'coupon_code'       => $data['cart']->coupon,
            'statusMessage'     => $statusMessage,
            'ip'                => \Request::ip(),
        ];

        if (Auth::guard('members')->check() == true) {
            $order["orderMail"]           = Auth::guard('members')->user()->email;
            $order["member_id"]           = Auth::guard('members')->user()->id;
            $order["billing_address_id"]  = $data["cart"]->others["billingAddress"];
            $order["shipping_address_id"] = $data["cart"]->others["deliveryAdress"];
        } else {
            $order["orderMail"] = $data["cart"]->others["guest_email"];
            //mail kayıtlı ise login,değilse kayıt edilip login edilmeli ve adresler eklenmeli
            if (\App\Member::where("email", "=", $data["cart"]->others["guest_email"])->count()) {
                $user = \App\Member::where("email", "=", $data["cart"]->others["guest_email"])->first();
                Auth::guard('members')->login($user, true);
            } else {
                $guestData = [
                    "email"    => $data["cart"]->others["guest_email"],
                    "name"     => $data["cart"]->others["guest_name"],
                    "surname"  => $data["cart"]->others["guest_surname"],
                    "password" => bcrypt("123456"),
                ];
                $user = Member::create($guestData);
                Auth::guard('members')->login($user, true);
            }
            $data["cart"]->others["member_id"] = $user->id;

            //todo::dataları düzenlemek gerekiyor adres
            $deliveryData = [
                "address_name" => $data["cart"]->others["newDeliveryAddressName"],
                "name"         => trim($data["cart"]->others["newDeliveryName"]),
                "surname"      => trim($data["cart"]->others["newDeliverySurname"]),
                "phone"        => $data["cart"]->others["newDeliveryPhone"],
                "phoneGsm"     => $data["cart"]->others["newDeliveryPhone"],
                "address"      => $data["cart"]->others["newDeliveryAddress"],
                "member_id"    => Auth::guard('members')->user()->id,
                "city"         => $data["cart"]->others["newDeliveryCity"],
                "state"        => $data["cart"]->others["newDeliveryState"],
            ];

            $createDelivery = \App\ShippingAddress::create($deliveryData);

            if ($data['cart']->others['chooseBilling'] == 1) {
                $createBilling = \App\BillingAddress::create($deliveryData);
            } else {
                $billingData = [
                    "address_name" => $data["cart"]->others["newBillingAddressName"],
                    "name"         => trim($data["cart"]->others["newBillingName"]),
                    "surname"      => trim($data["cart"]->others["newBillingSurname"]),
                    "phone"        => $data["cart"]->others["newBillingPhone"],
                    "phoneGsm"     => $data["cart"]->others["newBillingPhone"],
                    "address"      => $data["cart"]->others["newBillingAddress"],
                    "member_id"    => Auth::guard('members')->user()->id,
                    "city"         => $data["cart"]->others["newBillingCity"],
                    "state"        => $data["cart"]->others["newBillingState"],
                ];

                // Fatura türü kurumsal
                if ($data['cart']->others['billingType'] == 2) {
                    $billingData["tax_place"] = $data["cart"]->others["newBillingTaxOffice"];
                    $billingData["tax_no"]    = $data["cart"]->others["newBillingTaxNo"];
                }
                $createBilling = \App\BillingAddress::create($billingData);
            }

            $order["shipping_address_id"] = $createDelivery->id;
            $order["billing_address_id"]  = $createBilling->id;
            $order["member_id"]           = $user->id;
        }

        // Siparişi oluştur
        $create = Order::create($order);

        $mailItems = "";

        $sonuc = false;

        if ($create) {
            //kargo slotu varsa ekleyelim
            if (isset($data["cart"]->others["shippingSlot"])) {
                $dataSlot = ["shipping_slot_id" => $data["cart"]->others["shippingSlot"], "order_id" => $create->id];

                try {
                    $addSlotOrder = \App\OrderSlot::create($dataSlot);
                } catch (Exception $e) {
                    $addSlotOrder = false;
                }
            }

            foreach ($data["cart"]->items as $k => $v) {
                $orderItem = [
                    "order_id"   => $create->id,
                    "qty"        => $v["qty"],
                    "price"      => $v["item"]->realPrice,
                    "name"       => $v["item"]->p->name,
                    "stock_code" => $v["item"]->p->stock_code,
                    "product_id" => $v["item"]->p->id,
                ];
                \App\Order_item::create($orderItem);

                //hatalı ödemede stok düşmesin
                if ($status != 9) {
                    DB::table('products')->where('id', $v["item"]->p->id)->decrement('stock', $v["qty"]);
                }

                $mailItems .= '<table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
                              <tbody>
                                <tr style="background: #f1f1f1; font-size: 12px">
                                  <td width="31%">' . $v["item"]->p->name . '</td>
                                  <td width="19%">' . $v["item"]->p->stock_code . '</td>
                                  <td width="13%">' . $myPrice->currencyFormat($v["item"]->realPrice) . ' TL</td>
                                  <td width="7%">x' . $v["qty"] . '</td>
                                  <td width="15%">  ' . $myPrice->currencyFormat($v["item"]->realPrice * $v["qty"]) . ' TL</td>
                                  <td width="15%">  ' . $myPrice->currencyFormat($v["item"]->realPrice) . ' TL</td>
                                </tr>
                              </tbody>
                            </table>';
            }

            //sipariş mail gönder
            if (Auth::guard('members')->check() == true) {
                $name    = Auth::guard('members')->user()->name;
                $surname = Auth::guard('members')->user()->surname;
            } else {
                $name    = $data["cart"]->others["guest_name"];
                $surname = $data["cart"]->others["guest_surname"];
            }

            if ($create->payment_type == 1) {
                $bank = \App\Bank::find($create->bank_id);
            }

            $shippingAddress = $create->shippingAddress; //\App\ShippingAddress::where('id','=',$create->shipping_address_id)->first();
            $billingAddress  = $create->billingAddress; //\App\BillingAddress::where('id','=',$create->billing_address_id)->first();

            if ($status == 1) {
                $mailText = "Siparişiniz onaylanmıştır. Sipariş detayları aşağıdadır.";
            } else {
                $mailText = "Siparişiniz sisteme aşağıdaki bilgiler ile kaydedilmiştir.";
            }

            if ($create->payment_type == 1) {
                $mailText .= " Ödemeniz gereken tutar " . $myPrice->currencyFormat($create->grand_total) . " TL 'dir.";
            }

            $discountInfo = "";
            if ($create->discount_amount > 0 && $create->coupon_code == null) {
                $discountInfo = '
                <table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
                <tbody>
                    <tr>
                    <td width="50%"> </td>
                    <td width="20%"><strong> Promosyon Avantajı:</strong></td>
                    <td width="15%">  ' . $myPrice->currencyFormat($create->discount_amount) . ' TL</td>
                    <td width="15%">  ' . $myPrice->currencyFormat($create->discount_amount) . ' TL</td>
                    </tr>
                </tbody>
                </table>';
            } elseif ($create->discount_amount > 0 && $create->coupon_code != null) {
                $discountInfo = '
                <table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
                <tbody>
                    <tr>
                    <td width="50%"> </td>
                    <td width="20%"><strong> Kupon Kodu İndirimi (' . $create->coupon_code . '):</strong></td>
                    <td width="15%">  ' . $myPrice->currencyFormat($create->discount_amount) . ' TL</td>
                    <td width="15%">  ' . $myPrice->currencyFormat($create->discount_amount) . ' TL</td>
                    </tr>
                </tbody>
                </table>';
            }

            $slot = "";
            if ($create->slot) {
                $slot = $create->slot->shippingSlot->time1 . " - " . $create->slot->shippingSlot->time2;
            }

            // Başarısız ödeme değilse mail ve sms gönder
            if ($status != 9) {
                \Mail::queue(
                    'mailTemplates.order',
                    array(
                        'name'            => $name,
                        'surname'         => $surname,
                        'bank'            => $create->payment_type == 1 ? \App\Bank::find($create->bank_id) : '',
                        'created'         => $create,
                        'date'            => Carbon::parse($create->created_at)->format('d-m-Y'),
                        'time'            => Carbon::parse($create->created_at)->format('H:i:s'),
                        'shippingAddress' => $shippingAddress,
                        'billingAddress'  => $billingAddress,
                        'shippingCompany' => $create->shippingCompany->name,
                        'slot'            => $slot,
                        'mailItems'       => $mailItems,
                        'taxAmount'       => $myPrice->currencyFormat($create->tax_amount),
                        'shippingAmount'  => $myPrice->currencyFormat($create->shipping_amount),
                        'grandTotal'      => $myPrice->currencyFormat($create->grand_total),
                        'discountInfo'    => $discountInfo,
                        'pdAmount'        => $myPrice->currencyFormat($create->pdAmount),
                        'mailText'        => $mailText,
                    ),
                    function ($message) use ($order) {
                        $message->from('consumer@marketpaketi.com.tr', 'marketpaketi.com.tr');
                        $message->to($order["orderMail"])->subject('Sipariş Dekontu.');
                    }
                );

                // SMS Gönder
                $create->sendSms('oluşturuldu.');
            }

            // Sipariş bilgilerini kargo firmasına gönder
            if ($status == 1) {
                try {
                    (new Shipment())->createShipment($create);
                } catch (\Throwable $th) {
                    Log::error($th->getMessage());
                }
            }

            $sonuc = true;
        }

        // Sipariş durumu onaylanmış ise sepeti boşalt
        if ($status != 9) {
            session()->forget('cart');
        }

        $cart          = new cart(Session::get('cart'));
        $cart->orderNo = $order["order_no"];
        $cart->orderId = $create->id;
        $cart->status  = true;

        if ($status == 9) {
            $cart->status = false;
        }

        Session::put('cart', $cart);

        return $sonuc;
    }

    public function orderResult()
    {
        $cart = new Cart(Session::get('cart'));
        if ($cart->status == true && $cart->orderId) {
            $order = Order::find($cart->orderId);
        } else {
            $order = [];
        }
        $deliveryDate = Carbon::now()->addDays(3)->format('Y-m-d');

        return view('frontEnd.blades.orderResult', compact('cart', 'order', 'deliveryDate'));
    }

    public function orders()
    {
        $user   = Auth::guard('members')->user();
        $orders = Order::with('items')->where('member_id', '=', $user->id)->where('status', '!=', 9)->orderBy('created_at', 'desc')->get();
        return view('frontEnd.blades.orders', compact('user', 'orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::where(["member_id" => Auth::guard('members')->user()->id, "id" => $id])->first();

        $pros    = "";
        $myPrice = new Price();

        foreach ($order->items as $item) {
            $pros .= '<ul class="siparis_detay_icerik">
											<li>' . $item->name . '</li>
											<li>' . $item->qty . ' X ' . $myPrice->currencyFormat($item->price) . ' ₺</li>
											<li>' . $item->stock_code . '</li>
											<li>' . $myPrice->currencyFormat($item->price * $item->qty) . ' ₺</li>
											<li>' . $myPrice->currencyFormat($item->price * $item->qty) . ' ₺</li>
										</ul>';
        }

        $bankText = "";
        if ($order->payment_type == 1) {
            $bank = \App\Bank::find($order->bank_id);
            if ($bank) {
                $bankText = '<ul class="sip_detay_satir">
                                        <li><strong>Banka Hesapları</strong></li>
                                        <li><strong>:</strong></li>
                                        <li>Banka : ' . $bank->name . '</li>
                                    </ul>

                                    <ul class="sip_detay_satir">
                                        <li><strong>Hesap Adı</strong></li>
                                        <li><strong>:</strong></li>
                                        <li>' . $bank->owner . ' - Hesap No : ' . $bank->iban . ' - Hesap Türü : ' . $bank->currency . '</li>
                                    </ul>';
            } else {
                $bankText = '<ul class="sip_detay_satir"><li>Banka bilgilerine ulaşılamadı.</li></ul>';
            }
        }

        $discountInfo = "";
        if ($order->discount_amount > 0 && $order->coupon_code == null) {
            $discountInfo = '<li><strong>Promosyon Avantajı</strong><span>:</span>' . $myPrice->currencyFormat($order->discount_amount) . ' ₺</li>';
        } elseif ($order->discount_amount > 0 && $order->coupon_code != null) {
            $discountInfo = '<li><strong>Kupon Kodu İndirimi (' . $order->coupon_code . ')</strong><span>:</span>' . $myPrice->currencyFormat($order->discount_amount) . ' ₺</li>';
        }

        $paymentText = "";
        if ($order->payment_type == 2 || $order->payment_type == 4) {
            $paymentText = "<li><strong>" . $order->payment . " Ücreti</strong><span>:</span>" . $myPrice->currencyFormat($order->pdAmount) . " ₺</li>";
        } else {
            $paymentText = "";
        }

        $slot = "";
        if ($order->slot) {
            $slot = "<ul class=\"sip_detay_satir\">
                        <li><strong>Teslimat Saati</strong></li>
                        <li><strong>:</strong></li>
                        <li>" . substr($order->slot->shippingSlot->time1, 0, -3) . " - " . substr($order->slot->shippingSlot->time2, 0, -3) . "</li>
                    </ul>";
        }

        return '<div id="siparis_detay" style="display: inline-block;">

								<div class="sip_baslik"> Sipariş Detayları</div>

								<div class="sip_detay">

									<ul class="sip_detay_satir">
										<li><strong>Ref No / Sipariş No</strong></li>
										<li><strong>:</strong></li>
										<li>' . $order->order_no . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>Ödeme Türü</strong></li>
										<li><strong>:</strong></li>
										<li>' . $order->payment . '</li>
									</ul>

									' . $bankText . '

									<ul class="sip_detay_satir">
										<li><strong>Kargo Firması</strong></li>
										<li><strong>:</strong></li>
										<li>' . $order->shippingCompany->name . '</li>
									</ul>
									' . $slot . '
									<ul class="sip_detay_satir">
										<li><strong>Sipariş Tarihi</strong></li>
										<li><strong>:</strong></li>
										<li>' . Carbon::parse($order->created_at)->format('d-m-Y H:i:s') . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>IP Adresi</strong></li>
										<li><strong>:</strong></li>
										<li>' . $order->ip . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>Sözleşme ve Önbilgilendirme Formu</strong></li>
										<li><strong>:</strong></li>
										<li>
											<a href="#"><i class="fa fa-pencil-square" aria-hidden="true"></i></a> &nbsp;
										  <a href="#"><i class="fa fa-cube" aria-hidden="true"></i></a>
										</li>
									</ul>

									<div class="siparis_detay_alan">

										<ul class="siparis_detay_baslik">
											<li>Ürün</li>
											<li>Adet</li>
											<li>Stok Kodu</li>
											<li>Toplam</li>
											<li>Havale</li>
										</ul>

										' . $pros . '

									</div>

									<ul class="siparis_toplam">
										' /*
        <li><strong>Ara Toplam</strong><span>:</span>'.$myPrice->currencyFormat($order->subtotal-$order->shipping_amount).' ₺</li>
        <li><strong>KDV Dahil</strong><span>:</span>'.$myPrice->currencyFormat($order->grand_total-$order->shipping_amount).' ₺</li>*/ . '
										<li><strong>KDV</strong><span>:</span>' . $myPrice->currencyFormat($order->tax_amount) . ' ₺</li>
										<li><strong>Kargo Ücreti</strong><span>:</span>' . $myPrice->currencyFormat($order->shipping_amount) . ' ₺</li>
                                        ' . $paymentText . '
                                        ' . $discountInfo . '
										<li><strong>Genel Toplam</strong><span>:</span>' . $myPrice->currencyFormat($order->grand_total) . ' ₺</li>

									</ul>

									<div class="clear"></div>

								</div>

							</div>';
    }

    public function shippingInfo($id)
    {
        $order = Order::where(["member_id" => Auth::guard('members')->user()->id, "id" => $id])->first();
        //dd($order);
        $shippingAddress = \App\ShippingAddress::where('id', '=', $order->shipping_address_id)->first();
        $billingAddress  = \App\BillingAddress::where('id', '=', $order->billing_address_id)->first();

        //dd($billingAddress);
        $is_einvoice = $billingAddress->is_einvoice == 0 ? "Hayır" : "Evet";

        return '<div id="teslimat_bilgisi" style="display: inline-block;">

								<div class="sip_baslik"> Teslimat Bilgileri</div>

								<div class="sip_detay">

									<ul class="sip_detay_satir">
										<li><strong>Adı Soyadı</strong></li>
										<li><strong>:</strong></li>
										<li>' . $shippingAddress->name . ' ' . $shippingAddress->surname . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>Adres</strong></li>
										<li><strong>:</strong></li>
										<li>' . $shippingAddress->address . '<br>' . $shippingAddress->state . ' ' . $shippingAddress->city . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>Telefon</strong></li>
										<li><strong>:</strong></li>
										<li>' . $shippingAddress->phone . '</li>
									</ul>

								</div>

								<br>

								<div class="sip_baslik"> Fatura Bilgileri</div>

								<div class="sip_detay">

									<ul class="sip_detay_satir">
										<li><strong>Adı Soyadı</strong></li>
										<li><strong>:</strong></li>
										<li>' . $billingAddress->name . ' ' . $billingAddress->surname . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>Adres</strong></li>
										<li><strong>:</strong></li>
										<li>' . $billingAddress->address . '<br>' . $billingAddress->state . ' ' . $billingAddress->city . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>Telefon</strong></li>
										<li><strong>:</strong></li>
										<li>' . $billingAddress->phone . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>Vergi No</strong></li>
										<li><strong>:</strong></li>
										<li>' . $billingAddress->tax_no . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>Vergi Dairesi</strong></li>
										<li><strong>:</strong></li>
										<li>' . $billingAddress->tax_place . '</li>
									</ul>

									<ul class="sip_detay_satir">
										<li><strong>E-fatura kullanıcısı mı?</strong></li>
										<li><strong>:</strong></li>
										<li>' . $is_einvoice . '</li>
									</ul>

								</div>

						  </div>';
    }

    public function refundRequest(Request $request, $id)
    {
        if (Auth::guard('members')->check() == true) {
            $order = Order::where('id', $id)->where('member_id', Auth::guard('members')->user()->id)->first();

            $refundRequest = $order->refundRequest; //\App\RefundRequest::where('order_id',$order->id)->first();

            $created = new Carbon($order->created_at);
            $now     = Carbon::now();

            if ($created->diff($now)->days < 15) {
                $dateStatus = 1;
            } else {
                $dateStatus = 0;
            }

            if ($order && count($order->items) && $dateStatus == 1 && count($refundRequest) < 1) {
                return view('frontEnd.blades.refundRequest', compact('order'));
            } else {
                return redirect('hesabim/siparisler');
            }
        } else {
            return redirect('./');
        }
    }

    public function refundRequestAdd(Request $request, $id)
    {
        $order = Order::find($id);
        //tarih check yapılacak 15 gün
        if (count($order) > 0) {
            $data   = ["order_id" => $order->id, "member_id" => Auth::guard('members')->user()->id, "code" => uniqid(), "refoundAmount" => 0, "status" => 0];
            $create = \App\RefundRequest::create($data);

            //dd($create->id);
            foreach ($request->get('id') as $key => $value) {
                $addData = [
                    "refund_request_id" => $create->id,
                    "product_id"        => $value,
                    "qty"               => $request->get('qty')[$key],
                    "status"            => 1,
                    "description"       => $request->get('description')[$key],
                ];
                $addProRefund = \App\RefundReqProduct::create($addData);
            }
            return redirect('hesabim/siparisler');
        } else {
            return redirect('hesabim/siparisler');
        }
    }

    public function contact()
    {
        return view('frontEnd.blades.contact');
    }

    public function contactForm()
    {
        return view('frontEnd.blades.contactForm');
    }

    public function contactFormPost(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required|',
            'email'   => 'required|email',
            'phone'   => 'required|',
            'subject' => 'required|',
            'message' => 'required|',
            'captcha' => 'required|captcha',
        ], [
            'name.required'    => 'Ad soyad alanı boş geçilemez.',
            'phone.required'   => 'Telefon alanı boş geçilemez.',
            'subject.required' => 'Konu alanı boş geçilemez.',
            'message.required' => 'Mesaj alanı boş geçilemez.',
            'email.required'   => 'E mail alanı boş geçilemez.',
            'email.email'      => 'Geçerli bir mail adresi giriniz.',
            'captcha.required' => 'Güvenlik kodu alanı boş geçilemez',
            'captcha.captcha'  => 'Güvenlik kodunu kontrol ediniz.',
        ]);

        \Mail::send(
            'mailTemplates.contact',
            array(
                'name'         => $request->get('name'),
                'email'        => $request->get('email'),
                'body_message' => $request->get('message'),
                'phone'        => $request->get('phone'),
                'subject'      => $request->get('subject'),
                'ip'           => \Request::ip(),
            ),
            function ($message) {
                $message->from('consumer@marketpaketi.com.tr', 'marketpaketi.com.tr');
                $message->to('info@marketpaketi.com.tr')->subject('İletişim Formu');
            }
        );

        if (count(\Mail::failures()) > 0) {
            return redirect()->back()->with("error", "Hata oluştu.");
        } else {
            return redirect()->back()->with("success", "İletişim formunuz tarafımıza ulaşmıştır.");
        }
    }

    public function getPages($slug)
    {
        //$allPages = \App\Pages::where('isStatic','0')->where('status','1')->where('slug','!=',$slug)->get();

        $allPages = \App\Pages::where([
            ['isStatic', '=', 0],
            ['status', '=', 1],
            ['slug', '!=', $slug],
        ])->get();

        $data = \App\Pages::where([
            ['isStatic', '<', 1],
            ['status', '=', 1],
            ['slug', '=', $slug],
        ])->first();
        //$data = \App\Pages::where('slug',$slug)->first();
        if ($data) {
            return view('frontEnd.blades.otherPages', compact('allPages', 'data'));
        } else {
            return abort(404);
        }
    }

    public function mss()
    {
        $data = \App\Pages::where('slug', 'mesafeli-satis-sozlesmesi')->first();
        return view('frontEnd.blades.infoPage', compact('data'));
    }

    public function ovt()
    {
        $data = \App\Pages::where('slug', 'odeme-ve-teslimat')->first();
        return view('frontEnd.blades.infoPage', compact('data'));
    }

    public function gvg()
    {
        $data = \App\Pages::where('slug', 'gizlilik-ve-guvenlik')->first();
        return view('frontEnd.blades.infoPage', compact('data'));
    }

    public function is()
    {
        $data = \App\Pages::where('slug', 'iade-sartlari')->first();
        return view('frontEnd.blades.infoPage', compact('data'));
    }

    public function blog(Request $request)
    {
        $page = $request->input('page', '1');

        $articles = Cache::remember('articles_' . $page, 10, function () {
            return \App\Article::where("status", 1)->orderBy('sort', 'desc')->paginate(4);
        });

        $artCats = Cache::remember('artCats', 10, function () {
            return \App\BlogCategory::where(["status" => 1, "parent_id" => 0])->orderBy('sort', 'desc')->limit(7)->get();
        });

        $other = Cache::remember('other_articles', 10, function () {
            return \App\Article::where("status", 1)->orderBy('created_at', 'desc')->limit(7)->get();
        });

        return view('frontEnd.blades.blog', compact('articles', 'artCats', 'other'));
    }

    public function blogCategory(Request $request)
    {
        $page = $request->input('page', '1');

        $artCat = Cache::remember('articlesCat_' . $request->category, 10, function () use ($request) {
            return \App\BlogCategory::where("slug", $request->category)->with('articles')->first();
        });

        $artCats = Cache::remember('artCats', 10, function () {
            return \App\BlogCategory::where(["status" => 1, "parent_id" => 0])->orderBy('sort', 'desc')->limit(7)->get();
        });

        $articles = Cache::remember('articles_' . $request->category . $page, 10, function () use ($artCat) {
            return \App\Article::where(["status" => 1, "category_id" => $artCat->id])->orderBy('sort', 'desc')->paginate(3);
        });

        $other = Cache::remember('other_articles', 10, function () {
            return \App\Article::where("status", 1)->orderBy('created_at', 'desc')->limit(7)->get();
        });

        return view('frontEnd.blades.blog', compact('articles', 'artCats', 'other'));
    }

    public function blogDetail(Request $request)
    {
        $artCats = Cache::remember('artCats', 10, function () {
            return \App\BlogCategory::where(["status" => 1, "parent_id" => 0])->orderBy('sort', 'desc')->limit(7)->get();
        });

        $article = Cache::remember('article_' . $request->article, 10, function () use ($request) {
            return \App\Article::where("slug", $request->article)->first();
        });

        $other = Cache::remember('other_articles', 10, function () {
            return \App\Article::where("status", 1)->orderBy('created_at', 'desc')->limit(7)->get();
        });

        if ($article && $artCats) {
            return view('frontEnd.blades.blogDetail', compact("article", "other", "artCats"));
        } else {
            return abort(404);
        }
    }

    public function categoryBreadCrump($parent_id)
    {
        $breadcrump = array();

        if ($parent_id != 0) {
            $cat = $this->getCategori($parent_id);

            if (!$cat) {
                return $breadcrump;
            }

            $breadcrump[] = [
                "slug"  => $cat->slug . "-c-" . $cat->id,
                "title" => $cat->title,
            ];

            if ($cat->parent_id != 0) {
                $breadcrump = array_merge($this->categoryBreadCrump($cat->parent_id), $breadcrump);
            }
        }

        return $breadcrump;
    }

    public function ordertrackFooter(Request $req)
    {
        $test  = $req->orderno;
        $order = Order::where('order_no', '=', $test)->first();
        if (isset($order) && !empty($order)) {
            $price           = new Price();
            $data            = $order;
            $dataItems       = "";
            $slot            = "";
            $grandTotalPrice = 0;

            $discountInfo = "";
            if ($data->discount_amount > 0 && $data->coupon_code == null) {
                $discountInfo = "<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
			  <tr>
			    <td width=\"44%\" style=\"padding-left:10px;\">
				</td>
				<td width=\"30%\" style='text-align:right;'>
					<b>Promosyon Avantajı:</b>
				</td>
				<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
					" . $price->currencyFormat($data->discount_amount) . " TL
				</td>
			  </tr>
			</table>";
            } elseif ($data->discount_amount > 0 && $data->coupon_code != null) {
                $discountInfo = "<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
			  <tr>
			    <td width=\"44%\" style=\"padding-left:10px;\">
				</td>
				<td width=\"30%\" style='text-align:right;'>
					<b>Kupon Kodu İndirimi (" . $data->coupon_code . "):</b>
				</td>
				<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
					" . $price->currencyFormat($data->discount_amount) . " TL
				</td>
			  </tr>
			</table>";
            }

            if ($data->slot) {
                $slot = "<tr>
						<td valign=\"top\"><b>Slot Seçimi</b></td>
						<td valign='top' align='center'>:</td>
						<td valign=\"top\">" . $data->slot->shippingSlot->time1 . " - " . $data->slot->shippingSlot->time2 . "</td>
					</tr>";
            }

            foreach ($data->items as $key => $val) {
                $dataItems .= "
            <table width=\"100%\" height=\"40\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;\">
              <tr>
                <td width='5%'>" . $val->product->img . "</td>
                <td width='43%'>" . $val->name . "</td>
                <td width='20%'>x " . $val->qty . "</td>
                <td width='30%'>" . $price->currencyFormat($val->price) . " TL</td>
              </tr>
	        </table>";

                // Genel Toplam Tutarını Hesapla
                $grandTotalPrice += ($val->price * $val->qty);
            }

            $bankText = "";

            $paymentText = "";

            return "<span class='DataList'>

        <div class=\"track-top\">
            <div class=\"track-orderno\">
            #<span>" . $data->order_no . "</span>
            </div>

            <div class=\"track-created\">
            Sipariş Tarihi: <span>" . $data->created_at . "</span>
            </div>
        </div>
<div class=\"modaltrack-bg\">
	<div class=\"track-bg track-name\">
    <i class=\"fa fa-user\"></i>  Ad ve Soyad: <span>" . $data->customer->fullname . "</span>
    </div>



    <div class=\"track-bg track-status\">
    <i class=\"fa fa-hourglass-start\"></i> Sipariş Durumu: <span>" . $data->statusText . "</span>
    </div>

    <div class=\"track-bg track-kargo\">
    <i class=\"fa fa-truck\"></i> Kargo Firması: <span>" . $data->shippingCompany->name . "</span>
    </div>
	" . $slot . "

    <div class=\"track-bg track-kargono\">
    <i class=\"fa fa-truck\"></i> Kargo No: <span>" . $data->shipping_no . "</span>
    </div>




<table width=\"100%\" height=\"30\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#f7f7f7;border-collapse:collapse;font-size:14px;font-family:arial;\">
  <tr>
    <td width='41%' style='padding-left:10px'>Ürünler</td>
	<td width='18%'>Miktar</td>
	<td width='27%'>Fiyat</td>
  </tr>
</table>
<div style=\"width:100%;max-height:121px;overflow-y:scroll; overflow-x:hidden; background:#fff; border-bottom: 1px solid #f7f7f7\" id='style-4bar'>
" . $dataItems . "
</div>
<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;\">
  <tr>
    <td width=\"44%\" style=\"padding-left:10px;\">
	</td>
	<td width=\"30%\" style='text-align:right;'>
		<b>Ara Toplam:</b>
	</td>
	<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
		" . $price->currencyFormat($data->grand_total - $data->tax_amount) . " TL
	</td>
  </tr>
</table>
<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;\">
  <tr>
    <td width=\"44%\" style=\"padding-left:10px;\">
	</td>
	<td width=\"30%\" style='text-align:right;'>
		<b>KDV:</b>
	</td>
	<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
		" . $price->currencyFormat($data->tax_amount) . " TL
	</td>
  </tr>
</table>
<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;\">
  <tr>
    <td width=\"44%\" style=\"padding-left:10px;\">
	</td>
	<td width=\"30%\" style='text-align:right;'>
		<b>KDV Dahil:</b>
	</td>
	<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
		" . $price->currencyFormat($data->grand_total) . " TL
	</td>
  </tr>
</table>
" . $discountInfo . "
	<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;\">
	  <tr>
		<td width=\"44%\" style=\"padding-left:10px;\">
		</td>
		<td width=\"30%\" style='text-align:right;'>
			<b>Kargo Ücreti:</b>
		</td>
		<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px'>
			" . $price->currencyFormat($data->shipping_amount) . " TL
		</td>
	  </tr>
	</table>
	" . $paymentText . "
	<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;\">
	  <tr>
		<td width=\"44%\" style=\"padding-left:10px;\">
		</td>
		<td width=\"30%\" style='text-align:right;'>
			<b>Genel Toplam:</b>
		</td>
		<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px'>
			" . $price->currencyFormat(($data->grand_total) - $data->discount_amount) . " TL
		</td>
	  </tr>
    </table>
    </div>
</span>";
        } else {
            return '<div class="modaltrack-bg">Böyle bir sipariş yok</div>';
        }
    }

    public function createSitemap()
    {
        // create new sitemap object
        $sitemap = App::make('sitemap');

        //category sitemap generate
        $counter        = 0;
        $sitemapCounter = 0;
        $cats           = DB::table('categories')->select('slug', 'id')->where('status', '1')->orderBy('id', 'desc')->get();
        $sitemap->add(url('/'), Carbon::now(), 1.0, 'daily');
        foreach ($cats as $c) {
            if ($counter == 2000) {
                $sitemap->store('xml', 'sitemap-category-' . $sitemapCounter, realpath('./sitemaps/'));
                $sitemap->addSitemap(secure_url('sitemaps/sitemap-category-' . $sitemapCounter . '.xml'));
                $sitemap->model->resetItems();
                $counter = 0;
                $sitemapCounter++;
            }
            $sitemap->add(url($c->slug . '-c-' . $c->id), Carbon::now(), 'daily');
            $counter++;
        }
        if (!empty($sitemap->model->getItems())) {
            $sitemap->store('xml', 'sitemap-category-' . $sitemapCounter, realpath('./sitemaps/'));
            $sitemap->addSitemap(secure_url('sitemaps/sitemap-category-' . $sitemapCounter . '.xml'));
            $sitemap->model->resetItems();
        }

        // get all products from db (or wherever you store them)
        //$products = DB::table('products')->select('slug', 'id')->where('status', '1')->orderBy('created_at', 'desc')->get();
        $products  = \App\Products::select('slug', 'id')->with('images')->where('status', '1')->orderBy('created_at', 'desc')->get();
        $myProduct = new Product();

        // counters
        $counter        = 0;
        $sitemapCounter = 0;

        // add every product to multiple sitemaps with one sitemap index
        foreach ($products as $key => $p) {
            if ($counter == 2000) {
                // generate new sitemap file
                $sitemap->store('xml', 'sitemap-product-' . $sitemapCounter, realpath('./sitemaps/'));
                // add the file to the sitemaps array
                $sitemap->addSitemap(secure_url('sitemaps/sitemap-product-' . $sitemapCounter . '.xml'));
                // reset items array (clear memory)
                $sitemap->model->resetItems();
                // reset the counter
                $counter = 0;
                // count generated sitemap
                $sitemapCounter++;
            }

            // add product to items array
            $sitemap->add(url($p->slug . '-p-' . $p->id), Carbon::now() /*$p->modified*/, 0.6/*$p->priority*/, 'weekly', ["images" => ["url" => $myProduct->baseImg($p->images, $p->id)]]);
            // count number of elements
            $counter++;
        }

        // you need to check for unused items
        if (!empty($sitemap->model->getItems())) {
            // generate sitemap with last items
            $sitemap->store('xml', 'sitemap-product-' . $sitemapCounter, realpath('./sitemaps/'));
            // add sitemap to sitemaps array
            $sitemap->addSitemap(secure_url('sitemaps/sitemap-product-' . $sitemapCounter . '.xml'));
            // reset items array
            $sitemap->model->resetItems();
        }

        //brand sitemap generate
        $counter        = 0;
        $sitemapCounter = 0;
        $brands         = DB::table('brands')->select('slug')->orderBy('id', 'desc')->get();
        foreach ($brands as $b) {
            if ($counter == 2000) {
                $sitemap->store('xml', 'sitemap-brand-' . $sitemapCounter, realpath('./sitemaps/'));
                $sitemap->addSitemap(secure_url('sitemaps/sitemap-brand-' . $sitemapCounter . '.xml'));
                $sitemap->model->resetItems();
                $counter = 0;
                $sitemapCounter++;
            }
            $sitemap->add(url($b->slug), Carbon::now(), 'daily');
            $counter++;
        }
        if (!empty($sitemap->model->getItems())) {
            $sitemap->store('xml', 'sitemap-brand-' . $sitemapCounter, realpath('./sitemaps/'));
            $sitemap->addSitemap(secure_url('sitemaps/sitemap-brand-' . $sitemapCounter . '.xml'));
            $sitemap->model->resetItems();
        }

        //static pages

        $sitemap->add(url('mesafeli-satis-sozlesmesi'), Carbon::now(), 'monthly');
        $sitemap->add(url('odeme-ve-teslimat'), Carbon::now(), 'monthly');
        $sitemap->add(url('gizlilik-ve-guvenlik'), Carbon::now(), 'monthly');
        $sitemap->add(url('iade-sartlari'), Carbon::now(), 'monthly');

        $counter        = 0;
        $sitemapCounter = 0;
        $pages          = DB::table('pages')->select('slug')->where('isStatic', '0')->orderBy('id', 'desc')->get();
        foreach ($pages as $b) {
            if ($counter == 2000) {
                $sitemap->store('xml', 'sitemap-static-' . $sitemapCounter, realpath('./sitemaps/'));
                $sitemap->addSitemap(secure_url('sitemaps/sitemap-static-' . $sitemapCounter . '.xml'));
                $sitemap->model->resetItems();
                $counter = 0;
                $sitemapCounter++;
            }
            $sitemap->add(url('sayfa/' . $b->slug), Carbon::now(), 'monthly');
            $counter++;
        }
        if (!empty($sitemap->model->getItems())) {
            $sitemap->store('xml', 'sitemap-static-' . $sitemapCounter, realpath('./sitemaps/'));
            $sitemap->addSitemap(secure_url('sitemaps/sitemap-static-' . $sitemapCounter . '.xml'));
            $sitemap->model->resetItems();
        }

        //blog pages sitemap generate
        /*
        $counter = 0;
        $sitemapCounter = 0;
        $pages = DB::table('blog')->select('slug')->where('isStatic','0')->orderBy('id', 'desc')->get();
        foreach ($pages as $b) {
        if ($counter == 2000) {
        $sitemap->store('xml', 'sitemap-blog-' . $sitemapCounter, realpath('./sitemaps/'));
        $sitemap->addSitemap(secure_url('sitemaps/sitemap-blog-' . $sitemapCounter . '.xml'));
        $sitemap->model->resetItems();
        $counter = 0;
        $sitemapCounter++;
        }
        $sitemap->add(url('sayfa/'.$b->slug), Carbon::now(), 1, 1);
        $counter++;
        }
        if (!empty($sitemap->model->getItems())) {
        $sitemap->store('xml', 'sitemap-blog-' . $sitemapCounter,realpath('./sitemaps/'));
        $sitemap->addSitemap(secure_url('sitemaps/sitemap-blog-' . $sitemapCounter . '.xml'));
        $sitemap->model->resetItems();
        }
         */

        // generate new sitemapindex that will contain all generated sitemaps above
        $sitemap->store('sitemapindex', 'sitemap', realpath('./'));
    }
}
