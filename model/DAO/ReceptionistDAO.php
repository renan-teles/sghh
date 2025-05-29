<?php

require_once __DIR__ . "/ClassDAO.php";

class ReceptionistDAO extends ClassDAO {
    private Receptionist $receptionist;

    public function __construct(Receptionist $receptionist, PDOConnection $pdoConnection) {
        $this->receptionist = $receptionist;
        parent::__construct($pdoConnection);
    }

    public function checkExistenceByNameAndEmail(): array|bool {
        try {
            $name = $this->getReceptionist()->getName();
            $email = $this->getReceptionist()->getEmail();

            $pdo = $this->getConnectionPDO();
            
            $sql = "SELECT 1 FROM receptionists
                    WHERE
                        name = :name 
                    OR
                        email = :email  
                    LIMIT 1";
         
            $query = $pdo->prepare($sql);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function deleteById(): bool {
        try {
            $id = $this->getReceptionist()->getId();

            $pdo = $this->getConnectionPDO();

            $sql = "DELETE FROM receptionists WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function editNameAndEmailById(): bool {
        try {
            $id = $this->getReceptionist()->getId();
            $name = $this->getReceptionist()->getName();
            $email = $this->getReceptionist()->getEmail();

            $pdo = $this->getConnectionPDO();
        
            $sql = "UPDATE receptionists SET name = :name, email = :email WHERE id = :id";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':name', $name);
            $query->bindValue(':email', $email);

            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function editPasswordById(): bool {
        try {
            $id = $this->getReceptionist()->getId();
            $newPassword =  $this->getReceptionist()->getNewPassword();
    
            $pdo = $this->getConnectionPDO();
        
            $sql = "UPDATE receptionists SET password = :password WHERE id = :id";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':password', $newPassword);
    
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function getReceptionist(): Receptionist {
        return $this->receptionist;
    }

    public function register(): bool {
        try {
            $name = $this->getReceptionist()->getName();
            $email = $this->getReceptionist()->getEmail();
            $password = $this->getReceptionist()->getPassword();
            
            $pdo = $this->getConnectionPDO();
           
            $sql = "INSERT INTO 
                        receptionists (name, email, password) 
                    VALUES 
                        (:name, :email, :password)";
           
            $query = $pdo->prepare($sql);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password);
           
            $query->execute();
           
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }
    
    public function searchByEmail(): bool|array {
        try {
            $email = $this->getReceptionist()->getEmail();

            $pdo = $this->getConnectionPDO();
            
            $sql = "SELECT * FROM receptionists
                    WHERE
                        email = :email  
                    LIMIT 1";
         
            $query = $pdo->prepare($sql);
            $query->bindParam(':email', $email);
            
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function searchById(): bool|array {
        try {
            $id = $this->getReceptionist()->getId();

            $pdo = $this->getConnectionPDO();
            
            $sql = "SELECT * FROM receptionists
                    WHERE
                        id = :id  
                    LIMIT 1";
         
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $id);
            
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }
}