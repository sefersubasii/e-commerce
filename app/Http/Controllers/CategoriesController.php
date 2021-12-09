<?php

namespace App\Http\Controllers;

use App\Categori;
use App\Products;
use App\Services\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get("parent")) {
            $parent = $request->get("parent");
        } else {
            $parent = 0;
        }
        return view('admin.categories', compact('parent'));
    }

    public function category2(Request $request)
    {
        return view('admin.categories2');
    }

    public function categoriesDatatable(Request $request)
    {

        if ($request->has('parent')) {
            $cats = \App\Categori::where('parent_id', $request->get('parent'))->get();
        } else {
            $cats = \App\Categori::where('parent_id', 0)->get();
        }

/*
foreach ($cats as $cat){
$cat->DT_RowId='row_'.$cat->id;
$cat->edit='<a href="'.url("admin/categories/edit/{$cat->id}").'" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>';
$cat->delete='<a href="'.url("admin/categories/delete/{$cat->id}").'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i> Sil</a>';
}
 */

        return Datatables::of($cats)->make(true);
    }

    public function categoriesDatatable2(Request $request)
    {

        $cats = \App\Categori::select('id', 'title', 'status')->get();

        return Datatables::of($cats)->make(true);
    }

    public function categorySoe()
    {
        $cats = \App\Categori::where('content', "")->select('id', 'title', 'slug', 'status')->get();
        //return Datatables::of($cats)->make(true);
        foreach ($cats as $key => $value) {
            echo "içeriği boş ----> <a href='https://www.marketpaketi.com.tr/admin/categories/edit/" . $value->id . "'>" . $value->title . "</a> ----> <a target='_blank' href='https://www.marketpaketi.com.tr/" . $value->slug . "-c-" . $value->id . "'>https://www.marketpaketi.com.tr/" . $value->slug . "-c-" . $value->id . "</a></br>";
        }

        echo "</br>";
        echo "<hr>";
        echo "</br>";

        $cats2 = \App\Categori::where('content', "!=", "")->select('id', 'title', 'slug', 'status')->get();
        //return Datatables::of($cats)->make(true);
        foreach ($cats2 as $key => $value) {
            echo "içeriği dolu ---->  <a href='https://www.marketpaketi.com.tr/admin/categories/edit/" . $value->id . "'>" . $value->title . "</a> ----> <a target='_blank' href='https://www.marketpaketi.com.tr/" . $value->slug . "-c-" . $value->id . "'>https://www.marketpaketi.com.tr/" . $value->slug . "-c-" . $value->id . "</a></br>";
        }

    }

    public function addCategory()
    {

        $allSubCategories = \App\Categori::where('parent_id', 0)->get();
        return view('admin.categoryAdd', compact('allSubCategories'));

    }

    public function createCategory(Request $request)
    {

        $seo = [
            "seo_title"       => $request->get("seo_title"),
            "seo_keywords"    => $request->get("seo_keywords"),
            "seo_description" => $request->get("seo_description"),
        ];
        $data = array(
            "title"     => $request->get("title"),
            "slug"      => str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("title")),
            "parent_id" => empty($request->get("parent_id")) ? 0 : $request->get("parent_id"),
            "code"      => $request->get("code"),
            "seo"       => json_encode($seo),
            "sort"      => $request->get("sort"),
            "content"   => $request->get("content"),
            "status"    => $request->get("status"),
        );

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/category/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('title')) . '-' . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            /* tinypng*/
            $tiny     = "";
            $filepath = $destinationPath . $filename;
            try {
                \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
                $source = \Tinify\fromFile($filepath);
                $source->toFile($filepath);
                $tiny = "ok";
            } catch (\Tinify\AccountException $e) {
                // Verify your API key and account limit.
                $tiny = $e->getMessage();
            } catch (\Tinify\ClientException $e) {
                // Check your source image and request options.
                $tiny = $e->getMessage();
            } catch (\Tinify\ServerException $e) {
                // Temporary issue with the Tinify API.
                $tiny = $e->getMessage();
            } catch (\Tinify\ConnectionException $e) {
                // A network connection error occurred.
                $tiny = $e->getMessage();
            } catch (Exception $e) {
                // Something else went wrong, unrelated to the Tinify API.
                $tiny = $e->getMessage();
            }
            /* tinypng*/
            $data["image"] = $filename;
        }

        if ($request->hasFile('imageCover')) {
            $image           = $request->file('imageCover');
            $destinationPath = public_path() . '/src/uploads/category/cover/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('title')) . '-' . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            /* tinypng*/
            $tiny     = "";
            $filepath = $destinationPath . $filename;
            try {
                \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
                $source = \Tinify\fromFile($filepath);
                $source->toFile($filepath);
                $tiny = "ok";
            } catch (\Tinify\AccountException $e) {
                // Verify your API key and account limit.
                $tiny = $e->getMessage();
            } catch (\Tinify\ClientException $e) {
                // Check your source image and request options.
                $tiny = $e->getMessage();
            } catch (\Tinify\ServerException $e) {
                // Temporary issue with the Tinify API.
                $tiny = $e->getMessage();
            } catch (\Tinify\ConnectionException $e) {
                // A network connection error occurred.
                $tiny = $e->getMessage();
            } catch (Exception $e) {
                // Something else went wrong, unrelated to the Tinify API.
                $tiny = $e->getMessage();
            }
            /* tinypng*/
            $data["imageCover"] = $filename;
        }

        $add = \App\Categori::create($data);
        if ($add) {
            $request->session()->flash('status', array(1, "Eklendi."));
            \LogActivity::addToLog('Kategori oluşturuldu.');
        } else {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/categories");
    }

    public function ajaxList(Request $request)
    {

        if (!empty($request->get('q'))) {
            return \App\Categori::select('title', 'id', 'parent_id')->where('title', 'like', '%' . $request->get('q') . '%')->paginate(15);
        } else {
            return \App\Categori::select('title', 'id', 'parent_id')->paginate(15);
        }

    }

    public function categoryDelete($id)
    {
        $br = \App\Categori::find($id);

        if (!empty($br->image)) {
            $destinationPath = public_path() . '/src/uploads/category/' . $br->image;
            if (file_exists($destinationPath)) {
                @unlink($destinationPath);
            }
        }
        $Category = new Category();
        $Category->deleteCat($id);

        try {
            //$br->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('Kategori silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/categories");
    }

    public function editCategory($id)
    {
        $data             = Categori::find($id);
        $allSubCategories = \App\Categori::where('parent_id', 0)->where('id', '!=', $id)->get();
        return view('admin.categoryEdit', compact('data', 'allSubCategories'));
    }

    public function updateCategory(Request $request)
    {

        //old image
        $old = Categori::find($request->get("id"));

        $seo = [
            "seo_title"       => $request->get("seo_title"),
            "seo_keywords"    => $request->get("seo_keywords"),
            "seo_description" => $request->get("seo_description"),
        ];
        $data = array(
            "title"     => $request->get("title"),
            "slug"      => str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("title")),
            "parent_id" => empty($request->get("parent_id")) ? 0 : $request->get("parent_id"),
            "code"      => $request->get("code"),
            "seo"       => json_encode($seo),
            "sort"      => $request->get("sort"),
            "content"   => $request->get("content"),
            "status"    => $request->get("status"),
        );

        //dd($request->hasFile('image'));

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/category/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('title')) . '-' . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            /* tinypng*/
            $tiny     = "";
            $filepath = $destinationPath . $filename;
            try {
                \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
                $source = \Tinify\fromFile($filepath);
                $source->toFile($filepath);
                $tiny = "ok";
            } catch (\Tinify\AccountException $e) {
                // Verify your API key and account limit.
                $tiny = $e->getMessage();
            } catch (\Tinify\ClientException $e) {
                // Check your source image and request options.
                $tiny = $e->getMessage();
            } catch (\Tinify\ServerException $e) {
                // Temporary issue with the Tinify API.
                $tiny = $e->getMessage();
            } catch (\Tinify\ConnectionException $e) {
                // A network connection error occurred.
                $tiny = $e->getMessage();
            } catch (Exception $e) {
                // Something else went wrong, unrelated to the Tinify API.
                $tiny = $e->getMessage();
            }
            /* tinypng*/
            $data["image"] = $filename;

            // old image delete
            if (!empty($old->image) && $old->image != $data["image"]) {
                $destinationPath = public_path() . '/src/uploads/category/' . $old->image;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }

        } /*else{
        // old image delete
        if (!empty($old->image)){
        $destinationPath = public_path().'/src/uploads/category/'.$old->image;
        if(file_exists($destinationPath)){
        @unlink($destinationPath);
        }
        $data["image"] = "";
        }
        }*/
        if ($request->hasFile('imageCover')) {
            $image           = $request->file('imageCover');
            $destinationPath = public_path() . '/src/uploads/category/cover/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('title')) . '-' . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            /* tinypng*/
            $tiny     = "";
            $filepath = $destinationPath . $filename;
            try {
                \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
                $source = \Tinify\fromFile($filepath);
                $source->toFile($filepath);
                $tiny = "ok";
            } catch (\Tinify\AccountException $e) {
                // Verify your API key and account limit.
                $tiny = $e->getMessage();
            } catch (\Tinify\ClientException $e) {
                // Check your source image and request options.
                $tiny = $e->getMessage();
            } catch (\Tinify\ServerException $e) {
                // Temporary issue with the Tinify API.
                $tiny = $e->getMessage();
            } catch (\Tinify\ConnectionException $e) {
                // A network connection error occurred.
                $tiny = $e->getMessage();
            } catch (Exception $e) {
                // Something else went wrong, unrelated to the Tinify API.
                $tiny = $e->getMessage();
            }
            /* tinypng*/
            $data["imageCover"] = $filename;

            // old image delete
            if (!empty($old->imageCover) && $old->imageCover != $data["imageCover"]) {
                $destinationPath = public_path() . '/src/uploads/category/cover/' . $old->imageCover;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }

        }

        try {
            $update = Categori::where('id', '=', $request->get("id"))
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Kategori düzenlendi.');

        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        if ($old->parent_id != 0) {
            $addUrl = "?parent=" . $old->parent_id;
        } else {
            $addUrl = "";
        }

        return redirect("admin/categories" . $addUrl);
    }

    public function nestableCategory()
    {
        return Categori::renderAsJson();
    }

    public function selectNestableCategory($id)
    {
        $pro        = Products::find($id);
        $categories = $pro->categori()->pluck('id');

        return Categori::selected($categories)->renderAsArray();
    }

    public function shortUpdateSort(Request $request)
    {
        $arr  = $request->get('data');
        $arr  = (array) $arr;
        $keys = array_keys($arr)[0];

        $id = str_replace('row_', '', $keys);

        if (is_numeric($arr[$keys]['sort'])) {
            $cat = \App\Categori::find($id);

            if ($cat) {
                $cat->sort = $arr[$keys]['sort'];
                $cat->save();
                $response = [
                    'data' => [
                        'sort' => $arr[$keys]['sort'],
                    ],
                ];
            } else {
                $response = [
                    'fieldErrors' => [
                        [
                            'status' => 'Kategori bulunamadı.',
                            'name'   => 'sort',
                        ],
                    ],
                    'data'        => [],
                ];
            }
        } else {
            $response = [
                'fieldErrors' => [
                    [
                        'status' => 'Geçerli bir değer giriniz.',
                        'name'   => 'sort',
                    ],
                ],
                'data'        => [],
            ];
        }

        return response()->json($response);

    }

    public function getCategories(Request $request)
    {
        $cat = \App\Categori::where(['parent_id' => $request->get('id')])->get(['id', 'title']);
        if ($cat) {
            $response = ['status' => 200, 'parent' => $request->get('id'), 'data' => $cat];
        } else {
            $response = ['status' => 0, 'data' => ''];
        }
        return response()->json($response);
    }

    public function categoryImageDelete(Request $request)
    {
        $id = $request->get('id');
        $br = \App\Categori::find($id);

        if (!empty($br->image)) {
            $destinationPath = public_path() . '/src/uploads/category/' . $br->image;
            if (file_exists($destinationPath)) {
                @unlink($destinationPath);
            }
        }
        $br->image = "";
        $br->save();
    }

    public function categoryImageCoverDelete(Request $request)
    {
        $id = $request->get('id');
        $br = \App\Categori::find($id);

        if (!empty($br->imageCover)) {
            $destinationPath = public_path() . '/src/uploads/category/cover/' . $br->image;
            if (file_exists($destinationPath)) {
                @unlink($destinationPath);
            }
        }
        $br->imageCover = "";
        $br->save();
    }

}
