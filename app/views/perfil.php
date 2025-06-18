<!DOCTYPE html>
<html lang="pt-br">
<?php require_once('template/head.php'); ?>

<body class="page-perfil">

    <form method="post" class="container" enctype="multipart/form-data">
        <h2>MEU PERFIL</h2>

        <label for="foto_cliente">FOTO DE PERFIL:</label><br>
        <input type="file" name="foto_cliente" id="foto_cliente" accept="image/*" style="display: none;">
        <label for="foto_cliente">
            <img id="imagemPerfil" src="<?= BASE_URL ?>assets/img/<?= htmlspecialchars($cliente['foto_cliente'] ?? 'perfil.jpg') ?>" alt="Foto Atual" class="profile-pic" style="cursor: pointer; max-width: 150px; border-radius: 50%;">
        </label>
        <small>Clique na imagem para alterar sua foto de perfil</small>

        <label for="nome">NOME:</label>
        <input type="text" name="nome" id="nome_cliente" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

        <label for="email">EMAIL:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>

        <label for="telefone">TELEFONE:</label>
        <input type="text" name="telefone" id="telefone_cliente" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>

        <label for="tipo_cliente">TIPO DE CLIENTE:</label>
        <select name="tipo_cliente" id="tipo_cliente" required>
            <option value="">Selecione</option>
            <option value="Física" <?= $cliente['tipo_cliente'] === 'Física' ? 'selected' : '' ?>>Pessoa Física</option>
            <option value="Jurídica" <?= $cliente['tipo_cliente'] === 'Jurídica' ? 'selected' : '' ?>>Pessoa Jurídica</option>
        </select>

        <label for="cpf_cnpj_cliente" id="labelCpfCnpj"><?= $cliente['tipo_cliente'] === 'Jurídica' ? 'CNPJ' : 'CPF' ?>:</label>
        <input type="text" name="cpf_cnpj_cliente" id="cpf_cnpj_cliente" value="<?= htmlspecialchars($cliente['cpf_cnpj_cliente']) ?>" required>

        <label for="data_nasc_cliente">DATA DE NASCIMENTO:</label>
        <input type="date" name="data_nasc_cliente" value="<?= htmlspecialchars($cliente['data_nasc_cliente']) ?>" required>

        <label for="id_uf">ESTADO:</label>
        <select name="id_uf" id="id_uf" required>
            <option value="">Selecione o estado</option>
            <?php foreach ($estados as $estado): ?>
                <option value="<?= $estado['id_uf'] ?>" <?= $cliente['id_uf'] == $estado['id_uf'] ? 'selected' : '' ?>>
                    <?= $estado['sigla_uf'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="status_cliente">STATUS DO CLIENTE:</label>
        <input type="text" name="status_cliente" id="status_cliente" value="<?= htmlspecialchars($cliente['status_cliente']) ?>">

        <label for="senha">ALTERAR SENHA (OPCIONAL):</label>
        <input type="password" name="senha" placeholder="Nova senha">

        <button class="btn">SALVAR ALTERAÇÕES</button>
        <a href="<?= BASE_URL ?>index.php?url=menu" class="btn btn-secondary">VOLTAR</a>
    </form>

    <?php if (!empty($_SESSION['msg_sucesso'])): ?>
        <div class="alert sucesso"><?= $_SESSION['msg_sucesso'] ?></div>
        <?php unset($_SESSION['msg_sucesso']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['msg_erro'])): ?>
        <div class="alert erro"><?= $_SESSION['msg_erro'] ?></div>
        <?php unset($_SESSION['msg_erro']); ?>
    <?php endif; ?>

    <script src="<?= BASE_URL ?>assets/js/viaCepEMascaras.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputFoto = document.getElementById('foto_cliente');
            const imgPreview = document.getElementById('imagemPerfil');

            inputFoto?.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imgPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            const telefone = document.getElementById('telefone_cliente');
            telefone?.addEventListener('input', function () {
                mascaraTelefone(this);
            });

            const nome = document.getElementById('nome_cliente');
            nome?.addEventListener('input', function () {
                mascaraNome(this);
            });

            const cpfCnpj = document.getElementById('cpf_cnpj_cliente');
            cpfCnpj?.addEventListener('input', function () {
                mascaraCpfCnpj(this);
            });

            const tipoCliente = document.getElementById('tipo_cliente');
            tipoCliente?.addEventListener('change', function () {
                const label = document.getElementById('labelCpfCnpj');
                label.textContent = tipoCliente.value === 'Jurídica' ? 'CNPJ:' : 'CPF:';
                cpfCnpj.value = '';
            });
        });
    </script>
</body>
</html>
