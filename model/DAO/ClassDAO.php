<?php

abstract class ClassDAO {
    protected PDOConnection $pdoConnection;

    public function __construct(PDOConnection $pdoConnection) {
        $this->pdoConnection = $pdoConnection;
    }

    public function getConnectionPDO(): PDO {
        return $this->pdoConnection->getPDO();
    }
}