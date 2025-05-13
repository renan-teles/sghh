<?php

//Connection to Database
require_once __DIR__ . '/../../../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../../../model/DAO/RoomDAO.php';
require_once __DIR__ . '/../../../model/room/Room.php';
require_once __DIR__ . '/../../../model/room/TypeRoom.php';
require_once __DIR__ . '/../../../model/room/actions/CustomSearchRoom.php';
require_once __DIR__ . '/../../../model/room/actions/SearchRoom.php';

//Rooms
$rooms = null;

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = 
[
    'custom-search-rooms',
    'search-room'    
];

//Validates
if($action === $actionsNames[0]){
    $columns = array_map(function ($value) {
        $value = trim($value);
        $isValid = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return $isValid && in_array($isValid, ["number", "is_available", "id_type_room", "daily_price", "capacity"])?   $isValid : "";
    }, $_POST['columns'] ?? []);

    $conditions = array_map(function ($value) {
        $value = trim($value);
        $isValid = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return $isValid && in_array($isValid, ["lt", "gt", "lte", "gte", "eq"])? $isValid : "";
    }, $_POST['conditions'] ?? []);

    $complements = array_map(function ($value) {
        $value = trim($value);
        if (strpos($value, ',') !== false) {
            $value = str_replace('.', '', $value); 
            $value = str_replace(',', '.', $value);
        }
        $isValid = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return $isValid || $isValid === "0"? $isValid : "";
    }, $_POST['complements'] ?? []);
}

if($action === $actionsNames[1]){
    $json = filter_input(INPUT_GET, 'n', FILTER_UNSAFE_RAW);
    $numberRoom = $json ? json_decode($json, true) : [];
}

//Create Objects 
$typeRoom = new TypeRoom(0,"");
$room = new Room(0, $numberRoom['n'] ?? 0, $typeRoom, 0, 0, 0, 0);

//Create DAO Object
$roomDAO = new RoomDAO($room, $connectDB);

//Actions
$actions = array(
    $actionsNames[0] => new CustomSearchRoom($columns ?? [], $conditions ?? [], $complements ?? []),
    $actionsNames[1] => new SearchRoom()
);

//Execute Action
if($action) {
    try {
        $rooms = $actions[$action]->execute($roomDAO);

        if($rooms === false){
            $_SESSION['msg-error'] = "Erro ao pesquisar quarto(s)!";
        }
 
        if($rooms === []){
            $_SESSION['msg-error'] = "Quarto(s) não encontrado(s)!";
        }   
    
        if($rooms && $action === "custom-search-rooms"){
            $_SESSION['msg-success'] = "Pesquisa realizada com sucesso!";
        }
    } catch(Exception $ex){
        $_SESSION['msg-error'] = $ex->getMessage();
    }
}