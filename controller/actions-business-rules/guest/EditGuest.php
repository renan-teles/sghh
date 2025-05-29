<?php

require_once __DIR__ . "/../Action.php";

class EditGuest implements Action {
    public function execute(ClassDAO $guestDAO): void{
        $guest = $guestDAO->getGuest();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/guests.php";

        if($guest->getId() <= 0) {
            throw new Exception("Id de hóspede inválido!");
        }

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/guests.php?act=search-guest-by-id&id=" . urlencode(json_encode(["id" => $guest->getId()]));

        if(!filter_var($guest->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido!");
        }
        
        if(!validateName($guest->getName())) {
            throw new Exception("Nome inválido!");
        }

        if(!validateCPF($guest->getCpf())) {
            throw new Exception("CPF inválido!");
        }

        if(!empty($guest->getCpfResponsible())){
            if(!validateCPF($guest->getCpfResponsible())) {
                throw new Exception("CPF de Responsável inválido!");
            }
        }

        if(!validateTelephone($guest->getTelephone())) {
            throw new Exception("Telefone inválido!");
        }
        
        if(!validateDate($guest->getDateBirth())) {
            throw new Exception("Data de nascimento inválida!");
        }
  
        if(!$guestDAO->editById()) {
            throw new Exception("Não foi possível editar os dados do hóspede.");
        }

        $_SESSION['msg-success'] = "Dados do Hóspede editados com sucesso!"; 
        header("Location: ../view/pages/guests.php?act=search-guest-by-id&id=" . urlencode(json_encode(["id" => $guest->getId()])));
    }   
}