<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerDocument;
use App\Models\CustomerFamily;
use App\Models\Vendor;
use App\Models\VendorWishlist;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

// use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'pin_no' => 'required|string|min:4',
                'phone_number' => 'required|string|unique:customers,phone_number',
                'gender' => 'nullable|in:male,female,other',
                'email' => 'nullable|email|unique:customers,email',
                'marital_status' => 'nullable|string',
                'dob' => 'nullable|date',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'address' => 'nullable|string',
                'profile_pic' => 'nullable|image|max:2048',
                // 'password' => 'required|string|min:6',

            ]);
            if ($request->has('dob') && $request->filled('dob')) {
                $validatedData['dob'] = Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d');
            } else {
                $validatedData['dob'] = null; // Set dob to null if not provided
            }
            $validatedData['password'] = Hash::make('12345678');
            if ($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('profile_pics'), $fileName);
                $validatedData['profile_pic'] = 'profile_pics/' . $fileName;
            }
            $randomDigits = mt_rand(10000, 99999);
            $referralCode = 'SOLU' . $randomDigits;
            $CustomerId = 'CUST' . $randomDigits;
            $validatedData['refer_code'] = $referralCode;
            $validatedData['customers_id'] = $CustomerId;
            $customer = Customer::create($validatedData);
            if ($request->has('from_referral_number') && !empty($request->from_referral_number)) {
                if ($this->isValidReferralNumber($request->from_referral_number)) {
                    $referralController = new ReferralController();
                    $referralUser = Customer::where('refer_code', $request->from_referral_number)->first();
                    // dd($referralUser);
                    $referralController->store($referralUser->id, $customer->id);
                } else {
                    return response()->json(['message' => 'Invalid referral number.', 'success' => false], 200);
                }
            }
            return response()->json(['message' => 'Customer registered successfully', 'data' => $customer], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], Response::HTTP_BAD_REQUEST);
        } catch (QueryException $e) {
            // return response()->json(['error' => 'Failed to register customer.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function customerDetails(Request $request)
    {
        $user = $request->user();
        if ($user) {
            return response()->json(['success' => true, 'user' => $user], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }
    }

    public function update(Request $request)
    {
        try {
            $login = Auth::user();
            $customer = Customer::findOrFail($login->id);
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string',
                'gender' => 'nullable|in:male,female,other',
                'phone_number' => 'nullable|string',
                'email' => 'nullable|email|unique:customers,email,' . $customer->id,
                'marital_status' => 'nullable|string',
                'dob' => 'nullable|date_format:d-m-Y',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'address' => 'nullable|string',
                'profile_pic' => 'nullable|image|max:2048',
                'password' => 'nullable|string|min:6',
                'pin_no' => 'nullable|string|min:4',
                'designation' => 'nullable|string',
                'company_name' => 'nullable|string',
                'pincode' => 'nullable|string',
            ]);
    
            if ($validator->fails()) {
                $response = ['status' => false];
                foreach ($validator->errors()->toArray() as $field => $messages) {
                    $response[$field] = $messages[0];
                }
                return response()->json($response, Response::HTTP_BAD_REQUEST);
            }
    
            $validatedData = $validator->validated();
    
            if ($request->has('dob') && $request->filled('dob')) {
                $validatedData['dob'] = Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d');
            }
    
            if ($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
                $photoFileName = uniqid() . '.' . $request->profile_pic->extension();
                $photoPath = $request->file('profile_pic')->move(public_path('user/profile_pic'), $photoFileName);
                $photoRelativePath = 'user/profile_pic/' . $photoFileName;
                $validatedData['profile_pic'] = $photoRelativePath;
            }
    
            if (isset($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }
            foreach ($validatedData as $key => $value) {
                if ($request->has($key)) {
                    $customer->$key = $value;
                }
            }
            $customer->save();
            return response()->json(['status' => true, 'message' => 'Customer details updated successfully', 'data' => $customer]);
    
        } catch (ValidationException $e) {
            return response()->json(['status' => false, 'error' => $e->validator->errors()], Response::HTTP_BAD_REQUEST);
        } catch (QueryException $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'phone_number' => 'required|numeric',
                'pin_no' => 'required|digits:4',
            ]);
            $customer = Customer::where('phone_number', $request->phone_number)->first();
            if ($customer && $this->validatePin($request->pin_no, $customer->pin_no)) {
                $token = $customer->createToken('CustomerToken')->plainTextToken;
                return response()->json(['message' => 'Login Successfully', 'token' => $token, 'id' => $customer->id], 200);
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

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $request->user()->tokens()->delete();
            return response()->json([
                'message' => 'Logout successful',
                'status' => 'success',
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not authenticated',
                'status' => 'error',
            ], 401);
        }
    }

    public function document(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'documents_images.*' => 'required|file',
                'document_description' => 'required',
                // 'customer_id' => 'required|exists:customers,id',
            ]);
            if ($validator->fails()) {
                $response = ['status' => false];
                foreach ($validator->errors()->toArray() as $field => $messages) {
                    $response[$field] = $messages[0];
                }
                return response()->json($response, Response::HTTP_BAD_REQUEST);
            }
            $description = $request->document_description;
            $documents = [];
            foreach ($request->file('documents_images') as $file) {
                if ($file->isValid()) {
                    $fileName = $file->getClientOriginalName();
                    $file->move(public_path('customer_doc'), $fileName);
                    $document = new CustomerDocument();
                    $document->documents_images = 'customer_doc/' . $fileName;
                    $document->document_description = $description;
                    // $document->customer_id = $request->customer_id;
                    $document->customer_id = Auth::id();
                    $document->save();
                    $documents[] = $document;
                }
            }
            return response()->json(['message' => 'Documents Uploaded successfully', 'data' => $documents]);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function AddFamily(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'gender' => 'nullable|in:male,female,other',
                'dob' => 'nullable|date',
                'phone_number' => 'nullable|string|max:20',
                'email' => 'required|string|email|max:255|unique:customer_families',
                'address' => 'nullable|string',
                'marital_status' => 'nullable|string',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'password' => 'nullable|string|min:8',
            ]);
            if ($validator->fails()) {
                $response = ['status' => false];
                foreach ($validator->errors()->toArray() as $field => $messages) {
                    $response[$field] = $messages[0];
                }
                return response()->json($response, Response::HTTP_BAD_REQUEST);
            }
            $request->merge(['dob' => Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d')]);
            $customerId = Auth::id();
            $user = CustomerFamily::create([
                'customer_id' => $customerId,
                // 'customer_id' => $request->customer_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'address' => $request->address,
                'marital_status' => $request->marital_status,
                'city' => $request->city,
                'state' => $request->state,
                'password' => Hash::make('12345678'),
            ]);
            return response()->json(['message' => 'Added successfully', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed. Please try again later.'], 500);
        }
    }
    public function addToWishlist(Request $request)
    {
        try {
            $request->validate([
                'vendor_id' => 'required|exists:vendors,id',
            ]);
            $customerId = Auth::id();
            $wishlistItem = VendorWishlist::create([
                'customer_id' => $customerId,
                'vendor_id' => $request->vendor_id,
            ]);
            return response()->json(['message' => 'Vendor added to wishlist successfully', 'wishlistItem' => $wishlistItem], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add vendor to wishlist'], 500);
        }
    }
    private function isValidReferralNumber($referralNumber)
    {
        $referralUser = Customer::where('refer_code', $referralNumber)->first();

        if ($referralUser) {
            return true;
        } else {
            return false;
        }
    }
    public function allvendors(Request $request)
    {
        $vendors = Vendor::all();
        $profile = "https://qbacp.com/solutionkey/public";
        $vendorsArray = $vendors->map(function ($vendor) use ($profile) {
            return [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'profession' => $vendor->profession,
                'area_of_interest' => $vendor->area_of_interest,
                'experience' => $vendor->experience,
                'current_job' => $vendor->current_job,
                'charge_per_minute_for_audio_call' => $vendor->charge_per_minute_for_audio_call,
                'charge_per_minute_for_video_call' => $vendor->charge_per_minute_for_video_call,
                'charge_per_minute_for_chat' => $vendor->charge_per_minute_for_chat,
                'city' => $vendor->city,
                'state' => $vendor->state,
                'address' => $vendor->address,
                'profile_picture' => $profile . '/' . $vendor->profile_picture,
                'cover_picture' => $profile . '/' . $vendor->cover_picture,
            ];
        })->toArray();
        return response()->json(['status' => 'Success', 'vendors' => $vendorsArray, 'message' => 'Data Successfully'], 200);
    }

    public function getVendorById(Request $request)
    {
        try {
            $vendor = Vendor::with('posts')->find($request->id);
            if (!$vendor) {
                return response()->json(['error' => 'Vendor not found'], 404);
            }
            $profileUrl = "https://qbacp.com/solutionkey/public";
            $posturl = "https://qbacp.com/solutionkey/public/images/posts/";
            $vendorArray = [
                'id' => $vendor->id,
                'vendor_id' => $vendor->vendor_id,
                'name' => $vendor->name,
                'highest_qualification' => $vendor->highest_qualification,
                'profession' => $vendor->profession,
                'area_of_interest' => $vendor->area_of_interest,
                'phone_number' => $vendor->phone_number,
                'gender' => $vendor->gender,
                'email' => $vendor->email,
                'experience' => $vendor->experience,
                'current_job' => $vendor->current_job,
                'charge_per_minute_for_audio_call' => $vendor->charge_per_minute_for_audio_call,
                'charge_per_minute_for_video_call' => $vendor->charge_per_minute_for_video_call,
                'charge_per_minute_for_chat' => $vendor->charge_per_minute_for_chat,
                'adhar_number' => $vendor->adhar_number,
                'pancard' => $vendor->pancard,
                'about' => $vendor->about,
                'city' => $vendor->city,
                'state' => $vendor->state,
                'address' => $vendor->address,
                'profile_picture' => $profileUrl . '/' . $vendor->profile_picture,
                'cover_picture' => $profileUrl . '/' . $vendor->cover_picture,
                'account_status' => $vendor->account_status,
                'created_at' => $vendor->created_at,
                'updated_at' => $vendor->updated_at,
                'posts' => $vendor->posts->map(function ($post) use ($posturl) {
                    return [
                        'id' => $post->id,
                        'post_image' => $posturl . $post->post_image,
                        'content' => $post->content,
                        'created_at' => $post->created_at,
                        'updated_at' => $post->updated_at,
                    ];
                })->toArray(),
            ];
            return response()->json(['status' => 'Success', 'message' => 'Data Successfully', 'vendor' => $vendorArray], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
