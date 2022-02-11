<?php

namespace App\Http\FormRequests;

class ArticleFormRequest extends AbstractFormRequest
{
    /**
     * Login form request rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'author' => 'required|min:3|max:60',
            'title' => 'required|min:3|max:60',
            'description' => 'required',
            'category_id' => 'required|integer'
        ];
    }
}



