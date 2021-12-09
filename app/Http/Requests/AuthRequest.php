<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AuthRequest extends Request
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
        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];

        if (env('APP_ENV') != 'local') {
            $rules['g-recaptcha-response'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'email.required'    => 'Lütfen e-posta adresinizi girin!',
            'email.email'       => 'Lütfen geçerli bir e-posta girin!',
            'password.required' => 'Lütfen şifrenizi girin!',
        ];

        if (env('APP_ENV') != 'local') {
            $messages['g-recaptcha-response.required'] = 'Lütfen Google reCaptcha onay kutunu işaretleyin!';
        }

        return $messages;
    }
}
