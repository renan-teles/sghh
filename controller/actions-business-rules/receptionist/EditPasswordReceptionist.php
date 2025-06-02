<?php

require_once __DIR__ . "/../Action.php";

class EditPasswordReceptionist implements Action {
    public function execute(ClassDAO $receptionistDAO): void{
        $receptionist = $receptionistDAO->getReceptionist();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/panel-receptionist.php";

        //Validate Receptionist Form Data
        if($receptionist->getId() <= 0) {
            throw new Exception("Id de recepcionista inválido!");
        }
        if(!validatePassword($receptionist->getPassword())) {
            throw new Exception("Senha atual inválida!");
        }
        if(!validatePassword($receptionist->getNewPassword())) {
            throw new Exception("Nova senha inválida!");
        }
        
        $receptionistDB = $receptionistDAO->searchById();
        if($receptionistDB === false){
            throw new Exception('Erro ao buscar dados do recepcionista!');
        }
        if($receptionistDB === []){ 
            throw new Exception('Os dados do recepcionista não foram encontrados.');
        }

        //Validate New Password
        $oldPassword = $receptionist->getPassword();
        $newPassword = $receptionist->getNewPassword();
        $passwordDB = $receptionistDB['password'];

        if(!password_verify($oldPassword, $passwordDB)){
            throw new Exception('Senha atual incorreta!');
        }

        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $receptionist->setNewPassword($passwordHash);
    
        //Edit Password
        if(!$receptionistDAO->editPasswordById()){
            throw new Exception('Não foi possível atualizar a senha.');
        }

        //Response
        $_SESSION['msg-success'] = "Senha atualizada com sucesso!"; 
        header("Location: ../view/pages/panel-receptionist.php");
    }
}