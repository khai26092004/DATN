<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::with('orders.items.product')->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function destroy($id)
    {
        $customer = User::findOrFail($id);

        // Optional: Check if user has orders before deleting
        // In a real app, you might want to soft delete or forbid deleting users with orders
        // For now, we will delete them. If cascading is set up in DB, orders usually go too,
        // or we can manually delete them or keep them null. 
        // Let's assume standard delete.

        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Đã xóa khách hàng thành công.');
    }
}
