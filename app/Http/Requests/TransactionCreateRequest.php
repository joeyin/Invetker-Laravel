<?php

namespace App\Http\Requests;

use App\Enums\Action;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TransactionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ticker' => ['required', 'string'],
            'datetime' => ['required', 'date'],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'action' => ['required', new Enum(Action::class)],
            'price' => ['required', 'numeric', 'gt:0'],
            'fee' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
