<?php

namespace App\Http\Controllers;

use App\Order;
use App\Products;
use App\Services\n11;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelAnalytics\LaravelAnalyticsFacade;
use Symfony\Component\HttpFoundation\Session\Session;
use Yajra\Datatables\Datatables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:user_read', ['only' => ['processLog', 'processLogDt']]);
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
    }

    public function index()
    {
        $order       = \App\Order::where('created_at', '>=', date('Y-m-d') . ' 00:00:00');
        $todayOrder  = $order->where('status', '!=', 9)->count();
        $todayMember = \App\Member::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->count();
        $orderSum    = \App\Order::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->where('status', '!=', 3)->where('status', '!=', 9)->sum('grand_total'); //$order->sum('grand_total');
        $waitConfirm = $order->where('status', '=', 0)->count();
        $ready       = \App\Order::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->where('status', '=', 1)->count();
        $cargo       = \App\Order::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->where('status', '=', 2)->count();
        $delivered   = \App\Order::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->where('status', '=', 4)->count();
        $refund      = \App\Order::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->where('status', '=', 3)->count();

        $weekSum  = \App\Order::where('status', '!=', 3)->where('status', '!=', 9)->where('created_at', '>=', Carbon::now()->startOfWeek())->sum('grand_total');
        $monthSum = \App\Order::where('status', '!=', 3)->where('status', '!=', 9)->where('created_at', '>=', Carbon::now()->startOfMonth())->sum('grand_total');

        //return dd(Carbon::now()->subWeek());

        // dd($order);
        $daily = [
            "todayOrder"  => $todayOrder,
            "todayMember" => $todayMember,
            "orderSum"    => $orderSum,
            "waitConfirm" => $waitConfirm,
            "ready"       => $ready,
            "cargo"       => $cargo,
            "delivered"   => $delivered,
            "refund"      => $refund,
            "weekSum"     => $weekSum,
            "monthSum"    => $monthSum,
        ];

        return view('admin.index', compact('daily'));
    }

    public function cacheClear(Request $request)
    {
        \Artisan::call('cache:clear');
        $request->session()->flash("status", array(1, "Önbellek temizlendi."));
        return redirect()->back();
    }

    public function analytics()
    {
        $analyticsData = LaravelAnalyticsFacade::getVisitorsAndPageViews(10);
        return response()->json($analyticsData);
    }

    public function statsReports()
    {
        return view('admin.stats.reports');
    }

    public function outputCustomersExcel(Request $request)
    {
        //        $data  = \App\Member::filterByRequest($request)->orderBy('created_at','desc')->offset(30000)->limit(1000000000)->get();

        $data = \App\Member::filterByRequest($request)->orderBy('created_at', 'desc');

        Excel::create('Üye Raporu', function ($excel) use ($data) {
            $excel->sheet('Rapor', function ($sheet) use ($data) {
                $sheet->loadView('admin.stats.excel.membersOutput')->with('data', $data);
            });
        })->download('xlsx');
    }

    public function exportOrdersExcel(Request $request)
    {
        $data = \App\Order::filterByRequest($request)
            ->select('id', 'order_no', 'member_id', 'customer_note', 'status', 'payment_type', 'shipping_address_id', 'grand_total', 'billOutput', 'created_at')
            ->with(array('shippingAddress' =>
                function ($query) {
                    $query->select('city', 'state', 'id');
                }))
            ->with(array('customer' =>
                function ($query) {
                    $query->select('id', 'name', 'surname', 'email');
                }))
            ->orderBy('created_at', 'desc')
            ->get();

        Excel::create('Sipariş Raporu', function ($excel) use ($data) {
            $excel->sheet('New sheet', function ($sheet) use ($data) {
                $sheet->loadView('admin.stats.excel.excel')
                    ->with('data', $data);
            });
        })->export('xlsx');
    }

    public function outputOrdersExcell(Request $request)
    {
        $data = \App\Order::filterByRequest($request)->select('id', 'order_no', 'member_id', 'customer_note', 'status', 'payment_type', 'shipping_id', 'shipping_no', 'shipping_address_id', 'billing_address_id', 'grand_total', 'billOutput', 'ip', 'created_at')->with(array('shippingAddress' => function ($query) {
            $query->select('id', 'city', 'state', 'surname', 'name', 'phone', 'phoneGsm', 'address');
        }))->with(array('billingAddress' => function ($query) {
            $query->select('id', 'city', 'state', 'surname', 'name', 'phone', 'phoneGsm', 'address', 'tax_no', 'tax_place');
        }))->with(array('shippingCompany' => function ($query) {
            $query->select('id', 'name');
        }))->with(array('customer' => function ($query) {
            $query->select('id', 'name', 'surname', 'email');
        }))->orderBy('created_at', 'desc')->get();

        // if ($request->has('time1') && $request->has('time2')) {
        //     $time1 = $request->get('time1') . ':00';
        //     $time2 = $request->get('time2') . ':00';

        //     $data = $data->filter(function ($value, $key) use ($time1, $time2) {
        //         return Carbon::createFromFormat('H:i:s', $value->created_at->toTimeString()) > Carbon::createFromFormat('H:i:s', $time1) && Carbon::createFromFormat('H:i:s', $value->created_at->toTimeString()) < Carbon::createFromFormat('H:i:s', $time2);
        //     });
        // }

        Excel::create('Sipariş Raporu', function ($excel) use ($data) {
            $excel->sheet('New sheet', function ($sheet) use ($data) {
                $sheet->loadView('admin.stats.excel.ordersOutput')
                    ->with('data', $data);
            });
        })->export('xlsx');
    }

    public function exportProductsExcel(Request $request)
    {
        $data = Products::filterByRequest($request)
            ->select('id', 'brand_id', 'name', 'stock', 'stock_code', 'barcode', 'status', 'price', 'final_price', 'tax', 'tax_status', 'created_at', 'discount_type', 'discount')
            ->with(array('categori' =>
                function ($query) {
                    $query->select('title');
                }))
            ->with(array('brand' =>
                function ($query) {
                    $query->select('name', 'id');
                }))
            ->filterByAddedDateTime()
            ->orderBy('created_at', 'desc')
            ->get();

        Excel::create('Ürün Raporu', function ($excel) use ($data) {
            $excel->sheet('Ürün Raporu', function ($sheet) use ($data) {
                $sheet->loadView('admin.stats.excel.productsReport')
                    ->with('data', $data);
            });
        })->export('xlsx');
    }

    /**
     * Ürün Excel Raporu,
     */
    public function outputProductsExcel(Request $request)
    {
        $data = Products::filterByRequest($request)
            ->select(
                'id', 'brand_id', 'name', 'discount', 'discount_type', 'stock', 
                'stock_code', 'barcode', 'status', 'price', 'final_price', 'costprice', 
                'tax', 'tax_status', 'created_at'
            )
            ->with(array('categori' =>
                function ($query) {
                    $query->select('title');
                }))
            ->with(array('brand' =>
                function ($query) {
                    $query->select('name', 'id');
                }))
            ->orderBy('created_at', 'desc')
            ->get();

        Excel::create('Ürün Raporu', function ($excel) use ($data) {
            $excel->sheet('Ürün Raporu', function ($sheet) use ($data) {
                $sheet->loadView('admin.stats.excel.productsOutput')
                    ->with('data', $data);
            });
        })->export('xlsx');
    }

    public function exportProductsSalesExcel(Request $request)
    {
        if ($request->has('brand_ids')) {
            $request->request->add(['brand_ids' => explode(",", $request->get('brand_ids')[0])]);
        }
        if ($request->has('category_ids')) {
            $request->request->add(['category_ids' => explode(",", $request->get('category_ids')[0])]);
        }

        $data = Products::filterByRequest($request)
            ->select('products.id', 'products.tax', 'products.tax_status', 'products.name', 'products.brand_id', 'products.stock_code', 'products.barcode', 'products.discount', 'products.discount_type', 'products.price', 'products.final_price', DB::raw('orders.status as order_status'), DB::raw('sum(qty) as count'))
            ->Join('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->with(array('categori' => function ($query) {
                $query->select('title');
            }))
            ->with(array('brand' => function ($query) {
                $query->select('name', 'id');
            }))
            ->where('orders.status', '!=', '9')
            ->where(function ($query) use ($request) {
                // Order Status Filter
                if ($request->has('order_status')) {
                    $query->where('orders.status', $request->get('order_status'));
                }

                // DateTime Filter
                if ($request->has('date1') && $request->has('date2') && $request->has('time1') && $request->has('time2')) {
                    $query->where('orders.created_at', '>=', sprintf('%s %s:00', $request->get('date1'), $request->get('time1')));
                    $query->where('orders.created_at', '<=', sprintf('%s %s:59', $request->get('date2'), $request->get('time2')));
                } else if ($request->has('date1') && $request->has('date2')) {
                    $query->whereDate('orders.created_at', '>=', $request->get('date1'));
                    $query->whereDate('orders.created_at', '<=', $request->get('date2'));
                } else if ($request->has('time1') && $request->has('time2')) {
                    $query->where('orders.created_at', '>=', sprintf('%s:00', $request->get('time1')));
                    $query->where('orders.created_at', '<=', sprintf('%s:59', $request->get('time2')));
                }
            })
            ->groupBy('products.id')
            ->get();

        Excel::create('Ürün Satış Raporu', function ($excel) use ($data) {
            $excel->sheet('Ürün Satış Raporu', function ($sheet) use ($data) {
                $sheet->loadView('admin.stats.excel.productsSalesReport')
                    ->with('data', $data);
            });
        })->export('xlsx');

        /*
    ->whereHas('order',function($query) use ($id){
    $query->where('product_to_cat.cid',$id);
    })
     */
    }

    public function pylist()
    {
        return view('admin.py.list');
    }

    public function n11datatable()
    {
        $data = \App\N11template::All();
        return Datatables::of($data)->make(true);
    }

    public function n11templateEdit(Request $request)
    {

        $data = \App\N11template::find($request->get('id'));

        if ($data) {
            $message = '<div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form method="POST" action="' . url('admin/n11/templates/update/' . $data->id) . '" id="createN11temp" enctype="multipart/form-data" class="form-horizontal form-bordered">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">N11 Şablonu Düzenle</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                   <div class="form-group">
                                                        <label for="templateName" class="col-sm-2 control-label">Şablon İsmi</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" id="templateName" class="form-control" value="' . $data->name . '" name="templateName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="shipping" class="col-sm-2 control-label">Kargo Süresi</label>
                                                        <div class="col-sm-10">
                                                            <select name="shipping" id="shipping" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                                <option ' . ($data->shipping == 1 ? 'selected' : '') . ' value="1">1</option>
                                                                <option ' . ($data->shipping == 2 ? 'selected' : '') . ' value="2">2</option>
                                                                <option ' . ($data->shipping == 3 ? 'selected' : '') . ' value="3">3</option>
                                                                <option ' . ($data->shipping == 4 ? 'selected' : '') . ' value="4">4</option>
                                                                <option ' . ($data->shipping == 5 ? 'selected' : '') . ' value="5">5</option>
                                                                <option ' . ($data->shipping == 6 ? 'selected' : '') . ' value="6">6</option>
                                                                <option ' . ($data->shipping == 7 ? 'selected' : '') . ' value="7">7</option>
                                                                <option ' . ($data->shipping == 8 ? 'selected' : '') . ' value="8">8</option>
                                                                <option ' . ($data->shipping == 9 ? 'selected' : '') . ' value="9">9</option>
                                                                <option ' . ($data->shipping == 10 ? 'selected' : '') . ' value="10">10</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="delivery" class="col-sm-2 control-label">Teslimat Şablonu</label>
                                                        <div class="col-sm-10">
                                                            <select name="delivery" id="delivery" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                                <option ' . ($data->delivery == 1 ? 'selected' : '') . ' value="1">ozkoru</option>
                                                                <option ' . ($data->delivery == 2 ? 'selected' : '') . ' value="2">ozkoru2</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="priceOpt" class="col-sm-2 control-label">Satış Fiyatı</label>
                                                        <div class="col-sm-5">
                                                            <select name="priceOpt" id="priceOpt" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                                <option ' . ($data->priceOpt == 1 ? 'selected' : '') . ' value="1">x</option>
                                                                <option ' . ($data->priceOpt == 2 ? 'selected' : '') . ' value="2">+</option>
                                                                <option ' . ($data->priceOpt == 3 ? 'selected' : '') . ' value="3">-</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <input name="price" value="' . $data->price . '" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="discount" class="col-sm-2 control-label">% İndirim Oranı</label>
                                                        <div class="col-sm-10">
                                                             <input name="discount" value="' . $data->discount . '" id="discount" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="start_date" class="col-sm-2 control-label">Başlangıç Tarihi</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control datepicker" name="start_date" id="start_date" value="' . str_replace("-", "/", $data->start_date) . '">
                                                        </div>
                                                        <label for="expire_date" class="col-sm-2 control-label">Bitiş Tarihi</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control datepicker" name="expire_date" id="expire_date" value="' . str_replace("-", "/", $data->expire_date) . '">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subtitle" class="col-sm-2 control-label">Alt Başlık</label>
                                                        <div class="col-sm-10">
                                                             <input name="subtitle" value="' . $data->subtitle . '" id="subtitle" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="_token" value="' . csrf_token() . '">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default">Uygula</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                                    </div>
                                    </form>
                              </div>
                            </div>';
            $response = ["status" => 200, "message" => $message];
        } else {
            $response = ["status" => 0, "message" => ""];
        }

        return response()->json($response);
    }

    public function n11templateUpdate(Request $request, $id)
    {
        $tmp = \App\N11template::find($id);

        if ($tmp) {
            $data = [
                "name"        => $request->get("templateName"),
                "shipping"    => $request->get("shipping"),
                "delivery"    => $request->get("delivery"),
                "priceOpt"    => $request->get("priceOpt"),
                "price"       => $request->get("price"),
                "discount"    => $request->get("discount"),
                "start_date"  => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("start_date")))),
                "expire_date" => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("expire_date")))),
                "subtitle"    => $request->get("subtitle"),
            ];

            try {
                $tmp->update($data);
                $request->session()->flash('status', array(1, "Şablon güncellendi!"));
                \LogActivity::addToLog('N11 şablonu güncellendi.');
            } catch (Exception $e) {
                $request->session()->flash('status', array(0, "Hata Oluştu!"));
            }
        }

        return redirect('admin/py/list');
    }

    public function n11templateCreate(Request $request)
    {
        $data = [
            "name"        => $request->get("templateName"),
            "shipping"    => $request->get("shipping"),
            "delivery"    => $request->get("delivery"),
            "priceOpt"    => $request->get("priceOpt"),
            "price"       => $request->get("price"),
            "discount"    => $request->get("discount"),
            "start_date"  => $request->get("start_date"),
            "expire_date" => $request->get("expire_date"),
            "subtitle"    => $request->get("subtitle"),
        ];

        try {
            $create = \App\N11template::create($data);
            $request->session()->flash("status", array(1, "Şablon Eklendi."));
            \LogActivity::addToLog('N11 şablonu oluşturuldu.');
        } catch (Exception $e) {
            $request->session()->flash("status", array(1, "Hata Oluştu."));
        }

        return redirect("admin/py/list");
    }

    public function n11templateDelete($id)
    {
        $tmp = \App\N11template::find($id);
        try {
            $tmp->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('N11 şablonu silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/py/list");
    }

    public function n11CatMap()
    {
        $localCat  = \App\Categori::where(['parent_id' => 0, 'status' => 1])->get(['id', 'title']);
        $templates = \App\N11template::all();

        $data   = ['app_key' => '39bb4d9e-3324-4274-a86c-1885d3259c7f', 'app_secret' => '8LdgdX9qSGG82StI'];
        $n11    = new N11($data);
        $n11Cat = $n11->GetTopLevelCategories();
        $n11Cat = $n11Cat->categoryList->category;
        //return dd($localCat);
        return view('admin.py.n11CatMap', compact('localCat', 'templates', 'n11Cat'));
    }

    public function n11CatMapDatatable()
    {
        $data = \App\N11catMap::with('n11Template')->get();
        return Datatables::of($data)->make(true);
    }

    public function n11GetCategories(Request $request)
    {
        $data     = ['app_key' => '39bb4d9e-3324-4274-a86c-1885d3259c7f', 'app_secret' => '8LdgdX9qSGG82StI'];
        $n11      = new N11($data);
        $response = $n11->GetSubCategory($request->get('id'));
        return response()->json($response);
    }

    public function n11CatMapCreate(Request $request)
    {

        $data = [
            'category_id'    => $request->get('categoryId'),
            'n11category_id' => $request->get('n11CategoryId'),
            'n11template_id' => $request->get('n11template_id'),
            'category'       => $request->get('localCategoryPath'),
            'n11category'    => $request->get('n11CategoryPath'),
        ];
        $create = \App\N11catMap::create($data);

        if ($create) {
            \LogActivity::addToLog('N11 kategori eşleştirme oluşturuldu.');
            $response = ["status" => 200];
        } else {
            $response = ["status" => 0, "message" => "Hata Oluştu."];
        }

        return response()->json($response);
    }

    public function n11CatMapDelete($id)
    {
        $tmp = \App\N11catMap::find($id);
        try {
            $tmp->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('N11 kategori eşleştirme silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/n11/category/map");
    }

    public function processLog()
    {
        return view('admin.processLog');
    }

    public function processLogDt(Request $request)
    {

        $length = intval($request->input('length'));
        $start  = intval($request->input('start'));
        $draw   = $request->get('draw');

        $logs  = \App\LogActivity::with('user')->latest()->limit($length)->offset($start)->get();
        $count = \App\LogActivity::count();

        $responseData = [
            "draw"            => $draw,
            "recordsTotal"    => $count,
            "recordsFiltered" => $count,
            "data"            => $logs,
        ];

        return response()->json($responseData);

        //$logs = \LogActivity::logActivityLists();
        //return Datatables::of($logs)->make(true);
    }

    public function statsOrders()
    {
        return view('admin.stats.statsOrder');
    }

    public function statsProducts()
    {
        return view('admin.stats.statsProducts');
    }

    public function statsCustomers()
    {
        return view('admin.stats.statsCustomers');
    }
}
