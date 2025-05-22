<?php

require_once __DIR__ . "/../../interface/Action.php";

class CancelAccommodation implements Action {
    public function execute(ClassDAO $accommodationDAO): void {
        $accommodation = $accommodationDAO->getAccommodation();
        
        if($accommodation->getGuestAccommodation()->getId() <= 0) {
            throw new Exception("Id de hospedagem inválido!");
        }

        /*
        $status = $accommodationDAO->checkStatusAccommodation(2);
        if($status) {
            throw new Exception("Não é possível cancelar uma hospedagem já finalizada.");
        }
        if($status === false){
            throw new Exception("Não é possível foi possível fazer a verificação de status de hospedagem.");
        }
        */
        
        if(!$accommodationDAO->cancelAccommodation()) {
            throw new Exception("Não foi possível cancelar a hospedagem.");
        }

        //Response
        $_SESSION['msg-success'] = "Hóspedagem cancelada com sucesso!"; 
        header("Location: ../view/pages/accommodations.php?act=search-accommodation-after-cancel-or-end&id=" . urlencode(json_encode(["id" => $accommodation->getGuestAccommodation()->getId()])));
    }
}