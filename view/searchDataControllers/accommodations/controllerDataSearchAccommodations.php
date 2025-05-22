<?php

//Connection to Database
require_once __DIR__ . '/../../../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../../../model/DAO/AccommodationDAO.php';
require_once __DIR__ . '/../../../model/accommodation/Accommodation.php';
require_once __DIR__ . '/../../../model/accommodation/GuestAccommodation.php';
require_once __DIR__ . '/../../../model/accommodation/StatusAccommodation.php';
require_once __DIR__ . '/../../../model/accommodation/StatusPayment.php';
require_once __DIR__ . '/../../../model/room/Room.php';
require_once __DIR__ . '/../../../model/room/TypeRoom.php';
require_once __DIR__ . '/../../../model/accommodation/actions/CustomSearchAccommodations.php';
require_once __DIR__ . '/../../../model/accommodation/actions/SearchAccommodationAfterInsertOrUpdate.php';
require_once __DIR__ . '/../../../model/accommodation/actions/SearchAccommodationAfterCancelOrEnd.php';

//Accommodations
$accommodations = null;

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = [
    'custom-search-accommodations',
    'search-accommodation-after-insert-or-update',    
    'search-accommodation-after-cancel-or-end'
];

//Validates
if($action === $actionsNames[0]){
    $columns = array_map(function ($value) {
        $value = trim($value);
        return in_array(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS), ["a.number_room", "a.id_status_accommodation", "a.id_status_payment"])? $value : "";
    }, $_POST['columns'] ?? []);

    $conditions = array_map(function ($value) {
        $value = trim($value);
        return in_array(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS), ["lt", "gt", "lte", "gte", "eq"])? $value : "";
    }, $_POST['conditions'] ?? []);

    $complements = array_map(function ($value) {
        $value = trim($value);
        return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? "";
    }, $_POST['complements'] ?? []);
}

if($action === $actionsNames[1]){
    $json = filter_input(INPUT_GET, 'nr', FILTER_UNSAFE_RAW);
    $infoRoom = $json ? json_decode($json, true) : [];

    $numberRoom = isset($infoRoom['nr']) ? filter_var($infoRoom['nr'], FILTER_VALIDATE_INT) : 0;
    $numberRoom = $numberRoom ?: 0;
}

if($action === $actionsNames[2]){
    $json = filter_input(INPUT_GET, 'id', FILTER_UNSAFE_RAW);
    $infoAccomm = $json ? json_decode($json, true) : [];

    $idAccomm = isset($infoAccomm['id']) ? filter_var($infoAccomm['id'], FILTER_VALIDATE_INT) : 0;
    $idAccomm = $idAccomm ?: 0;
}

//Create Objects 
$typeRoom = new TypeRoom(0,"");
$room = new Room(0, $numberRoom ?? 0, $typeRoom, 0, -1, 0, 0);

$statusPayment = new StatusPayment(0,"");
$statusAccommodation = new StatusAccommodation(0,"");

$guestAccommodation = new GuestAccommodation($idAccomm ?? 0, []);
$accommodation = new Accommodation($guestAccommodation, $room, $statusAccommodation, $statusPayment, "", "", 0);

//Create DAO Object
$accommodationDAO = new AccommodationDAO($accommodation, $connectDB);

//Actions
$actions = [
    $actionsNames[0] => new CustomSearchAccommodation($columns ?? [], $conditions ?? [], $complements ?? []),
    $actionsNames[1] => new SearchAccommodationAfterInsertOrUpdate(),
    $actionsNames[2] => new SearchAccommodationAfterCancelOrEnd()
];

//Execute Action
if($action && in_array($action, $actionsNames)) {
    try {
        $accommodations = $actions[$action]->execute($accommodationDAO);

        if($accommodations === false){
            $_SESSION['msg-error'] = "Erro ao pesquisar hospedagem(s)!";
        }
 
        if($accommodations === []){
            $_SESSION['msg-error'] = "Hospedagem(s) não encontrado(s)!";
        }   
    
        if($accommodations && $action === "custom-search-accommodations"){
            $_SESSION['msg-success'] = "Pesquisa realizada com sucesso!";
        }
    } catch(Exception $ex){
        $_SESSION['msg-error'] = $ex->getMessage();
    }
}