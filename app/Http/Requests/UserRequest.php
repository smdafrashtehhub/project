<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_name'=>'required|string|max:255',
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'age'=>['required',function($attr,$value,$fail){
            if($value<18)
            $fail($attr.' must be bigger than 18 yo');
            }],
            'gender'=>'required',
            'email'=>'required|email|unique:users',
            'phone_number'=>'required',
            'address'=>'required|string',
            'postal_code'=>'required',
            'country'=>'required',
            'province'=>'required',
            'city'=>'required',
            'password'=>'required',
            'image'=>'required'
        ];
    }
}
