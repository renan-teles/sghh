<?php

require_once __DIR__ . "/../../interface/Action.php";

class RegisterRoom implements Action {
    public function execute(ClassDAO $roomDAO): void {
        $room = $roomDAO->getRoom();

        if($room->getNumber() <= 0) {
            throw new Exception("Número de quarto inválido!");
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
        if($room->getIsAvailable() < 0 || $room->getIsAvailable() > 1) {
            throw new Exception("Disponibilidade de quarto inválida!");
        }

        if(!$roomDAO->register()) {
            throw new Exception("Não foi possível cadastrar o quarto.");
        }

        $_SESSION['msg-success'] = "Quarto cadastrado com sucesso!"; 
        header("Location: ../view/pages/rooms.php?act=search-room&n=" . urlencode(json_encode(["n" => $room->getNumber()])));
    }
}