<?php

class ErroController extends Controller
{
    public function index()
    {
        echo "Erro: Controller ou ação não encontrada.";
        // Você pode também dar um var_dump na URL ou parâmetros para debugar
        // var_dump($_GET);
    }
}