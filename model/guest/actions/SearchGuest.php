<?php

class SearchGuest {
    public function execute(classDAO $guestDAO){
        $email = $guestDAO->getGuest()->getEmail();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Parâmetro de busca inválido!");
        }
    
        return $guestDAO->searchByEmail();
    }
}