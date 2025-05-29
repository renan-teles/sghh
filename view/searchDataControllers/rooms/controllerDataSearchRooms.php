<?php

//Connection to Database
require_once __DIR__ . '/../../../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../../../model/DAO/RoomDAO.php';
require_once __DIR__ . '/../../../model/room/Room.php';
require_once __DIR__ . '/../../../model/room/AvailabilityRoom.php';
require_once __DIR__ . '/../../../model/room/TypeRoom.php';
require_once __DIR__ . '/../../../controller/actions-business-rules/room/CustomSearchRoom.php';
require_once __DIR__ . '/../../../controller/actions-business-rules/room/SearchRoomByNumber.php';

//Rooms
$rooms = null;

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = [
    'custom-search-rooms',
    'search-room-by-number'    
];

//Validates
if($action === $actionsNames[0]){
    //Valid Params
    $columns = array_map(function ($value) {
        $value = trim($value);
        return in_array(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS), ["number", "id_availability_room", "id_type_room", "daily_price", "capacity"])? $value : "";
    }, $_POST['columns'] ?? []);

    $conditions = array_map(function ($value) {
        $value = trim($value);
        return in_array(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS), ["lt", "gt", "lte", "gte", "eq"])? $value : "";
    }, $_POST['conditions'] ?? []);

    $complements = array_map(function ($value) {
        $value = trim($value);
        if (strpos($value, ',') !== false) {
            $value = str_replace('.', '', $value); 
            $value = str_replace(',', '.', $value);
        }
        return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }, $_POST['complements'] ?? []);
}

if ($action === $actionsNames[1]) {
    $json = filter_input(INPUT_GET, 'n', FILTER_UNSAFE_RAW);
    $infoRoom = json_decode($json ?? '', true) ?? [];

    $numberRoom = isset($infoRoom['n']) ? filter_var($infoRoom['n'], FILTER_VALIDATE_INT) : 0;
    $numberRoom = $numberRoom ?: 0;
}

// Create Objects
$typeRoom = new TypeRoom(0, "");
$availabilityRoom = new AvailabilityRoom(0, "");
$room = new Room(0, $numberRoom ?? 0, $typeRoom, 0, $availabilityRoom, 0, 0);

//Create DAO Object
$roomDAO = new RoomDAO($room, $pdoConnection);

//Actions
$actions = array(
    $actionsNames[0] => new CustomSearchRoom($columns ?? [], $conditions ?? [], $complements ?? []),
    $actionsNames[1] => new SearchRoomByNumber()
);

//Execute Action
if($action && in_array($action, $actionsNames)) {
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