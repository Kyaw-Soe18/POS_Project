<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    // direct change password
    public function changePasswordPage(){
        return view('user.changePassword');
    }

    // change password
    public function changePassword(Request $request){
        $validator = $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        //to get old password from database
        $dbHashPassword = User::select('password')->where('id',Auth::user()->id)->first(); // hash
        $dbHashPassword = $dbHashPassword['password'];

        $userOldPassword = $request->oldPassword; // plain text

        if(Hash::check($userOldPassword, $dbHashPassword)){ //[plain text , hash value]
            $data = [
                'password' => Hash::make($request->newPassword)
            ];

            User::where('id', Auth::user()->id)->update($data);
            Alert::success('Update Success', 'Password Change successfully...');

            return back();
        }

        Alert::error('Error Message', 'Old Password do not match! Try Again...');
        return back();
    }

}
