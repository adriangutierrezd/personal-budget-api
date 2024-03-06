<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Policies\V1\RevenuePolicy;

class UpdateRevenueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $revenue = $this->route('revenue');
        return $this->user() != null && $this->user()->can('update', [$revenue, RevenuePolicy::class]);
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
            'description' => ['sometimes'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric']
            ];
        }else{
            return [
                'name' => ['sometimes', 'required', 'max:100'],
                'description' => ['sometimes'],
                'date' => ['sometimes', 'required', 'date'],
                'amount' => ['sometimes', 'required', 'numeric']
            ];
        }
    }
}
