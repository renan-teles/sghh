<?php
session_start();

//Connection to Database
require_once __DIR__ . '/../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../model/DAO/RoomDAO.php';
require_once __DIR__ . '/../model/room/Room.php';
require_once __DIR__ . '/../model/room/TypeRoom.php';
require_once __DIR__ . '/../model/room/actions/DeleteRoom.php';
require_once __DIR__ . '/../model/room/actions/EditRoom.php';
require_once __DIR__ . '/../model/room/actions/RegisterRoom.php';
require_once __DIR__ . '/validate.php';

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = 
[
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
$numberRoom = $numberRoom ? $numberRoom : 0;

$floorRoom = filter_input(INPUT_POST, 'floor_room', FILTER_VALIDATE_INT);
$floorRoom = $floorRoom ? $floorRoom : 0;

$capacityRoom = filter_input(INPUT_POST, 'capacity_room', FILTER_VALIDATE_INT);
$capacityRoom = $capacityRoom ? $capacityRoom : 0;

$idTypeRoom = filter_input(INPUT_POST, 'type_room', FILTER_VALIDATE_INT);
$idTypeRoom = $idTypeRoom ? $idTypeRoom : 0;

$isAvailable = filter_input(INPUT_POST, 'is_available', FILTER_VALIDATE_INT);
$isAvailable = $isAvailable ? $isAvailable : 1;

$dailyPriceRoom = filter_input_float($_POST['daily_price_room'] ?? "");

//Create Objects 
$typeRoom = new TypeRoom($idTypeRoom,"");
$room = new Room(0, $numberRoom, $typeRoom, $dailyPriceRoom, $isAvailable, $capacityRoom, $floorRoom);

//Set ID
if($action !== 'register-room'){
    $idRoom = filter_input(INPUT_POST, 'roomId', FILTER_VALIDATE_INT);
    $idRoom = $idRoom ? $idRoom : 0;
    $room->setId($idRoom);
}

//Create DAO Object
$roomDAO = new RoomDAO($room, $connectDB);

//Actions
$actions = array(
    $actionsNames[0] => new DeleteRoom(),
    $actionsNames[1] => new EditRoom(),
    $actionsNames[2] => new RegisterRoom()
);

//Execute Action
try{
    $actions[$action]->execute($roomDAO);
} catch(Exception $ex){
    $_SESSION['msg-error'] = $ex->getMessage();
    header("Location: ../view/pages/rooms.php");
}