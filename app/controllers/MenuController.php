<?php

class MenuController extends Controller
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

        //Buscar o cliente na API
        $url = BASE_API . "buscarCliente/" . $dadosToken['id'];

        //Reconhecimento da chave (Inicializa uma sessão cURL)
        $ch = curl_init($url);
        //Definir que o conteudo venha com string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        //Recebe os dados dessa solicitação
        $response = curl_exec($ch);
        //Obtém o código HTTP da resposta (200, 400, 401)
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //Encerra a sessão cURL
        curl_close($ch);

        if ($statusCode != 200) {
            echo "Erro ao buscar o cliente na API.\n";
            echo "Código HTTP: $statusCode";
            exit;
        }

        //Separa os dados em 'campos'
        $cliente = json_decode($response, true);

        $dados = array();
        $dados['titulo'] = 'Barbernac - Menu';

        $dados['nome'] = $cliente['nome'] ?? 'Cliente';

        $this->carregarViews('menu', $dados);
    }
}
