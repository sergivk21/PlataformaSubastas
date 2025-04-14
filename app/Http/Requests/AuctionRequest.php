<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuctionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'end_date' => 'required|date|after:now',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título es obligatorio',
            'title.max' => 'El título no puede tener más de 255 caracteres',
            'description.required' => 'La descripción es obligatoria',
            'starting_price.required' => 'El precio inicial es obligatorio',
            'starting_price.numeric' => 'El precio inicial debe ser un número',
            'starting_price.min' => 'El precio inicial debe ser mayor o igual a 0',
            'end_date.required' => 'La fecha de fin es obligatoria',
            'end_date.date' => 'La fecha de fin debe ser una fecha válida',
            'end_date.after' => 'La fecha de fin debe ser posterior a la fecha actual',
        ];
    }
}
