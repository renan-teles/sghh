<?php

require_once __DIR__ . "/../Action.php";

class RegisterRoom implements Action {
    public function execute(ClassDAO $roomDAO): void {
        $room = $roomDAO->getRoom();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/rooms.php";

        //Validate Room Form Data
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
        if($room->getAvailability()->getId() < 0 || $room->getAvailability()->getId() > 3) {
            throw new Exception("Disponibilidade de quarto inválida!");
        }

        //Check Room Existence
        $status = $roomDAO->checkExistenceByNumber();
        if($status) {
            throw new Exception("Informações de quarto já cadastradas no sistema!");
        }
        if($status === false) {
            throw new Exception("Erro ao fazer verificação de existência de informações do quarto!");
        }
        
        //Register Room
        if(!$roomDAO->register()) {
            throw new Exception("Não foi possível cadastrar as informações do quarto.");
        }

        //Response
        $_SESSION['msg-success'] = "Informações de quarto cadastradras com sucesso!"; 
        header("Location: ../view/pages/rooms.php?act=search-room-by-number&n=" . urlencode(json_encode(["n" => $room->getNumber()])));
    }
}