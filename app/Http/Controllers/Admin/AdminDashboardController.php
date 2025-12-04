<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    // direct admin dashboard page
    public function index(){
        $total_sale_amount = Order::sum('total_price');

        $userCount = User::where('role','user')->count();

        $adminCount = User::orWhere('role','admin')->orWhere('role','superadmin')->count();
        
        $orderPendingCount = Order::where('status',0)->groupBy('order_code')->get();

        $orderPendingCount = count($orderPendingCount);

        $orderSuccessCount = Order::where('status',1)->groupBy('order_code')->get();

        $orderSuccessCount = count($orderSuccessCount);

        $categoryCount = Category::count();

        $productCount = Product::count();

        $paymentType = Payment::count();
        
        return view('admin.home', compact('total_sale_amount', 'adminCount', 'userCount', 'orderPendingCount', 'orderSuccessCount', 'categoryCount', 'productCount', 'paymentType'));
    }
}
