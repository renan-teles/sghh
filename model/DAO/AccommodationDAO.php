<?php

require_once __DIR__ . "/ClassDAO.php";

class AccommodationDAO extends ClassDAO {
    private Accommodation $accommodation;

    public function __construct(Accommodation $accommodation, PDOConnection $pdoConnection) {
        $this->accommodation = $accommodation;
        parent::__construct($pdoConnection);
    }

    public function getAccommodation(): Accommodation {
        return $this->accommodation;
    }

    public function cancelAccommodation(): bool {
        try {
            $id = $this->getAccommodation()->getGuestAccommodation()->getIdAccommodation();
            
            $pdo =  $this->getConnectionPDO();
        
            $sql = "CALL cancel_accommodation(?)";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(1, $id, PDO::PARAM_INT);
        
            $query->execute();
    
            return true;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function checkRoomAvailabilityByNumber(): bool|array {
        try {
            $numberRoom = $this->getAccommodation()->getRoom()->getNumber();
         
            $pdo = $this->getConnectionPDO();
            
            $sql = "SELECT 1 FROM rooms
                    WHERE
                        number = :numberRoom
                        AND
                            id_availability_room = 2
                        OR
                            id_availability_room = 3
                    LIMIT 1";
         
            $query = $pdo->prepare($sql);
            $query->bindParam(':numberRoom', $numberRoom);
            
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            exit;
            return false;
        }
    }
   
    public function checkStatusAccommodationById(int $numberStatus): bool|array {
        try {
            $id = $this->getAccommodation()->getGuestAccommodation()->getIdAccommodation();
            
            $pdo =  $this->getConnectionPDO();
        
            $sql = "SELECT 1 FROM accommodations
                    WHERE
                        id = :id
                    AND
                        id_status_accommodation = $numberStatus
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

    public function checkExistenceGuestsByCpfs(): bool|array {
        try {
            $cpfGuests = $this->getAccommodation()->getGuestAccommodation()->getCPfGuests();
            
            $pdo =  $this->getConnectionPDO();
        
            $whereClauses = [];
            $params = [];
    
            for ($i = 0; $i < count($cpfGuests); $i++) {               
                $whereClauses[] = "cpf = ?";
                $values[] = $cpfGuests[$i];
            }
    
            $whereSQL = count($whereClauses) ? "WHERE " . implode(" OR ", $whereClauses) : "";
    
            $sql = "SELECT 1 FROM guests $whereSQL";
    
            $query = $pdo->prepare($sql);
            $query->execute($values);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function customSearch(array $columns, array $conditions, array $complements): array|bool {
        try {
            $pdo =  $this->getConnectionPDO();

            $conditionsSymbols = [
                "lt" => "<",
                "gt" => ">",
                "lte" => "<=",
                "gte" => ">=",
                "eq" => "="
            ];
    
            $whereClauses = [];
            $params = [];

            for ($i = 0; $i < count($columns); $i++) {
                $column = $columns[$i];
                $operator = $conditionsSymbols[$conditions[$i]];
               
                $whereClauses[] = "$column $operator ?";
                $values[] = $complements[$i];
            }
    
            $whereSQL = count($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";
    
            $sql = "SELECT 
                a.id,
                GROUP_CONCAT(CONCAT(g.name, ' - ', g.cpf, ' - ', g.telephone) SEPARATOR ', ') AS guests,
                a.number_room,
                r.capacity as capacity_room,
                r.daily_price as daily_price_room,
                a.date_checkin,
                a.date_checkout,
                sa.status_accommodation,
                sp.status_payment,
                a.total_value
            FROM accommodations a
                JOIN guest_accommodation ga ON ga.id_accommodation = a.id
                JOIN guests g ON g.cpf = ga.cpf_guest
                JOIN status_accommodations sa ON sa.id = a.id_status_accommodation
                JOIN status_payments sp ON sp.id = a.id_status_payment 
                JOIN rooms r ON r.number = a.number_room 
            $whereSQL
            GROUP BY a.id";

            $query = $pdo->prepare($sql);
            $query->execute($values);

            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return !in_array(null, $result[0] ?? [])? $result : [];
        } catch (PDOException $exc) {
            return false;
        }
    }
        
    // public function delete(): bool {return false;}

    public function editById(): bool {
        try {
            $id =  $this->getAccommodation()->getGuestAccommodation()->getIdAccommodation();
            $dateCheckin = $this->getAccommodation()->getDateCheckin();
            $dateCheckout = $this->getAccommodation()->getDateCheckout();
            $totalValue = $this->getAccommodation()->getTotalValue();

            $pdo =  $this->getConnectionPDO();
        
            $sql = "UPDATE 
                        accommodations
                    SET 
                        date_checkin = :dateCheckin, 
                        date_checkout = :dateCheckout,
                        total_value = :totalValue
                    WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':dateCheckin', $dateCheckin);
            $query->bindParam(':dateCheckout', $dateCheckout);
            $query->bindParam(':totalValue', $totalValue);
           
            $query->execute();
            
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            return false;
        }
    }
    
    public function endAccommodation(): bool {
        try {
            $id = $this->getAccommodation()->getGuestAccommodation()->getIdAccommodation();
            
            $pdo =  $this->getConnectionPDO();
        
            $sql = "CALL end_accommodation(?)";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(1, $id, PDO::PARAM_INT);
        
            $query->execute();
    
            return true;
        } catch (PDOException $exc) {
            return false;
        }
    }

    public function register(): bool {
        $pdo =  $this->getConnectionPDO();
        
        try {
            $numberRoom = $this->getAccommodation()->getRoom()->getNumber();
            $idStatusAccommodation = $this->getAccommodation()->getStatusAccommodation()->getId();
            $idStatusPayment = $this->getAccommodation()->getStatusPayment()->getId();
            $dateCheckin = $this->getAccommodation()->getDateCheckin();
            $dateCheckout = $this->getAccommodation()->getDateCheckout();
            $totalValue = $this->getAccommodation()->getTotalValue();

            $pdo->beginTransaction();
    
            $sqlInsertAccommodations = "INSERT INTO 
                        accommodations 
                        (number_room, id_status_accommodation, id_status_payment, date_checkin, date_checkout, total_value) 
                    VALUES 
                        (:numberRoom, :idStatusAccommodation, :idStatusPayment, :dateCheckin, :dateCheckout, :totalValue)";
    
            $query1 = $pdo->prepare($sqlInsertAccommodations);
            $query1->bindParam(':numberRoom', $numberRoom);
            $query1->bindParam(':idStatusAccommodation', $idStatusAccommodation);
            $query1->bindParam(':idStatusPayment', $idStatusPayment);
            $query1->bindParam(':dateCheckin', $dateCheckin);
            $query1->bindParam(':dateCheckout', $dateCheckout);
            $query1->bindParam(':totalValue', $totalValue);
    
            $query1->execute();
            
            $idAccommodation = $pdo->lastInsertId();
            $cpf_guests = $this->getAccommodation()->getGuestAccommodation()->getCpfGuests();
    
            $placeholders = [];
            $values = [];
    
            foreach ($cpf_guests as $cpf) {
                $placeholders[] = "(?, ?)";
                $values[] = $cpf;
                $values[] = $idAccommodation;
            }
    
            $sql2 = "INSERT INTO guest_accommodation 
                        (cpf_guest, id_accommodation) 
                     VALUES " . implode(", ", $placeholders);

            $query2 = $pdo->prepare($sql2);

            $query2->execute($values);
    
            $pdo->commit();
    
            return $query1->rowCount() > 0 && $query2->rowCount() > 0;
        } catch (PDOException $exc) {
            $pdo->rollBack();
            return false;
        }
    }

    public function searchByNumberRoom(): array|bool {
        try {
            $number = $this->getAccommodation()->getRoom()->getNumber();
           
            $pdo =  $this->getConnectionPDO();

            $sql = "SELECT 
                        a.id,
                        GROUP_CONCAT(CONCAT(g.name, ' - ', g.cpf, ' - ', g.telephone) SEPARATOR ', ') AS guests,
                        a.number_room,
                        r.capacity as capacity_room,
                        r.daily_price as daily_price_room,
                        a.date_checkin,
                        a.date_checkout,
                        sa.status_accommodation,
                        sp.status_payment,
                        a.total_value
                    FROM accommodations a
                        JOIN guest_accommodation ga ON ga.id_accommodation = a.id
                        JOIN guests g ON g.cpf = ga.cpf_guest
                        JOIN status_accommodations sa ON sa.id = a.id_status_accommodation
                        JOIN status_payments sp ON sp.id = a.id_status_payment
                        JOIN rooms r ON r.number = a.number_room 
                    WHERE a.id_status_accommodation = 1 and a.number_room = :numberRoom;";
    
            $query = $pdo->prepare($sql);
            $query->bindParam(':numberRoom', $number, PDO::PARAM_INT);
            
            $query->execute();
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result ?: [];
        } catch (PDOException $exc) {
            return false;
        }
    }
   
    public function searchById(): array|bool {
        try {
            $id = $this->getAccommodation()->getGuestAccommodation()->getIdAccommodation();
            
            $pdo =  $this->getConnectionPDO();
          
            $sql = "SELECT 
                        a.id,
                        GROUP_CONCAT(CONCAT(g.name, ' - ', g.cpf, ' - ', g.telephone) SEPARATOR ', ') AS guests,
                        a.number_room,
                        r.capacity as capacity_room,
                        r.daily_price as daily_price_room,
                        a.date_checkin,
                        a.date_checkout,
                        sa.status_accommodation,
                        sp.status_payment,
                        a.total_value
                    FROM accommodations a
                        JOIN guest_accommodation ga ON ga.id_accommodation = a.id
                        JOIN guests g ON g.cpf = ga.cpf_guest
                        JOIN status_accommodations sa ON sa.id = a.id_status_accommodation
                        JOIN status_payments sp ON sp.id = a.id_status_payment
                        JOIN rooms r ON r.number = a.number_room 
                    WHERE a.id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            
            $query->execute();
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result ?: [];
        } catch (PDOException $exc) {
            return false;
        }
    }
}