<?php

namespace App\Http\FormRequests;

class LoginFormRequest extends AbstractFormRequest
{
    /**
     * Login form request rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:5|max:25'
        ];
    }
}



