<?php

require_once __DIR__ . "/../Action.php";

class EditRoom implements Action {
    public function execute(ClassDAO $roomDAO): void {
        $room = $roomDAO->getRoom();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/rooms.php";

        if($room->getNumber() <= 0) {
            throw new Exception("Número de quarto inválido!");
        }

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/rooms.php?act=search-room-by-number&n=" . urlencode(json_encode(["n" => $room->getNumber()]));

        if($room->getId() <= 0) {
            throw new Exception("Id de quarto inválido!");
        }

        if($room->getFloor() <= 0) {
            throw new Exception("Andar do quarto inválido!");
        }

        if($room->getCapacity() <= 0) {
            throw new Exception("Capacidade do quarto inválida!");
        }

        if($room->getType()->getId() <= 0) {
            throw new Exception("Tipo de quarto inválido!");
        }

        if($room->getDailyPrice() <= 0.0) {
            throw new Exception("Preço da diária de quarto inválida!");
        }

        if($room->getAvailability()->getId() < 0 || $room->getAvailability()->getId() > 3) {
            throw new Exception("Disponibilidade de quarto inválida!");
        }

        if($roomDAO->checkRoomAvailabilityById()){
            throw new Exception("Não é possível editar informações de quartos que estejam ocupados.");
        }

        if(!$roomDAO->editById()) {
            throw new Exception("Não foi possível editar as informações do quarto.");
        }

        $_SESSION['msg-success'] = "Informações do quarto editadas com sucesso!"; 
        header("Location: ../view/pages/rooms.php?act=search-room-by-number&n=" . urlencode(json_encode(["n" => $room->getNumber()])));
    }
}