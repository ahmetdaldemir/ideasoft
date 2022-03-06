<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'customerId' => 'required|integer',
            'items.*.productId' => 'required|integer',
            'items.*.quantity' => 'required|integer',
            'items.*.unitPrice' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'items.*.total' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'total' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
        ];
    }
}
