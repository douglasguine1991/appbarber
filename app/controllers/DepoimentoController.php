<?php

class DepoimentoController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        $dados = array();
        $dados['titulo'] = 'Appbarber - Depoimento';

        $this->carregarViews('depoimentos', $dados);
    }

    public function enviarDepoimento()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        $descricao = $_POST['descricao'] ?? '';
        $nota = $_POST['nota'] ?? '';

        // Analisar preenchimento da descrição e da nota
        if (empty($descricao) || empty($nota)) {
            echo 'Preencha todos os campos';
            return;
        }

        $postData = [
            'descricao_depoimento' => $descricao,
            'nota' => $nota
        ];

        $url = BASE_API . "NovoDepoimento";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // Use http_build_query para enviar como application/x-www-form-urlencoded
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token'],
            'Content-Type: application/x-www-form-urlencoded' // cabeçalho importante para o formato dos dados
        ]);

        $resposta = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // Debug: para ver exatamente o que a API está retornando
         //echo "<pre>Resposta raw da API:\n";
         //var_dump($resposta);
         //echo "</pre>";
         //exit;
        
        if ($statusCode == 200) {
            $response = json_decode($resposta, true);
        
            if ($response === null) {
                echo "Erro ao decodificar JSON: " . json_last_error_msg();
                exit;
            }
        
            if (isset($response['sucesso']) && $response['sucesso']) {
                header("Location: " . BASE_URL . "index.php?url=menu");
                exit;
            } else {
                echo "Erro: Depoimento não inserido ou retorno inesperado.";
                exit;
            }
        } else {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }
    }
}        

