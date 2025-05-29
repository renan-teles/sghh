<?php

require_once __DIR__ . "/../Action.php";

class SearchRoomByNumber {
    public function execute(classDAO $roomDAO){
        $number = $roomDAO->getRoom()->getNumber();

        if (!$number || $number <= 0) {
            throw new Exception("Parâmetro de busca inválido!");
        }

        return $roomDAO->searchByNumber();
    }
}