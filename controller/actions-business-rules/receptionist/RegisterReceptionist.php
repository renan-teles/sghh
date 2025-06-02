<?php

require_once __DIR__ . "/../Action.php";

class RegisterReceptionist implements Action {
    public function execute(ClassDAO $receptionistDAO): void{
        $receptionist = $receptionistDAO->getReceptionist();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/register-receptionist.php";

        //Validate Receptionist Form Data 
        if(!validateName($receptionist->getName())) {
            throw new Exception("Nome inválido!");
        }
        if(!filter_var($receptionist->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido!");
        }
        if(!validatePassword($receptionist->getPassword())) {
            throw new Exception("Senha inválida!");
        }

        //Hash Password
        $passwordHash = password_hash($receptionist->getPassword(), PASSWORD_DEFAULT);
        $receptionist->setPassword($passwordHash);

        //Check Receptionist Existence
        $status = $receptionistDAO->checkExistenceByNameAndEmail();
        if($status){
            throw new Exception("Os dados do recepcionista já estão cadastrados no sistema!");
        }
        if($status === false) {
            throw new Exception("Erro ao verificar existência de dados do recepcionista no sistema!");
        }

        //Register Receptionist
        if(!$receptionistDAO->register()) {
            throw new Exception("Não foi possível cadastrar os dados do recepcionista.");
        }

        //Response
        $_SESSION['msg-success'] = "Dados do recepcionista cadastrados com sucesso!"; 
        header("Location: ../index.php");
    }
}