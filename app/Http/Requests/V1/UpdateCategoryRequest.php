<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Policies\V1\CategoryPolicy;


class UpdateCategoryRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $category = $this->route('category');
        return $this->user() != null && $this->user()->can('update', [$category, CategoryPolicy::class]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $method = $this->method();
        if($method === 'PUT'){
            return [
                'name' => ['required', 'max:100'],
                'color' => ['required', 'max:7']
            ];
        }else{
            return [
                'name' => ['sometimes', 'required', 'max:100'],
                'color' => ['sometimes', 'required', 'max:7']
            ];
        }
    }

}
