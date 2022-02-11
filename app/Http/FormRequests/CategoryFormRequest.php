<?php

namespace App\Http\FormRequests;

class CategoryFormRequest extends AbstractFormRequest
{
    /**
     * Login form request rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'category_name' => 'required|min:3|max:60|string'
        ];
    }
}



