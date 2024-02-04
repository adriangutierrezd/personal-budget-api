<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Policies\V1\RecurringPolicy;

class UpdateRecurringRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $recurring = $this->route('recurring');
        return $this->user() != null && $this->user()->can('update', [$recurring, RecurringPolicy::class]);
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
            'categoryId' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:100'],
            'description' => ['sometimes'],
            'amount' => ['required', 'numeric']
            ];
        }else{
            return [
                'categoryId' => ['sometimes', 'required', 'exists:categories,id'],
                'name' => ['sometimes', 'required', 'max:100'],
                'description' => ['sometimes'],
                'amount' => ['sometimes', 'required', 'numeric']
            ];
        }
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
