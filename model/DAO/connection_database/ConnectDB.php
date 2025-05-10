<?php

require_once __DIR__ . "./interface/DatabaseConnection.php";

class ConnectDB implements DatabaseConnection {
    private DatabaseConnection $databaseConnection;

    public function __construct(DatabaseConnection $databaseConnection) {
        $this->databaseConnection = $databaseConnection;
    }

    /**
    * @throws Exception
    */
    public function connect(): void {
        $this->databaseConnection->connect();
    }

    public function getDatabaseConnection(): PDO {
        return $this->databaseConnection->getDatabaseConnection();
    }
}