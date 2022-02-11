<?php

namespace App\Http\FormRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class AbstractFormRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        //
    }

    /**
     * @return array
     * @throws ValidationException
     */
    public function toArray(): array
    {
        if ($this->errors()) {
            throw (new ValidationException($this->validator));
        }

        $values = $this->validated();

        return $values;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->getValidatorInstance()->errors()->toArray();
    }


}
