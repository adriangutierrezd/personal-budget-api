<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Policies\V1\EquityStatementPolicy;

class UpdateEquityStatementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $expense = $this->route('equity_statement');
        return $this->user() != null && $this->user()->can('update', [$expense, EquityStatementPolicy::class]);
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
            'type' => ['required', 'in:ASSET,LIABILITY'],
            'description' => ['sometimes'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric']
            ];
        }else{
            return [
                'categoryId' => ['sometimes', 'required', 'exists:categories,id'],
                'name' => ['sometimes', 'required', 'max:100'],
                'type' => ['required', 'in:ASSET,LIABILITY'],
                'description' => ['sometimes'],
                'date' => ['sometimes', 'required', 'date'],
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
