<?php

require_once __DIR__ . "/ClassDAO.php";

class RoomDAO extends ClassDAO {
    private Room $room;

    public function __construct(Room $room, PDOConnection $pdoConnection) {
        $this->room = $room;
        parent::__construct($pdoConnection);
    }

    public function accommodationAssociationCheckByNumber(): array|bool {
        try {
            $number = $this->getRoom()->getNumber();

            $pdo = $this->getConnectionPDO();
            
            $sql = "SELECT 1 FROM accommodations
                    WHERE
                        number_room = :number
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

    public function checkRoomAvailabilityById(): bool|array {
        try {
            $id = $this->getRoom()->getId();
         
            $pdo = $this->getConnectionPDO();
            
            $sql = "SELECT 1 FROM rooms
                    WHERE
                            id = :id
                        AND
                            id_availability_room = 2
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

    public function checkExistenceByNumber(): bool|array {
        try {
            $number = $this->getRoom()->getNumber();
         
            $pdo = $this->getConnectionPDO();
            
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

    public function customSearch(array $columns, array $conditions, array $complements): array|bool {
        try {
            $pdo = $this->getConnectionPDO();
    
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
                        r.id, tr.type_room, ar.availability_room, r.number, r.floor, r.capacity, r.daily_price
                    FROM
                        rooms r
                    INNER JOIN types_rooms tr ON r.id_type_room = tr.id
                    INNER JOIN availability_rooms ar ON r.id_availability_room = ar.id
                    $whereSQL 
                    ORDER BY r.number";
    
            $query = $pdo->prepare($sql);
            $query->execute($values);
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result ?: [];
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            exit;
            return false;
        }
    }

    public function deleteById(): bool {
        try {
            $id = $this->getRoom()->getId();

            $pdo = $this->getConnectionPDO();

            $sql = "DELETE FROM rooms WHERE id = :id";
    
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
            $id = $this->getRoom()->getId();
            $idTypeRoom = $this->getRoom()->getType()->getId();
            $idAvailailityRoom = $this->getRoom()->getAvailability()->getId();
            $number = $this->getRoom()->getNumber();
            $floor = $this->getRoom()->getFloor();
            $capacity = $this->getRoom()->getCapacity();
            $dailyPrice = $this->getRoom()->getDailyPrice();
            $pdo = $this->getConnectionPDO();
        
            $sql = "UPDATE 
                        rooms 
                    SET 
                        id_type_room = :idTypeRoom, 
                        id_availability_room = :idAvailailityRoom,
                        number = :number,
                        floor = :floor,
                        capacity = :capacity,
                        daily_price = :dailyPrice
                    WHERE id = :id";
        
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':idAvailailityRoom', $idAvailailityRoom);
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

    public function getRoom(): Room {
        return $this->room;
    }

    public function register(): bool {
        try {
            $idTypeRoom = $this->getRoom()->getType()->getId();
            $idAvailabilityRoom = $this->getRoom()->getAvailability()->getId();
            $number = $this->getRoom()->getNumber();
            $floor = $this->getRoom()->getFloor();
            $capacity = $this->getRoom()->getCapacity();
            $dailyPrice = $this->getRoom()->getDailyPrice();

            $pdo = $this->getConnectionPDO();
           
            $sql = "INSERT INTO 
                        rooms (id_type_room, id_availability_room, number, floor, capacity, daily_price) 
                    VALUES 
                        (:idTypeRoom, :idAvailabilityRoom, :number, :floor, :capacity, :dailyPrice)";
           
            $query = $pdo->prepare($sql);
            $query->bindParam(':idTypeRoom', $idTypeRoom);
            $query->bindParam(':idAvailabilityRoom', $idAvailabilityRoom);
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

    public function searchByNumber(): array|bool{
        try {        
            $number = $this->getRoom()->getNumber();

            $pdo = $this->getConnectionPDO();
    
            $sql = "SELECT 
                        r.id, tr.type_room, ar.availability_room, r.number, r.floor, r.capacity, r.daily_price
                    FROM 
                        rooms r 
                    INNER JOIN types_rooms tr on r.id_type_room = tr.id 
                    INNER JOIN availability_rooms ar on r.id_availability_room = ar.id 
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