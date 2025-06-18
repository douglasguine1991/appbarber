<?php

class Rotas
{
    public function executar()
    {
        $url = '';

        if (isset($_GET['url'])) {
            $url = $_GET['url']; // pega url sem adicionar barra
        }

        $parametro = [];

        if (!empty($url)) {
            $urlArray = explode('/', $url);

            $controladorAtual = ucfirst($urlArray[0]) . 'Controller';
            $acaoAtual = $urlArray[1] ?? 'index';

            // Se existir mais parâmetros depois da ação
            if (count($urlArray) > 2) {
                $parametro = array_slice($urlArray, 2);
            }
        } else {
            $controladorAtual = 'LoginController';
            $acaoAtual = 'index';
        }

        // Verificar se o arquivo do controlador existe e se o método existe
        if (!file_exists('../app/controllers/' . $controladorAtual . '.php') || !method_exists($controladorAtual, $acaoAtual)) {
            echo "Não encontrado: Controller = $controladorAtual, Ação = $acaoAtual";
            $controladorAtual = 'ErroController';
            $acaoAtual = 'index';
        }

        require_once('../app/controllers/' . $controladorAtual . '.php');

        $controler = new $controladorAtual;

        call_user_func_array([$controler, $acaoAtual], $parametro);
    }
}

