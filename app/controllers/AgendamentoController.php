<?php

class AgendamentoController extends Controller
{
    public function index()
    {
        // Verifica autenticação
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

        // Inicializa as variáveis para evitar erro de variável indefinida
        $servicos = [];
        $funcionarios = [];

        // Buscar os serviços da API
        $urlServicos = BASE_API . "listarServico";
        $chServicos = curl_init($urlServicos);
        curl_setopt($chServicos, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chServicos, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseServicos = curl_exec($chServicos);
        $statusCodeServicos = curl_getinfo($chServicos, CURLINFO_HTTP_CODE);
        curl_close($chServicos);

        if ($statusCodeServicos === 200) {
            $servicos = json_decode($responseServicos, true);
        } else {
            $_SESSION['msg_erro'] = "Erro ao buscar os serviços. Código: $statusCodeServicos";
        }

        // Buscar os funcionários da API
        $urlFuncionarios = BASE_API . "listarFunc/";
        $chFuncionarios = curl_init($urlFuncionarios);
        curl_setopt($chFuncionarios, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chFuncionarios, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseFuncionarios = curl_exec($chFuncionarios);
        $statusCodeFuncionarios = curl_getinfo($chFuncionarios, CURLINFO_HTTP_CODE);
        curl_close($chFuncionarios);

        if ($statusCodeFuncionarios === 200) {
            $funcionarios = json_decode($responseFuncionarios, true);
        } else {
            $_SESSION['msg_erro'] = "Erro ao buscar os funcionários. Código: $statusCodeFuncionarios";
        }

        // Processar POST para criar agendamento
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['data_agenda'];
            $hora = $_POST['hora_agenda'];
            $dataAgendamento = $data . ' ' . $hora;

            $dadosAgendamento = [
                'id' => $dadosToken['id'], // ID do cliente autenticado
                'id_servico' => $_POST['id_servico'],
                'id_funcionario' => $_POST['id_funcionario'],
                'data_agendamento' => $dataAgendamento,
            ];

            $urlAgendar = BASE_API . "criarAgendamento";
            $chAgenda = curl_init($urlAgendar);
            curl_setopt($chAgenda, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chAgenda, CURLOPT_POSTFIELDS, json_encode($dadosAgendamento));
            curl_setopt($chAgenda, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $_SESSION['token'],
                'Content-Type: application/json'
            ]);

            $resposta = curl_exec($chAgenda);
            $statusCodeAgenda = curl_getinfo($chAgenda, CURLINFO_HTTP_CODE);
            curl_close($chAgenda);

            if ($statusCodeAgenda === 200 || $statusCodeAgenda === 201) {
                $_SESSION['msg_sucesso'] = 'Agendamento realizado com sucesso!';
                header("Location: " . BASE_URL . "index.php?url=agendamento");
                exit;
            } else {
                $_SESSION['msg_erro'] = "Erro ao agendar. Código: $statusCodeAgenda";
            }
        }

        // Carregar a view com os dados
        $dados = [];
        $dados['titulo'] = 'AppBarber - Agendamento';
        $dados['servicos'] = $servicos;
        $dados['funcionarios'] = $funcionarios;

        $this->carregarViews('agendamento', $dados);
    }
}
