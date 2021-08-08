<?php

namespace App\Http\Requests;

use App\Customs\Responder;
use Illuminate\Foundation\Http\FormRequest;
 use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    use Responder;
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
            'password' => 'required',
            'email' => 'required|email',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email is Required ',
            'password.required' => 'Password is Required ',
            'email.email' => 'Please provide valid Email',
        ];
    }

    /*handle failed validation*/

    public $validator = null;
    protected function failedValidation(
        \Illuminate\Contracts\Validation\Validator $validator
    ) {
        $this->validator = $validator;
        $errorString='';
        foreach ($validator->errors()->all() as $value) {
            $errorString .= $value;
        }
        throw new HttpResponseException($this->errorResponse(400,$errorString));
    }
}
