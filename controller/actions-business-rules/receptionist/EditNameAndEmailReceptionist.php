<?php

require_once __DIR__ . "/../Action.php";

class EditNameAndEmailReceptionist implements Action {
    public function execute(ClassDAO $receptionistDAO): void{
        $receptionist = $receptionistDAO->getReceptionist();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/panel-receptionist.php";

        if($receptionist->getId() <= 0) {
            throw new Exception("Id de recepcionista inválido!");
        }

        if(!validateName($receptionist->getName())) {
            throw new Exception("Nome inválido!");
        }
        
        if(!filter_var($receptionist->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido!");
        }

        if(!$receptionistDAO->editNameAndEmailById()) {
            throw new Exception("Não foi possível atualizar os dados do recepcionista.");
        }

        $receptionistDB = $receptionistDAO->searchByEmail();

        if($receptionistDB === false){
            throw new Exception("Erro ao buscar dados do recepcionista!");  
        }

        if($receptionistDB === []){
            unset($_SESSION['receptionistData']);
            $_SESSION['url_redirect_after_error_or_exception'] = "../index.php";
            throw new Exception("Os dados do recepcionista não foram encontrados, tente logar novamente com os novos dados.");
        }

        $_SESSION['receptionistData'] = array(
            'id' => intval($receptionistDB['id']), 
            'name' => $receptionistDB['name'], 
            'email' => $receptionistDB['email']
        );

        $_SESSION['msg-success'] = "Dados do recepcionista editados com sucesso!"; 
        header("Location: ../view/pages/panel-receptionist.php");
    }
}