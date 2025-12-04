<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    // category list page
    public function list(){
        $data = Category::orderBy('created_at' , 'asc')->paginate(3);
        return view('admin.category.list' , compact('data'));
    }

    // category create page
    public function createpage(){
        return view('admin.category.create');
    }
    
    // create data
    public function create(Request $request){
        $validator = $request->validate([
            'category' => 'required|unique:categories,name', //not db field
        ],[
            'category.required' => 'Category field is required.',
            'category.unique' => 'This category has already been taken.Please Choose another one!!!',
        ]);

        Category::create([
            'name' => $request->category
        ]);

        Alert::success('Insert Success', 'Category Insert Successfully...');

        return back();
    }

    // delete category
    public function delete($id){
        Category::where('id', $id)->delete();

        Alert::success('Delete Success', 'Category Delete Successfully...');

        return back();
    }

    // delete category
    public function edit($id){
        $data = Category::where('id', $id)->first();

        return view('admin.category.edit', compact('data'));
    }

    // update category
    public function update(Request $request){
        $validator = $request->validate([
            'category' => 'required|unique:categories,name,'.$request->categoryId
        ]);

        Category::where('id', $request->categoryId)->update([
            'name' => $request->category
        ]);

        Alert::success('Update Success', 'Category Update Successfully...');

        return to_route('categoryList');
    }
}
