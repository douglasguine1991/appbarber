<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body class="page-agendamento">
    <div class="container">
        <h1>AGENDAMENTO</h1>

        <?php if (!empty($_SESSION['msg_sucesso'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['msg_sucesso']; unset($_SESSION['msg_sucesso']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['msg_erro'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['msg_erro']; unset($_SESSION['msg_erro']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="agendamento-form">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="data_agenda">DATA</label>
                    <input type="date" class="form-input" name="data_agenda" id="data_agenda" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="hora_agenda">HORA</label>
                    <select class="form-select" name="hora_agenda" id="hora_agenda" required>
                        <option value="" disabled selected>Selecione a hora</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="id_funcionario">FUNCIONÁRIO</label>
                <select class="form-select" name="id_funcionario" id="id_funcionario" required>
                    <option value="" disabled selected>Selecione o funcionário</option>
                    <?php if (!empty($funcionarios) && is_array($funcionarios)): ?>
                        <?php foreach ($funcionarios as $func): ?>
                            <?php if ($func['status_funcionario'] === 'Ativo' && $func['cargo'] === 'Barbeiro'): ?>
                                <option value="<?= $func['id'] ?>">
                                    <?= htmlspecialchars($func['nome_funcionario']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>Nenhum funcionário disponível</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="id_servico">SERVIÇO</label>
                <select class="form-select" name="id_servico" id="id_servico" required>
                    <option value="">Selecione o serviço</option>
                    <?php if (!empty($servicos) && is_array($servicos)): ?>
                        <?php foreach ($servicos as $servico): ?>
                            <option value="<?= $servico['id_servico'] ?>">
                                <?= htmlspecialchars($servico['nome_servico']) ?> - R$<?= number_format($servico['preco_base_servico'], 2, ',', '.') ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>Nenhum serviço disponível</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">CONFIRMAR AGENDAMENTO</button>
            </div>
        </form>

        <div class="secondary-actions">
            <a href="<?php echo BASE_URL; ?>index.php?url=Menu" class="btn-secondary">VOLTAR</a>
            <a href="<?php echo BASE_URL; ?>index.php?url=ListarAgenda" class="btn-secondary">VER AGENDAMENTOS</a>
        </div>
    </div>
</body>

</html>
