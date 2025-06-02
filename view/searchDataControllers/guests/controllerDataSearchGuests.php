<?php

//Connection to Database
require_once __DIR__ . '/../../../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../../../model/DAO/GuestDAO.php';
require_once __DIR__ . '/../../../model/guest/Guest.php';
require_once __DIR__ . '/../../../controller/actions-business-rules/guest/CustomSearchGuests.php';
require_once __DIR__ . '/../../../controller/actions-business-rules/guest/SearchGuestByEmail.php';
require_once __DIR__ . '/../../../controller/actions-business-rules/guest/SearchGuestById.php';
require_once __DIR__ . '/../../../controller/validate.php';

//Rooms
$guests = null;

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = [
    'custom-search-guests',
    'search-guest-by-email', 
    'search-guest-by-id' 
];

//Validates
if($action === $actionsNames[0]){
    $columns = array_map(function ($value) {
        $value = trim($value);
        return in_array(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS), ["name", "email", "cpf", "cpf_responsible", "telephone"])? $value : "";
    }, $_POST['columns'] ?? []);

    $conditions = array_map(function ($value) {
        $value = trim($value);
        return in_array(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS),  ["eq"])? $value : "";
    }, $_POST['conditions'] ?? []);

    $complements = array_map(function ($value) {
        $value = trim($value);

        if (strpos($value, '(') !== false && strpos($value,')') !== false && strpos($value, '-') !== false){
            $value = preg_replace('/\D/', '', $value);
            if(!validateTelephone($value)){
                return "";
            }
        }
        
        if (strpos($value, '.') !== false && strpos($value,'-') !== false){
            $value = preg_replace('/[^0-9]/', '', $value);
            if(!validateCPF($value)){
                return "";
            }
        }
        
        if (strpos($value, '.') !== false && strpos($value, '@') !== false){
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                return "";
            }
        }

        return $value;
    }, $_POST['complements'] ?? []);
}

if($action === $actionsNames[1]){
    $json = filter_input(INPUT_GET, 'e', FILTER_UNSAFE_RAW);
    $infoGuest = $json ? json_decode($json, true) : [];

    $emailGuest = isset($infoGuest["e"]) ? filter_var($infoGuest["e"], FILTER_VALIDATE_EMAIL) : "";
}

if($action === $actionsNames[2]){
    $json = filter_input(INPUT_GET, 'id', FILTER_UNSAFE_RAW);
    $infoGuest = $json ? json_decode($json, true) : [];

    $idGuest = isset($infoGuest["id"]) ? filter_var($infoGuest["id"], FILTER_VALIDATE_INT) : "";
    $idGuest = $idGuest ?: 0;
}

//Create Objects 
$guest = new Guest($idGuest ?? 0, "", $emailGuest ?? "", "", "", "", "");

//Create DAO Object
$guestDAO = new GuestDAO($guest, $pdoConnection);

//Actions
$actions = array(
    $actionsNames[0] => new CustomSearchGuest($columns ?? [], $conditions ?? [], $complements ?? []),
    $actionsNames[1] => new SearchGuestByEmail(),
    $actionsNames[2] => new SearchGuestById()
);

//Execute Action
if($action && in_array($action, $actionsNames)) {
    try {
        $guests = $actions[$action]->execute($guestDAO);

        if($guests === false){
            $_SESSION['msg-error'] = "Erro ao pesquisar hóspede(s)!";
        }
 
        if($guests === []){
            $_SESSION['msg-error'] = "Hóspede(s) não encontrado(s)!";
        }   
    
        if($guests && $action === "custom-search-guests"){
            $_SESSION['msg-success'] = "Pesquisa realizada com sucesso!";
        }
    } catch(Exception $ex){
        $_SESSION['msg-error'] = $ex->getMessage();
    }
}