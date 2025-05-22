<?php

require_once __DIR__ . "/../../interface/Action.php";

class EndAccommodation implements Action {
    public function execute(ClassDAO $accommodationDAO): void {
        $accommodation = $accommodationDAO->getAccommodation();
          
        if($accommodation->getGuestAccommodation()->getId() <= 0) {
            throw new Exception("Id de hospedagem inválido!");
        }

        /*
        $status = $accommodationDAO->checkStatusAccommodation(3);
        if($status) {
            throw new Exception("Não é possível finalizar uma hospedagem já cancelada.");
        }
        if($status === false){
            throw new Exception("Não é possível foi possível fazer a verificação de status de hospedagem.");
        }
        */

        if(!$accommodationDAO->endAccommodation()) {
            throw new Exception("Não foi possível finalizar a hospedagem.");
        }

        $_SESSION['msg-success'] = "Hóspedagem finalizada com sucesso!"; 
        header("Location: ../view/pages/accommodations.php?act=search-accommodation-after-cancel-or-end&id=" . urlencode(json_encode(["id" => $accommodation->getGuestAccommodation()->getId()])));
    }
}