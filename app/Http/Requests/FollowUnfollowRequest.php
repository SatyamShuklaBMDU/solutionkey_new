<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FollowUnfollowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd('1');
        return [
            'vendor_id'=>[
                'required',
                'exists:vendors,id',
                function($attribute, $value, $fail) {
                    if($value === Auth::id()) {
                        $fail("You cannot follow yourself, buddy.");
                    }
                }    
            ],
        ];
    }
}
