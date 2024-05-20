<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class VendorController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'highest_qualification' => 'nullable|string|max:255',
                'profession' => 'required|string|max:255',
                'area_of_interest' => 'nullable|string|max:255',
                'phone_number' => 'required|string|min:10|unique:vendors,phone_number',
                'email' => 'nullable|string|email|max:255',
                'experience' => 'nullable|string|max:255',
                'current_job' => 'nullable|string|max:255',
                'charge_per_minute_for_audio_call' => 'nullable|numeric',
                'charge_per_minute_for_video_call' => 'nullable|numeric',
                'charge_per_minute_for_chat' => 'nullable|numeric',
                'adhar_number' => 'nullable|string|max:255',
                'pancard' => 'nullable|string|max:255',
                'about' => 'nullable|string',
                'profile_picture' => 'nullable|image|max:2048',
                'cover_picture' => 'nullable|image|max:2048',
                'pin_no' => 'required|min:4|numeric',
                // 'password' => 'required|string|min:8',
            ]);
            $profilePicturePath = null;
            $coverPicturePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePicture = $request->file('profile_picture');
                $profilePicturePath = $profilePicture->getClientOriginalName();
                $profilePicture->move(public_path('vendor_profile_pic'), $profilePicturePath);
                $profilePicturePath = 'vendor_profile_pic' . '/' . $profilePicturePath;
            }
            if ($request->hasFile('cover_picture')) {
                $coverPicture = $request->file('cover_picture');
                $coverPicturePath = $coverPicture->getClientOriginalName();
                $coverPicture->move(public_path('vendor_cover_pic'), $coverPicturePath);
                $coverPicturePath = 'vendor_cover_pic' . '/' . $coverPicturePath;
            }
            $randomDigits = mt_rand(10000, 99999);
            $vendorid = 'VEND' . $randomDigits;
            $vendor = new Vendor();
            $vendor->fill($request->all());
            // $vendor->password = Hash::make($request->input('password'));
            $vendor->profile_picture = $profilePicturePath;
            $vendor->cover_picture = $coverPicturePath;
            $vendor->vendor_id = $vendorid;
            $vendor->account_status = '0';
            $vendor->save();
            return response()->json(['message' => 'Vendor registered successfully', 'data' => $vendor], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register vendor', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $login = Auth::user();
            // dd($login->id);
            $vendor = Vendor::findOrFail($login->id);
            $validatedData = $request->validate([
                'name' => 'string|max:255',
                'highest_qualification' => 'nullable|string|max:255',
                'gender' => 'nullable|in:male,female,other',
                'profession' => 'nullable|string|max:255',
                'area_of_interest' => 'nullable|string|max:255',
                'phone_number' => 'string|max:20',
                'email' => 'nullable|string|email|max:255',
                'experience' => 'nullable|string|max:255',
                'current_job' => 'nullable|string|max:255',
                'charge_per_minute_for_audio_call' => 'nullable|numeric',
                'charge_per_minute_for_video_call' => 'nullable|numeric',
                'charge_per_minute_for_chat' => 'nullable|numeric',
                'adhar_number' => 'nullable|string|max:12|min:12',
                'pancard' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:50',
                'state' => 'nullable|string|max:50',
                'address' => 'nullable|string|max:100',
                'about' => 'nullable|string',
                'status' => 'nullable|string|max:255',
                'profile_picture' => 'nullable|image|max:2048',
                'cover_picture' => 'nullable|image|max:2048',
                'pin_no' => 'nullable|string|min:4',
            ]);
            if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
                $photoFileName = uniqid() . '.' . $request->profile_picture->extension();
                $photoPath = $request->file('profile_picture')->move(public_path('vendor/profile_picture'), $photoFileName);
                $photoRelativePath = 'vendor/profile_picture/' . $photoFileName;
                $validatedData['profile_picture'] = $photoRelativePath;
            }
            if ($request->hasFile('cover_picture') && $request->file('cover_picture')->isValid()) {
                $photoFileName = uniqid() . '.' . $request->cover_picture->extension();
                $photoPath = $request->file('cover_picture')->move(public_path('vendor/cover_picture'), $photoFileName);
                $photoRelativePath = 'vendor/cover_picture/' . $photoFileName;
                $validatedData['cover_picture'] = $photoRelativePath;
            }
            $vendor->update($validatedData);
            return response()->json(['message' => 'Vendor details updated successfully', 'data' => $vendor], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Vendor not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update vendor details', 'error' => $e->getMessage()], 500);
        }
    }
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('phone_number', 'pin_no');
    //     // $request->validate([
    //     //         'phone_number' => 'required|numeric',
    //     //         'pin_no' => 'required|digits:4',
    //     //     ]);
    //     $vendor = Vendor::where('phone_number', $request->phone_number)->first();
    //     if ($vendor) {
    //         if ($vendor->account_status == '1') {
    //             if (Auth::guard('vendor')->attempt($credentials)) {
    //                 $vendor = Auth::guard('vendor')->user();
    //                 $token = $vendor->createToken('VendorAppToken')->plainTextToken;
    //                 return response()->json(['token' => $token , 'message' => 'Login Successfully.'], 200);
    //             } else {
    //                 return response()->json(['message' => 'Invalid credentials'], 401);
    //             }
    //         } else if ($vendor->account_status == '2') {
    //             return response()->json(['message' => 'Login failed'], 401);
    //         }else{
    //             return response()->json(['message' => 'Login failed'], 401);
    //         }
    //     }
    //     return response()->json(['message' => 'Invalid credentials'], 401);
    // }
    public function vendorDetails(Request $request)
    {
        $login = Auth::user();
        // dd($login);
        if($login){
            return response()->json(['Vendor'=>$login ,'message' => 'Vendors All Details'], 200);
        }
        else{
            return response()->json(['message' => 'Not Authenticated Vendor'],401);
        }
    }
    
    public function login(Request $request)
    {
        try {
            $request->validate([
                'phone_number' => 'required|numeric',
                'pin_no' => 'required|digits:4',
            ]);
            $vendor = Vendor::where('phone_number', $request->phone_number)->first();
            if ($vendor && $this->validatePin($request->pin_no, $vendor->pin_no)) {
                $token = $vendor->createToken('VendorAppToken')->plainTextToken;
                return response()->json(['message'=>'Login Successfully','token' => $token,'id' => $vendor->id], 200);
            } else {
                throw ValidationException::withMessages([
                    'phone_number' => ['The provided credentials are incorrect.'],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    
    private function validatePin($inputPin, $storedPin)
    {
        return $inputPin === $storedPin;
    }

    // public function logout(Request $request)
    // {
    //     if(Auth::user()){
    //         $request->user()->tokens()->delete();
    //         return response()->json(['message' => 'Logged out successfully'], 200);
    //     }
    // }
    
    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::user()) {
           
            $request->user()->tokens()->delete();
    
            // Return a response indicating successful logout
            return response()->json([
                'message' => 'Logout successful',
                'status' => 'success'
            ], 200);
        } else {
            // Return an error response if the user is not authenticated
            return response()->json([
                'message' => 'User not authenticated',
                'status' => 'error'
            ], 401);
        }
    }
    
    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|string|same:new_password',
            ]);
            $vendor = Auth::user();
            if (!Hash::check($request->current_password, $vendor->password)) {
                return response()->json(['message' => 'The provided current password is incorrect'], 422);
            }
            $vendor->password = Hash::make($request->new_password);
            $vendor->save();
            return response()->json(['message' => 'Password changed successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to change password', 'error' => $e->getMessage()], 500);
        }
    }

}
