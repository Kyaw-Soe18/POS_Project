<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class userProfileController extends Controller
{
    // profile details
    public function profileDetails(){
        return view('user.profile');
    }

    //user profile update
    public function update(Request $request){
        $this->validationCheck($request) ; 
        $userData = $this->requestUserData($request);
        // dd($userData);

        if($request->hasFile('image')){
            $oldImageName = $request->oldImage;
            //dd($oldImageName);

            //delete old image
            if($request->oldImage != null){
                if(file_exists(public_path('userProfile/'.$oldImageName))){
                    unlink(public_path('userProfile/'.$oldImageName));
                }
            }

            //update new image
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/userProfile/' , $fileName);
            $userData['image'] = $fileName ;
        }else{
            $userData['image'] = $request->oldImage;
        }

        User::where('id' , Auth::user()->id)->update($userData);
        Alert::success('Update Success', 'Profile has been updated successfully...');
        return back();
    }

    //request user data
    private function requestUserData($request){
        //dd(Auth::user()->name);
        $data = [];
        if(Auth::user()->name != null){
            $data['name'] = Auth::user()->provider == 'simple' ? $request->name : Auth::user()->name ; 
        }else{
            $data['nickname'] = Auth::user()->provider == 'simple' ? $request->name : Auth::user()->name  ; 
        }

        $data['email'] = Auth::user()->provider == 'simple' ? $request->email : Auth::user()->email ; 
        $data['phone'] = $request->phone ; 
        $data['address'] = $request->address ; 
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
