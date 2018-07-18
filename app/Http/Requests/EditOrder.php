<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditOrder extends FormRequest
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
            'order_id'      => 'required|array',
            'order_id.*'    => 'required|exists:orders,id',
            'product_code'      => 'required|array',
            'product_code.*'    => 'required|exists:products,code',
            'product_color'      => 'required|array',
            'product_color.*'    => 'required',
            'product_qtyp'      => 'required|array',
            'product_qtyp.*'    => 'required|numeric',
        ];
    }
}
