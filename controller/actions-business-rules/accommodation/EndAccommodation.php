<?php

require_once __DIR__ . "/../Action.php";

class EndAccommodation implements Action {
    public function execute(ClassDAO $accommodationDAO): void {
        $accommodation = $accommodationDAO->getAccommodation();
          
        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/accommodations.php";

        if($accommodation->getGuestAccommodation()->getIdAccommodation() <= 0) {
            throw new Exception("Id de hospedagem inválido!");
        }

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/accommodations.php?act=search-accommodation-after-cancel-or-end&id=" . urlencode(json_encode(["id" => $accommodation->getGuestAccommodation()->getIdAccommodation()]));
     
        /*
        $status = $accommodationDAO->checkStatusAccommodationById(3);
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
        header("Location: ../view/pages/accommodations.php?act=search-accommodation-after-cancel-or-end&id=" . urlencode(json_encode(["id" => $accommodation->getGuestAccommodation()->getIdAccommodation()])));
    }
}