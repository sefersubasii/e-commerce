<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:user_read', ['only' => ['index']]);
        $this->middleware('permission:user_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.user.users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newUser = User::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password')),
            'api_token' => str_random(60),
        ]);

        $roles = $request->roles;

        foreach ($roles as $role) {
            $newUser->attachRole($role);
        }

        if (!File::exists(realpath('laravel-filemanager') . '/files/' . $newUser->id)) {
            mkdir(realpath('laravel-filemanager') . '/files/' . $newUser->id, 0777, true);
        }

        LogActivity::addToLog('Kullanıcı oluşturuldu.');

        return redirect("admin/user");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.user.edit', compact('user'));
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
        $user       = User::find($id);
        $user->name = $request->name;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        if (!$user->api_token) {
            $user->api_token = str_random(60);
        }

        $user->save();

        $roles = $request->roles;

        DB::table('role_user')
            ->where('user_id', $id)
            ->delete();

        foreach ($roles as $role) {
            $user->attachRole($role);
        }

        LogActivity::addToLog('Kullanıcı düzenlendi.');

        return redirect('admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);

        LogActivity::addToLog(
            sprintf(
                '%s(%s) adlı kullanıcı silindi!',
                $user->name,
                $user->id
            ),
            $user
        );

        $user->delete();

        return redirect('admin/user');
    }

    public function datatable()
    {
        return Datatables::of(User::all())->make(true);
    }
}
