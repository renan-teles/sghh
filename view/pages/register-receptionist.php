<?php 
    session_start();
    require_once __DIR__ . '/../components/message.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH</title>
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container-fluid bg-img" >
        <main class="col-12 d-flex justify-content-center align-items-center" style="height: 100dvh;">
            <form id='form' action='../../controller/controllerReceptionist.php?act=register-receptionist' method='POST' class='col-12 col-sm-8 col-md-6 col-lg-5 bg-light p-4 shadow rounded'>
                <div class='mb-3 text-center'>
                    <h2 class="text-brown">SGHH</h2>
                    <h5>Criar Conta de Recepcionista</h5>
                </div>
                <hr>
                <div class='mb-3'>
                    <?php showMessage(); ?>
                </div>
                <div class='mb-3'>
                    <label class='form-label'>Nome:</label>
                    <input type='text' class='form-control' name='name_receptionist' placeholder='Digite seu nome...'/>
                    <span class='form-text text-danger d-none'>O nome deve conter no mínimo 4 caracteres e não conter números!</span>
                </div>
                <div class='mb-3'>
                    <label class='form-label'>Email:</label>
                    <input type='email' class='form-control' name='email_receptionist' placeholder='Digite seu email...' />
                    <span class='form-text text-danger d-none'>Email inválido!</span>
                </div>
                <div class="mb-3">
                    <label class='form-label'>Senha:</label>
                    <div class="input-group">
                        <input type='password' class='form-control' name='password_receptionist' id='password' placeholder='Crie sua senha...' />
                        <button class="btn btn-brown" type="button" id="view-password"><i class="bi-eye-fill"></i></button>
                    </div>
                    <span class='form-text text-danger d-none'>A senha deve conter no mínimo 7 caracteres, sendo eles não especiais!</span>
                </div>
                <hr>
                <div>
                    <button type='submit' class='btn btn-brown col-12 mb-1'>Criar Conta</button>
                    <a href='../../index.php' class='btn btn col-12'>Entrar Com Minha Conta</a>
                </div>
            </form>
        </main>
    </div>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../../view/assets/js/js_pages/register-receptionist.js" type="module"></script>
</body>
</html>