<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class PagesController extends Controller
{

    public function index()
    {
        return view('admin.pages');
    }

    public function addPages()
    {
        return view('admin.pagesAdd');
    }

    public function createPages(Request $request)
    {
        $seo  = [
            "seo_title"       => $request->get("seo_title"),
            "seo_keywords"    => $request->get("seo_keywords"),
            "seo_description" => $request->get("seo_description")
        ];
        $data = array(
            "title" => $request->get("title"),
            "slug" => str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("title")),
            "seo" => json_encode($seo),
            "sort" => $request->get("sort"),
            "status" => $request->get("status"),
            "content" => $request->get("content")
        );

        $add = \App\Pages::create($data);
        if ($add) {
            $request->session()->flash('status', array(1, "Eklendi."));
        } else {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/pages");
    }

    public function pagesDatatable()
    {
        $pages = \App\Pages::all()->map(function ($item) {
            $item->slug = $item->isStatic ? url($item->slug) : route('page', $item->slug);

            return $item;
        });

        return Datatables::of($pages)->make(true);
    }

    public function editPages($id)
    {
        $data = \App\Pages::find($id);
        return view('admin.pagesEdit', compact('data'));
    }

    public function updatePages(Request $request)
    {
        $seo  = [
            "seo_title"       => $request->get("seo_title"),
            "seo_keywords"    => $request->get("seo_keywords"),
            "seo_description" => $request->get("seo_description")
        ];
        $data = array(
            "title" => $request->get("title"),
            "slug" => str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("title")),
            "seo" => json_encode($seo),
            "sort" => $request->get("sort"),
            "status" => $request->get("status"),
            "content" => $request->get("content")
        );

        try {
            $update = \App\Pages::where('id', '=', $request->get("id"))
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect("admin/pages");
    }

    public function deletePages($id)
    {
        $br = \App\Pages::find($id);
        try {
            $br->delete();
            Session()->flash('status', array(1, "Silindi."));
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/pages");
    }
}
