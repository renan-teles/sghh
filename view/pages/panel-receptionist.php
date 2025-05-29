<?php
    session_start();
  
    //Check Login
    require __DIR__ . "/../utils/utils.php";
    checkLogin();

    //Get Data Receptionist
    $receptionistData = $_SESSION['receptionistData'];
  
    //Require Components
    include_once '../components/navbar.php';
    include_once '../components/message.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH - Meu Painel</title>
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-brown">
    <div>
        <?php showNavbar("panel-receptionist"); ?>

        <main class="container-lg mt-4">
            <div class="col-12 bg-light rounded shadow-sm p-4">
                <div class="row">
                    <div class="col-12 col-md text-center text-md-start">
                        <h2><i class='bi-person-vcard me-2'></i>Minhas Informações</h2>
                    </div>
                    <div class="col-12 col-md text-center text-start text-md-end">
                        <button id="btnOpenModalDeleteReceptionist" class='btn btn-danger mt-2 mt-md-0' type='button' data-bs-target='#modalDeleteUser' data-bs-toggle='modal'>
                            <i class='bi-person-x me-1'></i>Deletar Conta
                        </button>
                    </div>
                </div>
                <div class="col-12"><hr /></div>
                <div class="col-12"><?php showMessage(); ?></div>
                <form id="formEditNameAndEmail" action="../../controller/controllerReceptionist.php?act=edit-name-and-email-receptionist" method="POST">
                    <div class="col-12 mb-3">
                        <h5><i class='bi-person-gear me-1'></i>Alterar informações gerais:</h5>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <label class="form-label">Nome:</label>
                            <input type="text" name="name_receptionist" value="<?= $receptionistData['name']; ?>" class="form-control" />
                            <span class='form-text text-danger d-none spanFormEditNameAndEmail'>O nome deve conter no mímino 4 caracteres e não conter números!</span>
                        </div>
                        <div class="col-md mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email_receptionist" value="<?= $receptionistData['email']; ?>" class="form-control" />
                            <span class='form-text text-danger d-none spanFormEditNameAndEmail'>Email inválido!</span>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    </div>
                </form>
                <div class="col-12"><hr /></div>
                <form id="formEditPassword" action="../../controller/controllerReceptionist.php?act=edit-password-receptionist" method="POST">
                    <div class="col-12 mb-3">
                        <h5><i class='bi-person-lock me-1'></i>Alterar senha:</h5>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <label class="form-label">Senha Atual:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_receptionist" id='current-password' placeholder="Digite a senha atual..."/>
                                <button class="btn btn-brown" type="button" id="btn-view-current-password"><i class="bi-eye-fill"></i></button>
                            </div>
                            <span class='form-text text-danger d-none spanFormEditPassword'>A senha atual deve conter no mínimo 7 caracteres, sendo eles não especiais!</span>
                        </div>
      
                        <div class="col-md mb-3">
                            <label class="form-label">Nova Senha:</label>
                            <div class="input-group">  
                                <input type="password" name="new_password_receptionist" id='new-password' placeholder="Digite a nova senha..." class="form-control" />
                                <button class="btn btn-brown" type="button" id="btn-view-new-password"><i class="bi-eye-fill"></i></button>
                            </div>
                            <span class='form-text text-danger d-none spanFormEditPassword'>A nova senha deve conter no mínimo 7 caracteres, sendo eles não especiais!</span>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button for="form2" type="submit" class="btn btn-success">Salvar Alteração</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- MODAL DELETE USER -->
    <div class="modal fade" id="modalDeleteUser" aria-hidden="true" aria-labelledby="modalDeleteItemLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class="bi-person-x me-1"></i>Deletar esta conta?</h4>
                    <span class="form-text">Todos os seus dados serão apagados do sistema.</span>
                    <hr>
                    <a id='btnDeleteReceptionist' href="../../controller/controllerReceptionist.php?act=delete-receptionist" class="btn btn-danger">Excluir</a>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/js_pages/panel-receptionist.js" type="module"></script>
</body>
</html> 