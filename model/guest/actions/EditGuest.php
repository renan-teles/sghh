<?php

require_once __DIR__ . "/../../interface/Action.php";

class EditGuest implements Action {
    public function execute(ClassDAO $guestDAO): void{
        $guest = $guestDAO->getGuest();

        if($guest->getId() <= 0) {
            throw new Exception("Id de hóspede inválido!");
        }
        if(!validateName($guest->getName())) {
            throw new Exception("Nome inválido!");
        }
        if(!validateEmail($guest->getEmail())) {
            throw new Exception("Email inválido!");
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
  
        if(!$guestDAO->edit()) {
            throw new Exception("Não foi possível editar o hóspede.");
        }

        $_SESSION['msg-success'] = "Hóspede editado com sucesso!"; 
        header("Location: ../view/pages/guests.php?act=search-guest&e=" . urlencode(json_encode(["e" => $guest->getEmail()])));
    }   
}