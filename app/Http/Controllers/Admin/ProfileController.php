<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    // profile details
    public function profileDetails(){
        return view('admin.profile.details');
    }

    // create admin account
    public function createAdminAccount(){
        return view('admin.profile.createAdminAccount');
    }

    // create new admin account
    public function create(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ]);

        $adminAccount = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'provider' => 'simple'
            
        ];

        User::create($adminAccount);

        Alert::success('Update Success', 'New admin created successfully...');

        return back();
    }
        

    // updata profile
    public function update(Request $request){
        $this->validationCheck($request) ; 
        $adminData = $this->requestAdminData($request);

        if($request->hasFile('image')){
            $oldImageName = $request->oldImage;
            //delete old image
            if($request->oldImage != null){
                if(file_exists(public_path('adminProfile/'.$oldImageName))){
                unlink(public_path('adminProfile/'.$oldImageName));
                }
            }

            //update new image
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/adminProfile/' , $fileName);
            $adminData['image'] = $fileName ;
        }else{
            $adminData['image'] = $request->oldImage;
        }

        User::where('id', Auth::user()->id)->update($adminData);

        Alert::success('Update Success', 'Profile has been updated successfully...');

        return back();
    }

    // direct account profile
    public function accountProfile($id){
        $account = User::where('id',$id)->first();
        return view('admin.profile.accountProfile', compact('account'));
    }

    // request admin data
    private function requestAdminData($request){
        $data=[

        ];

        if(Auth::user()->name != null){
            $data['name'] = Auth::user()->provider == 'simple' ? $request->name : Auth::user()->name;
        }else{
            $data['nickname'] = Auth::user()->provider == 'simple' ? $request->name : Auth::user()->name;
        }

        $data['email'] = Auth::user()->provider == 'simple' ? $request->email : Auth::user()->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;

        return $data;
    }

    //create | update validaion check
    private function validationCheck($request){

        $rules = [ 
            'phone' => 'required|unique:users,phone,'.Auth::user()->id,
            'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg|file',
        ];

        if(Auth::user()->provider == 'simple'){
            $rules['name'] = 'required';
            $rules['email'] = 'required|unique:users,email,'.Auth::user()->id;
        }

        $message = [] ;
        
        $validator = $request->validate($rules , $message);
    }
}
