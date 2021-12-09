<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderBy('id', 'DESC')->get();

        return view('admin.comments.index', compact('comments'));
    }

    public function datatables(){
        $comments = Comment::orderBy('id', 'DESC')->get();
        $comments = $comments->map(function($item){
            $item->edit = '<a href="'.route('admin.comments.edit', $item->id).'" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>';
            $item->delete = '<form action="'.route('admin.comments.destroy', $item->id).'" method="POST">'.csrf_field().method_field('DELETE').'<button type="submit" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i> Sil</button></form>';
            return $item;
        });

        return Datatables::of($comments)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Comment::create($request->all());

        session()->flash('status', array(1, "İşlem başarıyla tamamlandı."));

        return redirect()->route('admin.comments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->update($request->all());

        session()->flash('status', array(1, "İşlem başarıyla tamamlandı."));

        return redirect()->route('admin.comments.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        session()->flash('status', array(1, "İşlem başarıyla tamamlandı."));

        return redirect()->route('admin.comments.index');
    }
}
