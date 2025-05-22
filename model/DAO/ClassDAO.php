<?php

abstract class ClassDAO {
    protected DatabaseConnection $databaseConnection;

    public function __construct(DatabaseConnection $databaseConnection) {
        $this->databaseConnection = $databaseConnection;
    }

    public function getDatabaseConnection(): DatabaseConnection {
        return $this->databaseConnection;
    }
}