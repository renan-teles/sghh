<?php

require_once __DIR__ . "/../../interface/Action.php";

class DeleteRoom implements Action {
    public function execute(ClassDAO $roomDAO): void {
        $room = $roomDAO->getRoom();

        if($room->getId() <= 0) {
            throw new Exception("Id de quarto inválido!");
        }

        if(!$roomDAO->delete()) {
            throw new Exception("Não foi possível excluir o quarto.");
        }

        $_SESSION['msg-success'] = "Quarto excluído com sucesso!"; 
        header("Location: ../view/pages/rooms.php");
    }
}