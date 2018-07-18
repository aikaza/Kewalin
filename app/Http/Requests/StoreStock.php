<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ArrayUnique;
use Illuminate\Validation\Rule;

class StoreStock extends FormRequest
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
            'lot_no'    => 'required|numeric',
            'p_code'    => 'required|array',
            'p_code.*'  => 'required|exists:products,code',
            'qtyp'      => 'required|array',
            'qtyp.*'    => 'required|numeric',
            'unit'      => 'required|exists:units,id',
            'qtys'      => 'required|array',
            'qtys'      => 'required',
            'cst'       => 'required'
        ];
    }
}
