<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\GreaterZero;
use App\Rules\ArrayUnique;

class StoreOrder extends FormRequest
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
            'c_id' => 'required|numeric|exists:customers,id',
            'p_code' => 'required|array',
            'p_code.*' => 'required|exists:products,code',
            'qtyp' => 'required|array',
            'qtyp.*' => ['required','numeric',new GreaterZero()],
            'created_for' => 'required|in:ext_minor,ext_major'
        ];
    }
}
