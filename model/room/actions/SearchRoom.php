<?php

class SearchRoom {
    public function execute(classDAO $roomDAO){
        $number = $roomDAO->getRoom()->getNumber();

        if (!$number || filter_var($number, FILTER_VALIDATE_INT) === false || $number <= 0) {
            throw new Exception("Parâmetro de busca inválido!");
        }
    
        return $roomDAO->searchByNumber();
    }
}