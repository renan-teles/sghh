<?php

class PDOConnection {
    private string $dns;
    private string $user;
    private string $pass;
    private PDO $pdo;

    public function __construct(string $dns, string $user, string $pass) {
        $this->dns = $dns;
        $this->user = $user;
        $this->pass = $pass;
    }

    public function getDns(): string {
        return $this->dns;
    }

    public function getUser(): string {
        return $this->user;
    }
    
    public function getPass(): string {
        return $this->pass;
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }

    public function connect(): void {
        try {
            $pdo = new PDO($this->getDns(), $this->getUser(), $this->getPass(), [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        } catch (PDOException $exc) {
            throw new Exception ("Falha ao realizar conexão com o banco de dados :(");
        }
    }
}