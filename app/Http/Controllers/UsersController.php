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
        if (auth()->user()->hasRole('super-admin')) {
            $users = User::all();
        } else if (auth()->user()->hasRole('admin')) {
            $users = User::where('unit_id', auth()->user()->unit_id)->get();
        } else {
            $users = User::where('id', auth()->user()->id)->get();
        }
        return view('users.index', compact('users'));
    }

    public function detail($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $units = Unit::all();
        return view('users.edit', compact('user', 'roles', 'units'));
    }

    public function password($id)
    {
        $user = User::find($id);
        return view('users.edit-password', compact('user'));
    }

    public function edit(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if ($user->hasRole('super-admin')) {
                return redirect()->back()->with(['error' => 'Tidak dapat mengubah akun super admin']);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->unit_id = $request->unit;
            $user->password = bcrypt($request->password) ?? $user->password;
            $user->jenis = $request->jenis;
            $user->save();
            $user->roles()->detach();
            foreach ($request->role as $role) {
                $user->assignRole($role);
            }
            return redirect('/users')->with(['success' => 'Data berhasil diubah']);
        } catch (\Exception $ex) {

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
            'unit'  =>  'required',
            'jenis' => 'required'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'role.required' => 'Role harus diisi',
            'unit.required' => 'Unit harus diisi',
            'jenis.required' => 'Jenis User harus diisi',
        ]);

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'unit_id' => $request->unit,
                'password' => bcrypt($request->password),
                'jenis' => $request->jenis
            ]);

            foreach ($request->role as $role) {
                $user->assignRole($role);
            }

            return redirect('/users')->with(['success' => 'Data berhasil ditambahkan']);
        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function hapus($id)
    {
        try {
            $user = User::find($id);
            if ($id == auth()->user()->id) {
                return redirect()->back()->with(['error' => 'Tidak dapat menghapus akun sendiri']);
            }
            if ($user->hasRole('super-admin')) {
                return redirect()->back()->with(['error' => 'Tidak dapat menghapus akun super admin']);
            }
            $user->delete();

            return redirect('/users')->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function ubahPassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ], [
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Password tidak cocok',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        try {
            $user = User::find($id);
            if ($user->hasRole('super-admin')) {
                return redirect()->back()->with(['error' => 'Tidak dapat mengubah password akun super admin']);
            }
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect('/users')->with(['success' => 'Password berhasil diubah']);
        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => $ex->getMessage() ?? 'Data gagal diubah']);
        }
    }
}
