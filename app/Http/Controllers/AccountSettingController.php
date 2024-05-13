<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class AccountSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($user)
    {
        $user = User::where('id', Auth::User()->id)->first();
        // dd($user);
        // echo "<pre>";
        //     print_r($user);
        // echo "</pre>";
        if ($user) {
            return view('account-setting.edit', compact('user'));
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $update = User::findOrFail($id);
        $update->first_name;
        $update->last_name;
        $update->password = Hash::make($request->password);
        $update->save();
        return redirect()->back()->with('success', 'Password updated successfully!');
        // $update->update($request->only('first_name', 'last_name','password'));
        // echo "<pre>";
        //     print_r($update);
        // echo "</pre>";
        // echo "Save";
    }

    // public function update(Request $request, $id)
    // {
    //     // dd($request);
    //     // echo "<pre>";
    //     //     print_r($id);
    //     // echo "</pre>";
    //     if ($request->get('profile')) {

    //         $this->validate($request, [
    //             'first_name' => 'required',
    //             'last_name' => 'required'
    //         ]);

    //         $update = User::findOrFail($id);
    //         $update->update($request->all());
    //         if (!is_null($request->file('image'))) {

    //             $imageName = $request->file('image')->getClientOriginalName();

    //             $request->file('image')->move(
    //                 base_path() . '/upload/users/',
    //                 $imageName
    //             );

    //             $update->image = $request->file('image')->getClientOriginalName();
    //             $update->save();
    //         }
    //         notify()->success('Account Settings update successfully', 'Success');
    //         Session::flash('flash_message', 'Profile Updated Successfully!');
    //         return redirect('home');
    //     }


    //     if ($request->get('pswdChng')) {
    //         $this->validate($request, [
    //             'new_password' => 'required|min:6',
    //             'confirm_password' => 'required|same:new_password|min:6|different:old_password'
    //         ]);
    //         $currentPassword = $request->get("old_password");
    //         $NewPassword = $request->get("new_password");
    //         $update = User::findOrFail($id);


    //         if (Hash::check($currentPassword, $update->password)) {
    //             $update->fill([
    //                 'password' => Hash::make($NewPassword)
    //             ])->save();

    //             Session::flash('flash_message', 'Password Changed successfully!');
    //             return redirect('home');
    //         } else {
    //             Session::flash('flash_message', 'Current Password is Incorrect!');
                
    //             // return ("save");
    //             return redirect('account-setting.edit' . $update->id . '/edit');
    //         }
    //     }
    // }
}
