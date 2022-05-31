<?php

namespace App\Http\Requests;

use App\Enums\CurrencyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'target_id' => ['required', 'exists:users,id'],
            'currency_type' => ['required', new Enum(CurrencyType::class)],
            'amount' => ['required'],
        ];
    }
}
