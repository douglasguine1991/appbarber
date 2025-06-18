<?php

class ListarServicoController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        $dadosToken = TokenHelper::validar($_SESSION['token']);

        if (!$dadosToken) {
            session_destroy();
            unset($_SESSION['token']);
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        // Buscar todos os serviços da API
        $urlServicos = BASE_API . "listarAgendamentoServicos/";
        $ch = curl_init($urlServicos);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode != 200) {
            echo "Erro ao buscar os serviços na API.<br>";
            echo "Código HTTP: $statusCode";
            exit;
        }

        $servicos = json_decode($response, true);

        $dados = [];
        $dados['titulo'] = 'Barbernac - Lista de Serviços';
        $dados['servicos'] = $servicos;

        $this->carregarViews('listarservico', $dados);
    }
}
