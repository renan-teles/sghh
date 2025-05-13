<?php

require_once __DIR__ . "/../../interface/Action.php";

class RegisterGuest implements Action {
    public function execute(ClassDAO $guestDAO): void{
        $guest = $guestDAO->getGuest();

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

        $status = $guestDAO->verifyExist();
        if($status === false) {
            throw new Exception("Erro ao verificar existência de hóspede no banco de dados!");
        }
        if($status){
            throw new Exception("Hóspede já cadastrado!");
        }
  
        if(!$guestDAO->register()) {
            throw new Exception("Não foi possível cadastrar o hóspede.");
        }

        $_SESSION['msg-success'] = "Hóspede cadastrado com sucesso!"; 
        header("Location: ../view/pages/guests.php?act=search-guest&e=" . urlencode(json_encode(["e" => $guest->getEmail()])));
    }   
}