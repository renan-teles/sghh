<?php

abstract class ClassDAO {
    private DatabaseConnection $databaseConnection;

    public function __construct(DatabaseConnection $databaseConnection) {
        $this->databaseConnection = $databaseConnection;
    }

    public function getDatabaseConnection(): DatabaseConnection {
        return $this->databaseConnection;
    }

    public function register(): bool {}
    
    public function edit(): bool {}
    
    public function delete(): bool {}
}