<?php

namespace App\Http\Controllers;

use App\Article;
use App\BlogCategory;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function categories(Request $request)
    {
        if ($request->get("parent")){
            $parent = $request->get("parent");    
        }else{
            $parent=0;
        }
        
        return view('admin.blog.categories',compact('parent'));
    }
    
    public function categoryAdd()
    {
        $allRootCategories=\App\BlogCategory::where('parent_id',0)->get();
        return view('admin.blog.categoryAdd',compact('allRootCategories'));
    }

    public function createCategory(Request $request)
    {

        $seo  = [
            "seo_title"       =>$request->get("seo_title"),
            "seo_keywords"    =>$request->get("seo_keywords"),
            "seo_description" =>$request->get("seo_description")
        ];
        $data = array(
            "title"=>$request->get("title"),
            "slug"=>str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("title")),
            "parent_id"=> empty($request->get("parent_id")) ? 0 : $request->get("parent_id"),
            "seo" =>json_encode($seo),
            "sort"=>$request->get("sort"),
            "status"=>$request->get("status")
        );

        if($request->hasFile('image')){
            $image = $request->file('image');
            $destinationPath = public_path().'/src/uploads/blogCategory/';
            $microtime = explode(' ', str_replace('0.', null, microtime()));
            $filename = str_slug($request->get('title')).$microtime[0].$microtime[1].".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;
        }

        $add = \App\BlogCategory::create($data);
        if ($add) {
            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/blog-categories");

    }

    public function editCategory($id)
    {
        $data = \App\BlogCategory::find($id);
        $allRootCategories=\App\BlogCategory::where('parent_id',0)->where('id','!=',$id)->get();
        return view('admin.blog.categoryEdit',compact('data','allRootCategories'));
    }

    public function updateCategory($id, Request $request)
    {
        $old = BlogCategory::find($id);

        $seo  = [
            "seo_title"       =>$request->get("seo_title"),
            "seo_keywords"    =>$request->get("seo_keywords"),
            "seo_description" =>$request->get("seo_description")
        ];
        $data = array(
            "title"=>$request->get("title"),
            "slug"=>str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("title")),
            "parent_id"=> empty($request->get("parent_id")) ? 0 : $request->get("parent_id"),
            "seo" =>json_encode($seo),
            "sort"=>$request->get("sort"),
            "status"=>$request->get("status")
        );

        If($request->hasFile('image')){
            $image = $request->file('image');
            $destinationPath = public_path().'/src/uploads/blogCategory/';
            $microtime = explode(' ', str_replace('0.', null, microtime()));
            $filename = str_slug($request->get('title')).$microtime[0].$microtime[1].".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;

            // old image delete
            if (!empty($old->image) && $old->image!=$data["image"]){
                $destinationPath = public_path().'/src/uploads/blogCategory/'.$old->image;
                if(file_exists($destinationPath)){
                    @unlink($destinationPath);
                }
            }

        }

        try {
            $update = BlogCategory::where('id','=',$id)
                ->update($data);
            $request->session()->flash("status",array(1,"Tebrikler."));

        } catch (Exception $e) {
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }

        return redirect("admin/blog-categories");
    }

    
    public function categoryDatatable(Request $request)
    {
        if ($request->get("parent")){
            $cats = \App\BlogCategory::where('parent_id',$request->get('parent'))->get();
        }else{
            $cats = \App\BlogCategory::where('parent_id',0)->get();
        }
        return Datatables::of($cats)->make(true);

    }
    
    public function deleteCategory($id)
    {
        $br = \App\BlogCategory::find($id);

        if (!empty($br->image)){
            $destinationPath = public_path().'/src/uploads/blogCategory/'.$br->image;
            if(file_exists($destinationPath)){
                @unlink($destinationPath);
            }
        }
        //$Category = new Category();
        //$Category->deleteCat($br);
        try {
            $br->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/blog-categories");
        
    }

    public function articles()
    {
        return view('admin.blog.articles');
    }

    public function articleDatatable()
    {
        $articles = \App\Article::all();
        return Datatables::of($articles)->make(true);
    }
    
    public function articleAdd()
    {
        $allRootCategories=\App\BlogCategory::where('parent_id',0)->get();
        return view('admin.blog.articleAdd',compact('allRootCategories'));
    }

    public function articleCreate(Request $request)
    {

        $seo  = [
            "seo_title"       =>$request->get("seo_title"),
            "seo_keywords"    =>$request->get("seo_keywords"),
            "seo_description" =>$request->get("seo_description")
        ];
        $data = array(
            "title"=>$request->get("title"),
            "slug"=>str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("title")),
            "content"=>$request->get("content"),
            "category_id"=>$request->get("category_id"),
            "seo" =>json_encode($seo),
            "sort"=>$request->get("sort"),
            "status"=>$request->get("status")
        );

        If($request->hasFile('image')){
            $image = $request->file('image');
            $destinationPath = public_path().'/src/uploads/articles/';
            $microtime = explode(' ', str_replace('0.', null, microtime()));
            $filename = str_slug($request->get('title')).$microtime[0].$microtime[1].".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;
        }

        $add = \App\Article::create($data);

        if ($add) {
            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/articles");

    }

    public function articleEdit($id)
    {
        $article = \App\Article::find($id);
        $allRootCategories=\App\BlogCategory::where('parent_id',0)->get();
        return view('admin.blog.articleEdit',compact('article','allRootCategories'));
    }

    public function articleUpdate($id, Request $request)
    {
        $old = Article::find($id);

        $seo  = [
            "seo_title"       =>$request->get("seo_title"),
            "seo_keywords"    =>$request->get("seo_keywords"),
            "seo_description" =>$request->get("seo_description")
        ];
        $data = array(
            "title"=>$request->get("title"),
            "slug"=>str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("title")),
            "content"=>$request->get("content"),
            "category_id"=> $request->get("category_id"),
            "seo" =>json_encode($seo),
            "sort"=>$request->get("sort"),
            "status"=>$request->get("status")
        );

        If($request->hasFile('image')){
            $image = $request->file('image');
            $destinationPath = public_path().'/src/uploads/articles/';
            $microtime = explode(' ', str_replace('0.', null, microtime()));
            $filename = str_slug($request->get('title')).$microtime[0].$microtime[1].".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;

            // old image delete
            if (!empty($old->image) && $old->image!=$data["image"]){
                $destinationPath = public_path().'/src/uploads/articles/'.$old->image;
                if(file_exists($destinationPath)){
                    @unlink($destinationPath);
                }
            }

        }

        try {
            $update = Article::where('id','=',$id)
                ->update($data);
            $request->session()->flash("status",array(1,"Tebrikler."));

        } catch (Exception $e) {
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }

        return redirect("admin/articles");
    }

    public function deleteArticle($id)
    {
        $br = \App\Article::find($id);

        if (!empty($br->image)){
            $destinationPath = public_path().'/src/uploads/articles/'.$br->image;
            if(file_exists($destinationPath)){
                @unlink($destinationPath);
            }
        }
        try {
            $br->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/articles");

    }
    
}
