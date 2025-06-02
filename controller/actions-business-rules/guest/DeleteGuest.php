<?php

require_once __DIR__ . "/../Action.php";

class DeleteGuest implements Action {
    public function execute(ClassDAO $guestDAO): void{
        $guest = $guestDAO->getGuest();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/guests.php";

        //Validate Guest Form Data
        if($guest->getId() <= 0) {
            throw new Exception("Id de hóspede inválido!");
        }

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/guests.php?act=search-guest-by-id&id=" . urlencode(json_encode(["id" => $guest->getId()]));

        if(!validateCPF($guest->getCpf())) {
            throw new Exception("CPF inválido!");
        }

        //Accommodation Association Check  
        if($guestDAO->accommodationAssociationCheckByCpf()){
            throw new Exception("Não é possível deletar um hóspede que já esteja associado a alguma hospedagem.");
        }

        //Delete Guest
        if(!$guestDAO->deleteById()) {
            throw new Exception("Não foi possível deletar os dados do hóspede.");
        }

        //Response
        $_SESSION['msg-success'] = "Dados do hóspede deletados com sucesso!"; 
        header("Location: ../view/pages/guests.php");
    }   
}