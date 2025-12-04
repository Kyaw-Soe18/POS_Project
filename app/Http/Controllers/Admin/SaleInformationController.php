<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleInformationController extends Controller
{
    // sale list
    public function list(){
        $order = Order::select('orders.id as order_id', 'orders.count as order_count', 'products.image as product_image', 'orders.created_at', 'orders.total_price', 'orders.status', 'orders.order_code', 'users.name as user_name', 'products.name as product_name')
                      ->leftJoin('products','orders.product_id','products.id')
                      ->leftJoin('users','orders.user_id','users.id')
                      ->where('orders.status',1)
                      ->groupBy('orders.order_code')
                      ->orderBy('orders.created_at','desc')
                      ->get();

        // dd($order->toArray());

        return view('admin.saleInformation.list', compact('order'));
    }
}
