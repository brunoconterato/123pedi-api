<?php

namespace Drinking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetailerStockItemRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'price'=>'required|numeric|min:0.01',
//            'min_selling_price'=>'numeric|min:0.01',
            'cost_price'=>'required|numeric|min:0.01',
            'quantity'=>'required|min:1',
            'expiration_date'=>'required|date|after:today'
        ];
    }

    public function messages()
    {
        return [
            'price.required' => 'Favor inserir um preço válido',
            'price.min' => 'Favor insira um preço positivo',

            'min_selling_price.min' => 'Favor insira um preço mínimo de venda positivo',

            'cost_price.required' => 'Favor inserir um preço de custo válido',
            'cost_price.min' => 'Favor insira um preço de custo positivo',

            'quantity.required'  => 'Favor inserir uma quantidade válida',
            'quantity.min' => 'Favor insira uma quantidade positiva',

            'expiration_date.required' => 'Favor inserir uma data de validade',
            'expiration_date.after' => 'Favor insira uma data depois de hoje'
        ];
    }
}
