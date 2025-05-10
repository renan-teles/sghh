<?php

require_once __DIR__ . "/../../interface/Action.php";

class EditRoom implements Action {
    public function execute(ClassDAO $roomDAO): void {
        $room = $roomDAO->getRoom();

        if($room->getId() <= 0) {
            throw new Exception("Id de quarto inválido!");
        }
        if($room->getNumber() <= 0) {
            throw new Exception("Número de quarto inválido!");
        }
        if($room->getFloor() <= 0) {
            throw new Exception("Andar do quarto inválido!");
        }
        if($room->getCapacity() <= 0) {
            throw new Exception("Capacidade do quarto inválida!");
        }
        if($room->getType() <= 0) {
            throw new Exception("Tipo de quarto inválido!");
        }
        if($room->getDailyPrice() <= 0.0) {
            throw new Exception("Preço da diária de quarto inválida!");
        }

        if(!$roomDAO->edit()) {
            throw new Exception("Não foi possível editar o quarto.");
        }

        $_SESSION['msg-success'] = "Quarto editado com sucesso!"; 
        header("Location: ../view/pages/rooms.php?n=" . urlencode(json_encode(["n" => $room->getNumber()])));
    }
}