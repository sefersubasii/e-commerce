<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$permission = \App\Permission::all();
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $data = [
            "name"         => $request->get("name"),
            "display_name" => $request->get("display_name"),
            "description"  => $request->get("description"),
        ];
        $role = Role::create($data);

        foreach ($request->permissions as $key => $value) {
            $role->attachPermission($value);
        }
        // $request->session()->flash("status",array(1,"Tebrikler."));
        return redirect("admin/role");

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
        $role             = Role::find($id);
        $permissions      = Permission::all();
        $role_permissions = $role->perms()->pluck('id', 'id')->toArray();
        return view('admin.role.edit', compact('role', 'permissions', 'role_permissions'));
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

        $role               = Role::find($id);
        $role->name         = $request->get("name");
        $role->display_name = $request->get("display_name");
        $role->description  = $request->get("description");
        $role->save();

        DB::table('permission_role')->where('role_id', $id)->delete();

        if ($request->permissions) {
            foreach ($request->permissions as $key => $value) {
                $role->attachPermission($value);
            }
        }

        return redirect("admin/role");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where("id", $id)->delete();
        Session()->flash('status', array(1, "Silindi."));
        return redirect('admin/role');
    }

    public function delete($id)
    {
        DB::table("roles")->where("id", $id)->delete();
        Session()->flash('status', array(1, "Silindi."));
        return redirect('admin/role');
    }

    public function dataTable()
    {
        $roles = \App\Role::all();
        return Datatables::of($roles)->make(true);
    }

    public function ajaxList()
    {
        return \App\Role::paginate(15);
    }
}
