<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
//            'user_name'=>'string|max:255',
            'first_name'=>'string|max:255',
//            'last_name'=>'string|max:255',
//            'age'=>[function($attr,$value,$fail){
//                if($value<18)
//                    $fail($attr.' must be bigger than 18 yo');
//            }],
//            'email'=>'email',
//            'address'=>'string',
        ];
    }
}
