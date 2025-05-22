<?php
session_start();

//Connection to Database
require_once __DIR__ . '/../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../model/DAO/AccommodationDAO.php';
require_once __DIR__ . '/../model/Accommodation/Accommodation.php';
require_once __DIR__ . '/../model/Accommodation/GuestAccommodation.php';
require_once __DIR__ . '/../model/Accommodation/StatusAccommodation.php';
require_once __DIR__ . '/../model/Accommodation/StatusPayment.php';
require_once __DIR__ . '/../model/Accommodation/actions/RegisterAccommodation.php';
require_once __DIR__ . '/../model/Accommodation/actions/EditAccommodation.php';
require_once __DIR__ . '/../model/Accommodation/actions/CancelAccommodation.php';
require_once __DIR__ . '/../model/Accommodation/actions/EndAccommodation.php';
require_once __DIR__ . '/../model/room/Room.php';
require_once __DIR__ . '/../model/room/TypeRoom.php';
require_once __DIR__ . '/validate.php';

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = [
    'register-accommodation',
    'edit-accommodation',
    'cancel-accommodation',
    'end-accommodation'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames)){
    $_SESSION['msg-error'] = "Ação inválida!"; 
    header('Location: ../view/pages/accommodations.php');
    exit;
}

//Get Form Data
$numberRoom = filter_input(INPUT_POST, 'number_room', FILTER_VALIDATE_INT);
$numberRoom = $numberRoom ? $numberRoom : 0;

$capacityRoom = filter_input(INPUT_POST, 'capacity_room', FILTER_VALIDATE_INT);
$capacityRoom = $capacityRoom ? $capacityRoom : 0;

$dailyPriceRoom = filter_input_float($_POST['daily_price_room'] ?? "");

$dateCheckin = filter_input(INPUT_POST, 'date_checkin', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$dateCheckout = filter_input(INPUT_POST, 'date_checkout', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

$cpfGuests = array_map(function ($value) {
    return filter_var(preg_replace('/[^0-9]/', '', trim($value)), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}, $_POST['cpf_guests'] ?? []);

//Create Objects 
$typeRoom = new TypeRoom(0,"");
$room = new Room(0, $numberRoom, $typeRoom, $dailyPriceRoom, -1, $capacityRoom, 0);

$statusPayment = new StatusPayment(0,"");
$statusAccommodation = new StatusAccommodation(0,"");

$guestAccommodation = new GuestAccommodation(0, $cpfGuests);
$accommodation = new Accommodation($guestAccommodation, $room, $statusAccommodation, $statusPayment, $dateCheckin, $dateCheckout, 0);

//Set ID
if($action !== 'register-accommodation'){
    $idAccommodation = filter_input(INPUT_POST, 'accommodationId', FILTER_VALIDATE_INT);
    $accommodation->getGuestAccommodation()->setId($idAccommodation ?: 0);
}

//Create DAO Object
$accommodationDAO = new AccommodationDAO($accommodation, $connectDB);

//Actions
$actions = [
    $actionsNames[0] => new RegisterAccommodation(),
    $actionsNames[1] => new EditAccommodation(),
    $actionsNames[2] => new CancelAccommodation(),
    $actionsNames[3] => new EndAccommodation()
];

//Execute Action
try{
    $actions[$action]->execute($accommodationDAO);
} catch(Exception $ex){
    $_SESSION['msg-error'] = $ex->getMessage();
    header("Location: ../view/pages/accommodations.php");
}