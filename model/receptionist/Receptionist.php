<?php

require_once __DIR__ . "/../person/Person.php";

class Receptionist extends Person {
    private string $password;
    private string $newPassword;

    public function __construct(int $id, string $name, string $email, string $password, string $newPassword){
        parent::__construct($id, $name, $email);
        $this->password = $password;
        $this->newPassword = $newPassword;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function getNewPassword(): string {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword): void {
        $this->newPassword = $newPassword;
    }
}