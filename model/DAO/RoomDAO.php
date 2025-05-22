<?php

require_once __DIR__ . "/ClassDAO.php";

class RoomDAO extends ClassDAO {
    private Room $room;

    public function __construct(Room $room, DatabaseConnection $databaseConnection) {
        $this->room = $room;
        parent::__construct($databaseConnection);
    }

    public function getRoom(): Room {
        return $this->room;
    }

    public function checkExistence(): bool|array {
        try {
            $number = $this->getRoom()->getNumber();
         
            $pdo = $this->getDatabaseConnection()->getDatabaseConnection();
            
            $sql = "SELECT 
                        1 
                    FROM 
                        rooms
                    WHERE
                        number = :number
                    LIMIT 1";
         
            $query = $pdo->prepare($sql);
            $query->bindParam(':number', $number);
            
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function register(): bool {
        try {
            $idTypeRoom = $this->getRoom()->getType()->getId();
            $number = $this->getRoom()->getNumber();
            $floor = $this->getRoom()->getFloor();
            $capacity = $this->getRoom()->getCapacity();
            $dailyPrice = $this->getRoom()->getDailyPrice();
            $isAvailable = $this->getRoom()->getIsAvailable();
            $pdo = $this->getDatabaseConnection()->getDatabaseConnection();
           
           $sql = "INSERT INTO 
                        rooms (id_type_room, number, floor, capacity, daily_price, is_available) 
                    VALUES 
                        (:idTypeRoom, :number, :floor, :capacity, :dailyPrice, :isAvailable)";
           
           $query = $pdo->prepare($sql);
            $query->bindParam(':idTypeRoom', $idTypeRoom);
            $query->bindParam(':number', $number);
            $query->bindParam(':floor', $floor);
            $query->bindParam(':capacity', $capacity);
            $query->bindParam(':dailyPrice', $dailyPrice);
            $query->bindParam(':isAvailable', $isAvailable);
           
            $query->execute();
           
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            exit;
            return false;
        }
    }

    public function edit(): bool {
        try {
            $id = $this->getRoom()->getId();
            $idTypeRoom = $this->getRoom()->getType()->getId();
            $number = $this->getRoom()->getNumber();
            $floor = $this->getRoom()->getFloor();
            $capacity = $this->getRoom()->getCapacity();
            $dailyPrice = $this->getRoom()->getDailyPrice();
            $pdo = $this->getDatabaseConnection()->getDatabaseConnection();
        
            $sql = "UPDATE 
                        rooms 
                    SET 
                        id_type_room = :idTypeRoom, 
                        number = :number,
                        floor = :floor,
                        capacity = :capacity,
                        daily_price = :dailyPrice
                    WHERE id = :id";
        
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':idTypeRoom', $idTypeRoom);
            $query->bindParam(':number', $number);
            $query->bindParam(':floor', $floor);
            $query->bindParam(':capacity', $capacity);
            $query->bindParam(':dailyPrice', $dailyPrice);
            
            $query->execute();
            
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function delete(): bool {
        try {
            $id = $this->getRoom()->getId();

            $pdo = $this->getDatabaseConnection()->getDatabaseConnection();

            $sql = "DELETE FROM rooms WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function customSearch(array $columns, array $conditions, array $complements): array|bool {
        try {
            $pdo = $this->getDatabaseConnection()->getDatabaseConnection();
    
            $conditionsSymbols = [
                "lt" => "<",
                "gt" => ">",
                "lte" => "<=",
                "gte" => ">=",
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
    
            $sql = "SELECT
                        r.id, tr.type_room, r.number, r.floor, r.capacity, r.daily_price, r.is_available
                    FROM
                        rooms r
                    INNER JOIN types_rooms tr ON r.id_type_room = tr.id
                    $whereSQL 
                    ORDER BY r.number";
    
            $query = $pdo->prepare($sql);
            $query->execute($values);
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result ?: [];
        } catch (PDOException $exc) {
            return false;
        }
    }
    
    public function searchByNumber(): array|bool{
        try {        
            $number = $this->getRoom()->getNumber();

            $pdo = $this->getDatabaseConnection()->getDatabaseConnection();
    
            $sql = "SELECT 
                        r.id, tr.type_room, r.number, r.floor, r.capacity, r.daily_price, r.is_available 
                    FROM 
                        rooms r 
                    INNER JOIN types_rooms tr on r.id_type_room = tr.id 
                    WHERE number = :number 
                    LIMIT 1";
       
            $query = $pdo->prepare($sql);
            $query->bindParam(':number', $number);

            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }
}