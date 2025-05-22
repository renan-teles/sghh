<?php

require_once __DIR__ . "/../../interface/Action.php";

class RegisterAccommodation implements Action {
    public function execute(ClassDAO $accommodationDAO): void {
        $accommodation = $accommodationDAO->getAccommodation();

        $accommodation->getStatusAccommodation()->setId(1);        
        $accommodation->getStatusPayment()->setId(2);

        $cpfs = $accommodation->getGuestAccommodation()->getCpfGuests();
        for($i = 0; $i < count($cpfs); $i++) {
            if(!validateCPF($cpfs[$i])) {
                throw new Exception("CPF'S inválidos!");
            }
        }

        $room = $accommodation->getRoom();
        if($room->getNumber() <= 0) {
            throw new Exception("Número de quarto inválido!");
        }
        if($room->getCapacity() <= 0) {
            throw new Exception("Capacidade do quarto inválida!");
        }
        if($room->getDailyPrice() <= 0.0) {
            throw new Exception("Preço da diária de quarto inválida!");
        }
        if(count($cpfs) > $room->getCapacity()){
            throw new Exception("A Capacidade de hóspedes no quarto foi ultrapassada!");
        }
        if(!validateDate($accommodation->getDateCheckin())) {
            throw new Exception("Data de chekin inválida!");
        }
        if(!validateDate($accommodation->getDateCheckout())) {
            throw new Exception("Data de chekout inválida!");
        }

        /**
        * @throws Exception
        */
        $accommodation->calculateTotalValue();

        if($accommodation->getTotalValue() <= 0){
            throw new Exception("Valor total inválido!");
        }

        $status = $accommodationDAO->checkExistenceGuests();
        if($status === []) {
            throw new Exception("Hóspede(s) não cadastrado(s) no sistema!");
        }
        if($status === false) {
            throw new Exception("Erro ao fazer verificação de cadastro de hóspedes!");
        }
        
        $status = $accommodationDAO->checkRoomAvailability();
        if($status) {
            throw new Exception("O quarto escolhido para a hospedagem não esta disponível!");
        }
        if($status === false) {
            throw new Exception("Erro ao fazer verificação de disponibilidade de quarto.");
        }

        if(!$accommodationDAO->register()) {
            throw new Exception("Não foi possível cadastrar a hospedagem.");
        }

        $_SESSION['msg-success'] = "Hóspedagem realizada com sucesso!"; 
        header("Location: ../view/pages/accommodations.php?act=search-accommodation-after-insert-or-update&nr=" . urlencode(json_encode(["nr" => $room->getNumber()])));
    }
}