<?php

namespace App\Services;

use App\Rules\EmailPattern;
use App\Rules\NamePattern;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidateListValues
{
    public function __invoke(array $listRows): true|string
    {
        foreach ($listRows as $listRow) {
            $listRow['cpf'] = preg_replace('/\D/', '', $listRow['cpf']);
            $validator = Validator::make(
                $listRow,
                [
                    'cpf' => 'required|string|size:11',
                    'city' => 'required|string|between:3,120',
                    'state' => 'required|string|between:3,120',
                    'name' => [
                        'required',
                        'string',
                        'between:3,120',
                        new NamePattern,
                    ],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        new EmailPattern,
                        Rule::unique('employees', 'email'),
                    ],
                ]
            );
            if ($validator->stopOnFirstFailure()->fails()) {
                $errors = $validator->errors();
                $key = $errors->keys()[0];
                $errorMessage = $errors->get($key)[0];
                $fieldValue = $listRow[$key];
                $message = $errorMessage.' : '.$fieldValue;

                logger()->error(
                    'Ocorreu um erro ao inserir os registros da planilha: ',
                    [$message]
                );

                return $message;
            }
        }

        return true;
    }
}
