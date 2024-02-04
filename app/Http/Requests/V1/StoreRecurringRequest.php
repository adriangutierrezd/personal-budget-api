<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecurringRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categoryId' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:100'],
            'description' => ['sometimes'],
            'amount' => ['required', 'numeric']
        ];
    }

    protected function prepareForValidation()
    {
        if($this->categoryId){
            $this->merge([
                'category_id' => $this->categoryId
            ]);
        }
    }
    
}
