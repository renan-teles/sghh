<?php 
    session_start();
    require_once __DIR__ . '/view/components/message.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH - Login</title>
    <link rel="stylesheet" href="view/assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="view/assets/css/style.css">
</head>
<body>
    <div class="container-fluid bg-img" >
        <main class="col-12 d-flex justify-content-center align-items-center" style="height: 100dvh;">
            <form id='form' action='controller/controllerReceptionist.php?act=login-receptionist' method='POST' class='col-12 col-sm-8 col-md-6 col-lg-5 bg-light p-4 shadow-lg rounded'>
                <div class='mb-3 text-center'>
                    <h2 class="text-brown">SGHH</h2>
                    <h5>Entrar Com Conta de Recepcionista</h5>
                </div>
                <hr>
                <div class='mb-3'>
                    <?php showMessage(); ?>
                </div>
                <div class='mb-3'>
                    <label class='form-label'>Email:</label>
                    <input type='email' class='form-control' name='email_receptionist' placeholder='Digite seu email...' />
                    <span class='form-text text-danger d-none'>Email inválido!</span>
                </div>
                <div class='mb-3'>
                    <label class='form-label'>Senha:</label>
                    <input type='password' class='form-control' name='password_receptionist' placeholder='Digite sua senha...' />
                    <span class='form-text text-danger d-none'>A senha deve conter no mínimo 7 caracteres, sendo eles não especiais!</span>
                </div>
                <hr>
                <div>
                    <button type='submit' class='btn btn-brown col-12 mb-1'>Entrar</button>
                    <a href='view/pages/register-receptionist.php' class='btn btn col-12'>Criar Conta de Recepcionista</a>
                </div>
            </form>
        </main>
    </div>
    <script src="view/assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
    <script src="view/assets/js/js_pages/login-receptionist.js" type="module"></script>
</body>
</html>