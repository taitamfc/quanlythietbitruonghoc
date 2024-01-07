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
        $rules = [
            'name' => 'required', 
            'email' => 'required|unique:users', 
            'password' => 'required', 
            'group_id' => 'required', 
            'nest_id' => 'required', 
        ];
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['email'] = 'required';
            unset($rules['password']);
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => 'Trường yêu cầu',
            'unique' => 'Đã tồn tại',
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
