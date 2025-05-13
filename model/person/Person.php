<?php

abstract class Person {
    protected int $id;
    protected string $name;
    protected string $email;

    public function __construct(int $id, string $name, string $email){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId(){
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }
    
    public function getName(){
        return $this->name;
    }

    public function setName(string $name){
        $this->name = $name;
    }
  
    public function getEmail(){
        return $this->email;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }
}