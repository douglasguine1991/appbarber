<?php

class PerfilController extends Controller
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dadosAtualizados = [
                'nome'      => $_POST['nome'],
                'email'     => $_POST['email'],
                'telefone'  => $_POST['telefone'],
                'id_uf'     => $_POST['id_uf'], 
            ];
        
            if (!empty($_POST['senha'])) {
                $dadosAtualizados['senha'] = $_POST['senha'];
            }
        
            if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] === UPLOAD_ERR_OK) {
                $dadosAtualizados['foto_cliente'] = new CURLFile(
                    $_FILES['foto_cliente']['tmp_name'],
                    $_FILES['foto_cliente']['type'],
                    $_FILES['foto_cliente']['name']
                );
            }
        
            $urlAtualizar = BASE_API . "atualizarCliente/" . $dadosToken['id'];
        
            $chAtualizar = curl_init($urlAtualizar);
            curl_setopt($chAtualizar, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chAtualizar, CURLOPT_POST, true); // <- MANTÉM COMO POST
            curl_setopt($chAtualizar, CURLOPT_POSTFIELDS, $dadosAtualizados);
        
            curl_setopt($chAtualizar, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $_SESSION['token']
            ]);
        
            $resposta = curl_exec($chAtualizar);
            $statusCodeAtualizar = curl_getinfo($chAtualizar, CURLINFO_HTTP_CODE);
            curl_close($chAtualizar);
        
            $response = json_decode($resposta, true);
        
            if ($statusCodeAtualizar === 200) {
                $_SESSION['msg_sucesso'] = 'Perfil atualizado com sucesso!';
                header("Location: " . BASE_URL . "index.php?url=perfil");
                exit;
            } else {
                $_SESSION['msg_erro'] = "Erro ao atualizar o perfil! Código: $statusCodeAtualizar";
            }
        }
        

        //Buscar os clientes na API
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
            echo "Erro ao buscar as ordens de serviço na API.\n";
            echo "Código HTTP: $statusCode";
            exit;
        }

        //Separa os dados em 'campos'
        $cliente = json_decode($response, true);

        //Fazer a busca da lista de estados
        $urlEstados = BASE_API . "listarEstados";
        $chEstados = curl_init($urlEstados);
        curl_setopt($chEstados, CURLOPT_RETURNTRANSFER, true);
        $responseEstados = curl_exec($chEstados);
        $statusCodeEstados = curl_getinfo($chEstados, CURLINFO_HTTP_CODE);
        curl_close($chEstados);

        $estados = ($statusCodeEstados == 200) ? json_decode($responseEstados, true) : [];


        $dados = array();
        $dados['titulo'] = 'appbarber - Perfil';

        $dados['cliente'] = $cliente;
        $dados['estados'] = $estados;

        $this->carregarViews('perfil', $dados);
    }

    
}
