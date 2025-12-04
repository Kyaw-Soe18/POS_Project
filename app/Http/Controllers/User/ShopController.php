<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaySlipHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ShopController extends Controller
{
    // direct product shop list
    public function shop($category_id = null){
        // dd($category_id);
        $products = Product::when(request('searchKey'),function($query){
                                $query->where('products.name','like','%'.request('searchKey').'%');
                            });

        if(request('minPrice') != null && request('maxPrice') != null){
            $products = $products->whereBetween('products.price',[request('minPrice'),request('maxPrice')]);
        }

        if(request('minPrice') != null && request('maxPrice') == null){
            $products = $products->where('products.price','>=',request('minPrice'));
        }

        if(request('minPrice') == null && request('maxPrice') != null){
            $products = $products->where('products.price','<=',request('maxPrice'));
        }

        $products = $products->select('products.*', 'categories.name as category_name')
                            ->leftJoin('categories', 'products.category_id', 'categories.id');
        
        if($category_id == null){
            $products = $products->paginate();
        }else{
            $products = $products->where('products.category_id', $category_id)->paginate(9);
        }

        $categories = Category::get();

        return view('user.shop', compact('products', 'categories'));
    }
    
    // direct product details
    public function details($id){
        $product = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.image' ,'products.count' ,'categories.name as category_name' )
                        ->leftJoin('categories', 'products.category_id' , 'categories.id') //table names from db
                        ->where('products.id',$id)
                        ->first();

        $comment = Comment::select('comments.*','users.name as user_name', 'users.image as user_profile')
                            ->leftJoin('users','comments.user_id','users.id')
                            ->where('comments.product_id',$id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $productRating = Rating::where('product_id',$id)->avg('count');

        $ratingCount = Rating::where('product_id',$id)->get();

        $userRating = Rating::select('count')->where('product_id', $id)->where('user_id', Auth::user()->id)->first();

        $userRating = $userRating == null ? 0 : $userRating['count'];

        $productList = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.image' ,'products.count' ,'categories.name as category_name' )
                        ->leftJoin('categories', 'products.category_id' , 'categories.id') //table names from db
                        ->get();

        return view('user.details', compact('product', 'comment', 'productRating', 'ratingCount', 'userRating', 'productList'));
    } 

    // comment
    public function comment(Request $request){
        $request->validate([
            'message' => 'required',
        ]);

        $data = [
            'product_id' => $request->productId,
            'user_id' => $request->userId,
            'message' => $request->message,
        ];

        Comment::create($data);

        return back();
    }

    // add rating
    public function addRating(Request $request){
        $ratingCheckData = Rating::where('product_id', $request->productId)->where('user_id', $request->userId)->first();

        
        if($ratingCheckData == null){
            Rating::create([
            'product_id' => $request->productId,
            'user_id' => $request->userId,
            'count' => $request->productRating,
        ]);
        }else {
            Rating::where('product_id', $request->productId)->where('user_id', $request->userId)->update([
                'count' => $request->productRating
            ]);
        }

        return back();
    }
    
    // direct cart page
    public function cart(){
        $id = Auth::user()->id;

        $cart = Cart::select('carts.*', 'products.name', 'products.price', 'products.image')
                    ->leftJoin('products', 'carts.product_id', 'products.id')
                    ->where('user_id', $id)
                    ->get();

        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item->price * $item->qty;
        }
        // dd($totalPrice);

        $payment = Payment::get();

        return view('user.cart', compact('cart', 'totalPrice', 'payment'));
    }

    // add to cart process
    public function addToCart(Request $request){
        $productId = $request->productId;
        $qty = $request->qty;
        $userId = Auth::user()->id;

        Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'qty' => $qty
        ]);

        return to_route('shopList');
    }

    // remove cart by cart_id
    public function removeCart(Request $request){
        // logger($request->cartId);

        Cart::where('id', $request->cartId)->delete();

        $data = Cart::where("user_id", Auth::user()->id)->get();

        $serverResponse = [
            'message' => 'success'
        ];

        return response()->json($serverResponse, 200);
    }

    public function order(Request $request){
        $orderArr = [];
        
        foreach($request->all() as $item){
            array_push($orderArr,[
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'status' => 0,
                'order_code' => $item['order_code'],
                'count' => $item['qty'],
                'total_price' => $item['total_price']
            ]);
            
            // Order::create([
            //     'user_id' => $item['user_id'],
            //     'product_id' => $item['product_id'],
            //     'status' => 0,
            //     'order_code' => $item['order_code'],
            //     'count' => $item['qty'],
            //     'total_price' => $item['total_price']
            // ]);

            // Cart::where('user_id', $item['user_id'])->where('product_id', $item['product_id'])->delete();
        }
        
        Session::put('orderList',$orderArr); // create

        return response()->json([
            "message" => "success",
            "status" => 200
        ]);
    }

    // direct orderList page
    public function orderList(){
        $order = Order::where('user_id',Auth::user()->id)
                      ->groupBy('order_code')
                      ->orderBy('created_at','desc')
                      ->get();

        return view('user.orderList', compact('order'));
    }

    // direct payment page
    public function payment(){
        // dd(Session::get('orderList'));
        $orderProduct = Session::get('orderList');
        $payment = Payment::orderBy('type','asc')->get();

        $total = 0;
        foreach ($orderProduct as $item) {
            $total += $item['total_price'];
        }
        
        return view('user.payment', compact('payment','orderProduct', 'total'));
    }

    // orderProduct
    public function orderProduct(Request $request){
        // cart => order
        // clean cart
        // user payslip data => payslip history

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'paymentMethod' => 'required',
            'payslipImage' => 'required',
        ]);

        $cartProduct = Session::get('orderList');

        foreach ($cartProduct as $item) {
            Order::create($item);
            Cart::where('user_id',$item['user_id'])->where('product_id',$item['product_id'])->delete();
        }

        // dd($request->all());

        $data = [
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'payment_method' => $request->paymentMethod,
            'order_code' => $request->orderCode,
            'order_amount' => $request->totalAmount,
        ];

        if($request->hasFile('payslipImage')){
            $fileName = uniqid().$request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move(public_path().'/payslipRecords/' , $fileName);
            $data['payslip_image'] = $fileName ;
        }

        PaySlipHistory::create($data);

        return to_route('orderList');
    }

    //direct user order details page
    public function orderDetails($userOrderCode){
        $order = Order::select('users.name as customer_name','orders.created_at','orders.order_code','products.image as product_image','products.name as product_name','products.price as product_price','orders.count as order_count')
                ->leftJoin('products','orders.product_id','products.id')
                ->leftJoin('users','orders.user_id','users.id')
                ->where('orders.order_code',$userOrderCode)
                ->get();
        // dd($order->toArray());

        $total = 0;
        foreach ($order as $item) {
           $total += $item->order_count * $item->product_price;
        }
        return view('user.orderDetails',compact('order','total'));
    }
    
}
