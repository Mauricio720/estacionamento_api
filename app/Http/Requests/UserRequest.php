<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
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
        $verboHttp = $this->getMethod();
        $requiredRule='required';
        $ruleUniqueEmail='unique:users';
        if ($verboHttp == 'PUT') {
            $requiredRule="";
            $ruleUniqueEmail=Rule::unique('users', 'email')->ignore(Auth::user()->id);
        }
     
        return [
            'name'=>['string'],
            'email' => ['email',$ruleUniqueEmail,$requiredRule],
            'password' => ['string', $requiredRule],
            'type' =>  ['string', $requiredRule],
        
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'email' => 'email',
            'password' => 'senha',
            'type' => 'tipo'
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
