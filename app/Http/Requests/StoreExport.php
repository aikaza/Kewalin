<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExport extends FormRequest
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
            'order_id.*'    => 'required|numeric|exists:orders,id',
            'p_id'          => 'required|array',
            'p_id.*'        => 'required|numeric|exists:products,id',
            'qtyp'          => 'required|array',
            'qtyp.*'        => 'required|numeric',
            'qtys'          => 'required|array',
            'qtys.*'        => 'required|numeric',
            'lot_no'        => 'required|array',
            'lot_no.*'      => 'required',
            'unit'          => [Rule::in(['y', 'm', 'kg'])],
            'c_id'          => 'required|exists:customers,id'   
        ];
    }
}
