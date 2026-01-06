<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->latest()->get();
        return view('admin.users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Đã thêm quản trị viên mới thành công.');
    }

    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa tài khoản của chính mình.');
        }

        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.users.index')->with('success', 'Đã xóa quản trị viên thành công.');
    }
}
