<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Models\UserShippingBillingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;

class AuthController extends Controller
{
    /**
     * Handle user login
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 422,
                'msg' => 'Provided email or password is incorrect'
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'msg' => 'Login successful',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    /**
     * Handle user registration
     */
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();

        // Check for duplicate email
        if (User::where('email', $data['email'])->exists()) {
            return response()->json([
                'status' => 422,
                'msg' => 'This email already exists'
            ], 422);
        }

        /** @var User $user */
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Auto-login after registration
        Auth::login($user);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 201,
            'msg' => 'Registration successful',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'Logged out successfully'
        ], 200);
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'currentPass' => 'required|string',
            'newPass'     => 'required|string|min:6'
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->currentPass, $user->password)) {
            return response()->json([
                'status' => 400,
                'msg' => 'The current password is incorrect'
            ], 400);
        }

        // Update new password
        $user->update([
            'password' => Hash::make($request->newPass)
        ]);

        return response()->json([
            'status' => 200,
            'msg' => 'Password successfully changed'
        ], 200);
    }

    /**
     * Fetch logged-in user (optional)
     */
    public function user(Request $request)
    {
        return response()->json([
            'status' => 200,
            'user' => $request->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Upload profile photo
        if ($request->hasFile('photo')) {
            $imageName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('uploads/profile'), $imageName);

            // Save into DB column `photo`
            $user->photo = 'uploads/profile/' . $imageName;
        }

        // Update other details
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'status' => 200,
            'msg' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    // public function saveAddress(Request $request)
    // {
    //     $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name'  => 'required|string|max:255',
    //         'shipping_phone'      => 'required|string|max:20',
    //         'shipping_address'    => 'required|string',
    //         'shipping_city'       => 'required|string',
    //         'shipping_state'      => 'required|string',
    //         'shipping_country'    => 'required|string',
    //         'shipping_zip'        => 'required|string|max:10',
    //     ]);

    //     $user = Auth::user();

    //     $address = UserShippingBillingAddress::updateOrCreate(
    //         ['user_id' => $user->id],
    //         [
    //             'first_name'      => $request->first_name,
    //             'last_name'       => $request->last_name,
    //             'shipping_phone'  => $request->shipping_phone,
    //             'shipping_address' => $request->shipping_address,
    //             'shipping_city'   => $request->shipping_city,
    //             'shipping_state'  => $request->shipping_state,
    //             'shipping_country' => $request->shipping_country,
    //             'shipping_zip'    => $request->shipping_zip,
    //         ]
    //     );

    //     return response()->json([
    //         'status' => 200,
    //         'msg'    => 'Address saved successfully',
    //         'data'   => $address
    //     ]);
    // }

    // public function getAddress(Request $request)
    // {
    //     $user = Auth::user();

    //     $address = UserShippingBillingAddress::where('user_id', $user->id)->first();

    //     return response()->json([
    //         'status' => 200,
    //         'data'   => $address
    //     ]);
    // }
    // Add new address
    public function saveAddress(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_country' => 'required|string',
            'shipping_zip' => 'required|string|max:10',
            'is_default' => 'sometimes|boolean',
            'shipping_division' => 'required|integer|exists:divisions,id',
            'shipping_district' => 'required|integer|exists:districts,id',
        ]);

        $user = Auth::user();

        if ($request->is_default) {
            UserShippingBillingAddress::where('user_id', $user->id)
                ->update(['is_default' => false]);
        }

        $address = UserShippingBillingAddress::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_country' => $request->shipping_country,
            'shipping_zip' => $request->shipping_zip,
            'is_default' => $request->is_default ?? false,

            'shipping_division' => $request->shipping_division,
            'shipping_district' => $request->shipping_district,
        ]);

        return response()->json([
            'status' => 200,
            'msg' => 'Address saved successfully',
            'data' => $address
        ]);
    }

    // Get all addresses
    public function getAddresses()
    {
        $user = Auth::user();

        $addresses = UserShippingBillingAddress::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $addresses
        ]);
    }

    // Update an address
    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_country' => 'required|string',
            'shipping_zip' => 'required|string|max:10',
            'is_default' => 'sometimes|boolean',
            'shipping_division' => 'required|integer|exists:divisions,id',
            'shipping_district' => 'required|integer|exists:districts,id',
        ]);

        $user = Auth::user();

        $address = UserShippingBillingAddress::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$address) {
            return response()->json(['status' => 404, 'msg' => 'Address not found']);
        }

        if ($request->is_default) {
            UserShippingBillingAddress::where('user_id', $user->id)
                ->update(['is_default' => false]);
        }

        $address->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_country' => $request->shipping_country,
            'shipping_zip' => $request->shipping_zip,
            'shipping_division' => $request->shipping_division,
            'shipping_district' => $request->shipping_district,
            'is_default' => $request->is_default ?? $address->is_default,
        ]);

        return response()->json([
            'status' => 200,
            'msg' => 'Address updated successfully',
            'data' => $address
        ]);
    }

    // Delete an address
    public function deleteAddress($id)
    {
        $user = Auth::user();

        $address = UserShippingBillingAddress::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$address) {
            return response()->json(['status' => 404, 'msg' => 'Address not found']);
        }

        $address->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'Address deleted successfully'
        ]);
    }

    // Set an address as default
    // public function setDefaultAddress($id)
    // {
    //     $user = Auth::user();

    //     $address = UserShippingBillingAddress::where('user_id', $user->id)
    //         ->where('id', $id)
    //         ->first();

    //     if (!$address) {
    //         return response()->json(['status' => 404, 'msg' => 'Address not found']);
    //     }

    //     UserShippingBillingAddress::where('user_id', $user->id)
    //         ->update(['is_default' => 0]);

    //     $address->update(['is_default' => 1]);

    //     return response()->json([
    //         'status' => 200,
    //         'msg' => 'Address set as default successfully',
    //         'data' => $address
    //     ]);
    // }


    public function setDefaultAddress($id)
    {
        $user = Auth::user();

        $address = UserShippingBillingAddress::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$address) {
            return response()->json(['status' => 404, 'msg' => 'Address not found']);
        }

        // Remove default from all user's addresses
        UserShippingBillingAddress::where('user_id', $user->id)
            ->update(['is_default' => 0]);

        // Set selected one as default
        $address->is_default = 1;
        $address->save();

        return response()->json([
            'status' => 200,
            'msg' => 'Default address updated successfully',
            'data' => $address
        ]);
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate OTP
        $otp = rand(100000, 999999);

        // Save OTP to user table (or a separate table) with expiry
        $user->otp = $otp;
        $user->otp_expiry = now()->addMinutes(10); // OTP valid for 10 minutes
        $user->save();

        // Send OTP email
        Mail::raw("Your OTP for password reset is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset OTP');
        });

        return response()->json([
            'status' => 200,
            'msg' => 'OTP sent to your email'
        ]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required|numeric'
        ]);

        $user = User::where('email', $request->email)->first();

        // OTP not found / expired / mismatched
        if (!$user->otp || $user->otp != $request->otp) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid OTP'
            ], 400);
        }

        if (now()->greaterThan($user->otp_expiry)) {
            return response()->json([
                'status' => 400,
                'msg' => 'OTP expired'
            ], 400);
        }

        return response()->json([
            'status' => 200,
            'msg' => 'OTP verified successfully'
        ]);
    }


    /**
     * Reset Password Using OTP
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'otp'      => 'required|numeric',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        // Validate OTP
        if (!$user->otp || $user->otp != $request->otp) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid OTP'
            ], 400);
        }

        // Check OTP expiry
        if (now()->greaterThan($user->otp_expiry)) {
            return response()->json([
                'status' => 400,
                'msg' => 'OTP expired'
            ], 400);
        }

        // Reset password
        $user->password = Hash::make($request->password);

        // Reset OTP fields
        $user->otp = null;
        $user->otp_expiry = null;

        $user->save();

        return response()->json([
            'status' => 200,
            'msg' => 'Password reset successfully'
        ]);
    }
}
