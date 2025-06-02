<?php

require_once __DIR__ . "/../Action.php";

class DeleteReceptionist implements Action {
    public function execute(ClassDAO $receptionistDAO): void{
        $receptionist = $receptionistDAO->getReceptionist();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/panel-receptionist.php";

        //Validate Receptionist ID
        if($receptionist->getId() <= 0) {
            throw new Exception("Id de recepcionista inválido!");
        }

        //Delete Recepcionist
        if(!$receptionistDAO->deleteById()){
            throw new Exception("Não foi possível deletar os dados do recepcionista!");
        }

        //Logout Receptionist
        unset($_SESSION['receptionistData']);
        
        //Response
        header("Location: ../index.php");
    }
}