<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Auction;

class BidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) {
                    $auction = $this->route('auction');
                    if ($value <= $auction->current_price) {
                        $fail('El monto debe ser mayor al precio actual (€' . number_format($auction->current_price, 2) . ')');
                    }
                }
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'El monto de la puja es obligatorio',
            'amount.numeric' => 'El monto debe ser un número',
            'amount.min' => 'El monto mínimo es 0.01',
        ];
    }

    public function attributes(): array
    {
        return [
            'amount' => 'monto',
        ];
    }
}
