<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Customs\Responder;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
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
            'name.required' => 'Name is Required ',
            'email.email' => 'Please provide valid Email',
            'email.unique' => 'Account already exists'
        ];
    }

    /*handle failed validation*/

    public $validator = null;
    protected function failedValidation(
        \Illuminate\Contracts\Validation\Validator $validator
    ) {
        $this->validator = $validator;

        $errorString = '';
        foreach ($validator->errors()->all() as $value) {
            $errorString .= $value;
        }
        throw new HttpResponseException($this->errorResponse(400, $errorString));
    }
}
