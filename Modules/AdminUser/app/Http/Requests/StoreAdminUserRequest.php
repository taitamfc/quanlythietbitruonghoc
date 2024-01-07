<?php

namespace Modules\AdminUser\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required', 
            'email' => 'required', 
            'password' => 'required', 
            'address' => 'required', 
            'phone' => 'required', 
            'gender' => 'required', 
            'birthday' => 'required', 
            'group_id' => 'required', 
            'nest_id' => 'required', 
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Trường không được để trống.', 
            'email.required' => 'Trường không được để trống.', 
            'password.required' => 'Trường không được để trống.', 
            'address.required' => 'Trường không được để trống.', 
            'phone.required' => 'Trường không được để trống.', 
            'gender.required' => 'Trường không được để trống.', 
            'birthday.required' => 'Trường không được để trống.', 
            'group_id.required' => 'Trường không được để trống.', 
            'nest_id.required' => 'Trường không được để trống.', 
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
