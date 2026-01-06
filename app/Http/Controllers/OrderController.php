<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(5);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        return view('checkout');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required',
            'phone' => 'required',
        ]);

        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            // Validate stock first
            foreach ($cart as $id => $item) {
                $product = \App\Models\Product::lockForUpdate()->find($id);
                if (!$product) {
                    throw new \Exception("Sản phẩm {$item['name']} không tồn tại.");
                }
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Sản phẩm {$item['name']} chỉ còn {$product->stock_quantity} sản phẩm trong kho.");
                }
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method ?? 'cod'
            ]);

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Deduct stock
                $product = \App\Models\Product::find($id);
                $product->decrement('stock_quantity', $item['quantity']);
            }

            session()->forget('cart');
            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Không thể hủy đơn hàng này vì đã được xử lý.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);

            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Đã hủy đơn hàng thành công.');
    }
}
