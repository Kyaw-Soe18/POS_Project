<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //product list page
    public function list(){
        // dd(request('searchKey'));
        $products = Product::when(request('searchKey'),function($query){
                        $query->whereAny(['name' ,'price' , 'count'] , 'like' , '%'.request('searchKey').'%');
                    })
                    ->paginate(3);
        return view('admin.product.list' , compact('products'));
    }

    //product create page
    public function create(){
        //to get category data when load this page
        $categories = Category::get();
        return view('admin.product.create' , compact('categories'));
    }

    //product create
    public function productCreate(Request $request){
        //dd($request->all());

        $this->validationCheck($request , "create");

        $data = $this->requestProductData($request);

        if($request->hasFile('image')){
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/productImages/' , $fileName);
            $data['image'] = $fileName ;
        }

        Product::create($data);
        Alert::success('Insert Success', 'Category has been inserted successfully...');
        return to_route('productList');
    }

    //product delete
    public function delete($id){
        Product::where('id',$id)->delete();
        Alert::success('Delete Success', 'Product has been deleted successfully...');
        return back();
    }

    //product details
    public function details($id){
        $data = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.image' ,'products.count' ,'categories.name as category_name' )
                        ->leftJoin('categories', 'products.category_id' , 'categories.id') //table names from db
                        ->where('products.id',$id)
                        ->first();
        //dd($data->toArray());
        return view('admin.product.details' , compact('data'));

    }

    //product edit
    public function edit($id){
        $products = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.image' ,'products.count' ,'categories.name as category_name' )
        ->leftJoin('categories', 'products.category_id' , 'categories.id') //table names from db
        ->where('products.id',$id)
        ->first();
        //dd($data->toArray());
       
        $categories = Category::get();
        return view('admin.product.edit' , compact('products','categories'));
    }

    //product update
    public function update(Request $request){
        //dd($request->all());
        $this->validationCheck($request , "update"); 

        $data = $this->requestProductData($request);

        if($request->hasFile('image')){
            //delete old image and upload new image
            $oldImageName = $request->oldImage;

            //delete old image
            if(file_exists(public_path('productImages/'.$oldImageName))){
                unlink(public_path('productImages/'.$oldImageName));
            }

            //update new image
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/productImages/' , $fileName);
            $data['image'] = $fileName ;
        }else{
            $data['image'] = $request->oldImage;
        }

        Product::where('id',$request->productId)->update($data);
        Alert::success('Update Success', 'Product has been updated successfully...');
        return to_route('productList');
    }

    //create | update validaion check
    private function validationCheck($request , $action){
        $rules = [ 
            'name' => 'required|unique:products,name,'.$request->productId ,
            'price' => 'required' ,
            'categoryName' => 'required' ,
            'count' => 'required|numeric' ,
            'description' => 'required' ,
        ];

        $rules['image'] = $action=="create" ? "required|mimes:png,jpg,jpeg|file" : "mimes:png,jpg,jpeg|file" ; 

        $message = [
            'name.required' => 'Name is required*' ,
            'price.required' => 'Price is required*' ,
            'categoryName.required' => 'Category name is required*' ,
            'count.required' => 'Count is required*' ,
            'description.required' => 'Description is required*' ,
            'image.required' => 'Image is required*' ,
         ] ;
        $validator = $request->validate($rules , $message);
    }

    //request product data
    private function requestProductData($request){
        return [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->categoryName,
            'count' => $request->count,
        ];
    }
}