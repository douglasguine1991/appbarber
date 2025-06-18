<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body>
    <main>
        <div class="container">

            <div class="servicos-container">

                <h3>Lista de Serviços</h3>

                <?php if (!empty($servicos) && is_array($servicos)) : ?>
                    <?php foreach ($servicos as $servico) : ?>
                        <div class="card-servico">
                            <p><span>Nome:</span> <?= htmlspecialchars($servico['nome_servico'] ?? 'N/D') ?></p>
                            <p><span>Descrição:</span> <?= htmlspecialchars($servico['descricao_servico'] ?? 'N/D') ?></p>
                            <p><span>Preço:</span> R$ <?= number_format($servico['preco_base_servico'] ?? 0, 2, ',', '.') ?></p>
                            <p class="status" style="color: green;">Status: <?= htmlspecialchars($servico['status_servico'] ?? 'Ativo') ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Nenhum serviço encontrado.</p>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>index.php?url=menu" class="menu-button exit">VOLTAR</a>
            </div>

        </div>
    </main>

    <script src="script/script.js"></script>
</body>

</html>
