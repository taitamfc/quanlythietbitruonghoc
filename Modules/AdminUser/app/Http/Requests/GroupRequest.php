<?php

namespace Modules\AdminUser\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required', // Quy tắc: bắt buộc phải có giá trị
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên không được để trống.', // Thông báo lỗi khi trường name không có giá trị
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
