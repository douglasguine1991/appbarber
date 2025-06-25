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

        <div class="profile-box">
                <form method="post" class="container">
                    <label>NOME:</label>
                    <input type="text" class="input_perfil" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
 
                    <label><strong>EMAIL:</strong></label>
                    <input type="email" class="input_perfil" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>
 
                    <label><strong>TELEFONE:</strong></label>
                    <input type="text" class="input_perfil" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>

 
                    <label><strong>ESTADO:</strong></label>
                    <select name="id_uf" class="form-control" required>
                        <option value="">Selecione o estado</option>
                        <?php foreach ($estados as $estado): ?>
                            <option value="<?= $estado['id_uf'] ?>" <?= $cliente['id_uf'] == $estado['id_uf'] ? 'selected' : '' ?>>
                                <?= $estado['sigla_uf'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
 
                    <label><strong>ALTERAR SENHA (OPCIONAL):</strong></label>
                    <input type="password" name="senha" class="form-control" placeholder="Nova senha">
 
                    <button type="submit" class="btn btn-custom">SALVAR ALTERAÇÕES</button>
                </form>
 
                <a href="<?php echo BASE_URL; ?>index.php?url=menu" class="menu-button exit">VOLTAR</a>
            </div>

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
