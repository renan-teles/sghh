<?php

require_once __DIR__ . "/../Action.php";

class RegisterGuest implements Action {
    public function execute(ClassDAO $guestDAO): void{
        $guest = $guestDAO->getGuest();

        $_SESSION['url_redirect_after_error_or_exception'] = "../view/pages/guests.php";

        if(!validateName($guest->getName())) {
            throw new Exception("Nome inválido!");
        }

        if(!filter_var($guest->getEmail(), FILTER_VALIDATE_EMAIL)) {
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

        $status = $guestDAO->checkExistenceByNameAndEmailAndCpf();
        
        if($status){
            throw new Exception("Hóspede já cadastrado no sistema!");
        }

        if($status === false) {
            throw new Exception("Erro ao verificar existência de hóspede no sistema!");
        }

        if(!$guestDAO->register()) {
            throw new Exception("Não foi possível cadastrar os dados do hóspede.");
        }

        $_SESSION['msg-success'] = "Dados do hóspede cadastrados com sucesso!"; 
        header("Location: ../view/pages/guests.php?act=search-guest-by-email&e=" . urlencode(json_encode(["e" => $guest->getEmail()])));
    }   
}