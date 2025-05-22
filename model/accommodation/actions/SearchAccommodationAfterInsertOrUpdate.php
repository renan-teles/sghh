<?php

class SearchAccommodationAfterInsertOrUpdate {
    public function execute(ClassDAO $accommodationDAO){
        $number = $accommodationDAO->getAccommodation()->getRoom()->getNumber();

        if (!$number || $number <= 0) {
            throw new Exception("Parâmetro de busca inválido!");
        }

        return $accommodationDAO->searchByNumberRoom();
    }
}