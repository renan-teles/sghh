<?php

require_once __DIR__ . "/../Action.php";

class EditAccommodation implements Action {
    public function execute(ClassDAO $accommodationDAO): void {
        $accommodation = $accommodationDAO->getAccommodation();

        $room = $accommodation->getRoom();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/accommodations.php";

        if($room->getNumber() <= 0) {
            throw new Exception("Número de quarto inválido!");
        }

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/accommodations.php?act=search-accommodation-after-insert-or-update&nr=" . urlencode(json_encode(["nr" => $room->getNumber()]));

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

        $numberOfDays = $checkin->diff($checkout)->days;
        if($numberOfDays === 0) $numberOfDays = 1;

        $accommodation->calculateTotalValue($numberOfDays);

        if(!$accommodationDAO->editById()) {
            throw new Exception("Não foi possível editar as informações da hospedagem.");
        }

        $_SESSION['msg-success'] = "Informações da hóspedagem editadas com sucesso!"; 
        header("Location: ../view/pages/accommodations.php?act=search-accommodation-after-insert-or-update&nr=" . urlencode(json_encode(["nr" => $room->getNumber()])));
    }
}