<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $heads = ['No', 'nama', 'permissions', 'created at', 'updated at', 'aksi'];
        return view('roles.index', compact('roles', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.add', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'Nama harus diisi',
        ]);
        try {
            $role = new Role();
            $role->name = $request->name;
            $role->save();
            if(!empty($role->permission)){
                $role->syncPermissions($request->permissions);
            }
            return redirect()->to('roles')->with('success', 'Berhasil menambah data');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() ?? 'Terjadi kesalahan');
        }
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
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
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
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'Nama harus diisi',
        ]);
        try {
            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();
            if(!empty($role->permission)){
                $role->syncPermissions($request->permissions);
            }
            return redirect()->to('roles')->with('success', 'Berhasil mengubah data');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() ?? 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Role::find($id);
            $role->delete();
            return redirect()->to('roles')->with('success', 'Berhasil menghapus data');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() ?? 'Terjadi kesalahan');
        }
    }
}
