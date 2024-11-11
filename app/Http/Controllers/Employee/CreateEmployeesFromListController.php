<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadEmployeesListRequest;
use App\Services\ProcessEmployeesListService;

final class CreateEmployeesFromListController extends Controller
{
    public function __invoke(
        UploadEmployeesListRequest $request,
        ProcessEmployeesListService $processEmployeesListService
    ) {
        $isTrue = $processEmployeesListService($request->validated('list'));
        if ($isTrue) {
            return response()->json(
                [
                    'message' => 'A lista está sendo processada. Você receberá um email assim que o processo terminar.',
                ],
                200
            );
        }


















        // salvo a planilha no filesystem - local por enquanto
        // disparo o job de processamento da planilha
        // a função retorna a resposta de que a planilha foi uploadeada com sucesso -
        // assim que tudo estiver salvo, ele receberá um email
        // o job pode chamar um service - ou posso mandar para um EDD
        // o service faz o processamento da planilha e salva no banco
        // quando terminado, posso criar um evento, que chama um listener, que manda o email
        // ver de enviar o email com o mailable do laravel - kyrios api tem isso
    }
}
