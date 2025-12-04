<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class RoleChangeController extends Controller
{
    // direct admin list page
    public function adminList(){
        $data = User::select('id', 'name', 'nickname', 'email', 'phone', 'address')
                    ->orWhere('role','admin')
                    ->orWhere('role','superadmin')
                    ->paginate(3);

        $userCount = User::where('role', 'user')->count();

        return view('admin.roleChange.adminList', compact('data', 'userCount'));
    }

    // delete admin account
    public function deleteAdminAccount($id){
        User::where('id',$id)->delete();

        Alert::success('Delete Success', 'Admin account deleted successfully...');
        return back();
    }

    // change admin account to user account
    public function changeUserRole($id){
        User::where('id',$id)->update(['role'=>'user']);

        Alert::success('Change User Role Success', 'Role changed successfully...');
        return back();
    }

    // direct user list page
    public function userList(){
        $data = User::select('id', 'name', 'nickname', 'email', 'phone', 'address')
                    ->where('role','user')
                    ->paginate(3);

        $adminCount = User::orWhere('role','admin')
                            ->orWhere('role','superadmin')
                            ->count();

        return view('admin.roleChange.userList', compact('data', 'adminCount'));

    }

    // delete admin account
    public function deleteUserAccount($id){
        User::where('id',$id)->delete();

        Alert::success('Delete Success', 'User account deleted successfully...');
        return back();
    }

    // change user account to admin account
    public function changeAdminRole($id){
        User::where('id',$id)->update(['role'=>'admin']);

        Alert::success('Change Admin Role Success', 'Role changed successfully...');
        return back();
    }
}