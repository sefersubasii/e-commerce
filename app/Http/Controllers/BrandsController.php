<?php

namespace App\Http\Controllers;

use App\Brand;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.brands');
    }

    public function add()
    {
        return view('admin.brandAdd');
    }

    public function createBrand(Request $request)
    {

        $data = array(
            "name" => $request->get("name"),
            "slug" => str_slug($request->get("name"), ''),
            "code" => $request->get("code"),
            "seo_title" => $request->get("seo_title"),
            "seo_keywords" => $request->get("seo_keywords"),
            "seo_description" => $request->get("seo_description"),
            "sort" => $request->get("sort"),
            "filter_status" => $request->get("filter_status") ? $request->get("filter_status") : 0
        );

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/brands/';
            $microtime = explode(' ', str_replace('0.', null, microtime()));
            $filename = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;
        }

        $add = \App\Brand::create($data);
        if ($add) {
            $request->session()->flash('status', array(1, "Eklendi."));
            \LogActivity::addToLog('Marka oluşturuldu.');
        } else {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/brands");
    }

    public function createShort(Request $request)
    {

        $data = array(
            "name" => $request->get("name"),
            "slug" => str_slug($request->get("name"), ''),
            "code" => $request->get("code"),
            "sort" => $request->get("sort"),
            "filter_status" => $request->get("filter_status") ? $request->get("filter_status") : 0
        );

        $add = \App\Brand::create($data);

        if ($add) {
            $response = ["status" => 200, "message" => "eklendi"];
            \LogActivity::addToLog('Marka oluşturuldu.');
        } else {
            $response = ["status" => 0, "message" => "hata Oluştu"];
        }

        return response()->json($response);
    }

    public function brandsDatatable()
    {

        $brands = \App\Brand::All();

        foreach ($brands as $brand) {
            $brand->edit = '<a href="' . url("admin/brands/edit/{$brand->id}") . '" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>';
            $brand->delete = '<a href="' . url("admin/brands/delete/{$brand->id}") . '" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i> Sil</a>';
            $resp[] = $brand;
        }
        return Datatables::of($brands)->make(true);
    }

    public function ajaxList(Request $request)
    {
        //return \App\Brand::paginate(15);
        if (!empty($request->get('q'))) {
            return \App\Brand::select('id', 'name')->where('name', 'like', '%' . $request->get('q') . '%')->paginate(15);
        } else {
            return \App\Brand::select('id', 'name')->paginate(15);
        }
    }

    public function brandsDelete($id)
    {
        $br = \App\Brand::find($id);

        if (!empty($br->image)) {
            $destinationPath = public_path() . '/src/uploads/brands/' . $br->image;
            if (file_exists($destinationPath)) {
                @unlink($destinationPath);
            }
        }
        try {
            $br->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('Marka silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/brands");
    }

    public function editBrand($id)
    {
        $data = Brand::with('category')->find($id);
        return view('admin.brandEdit', compact('data'));
    }

    public function updateBrand(Request $request)
    {
        //old image
        $old = Brand::find($request->get("id"));
        if ($request->has("filter_status")) {
            $status = 1;
        } else {
            $status = 0;
        }
        $data = array(
            "name" => $request->get("name"),
            "slug" => str_slug($request->get("name"), ''),
            "code" => $request->get("code"),
            "seo_title" => $request->get("seo_title"),
            "seo_keywords" => $request->get("seo_keywords"),
            "seo_description" => $request->get("seo_description"),
            "extra_content" => $request->get("extra_content"),
            "sort" => $request->get("sort"),
            "filter_status" => $status
        );

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/brands/';
            $microtime = explode(' ', str_replace('0.', null, microtime()));
            $filename = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;

            // old image delete
            if (!empty($old->image) && $old->image != $data["image"]) {
                $destinationPath = public_path() . '/src/uploads/brands/' . $old->image;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }
        }

        //$data=array();

        try {
            $update = \App\Brand::where('id', '=', $request->get("id"))
                ->update($data);

            if ($request->get('brandCatId')) {

                foreach ($request->get('brandCatId') as $key => $value) {

                    $item = \App\BrandCategory::firstOrNew(array('category_id' => $value, 'brand_id' => $request->get("id")));
                    $item->brand_id    = $request->get("id");
                    $item->content     = $request->get('content')[$key];
                    $item->title       = $request->get('brandCatTitle')[$key];
                    $item->description = $request->get('bcdescription')[$key];

                    //dd($request->file('imageCat')[1]);

                    if ($request->file('imageCat')[$key]) {

                        $image = $request->file('imageCat')[$key];
                        $destinationPath = public_path() . '/src/uploads/brands-category/';
                        $microtime = explode(' ', str_replace('0.', null, microtime()));
                        $filename = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
                        $image->move($destinationPath, $filename);
                        $new["image"] = $filename;

                        // old image delete
                        if (!empty($item->image) && $item->image != $request->get("imageCat")[$key]) {
                            $destinationPath = public_path() . '/src/uploads/brands-category/' . $item->image;
                            if (file_exists($destinationPath)) {
                                @unlink($destinationPath);
                            }
                        }
                        $item->image = $new["image"];
                    }

                    $item->save();
                }
            }

            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Marka düzenlendi.');


            //dd($request->session()->get("status"));
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        /*
        
        if ($update) {
            $request->session()->flash('status', 'Güncellendi!');
        }else{
            $request->session()->flash('status', 'Hata Oluştu!');
        }
        */
        // $data = Brand::find($old->id);
        // return view('admin.brandEdit', compact('data'));
        return redirect("admin/brands/edit/" . $old->id);
    }
}
