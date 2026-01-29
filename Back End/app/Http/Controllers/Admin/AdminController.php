<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Array_;

class AdminController extends Controller
{
    public function loginAdmin(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/home');
        }
        return redirect()->back()->with('error', 'Email or password is incorrect');
    }


    public function loginView()
    {
        return view('adminPanel.login');
    }

    public function logOut()
    {
        Auth::guard('admin')->logout();
        return redirect()->intended('/');
    }
    // public function adminDelete(Request $request){
    //     Admin::where('id',$request->id)->delete();
    //     return redirect()->back()->with('success', 'Successfully admin deleted');

    // }
    public function adminDelete($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found.');
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Successfully admin deleted');
    }


    public function adminRole()
    {
        $common_data = new Array_();
        $common_data->title = 'Role Create';
        return view('adminPanel.role.create_role')->with(compact('common_data'));
    }

    public function adminStore(Request $request)
    {
        $info = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin_type' => $request->role_id,
        ]);
        if ($info) {
            return redirect()->back()->with('success', 'Successfully Created User');
        } else {
            return redirect()->back()->with('error', 'Internal Error');
        }
    }

    public function adminCreate()
    {
        $common_data = new Array_();
        $common_data->title = 'User Create';
        $role = Role::where('status', 1)->get();
        $admin = Admin::get();
        return view('adminPanel.role.create_admin')->with(compact('common_data', 'role', 'admin'));
    }

    public function adminRoleStore(Request $request)
    {
        $role = new Role();
        $role->name = $request->role_name;
        $role->access_role_list = implode(",", $request->role_id);
        $role->save();
        return redirect()->back()->with('success', 'Successfully Created Role');
    }
    public function myProfile()
    {
        $admin = Auth::guard('admin')->user();
        return view('adminPanel.myProfile', compact('admin'));
    }

    // Update profile (name, email, phone, photo)
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->gender = $request->gender;
        $admin->address = $request->address;
        $admin->city = $request->city;
        $admin->state = $request->state;
        $admin->pincode = $request->pincode;

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($admin->profile_photo && file_exists(public_path('uploads/admin/' . $admin->profile_photo))) {
                unlink(public_path('uploads/admin/' . $admin->profile_photo));
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/admin'), $photoName);
            $admin->profile_photo = $photoName;
        }

        $admin->save();

        return redirect('home')->with('success', 'Profile updated successfully!');
    }


    // Show change password page
    // public function changePasswordPage()
    // {
    //     return view('adminPanel.changePassword');
    // }

    public function changePasswordPage()
    {
        $admin = Auth::guard('admin')->user();
        return view('adminPanel.changePassword', compact('admin'));
    }

    // Change password handler
    // public function changePassword(Request $request)
    // {
    //     $request->validate([
    //         'old_password' => ['required'],
    //         'new_password' => ['required', 'min:6', 'confirmed'],
    //     ]);

    //     $admin = Auth::guard('admin')->user();

    //     if (!Hash::check($request->input('old_password'), $admin->password)) {
    //         return back()->with('error', 'Old password is incorrect.');
    //     }

    //     $admin->password = Hash::make($request->input('new_password'));
    //     $admin->save();

    //     return back()->with('success', 'Password changed successfully.');
    // }

    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->old_password, $admin->password)) {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect('home')->with('success', 'Password updated successfully.');
    }
}
