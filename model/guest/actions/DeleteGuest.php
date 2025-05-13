<?php

require_once __DIR__ . "/../../interface/Action.php";

class DeleteGuest implements Action {
    public function execute(ClassDAO $guestDAO): void{
        $guest = $guestDAO->getGuest();

        if($guest->getId() <= 0) {
            throw new Exception("Id de hóspede inválido!");
        }

        if(!$guestDAO->delete()) {
            throw new Exception("Não foi possível excluir o hóspede.");
        }

        $_SESSION['msg-success'] = "Hóspede excluído com sucesso!"; 
        header("Location: ../view/pages/guests.php");
    }   
}