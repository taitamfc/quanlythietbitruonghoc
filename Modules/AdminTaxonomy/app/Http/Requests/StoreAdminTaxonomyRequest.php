<?php

namespace Modules\AdminTaxonomy\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminTaxonomyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $tableName = 'taxonomies';
        $modelName = $this->type ? $this->type : '';
        if($modelName){
            $modelClass = '\App\Models\\' . $modelName;
            $tableName = with(new $modelClass)->getTable();
        }
        $rules = [
            'name' => 'required|unique:'.$tableName.',name',
        ];
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = 'required';
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
