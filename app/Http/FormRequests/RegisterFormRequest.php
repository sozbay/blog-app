<?php

namespace App\Http\FormRequests;

class RegisterFormRequest extends AbstractFormRequest
{
    /**
     * Login form request rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:60|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:25'
        ];
    }
}



