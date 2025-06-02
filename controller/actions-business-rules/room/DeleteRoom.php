<?php

require_once __DIR__ . "/../Action.php";

class DeleteRoom implements Action {
    public function execute(ClassDAO $roomDAO): void {
        $room = $roomDAO->getRoom();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/rooms.php";

        //Validate Room Form Data
        if($room->getNumber() <= 0) {
            throw new Exception("Número de quarto inválido!");
        }

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/rooms.php?act=search-room-by-number&n=" . urlencode(json_encode(["n" => $room->getNumber()]));

        if($room->getId() <= 0) {
            throw new Exception("Id de quarto inválido!");
        }

        //Accommodation Association Check  
        if($roomDAO->accommodationAssociationCheckByNumber()){
            throw new Exception("Não é possível deletar um quarto que já esteja associado a alguma hospedagem.");
        }

        //Delete Room
        if(!$roomDAO->deleteById()) {
            throw new Exception("Não foi possível deletar as informações do quarto.");
        }

        //Response
        $_SESSION['msg-success'] = "Informações do quarto deletadas com sucesso!"; 
        header("Location: ../view/pages/rooms.php");
    }
}