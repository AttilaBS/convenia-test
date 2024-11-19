<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Api Responses
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for API custom responses and messages.
    |
    */
    'search' => [
        'missing-criteria' => [
            'message' => 'É necessário informar um critério válido de busca',
            'status' => 422,
        ],
    ],
    'model' => [
        'not_found' => [
            'message' => 'Não foi encontrado nenhum resultado com os dados informados.',
            'status' => 500,
        ],
        'created' => [
            'message' => 'O registro foi criado com sucesso!',
            'status' => 201,
        ],
        'not_created' => [
            'message' => 'Ocorreu um erro e o registro não foi criado.',
            'status' => 400,
        ],
        'deleted' => [
            'message' => 'O registro de id :uuid foi removido!',
            'status' => 200,
        ],
        'not_deleted' => [
            'message' => 'Ocorreu um erro e o registro de id :uuid não foi removido!',
            'status' => 400,
        ],
    ],
    'user' => [
        'invalid_credentials' => [
            'message' => 'Email ou senha inválidos',
            'status' => 401,
        ],
        'not_logged_in' => [
            'message' => 'Este usuário não está logado no sistema',
            'status' => 404,
        ],
        'unauthorized' => [
            'message' => 'O usuário não possui permissão para acessar esta rota!',
            'status' => 403,
        ],
        'logout_success' => [
            'message' => 'Logout realizado com sucesso.',
            'status' => 200,
        ],
        'logout_error' => [
            'message' => 'Erro ao efetuar logout.',
            'status' => 400,
        ],
    ],
    'policy' => [
        'deny' => 'Você não possui acesso a este recurso!',
    ],
    'employee' => [
        'not_updated' => [
            'message' => 'Ocorreu um erro e o cadastro do colaborador id :uuid não foi atualizado.',
            'status' => 400,
        ],
        'list_error' => [
            'message' => 'Ocorreu um erro ao buscar a lista de colaboradores.',
            'status' => 400,
        ],
        'upload' => [
            'list' => [
                'processing' => [
                    'message' => 'A lista está sendo processada. Você receberá um email assim que o processo terminar.',
                    'status' => 200,
                ],
                'error' => [
                    'message' => 'Ocorreu um erro ao inserir a lista. Tente novamente mais tarde.',
                    'status'=> 400,
                ],
                'success' => 'Processamento realizado com sucesso',
                'failure' => 'Ocorreu um erro ao processar a lista no bloco nº :attribute',
            ],
        ],
    ],
];
