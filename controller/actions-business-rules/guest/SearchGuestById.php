<?php

require_once __DIR__ . "/../Action.php";

class SearchGuestById {
    public function execute(classDAO $guestDAO){
        $id = $guestDAO->getGuest()->getId();

        if($id <= 0) {
            throw new Exception("Id de hóspede inválido!");
        }
    
        return $guestDAO->searchById();
    }
}