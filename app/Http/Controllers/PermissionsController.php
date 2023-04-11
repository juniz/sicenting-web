<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        $heads = ['No', 'Nama', 'Created at', 'Updated at', 'Aksi'];
        return view('permissions.index', compact('permissions', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ],[
            'name.required' => 'Nama harus diisi'
        ]);
        try{
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->save();
            return redirect()->to('permissions')->with('success', 'Berhasil menambah data');
        }catch(Exception $ex){
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
        $permission = Permission::find($id);
        return view('permissions.edit', compact('permission'));
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
        $this->validate($request,[
            'name' => 'required'
        ],[
            'name.required' => 'Nama harus diisi'
        ]);
        try{
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->to('permissions')->with('success', 'Berhasil mengubah data');
        }catch(Exception $ex){
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
        try{
            $permission = Permission::find($id);
            $permission->delete();
            return redirect()->to('permissions')->with('success', 'Berhasil menghapus data');
        }catch(Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() ?? 'Terjadi kesalahan');
        }
    }
}
