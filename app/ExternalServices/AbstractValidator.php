<?php


namespace App\ExternalServices;


use Illuminate\Support\Facades\Validator;
use App\ExternalServices\ExceptionsServices\ExternalProviderLocalException;

abstract class AbstractValidator
{
    public array $rules = [];

    public function validate(array $inputs): array
    {
        $validator = Validator::make($inputs, $this->getRules());
        throw_if($validator->fails(), new ExternalProviderLocalException("Data Validation Exception, {$validator->errors()->toJson()}"));
        return $this->formatData($validator->validated());
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function formatData($data)
    {
        return $data;
    }
}