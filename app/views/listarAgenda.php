<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body>
    <main>
        <div class="container">
            <div class="agendamentos-container">
                <h3>Lista de agendamentos</h3>

                <?php if (!empty($agendamentos) && is_array($agendamentos)) : ?>
                    <?php foreach ($agendamentos as $item) : ?>
                        <?php
                            $status = $item['status_agendamento'] ?? 'Indefinido';
                            $statusColor = match ($status) {
                                'Concluído' => 'green',
                                'Cancelado' => 'red',
                                'Em análise' => '#0099ff',
                                'Confirmado' => 'orange',
                                default => 'gray',
                            };
                        ?>
                   <div class="card-agendamento">
                            <p><span>Funcionário:</span> <?= $item['nome_funcionario'] ?></p>
                            <p><span>Data Agenda:</span> <?= date('d/m/Y H:i', strtotime($item['data_agendamento'])) ?></p>
                            <p><span>Serviço:</span> <?= $item['nome_servico'] ?></p>
                            <p style="color: <?= $statusColor ?>;" class="status">Status: <?= $status ?></p>
                        </div>
 
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Nenhum agendamento encontrado.</p>
                <?php endif; ?>

            </div>
            <a href="<?= BASE_URL ?>index.php?url=menu" class="btn btn-back">VOLTAR</a>
        </div>
    </main>

    <script src="script/script.js"></script>
</body>

</html>
