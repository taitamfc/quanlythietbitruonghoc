<?php

namespace Modules\Borrow\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBorrowRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'borrow_date' => 'required',
            'devices.*.lesson_name' => 'required',
            'devices.*.lecture_name' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'borrow_date.required' => 'Trường yêu cầu',
            'devices.*.lesson_name.required' => 'Trường yêu cầu',
            'devices.*.lecture_name.required' => 'Trường yêu cầu',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'success' => false,
            'has_errors' => true,
        ], 200));
    }
}
