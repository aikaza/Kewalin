<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExportPrice extends FormRequest
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
           'id'      => 'required|array',
           'id.*'    => 'required|numeric|exists:exports,id',
           'price'      => 'required|array',
           'price.*'    => 'required|numeric',
           'qtys'      => 'required|array',
           'qtys.*'    => 'required|numeric'
       ];
   }
}
