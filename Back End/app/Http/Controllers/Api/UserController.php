<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserShippingBillingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // -------------------- API: Save or Update User Address --------------------
    public function userAddress(Request $request)
    {
        $userinfo = UserShippingBillingAddress::where('user_id', Auth::user()->id)->first();

        if ($userinfo) {
            $userinfo->update([
                'email' => $request->shipping_email,
                'first_name' => $request->shipping_first_name,
                'last_name' => $request->shipping_last_name,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_country' => $request->shipping_country,
                'shipping_zip' => $request->shipping_zip,
                'shipping_phone' => $request->shipping_phone,
                'shipping_state' => $request->shipping_state,
                'shipping_division' => $request->shipping_division,
                'shipping_district' => $request->shipping_district,
                'billing_address' => $request->billing_address,
                'billing_city' => $request->billing_city,
                'billing_country' => $request->billing_country,
                'billing_zip' => $request->billing_zip,
                'billing_state' => $request->billing_state,
                'billing_first_name' => $request->billing_first_name,
                'billing_last_name' => $request->billing_last_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_division' => $request->billing_division,
                'billing_district' => $request->billing_district,
            ]);

            return response()->json(['status' => 200, 'msg' => 'Address edited successfully']);
        } else {
            $useraddress = new UserShippingBillingAddress();
            $useraddress->fill($request->all());
            $useraddress->user_id = Auth::user()->id;
            $useraddress->save();

            return response()->json(['status' => 200, 'msg' => 'Address created successfully']);
        }
    }

    // -------------------- API: Get User Address --------------------
    public function userAddressGet()
    {
        $userinfo = UserShippingBillingAddress::where('user_id', Auth::user()->id)->first();
        return response()->json(['status' => 200, 'data' => $userinfo]);
    }

    // -------------------- API: Get All Users --------------------
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    // -------------------- ADMIN: Show Customer List --------------------
    public function adminUserList()
    {
        $users = User::all();
        return view('adminPanel.customers.customer_list', compact('users'));
    }

    // -------------------- ADMIN: View Single Customer --------------------
    public function view($id)
    {
        $user = User::findOrFail($id);
        return view('adminPanel.customers.customer_view', compact('user'));
    }

    // -------------------- ADMIN: Show Edit Customer Form --------------------
    // public function edit($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('adminPanel.customers.customer_edit', compact('user'));
    // }

    // -------------------- ADMIN: Update Customer --------------------
    // public function update(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->update($request->only(['name', 'email', 'phone', 'address', 'status']));

    //     return redirect()->route('admin.customer.list')
    //         ->with('success', 'Customer updated successfully!');
    // }

    // -------------------- ADMIN: Delete Customer --------------------
    public function destroy($id)
{
    $customer = User::findOrFail($id);
    $customer->delete();

    return redirect()->route('admin.customer.list')->with('success', 'Customer deleted successfully.');
}

    // -------------------- ADMIN: Store New Customer --------------------
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status ?? 'active',
            'password' => bcrypt('123456'), // default password
        ]);

        return redirect()->route('admin.customer.list')
            ->with('success', 'Customer created successfully!');
    }
}
