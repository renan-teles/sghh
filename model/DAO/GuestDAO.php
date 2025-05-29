<?php

require_once __DIR__ . "/ClassDAO.php";

class GuestDAO extends ClassDAO {
    private Guest $guest;
   
    public function __construct(Guest $guest, PDOConnection $pdoConnection) {
        $this->guest = $guest;
        parent::__construct($pdoConnection);
    }

    public function accommodationAssociationCheckByCpf(): array|bool {
        try {
            $cpf = $this->getGuest()->getCpf();

            $pdo = $this->getConnectionPDO();
            
            $sql = "SELECT 1 FROM guest_accommodation
                    WHERE
                        cpf_guest = :cpf
                    LIMIT 1";

            $query = $pdo->prepare($sql);
            $query->bindParam(':cpf', $cpf);
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function checkExistenceByNameAndEmailAndCpf(): array|bool {
        try {
            $name = $this->getGuest()->getName();
            $email = $this->getGuest()->getEmail();
            $cpf = $this->getGuest()->getCpf();
            $telephone = $this->getGuest()->getTelephone();

            $pdo = $this->getConnectionPDO();
            
            $sql = "SELECT  1 FROM guests
                    WHERE
                        name = :name 
                    OR
                        email = :email 
                    OR
                        cpf = :cpf
                    OR telephone = :telephone 
                    LIMIT 1";
         
            $query = $pdo->prepare($sql);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':cpf', $cpf);
            $query->bindParam(':telephone', $telephone);
            
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function customSearch(array $columns, array $conditions, array $complements): array|bool {
        try {
            $pdo = $this->getConnectionPDO();
        
            $conditionsSymbols = [
                "eq" => "="
            ];
    
            $whereClauses = [];
            $values = [];
    
            for ($i = 0; $i < count($columns); $i++) {
                $column = $columns[$i];
                $operator = $conditionsSymbols[$conditions[$i]];
               
                $whereClauses[] = "$column $operator ?";
                $values[] = $complements[$i];
            }
    
            $whereSQL = count($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";
    
            $sql = "SELECT * FROM guests $whereSQL";
    
            $query = $pdo->prepare($sql);
            $query->execute($values);
            
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result ?: [];
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function deleteById(): bool {
        try {
            $id = $this->getGuest()->getId();

            $pdo = $this->getConnectionPDO();

            $sql = "DELETE FROM guests WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function editById(): bool {
        try {
            $id = $this->getGuest()->getId();
            $name = $this->getGuest()->getName();
            $email = $this->getGuest()->getEmail();
            $cpf = $this->getGuest()->getCpf();
            $cpfResponsible = $this->getGuest()->getCpfResponsible();
            $telephone = $this->getGuest()->getTelephone();
            $dateBirth = $this->getGuest()->getDateBirth();

            $pdo = $this->getConnectionPDO();
        
            $sql = "UPDATE 
                        guests 
                    SET 
                        name = :name, 
                        email = :email,
                        cpf = :cpf,
                        cpf_responsible = :cpfResponsible,
                        telephone = :telephone,
                        date_birth = :dateBirth
                    WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':cpf', $cpf);
            $query->bindParam(':cpfResponsible', $cpfResponsible);
            $query->bindParam(':telephone', $telephone);
            $query->bindParam(':dateBirth', $dateBirth);
            
            $query->execute();
            
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function getGuest(): Guest{
        return $this->guest;
    }

    public function register(): bool {
        try {
            $name = $this->getGuest()->getName();
            $email = $this->getGuest()->getEmail();
            $cpf = $this->getGuest()->getCpf();
            $cpfResponsible = $this->getGuest()->getCpfResponsible();
            $telephone = $this->getGuest()->getTelephone();
            $dateBirth = $this->getGuest()->getDateBirth();

            $pdo = $this->getConnectionPDO();
            
            $sql = "INSERT INTO 
                        guests (name, email, cpf, cpf_responsible, telephone, date_birth) 
                    VALUES 
                        (:name, :email, :cpf, :cpf_responsible, :telephone, :dateBirth)";
         
            $query = $pdo->prepare($sql);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':cpf', $cpf);
            $query->bindParam(':cpf_responsible', $cpfResponsible);
            $query->bindParam(':telephone', $telephone);
            $query->bindParam(':dateBirth', $dateBirth);
            
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function searchByEmail(): array|bool{
        try {        
            $email = $this->getGuest()->getEmail();

            $pdo = $this->getConnectionPDO();
    
            $sql = "SELECT * FROM guests WHERE email = :email LIMIT 1";
       
            $query = $pdo->prepare($sql);
            $query->bindParam(':email', $email);

            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function searchById(): array|bool{
        try {        
            $id = $this->getGuest()->getId();

            $pdo = $this->getConnectionPDO();
    
            $sql = "SELECT * FROM guests WHERE id = :id LIMIT 1";
       
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $id);

            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }
}