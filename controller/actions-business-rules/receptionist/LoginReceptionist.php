<?php

require_once __DIR__ . "/../Action.php";

class LoginReceptionist implements Action {
    public function execute(ClassDAO $receptionistDAO): void {
        $receptionist = $receptionistDAO->getReceptionist();
        
        $_SESSION['url_redirect_after_error_or_exception'] = "../index.php";

        if(!filter_var($receptionist->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido!");
        }

        if(!validatePassword($receptionist->getPassword())) {
            throw new Exception("Senha inválida!");
        }

        $receptionistDB = $receptionistDAO->searchByEmail();

        if($receptionistDB === false){
            throw new Exception("Erro ao buscar dados do recepcionista!");  
        }
        
        if($receptionistDB === []){
            throw new Exception("Os dados do recepcionista não foram encontrados!"); 
        }

        $password = $receptionist->getPassword();
        $passwordDB = $receptionistDB['password'];

        if(!password_verify($password, $passwordDB)){
            throw new Exception("Credenciais inválidas ou incorretas!"); 
        }

        $_SESSION['receptionistData'] = array(
            'id' => intval($receptionistDB['id']), 
            'name' => $receptionistDB['name'], 
            'email' => $receptionistDB['email']
        );

        header('Location: ../view/pages/home.php');
    }
}