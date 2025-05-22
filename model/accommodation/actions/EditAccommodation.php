<?php


require_once __DIR__ . "/../../interface/Action.php";

class EditAccommodation implements Action {
    public function execute(ClassDAO $accommodationDAO): void {
        $accommodation = $accommodationDAO->getAccommodation();

        //ROOM Accomodation
        $room = $accommodation->getRoom();

        //Validates
        if($room->getNumber() <= 0) {
            throw new Exception("Número de quarto inválido!");
        }

        if($room->getCapacity() <= 0) {
            throw new Exception("Capacidade do quarto inválida!");
        }

        if($room->getDailyPrice() <= 0.0) {
            throw new Exception("Preço da diária de quarto inválida!");
        }

        if(!validateDate($accommodation->getDateCheckin())) {
            throw new Exception("Data de chekin inválida!");
        }
        
        if(!validateDate($accommodation->getDateCheckout())) {
            throw new Exception("Data de chekout inválida!");
        }

        //Calculate Total Value
        /**
        * @throws Exception
        */
        $accommodation->calculateTotalValue();

        if($accommodation->getTotalValue() <= 0){
            throw new Exception("Valor total inválido!");
        }

        //Execute Query
        if(!$accommodationDAO->edit()) {
            throw new Exception("Não foi possível editar a hospedagem.");
        }

        //Response
        $_SESSION['msg-success'] = "Hóspedagem editada com sucesso!"; 
        header("Location: ../view/pages/accommodations.php?act=search-accommodation-after-insert-or-update&nr=" . urlencode(json_encode(["nr" => $room->getNumber()])));
    }
}