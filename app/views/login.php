<!DOCTYPE html>
<html lang="pt-br">
<?php
    require_once('template/head.php');
?>
<body class="page-login">
    <img src="<?php echo BASE_URL; ?>assets/img/logo1.png" alt="Logo" class="external-logo">
    
    <div class="container">
        <h2 class="login-title">LOGIN</h2>
        
        <form action="<?php echo BASE_URL; ?>index.php?url=login/autenticar" method="POST">
            <div class="login-box">
                <div class="input-group">
                    <label for="email">E-MAIL</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                
                <div class="input-group">
                    <label for="senha">SENHA</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>
                
                <div class="forgot-password">
                <p><a href="<?php echo BASE_URL; ?>index.php?url=recuperarsenha">Esqueci a Senha</a></p>
                </div>
                
                <button type="submit" class="login-button">ENTRAR</button>
            </div>
        </form>
    </div>

    <script>
        if ('serviceWorker' in navigator){
            window.addEventListener('load', function(){
                navigator.serviceWorker.register('service_worker.js')
                .then(function (registration){
                    console.log('Service Worker registrado', registration.scope);
                })
                .catch(function(error){
                    console.log('Erro ao registrar o service worker', error)
                });
            });
        }
    </script>
    
</body>
</html>