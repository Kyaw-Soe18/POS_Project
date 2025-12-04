<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaySlipHistory;
use App\Http\Controllers\Controller;

class OrderBoardController extends Controller
{
    // order list page
    public function userOrderList(){
        $order = Order::select('orders.id as order_id', 'users.id as user_id', 'orders.created_at', 'orders.total_price', 'orders.status', 'orders.order_code', 'users.name as user_name', 'products.name as product_name')
                      ->leftJoin('products','orders.product_id','products.id')
                      ->leftJoin('users','orders.user_id','users.id')
                      ->groupBy('orders.order_code')
                      ->orderBy('orders.created_at','desc')
                      ->paginate(3);

        return view('admin.orderBoard.list', compact('order'));
    }

    // check details of order
    public function userOrderDetails($orderCode){
        $order = Order::select('users.name as customer_name', 'users.phone as user_phone', 'orders.order_code', 'orders.created_at', 'products.image as product_image', 'products.name as product_name', 'products.price as product_price', 'orders.count as order_count')
                      ->leftJoin('products','orders.product_id','products.id')
                      ->leftJoin('users','orders.user_id','users.id')
                      ->where('orders.order_code',$orderCode)
                      ->get();
        // dd($order->toArray());

        $payslipData = PaySlipHistory::select('pay_slip_histories.*', 'payments.type as payment_type')
                                     ->leftJoin('payments','pay_slip_histories.payment_method','payments.id')
                                     ->where('pay_slip_histories.order_code',$orderCode)
                                     ->first();
        // dd($payslipData->toArray());

        $total = 0;
        foreach ($order as $item) {
           $total += $item->order_count * $item->product_price;
        }

        return view('admin.orderBoard.details', compact('order', 'total', 'payslipData'));
    }

    // change orderCode status
    public function changeStatus(Request $request){
        Order::where('order_code',$request->orderCode)->update([
            'status' => $request->status
        ]);
    }
}
