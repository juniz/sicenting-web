<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UsersController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function detail($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $units = Unit::all();
        return view('users.edit', compact('user', 'roles', 'units'));
    }

    public function edit(Request $request, $id)
    {
        try{

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->unit_id = $request->unit;
            $user->password = bcrypt($request->password) ?? $user->password;
            $user->save();
            $user->roles()->detach();
            foreach($request->role as $role){
                $user->assignRole($role);
            }
            return redirect('/users')->with(['success' => 'Data berhasil diubah']);

        }catch(\Exception $ex){

            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function tambah()
    {
        $units = Unit::all();
        $roles = Role::all();
        return view('users.tambah', compact('units', 'roles'));
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required',
            'unit'  =>  'required'
        ],[
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'role.required' => 'Role harus diisi',
            'unit.required' => 'Unit harus diisi'
        ]);

        try{

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'unit_id' => $request->unit,
                'password' => bcrypt($request->password),
            ]);

            foreach($request->role as $role){
                $user->assignRole($role);
            }

            return redirect('/users')->with(['success' => 'Data berhasil ditambahkan']);

        }catch(\Exception $ex){

            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }
}
