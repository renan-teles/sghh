<?php
session_start();

//Connection to Database
require_once __DIR__ . '/../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../model/DAO/RoomDAO.php';
require_once __DIR__ . '/../model/room/Room.php';
require_once __DIR__ . '/../model/room/TypeRoom.php';
require_once __DIR__ . '/../model/room/AvailabilityRoom.php';
require_once __DIR__ . '/actions-business-rules/room/DeleteRoom.php';
require_once __DIR__ . '/actions-business-rules/room/EditRoom.php';
require_once __DIR__ . '/actions-business-rules/room/RegisterRoom.php';
require_once __DIR__ . '/validate.php';

//Url Redirect
$_SESSION['url_redirect_after_error_or_exception'] = "";

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = [
    'delete-room',
    'edit-room',
    'register-room'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames)){
    $_SESSION['msg-error'] = "Ação inválida!"; 
    header('Location: ../view/pages/rooms.php');
    exit;
}

//Get Form Data
$numberRoom = filter_input(INPUT_POST, 'number_room', FILTER_VALIDATE_INT);
$numberRoom = $numberRoom ?: 0;

$floorRoom = filter_input(INPUT_POST, 'floor_room', FILTER_VALIDATE_INT);
$floorRoom = $floorRoom ?: 0;

$capacityRoom = filter_input(INPUT_POST, 'capacity_room', FILTER_VALIDATE_INT);
$capacityRoom = $capacityRoom ?: 0;

$idTypeRoom = filter_input(INPUT_POST, 'type_room', FILTER_VALIDATE_INT);
$idTypeRoom = $idTypeRoom ?: 0;

$idAvailabilityRoom = filter_input(INPUT_POST, 'availability_room', FILTER_VALIDATE_INT);
$idAvailabilityRoom = $idAvailabilityRoom ?: 1;

$dailyPriceRoom = filter_input_float($_POST['daily_price_room'] ?? "");

//Create Objects 
$typeRoom = new TypeRoom($idTypeRoom,"");
$availabilityRoom = new AvailabilityRoom($idAvailabilityRoom, "");
$room = new Room(0, $numberRoom, $typeRoom, $dailyPriceRoom, $availabilityRoom, $capacityRoom, $floorRoom);

//Set ID
if($action !== 'register-room'){
    $idRoom = filter_input(INPUT_POST, 'roomId', FILTER_VALIDATE_INT);
    $room->setId($idRoom ?: 0);
}

//Create DAO Object
$roomDAO = new RoomDAO($room, $pdoConnection);

//Actions
$actions = [
    $actionsNames[0] => new DeleteRoom(),
    $actionsNames[1] => new EditRoom(),
    $actionsNames[2] => new RegisterRoom()
];

//Execute Action
try {
    $actions[$action]->execute($roomDAO);
} catch(Exception $ex) {
    $_SESSION['msg-error'] = $ex->getMessage();
    header("Location: " . $_SESSION['url_redirect_after_error_or_exception']);
    unset($_SESSION['url_redirect_after_error_or_exception']);
}