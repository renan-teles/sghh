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
require_once __DIR__ . '/../model/room/Room.php';
require_once __DIR__ . '/../model/room/TypeRoom.php';
require_once __DIR__ . '/../model/room/AvailabilityRoom.php';
require_once __DIR__ . '/actions-business-rules/accommodation/RegisterAccommodation.php';
require_once __DIR__ . '/actions-business-rules/accommodation/EditAccommodation.php';
require_once __DIR__ . '/actions-business-rules/accommodation/CancelAccommodation.php';
require_once __DIR__ . '/actions-business-rules/accommodation/EndAccommodation.php';
require_once __DIR__ . '/validate.php';

//Url Redirect
$_SESSION['url_redirect_after_error_or_exception'] = "";

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = [
    'cancel-accommodation',
    'edit-accommodation',
    'end-accommodation',
    'register-accommodation'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames)){
    $_SESSION['msg-error'] = "Ação inválida!"; 
    header('Location: ../view/pages/accommodations.php');
    exit;
}

//Get Form Data
$numberRoom = filter_input(INPUT_POST, 'number_room', FILTER_VALIDATE_INT);
$numberRoom = $numberRoom ?: 0;

$capacityRoom = filter_input(INPUT_POST, 'capacity_room', FILTER_VALIDATE_INT);
$capacityRoom = $capacityRoom ?: 0;

$dailyPriceRoom = filter_input_float($_POST['daily_price_room'] ?? "");

$dateCheckin = filter_input(INPUT_POST, 'date_checkin', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$dateCheckout = filter_input(INPUT_POST, 'date_checkout', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

$cpfGuests = array_map(function ($value) {
    return filter_var(preg_replace('/[^0-9]/', '', trim($value)), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}, $_POST['cpf_guests'] ?? []);

//Create Objects 
$typeRoom = new TypeRoom(0,"");
$availabilityRoom = new AvailabilityRoom(0, "");
$room = new Room(0, $numberRoom, $typeRoom, $dailyPriceRoom, $availabilityRoom, $capacityRoom, 0);

$statusPayment = new StatusPayment(0,"");
$statusAccommodation = new StatusAccommodation(0,"");

$guestAccommodation = new GuestAccommodation(0, 0, $cpfGuests);
$accommodation = new Accommodation($guestAccommodation, $room, $statusAccommodation, $statusPayment, $dateCheckin, $dateCheckout, 0);

//Set ID
if($action !== 'register-accommodation'){
    $idAccommodation = filter_input(INPUT_POST, 'accommodationId', FILTER_VALIDATE_INT);
    $accommodation->getGuestAccommodation()->setIdAccommodation($idAccommodation ?: 0);
}

//Create DAO Object
$accommodationDAO = new AccommodationDAO($accommodation, $pdoConnection);

//Actions
$actions = [
    $actionsNames[0] => new CancelAccommodation(),
    $actionsNames[1] => new EditAccommodation(),
    $actionsNames[2] => new EndAccommodation(),
    $actionsNames[3] => new RegisterAccommodation()
];

//Execute Action
try{
    $actions[$action]->execute($accommodationDAO);
} catch(Exception $ex){
    $_SESSION['msg-error'] = $ex->getMessage();
    header("Location: " . $_SESSION["url_redirect_after_error_or_exception"]);
    unset($_SESSION["url_redirect_after_error_or_exception"]);
}