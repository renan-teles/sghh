<?php

class SearchAccommodationAfterCancelOrEnd {
    public function execute(ClassDAO $accommodationDAO){
        $id = $accommodationDAO->getAccommodation()->getGuestAccommodation()->getId();

        if (!$id || $id <= 0) {
            throw new Exception("Parâmetro de busca inválido!");
        }

        return $accommodationDAO->searchById();
    }
}