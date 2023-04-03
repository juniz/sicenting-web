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
        return view('users.edit', compact('user'));
    }

    public function edit(Request $request, $id)
    {
        try{

            $user = User::find($id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = bcrypt($request->password) ?? $user->password;
            $user->save();
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
            'username' => 'required',
            'password' => 'required|confirmed|min:6',
            'role' => 'required',
            'unit'  =>  'required'
        ]);

        try{

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);

            $user->assignRole($request->role);

            return redirect('/users')->with(['success' => 'Data berhasil ditambahkan']);

        }catch(\Exception $ex){

            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }
}
