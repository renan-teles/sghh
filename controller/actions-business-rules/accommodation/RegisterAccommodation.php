<?php

require_once __DIR__ . "/../Action.php";

class RegisterAccommodation implements Action {
    public function execute(ClassDAO $accommodationDAO): void {
        $accommodation = $accommodationDAO->getAccommodation();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/accommodations.php";

        //Set Accommodation
        $accommodation->getStatusAccommodation()->setId(1);//Ativa   
        $accommodation->getStatusPayment()->setId(2);//Pendente

        //Validate CPF's Guests
        $cpfs = $accommodation->getGuestAccommodation()->getCpfGuests();
        for($i = 0; $i < count($cpfs); $i++) {
            if(!validateCPF($cpfs[$i])) {
                throw new Exception("CPF(S) inválido(s)!");
            }
        }

        //Validate Room Form Data 
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

        //Validate Chekin and Checkout
        $today = new DateTime();
        $checkin = new DateTime($accommodation->getDateCheckin());
        $checkout = new DateTime($accommodation->getDateCheckout());
        
        $today->setTime(0, 0);
        $checkin->setTime(0, 0);
        $checkout->setTime(0, 0);

        if ($checkin < $today) {
            throw new Exception("O checkin não pode ser anterior à data de hoje.");
        }
        if ($checkout < $today) {
            throw new Exception("O checkout não pode ser anterior à data de hoje.");
        }
        if ($checkout < $checkin) {
            throw new Exception("O checkout não pode ser anterior ao checkin.");
        }

        //Calculate Total Value
        $numberOfDays = $checkin->diff($checkout)->days;
        if($numberOfDays === 0) $numberOfDays = 1;
        $accommodation->calculateTotalValue($numberOfDays);

        $status = null;

        //Check Guests Existence 
        $status = $accommodationDAO->checkExistenceGuestsByCpfs();
        if($status === []) {
            throw new Exception("Dados de hóspede(s) não cadastrado(s) no sistema!");
        }
        if($status === false) {
            throw new Exception("Erro ao fazer verificação de cadastro de dados de hóspede(s)!");
        }
        
        //Check Room Availability
        $status = $accommodationDAO->checkRoomAvailabilityByNumber();
        if($status) {
            throw new Exception("O quarto escolhido para a hospedagem esta ocupado ou indisponível!");
        }
        if($status === false) {
            throw new Exception("Erro ao fazer verificação de disponibilidade de quarto.");
        }

        //Register Accommodation
        if(!$accommodationDAO->register()) {
            throw new Exception("Não foi possível cadastrar as informações da hospedagem.");
        }

        //Response
        $_SESSION['msg-success'] = "Informações da hóspedagem cadastradas com sucesso!"; 
        header("Location: ../view/pages/accommodations.php?act=search-accommodation-after-insert-or-update&nr=" . urlencode(json_encode(["nr" => $room->getNumber()])));
    }
}