<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarRequest extends FormRequest
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
            'model'=>['string','required'],
            'color' => ['string','required'],
            'license_plate' => ['string','required'],
            'clients_id' => ['required', 'exists:clients,id'],
        ];
    }

    public function attributes(){
        return [
            'model' => 'modelo',
            'color' => 'cor',
            'license_plate' => 'placa',
            'clients_id' => 'cliente',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => $validator->errors()->first(),
            'status' => 400
        ], 400));
    }
}
