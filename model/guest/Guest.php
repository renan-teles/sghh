<?php

require_once __DIR__ . "/../person/Person.php";

class Guest extends Person {
    private string $cpf;
    private string $cpf_responsible;
    private string $telephone;
    private string $date_birth;

    public function __construct(int $id, string $name, string $email, string $cpf, string $cpfResponsible, string $telephone, string $date_birth){
        parent::__construct($id, $name, $email);
        $this->cpf = $cpf;
        $this->cpf_responsible = $cpfResponsible;
        $this->telephone = $telephone;
        $this->date_birth = $date_birth;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function setCpf(string $cpf){
        $this->cpf = $cpf;
    }
   
    public function getCpfResponsible(){
        return $this->cpf_responsible;
    }

    public function setCpfResponsible(string $cpfResponsible){
        $this->cpf_responsible = $cpfResponsible;
    }
    
    public function getTelephone(){
        return $this->telephone;
    }

    public function setTelephone(string $telephone){
        $this->telephone = $telephone;
    }
    
    public function getDateBirth(){
        return $this->date_birth;
    }

    public function setDateBirth(string $date_birth){
        $this->date_birth = $date_birth;
    }
}