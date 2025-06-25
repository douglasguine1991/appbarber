<?php
 
class ListarAgendaController extends Controller
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
 
        // Buscar agendamentos do cliente logado na API
        $url = BASE_API . "agendamentosPorCliente/" . $dadosToken['id'];
 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
 
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
 
        if ($statusCode != 200) {
            echo "Erro ao buscar os agendamentos.\n";
            echo "Código HTTP: $statusCode";
            exit;
        }
 
        $agendamentos = json_decode($response, true);
 
        $dados = array();
        $dados['titulo'] = 'AppBarber - Meus Agendamentos';
 
        $dados['agendamentos'] = $agendamentos;
 
        $this->carregarViews('listarAgenda', $dados);
    }
 
    public function cancelarAgenda()
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
 
        if (!isset($_POST['id'])) {
            $_SESSION['msg_erro'] = 'ID do agendamento não fornecido.';
            header("Location: " . BASE_URL . "index.php?url=listarAgenda");
            exit;
        }
 
        $idAgendamento = $_POST['id_agendamento'];
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, BASE_API . "agendamentos/$idAgendamento/cancelar"); // Endpoint ajustado
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $_SESSION['token'],
            "Content-Type: application/json"
        ]);
 
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
 
        $resposta = json_decode($response, true);
 
        if ($statusCode === 200) {
            $_SESSION['msg_sucesso'] = $resposta['mensagem'] ?? 'Agendamento cancelado com sucesso!';
        } else {
            $_SESSION['msg_erro'] = $resposta['mensagem'] ?? 'Erro ao cancelar agendamento.';
        }
 
        header("Location: " . BASE_URL . "index.php?url=listarAgenda");
        exit;
    }
}
 