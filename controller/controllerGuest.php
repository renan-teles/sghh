<?php
session_start();

//Connection to Database
require_once __DIR__ . '/../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../model/DAO/GuestDAO.php';
require_once __DIR__ . '/../model/guest/Guest.php';
require_once __DIR__ . '/actions-business-rules/guest/DeleteGuest.php';
require_once __DIR__ . '/actions-business-rules/guest/EditGuest.php';
require_once __DIR__ . '/actions-business-rules/guest/RegisterGuest.php';
require_once __DIR__ . '/validate.php';

//Url Redirect
$_SESSION['url_redirect_after_error_or_exception'] = "";

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = [
    'delete-guest',
    'edit-guest',
    'register-guest'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames)){
    $_SESSION['msg-error'] = "Ação inválida!"; 
    header('Location: ../view/pages/guests.php');
    exit;
}

//Get Form Data
$nameGuest = $_POST['name_guest'] ?? '';

$emailGuest = $_POST['email_guest'] ?? '';

$cpf = filter_input(INPUT_POST, 'cpf_guest', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cpfGuest = $cpf ? preg_replace('/[^0-9]/', '', $cpf) : "";

$cpfResponsible = filter_input(INPUT_POST, 'cpf_responsible_guest', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cpfResponsibleGuest = $cpfResponsible ? preg_replace('/[^0-9]/', '', $cpfResponsible) : "";

$telephone = filter_input(INPUT_POST, 'telephone_guest', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$telephoneGuest = $telephone? preg_replace('/\D/', '', $telephone) : "";

$dateBirthGuest = filter_input(INPUT_POST, 'date_birth_guest', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

//Create Objects 
$guest = new Guest(0, $nameGuest, $emailGuest, $cpfGuest, $cpfResponsibleGuest, $telephoneGuest, $dateBirthGuest);

//Set ID
if($action !== 'register-guest'){
    $idGuest = filter_input(INPUT_POST, 'guestId', FILTER_VALIDATE_INT);
    $guest->setId($idGuest ?: 0);
}

//Create DAO Object
$guestDAO = new GuestDAO($guest, $pdoConnection);

//Actions
$actions = [
    $actionsNames[0] => new DeleteGuest(),
    $actionsNames[1] => new EditGuest(),
    $actionsNames[2] => new RegisterGuest()
];

//Execute Action
try {
    $actions[$action]->execute($guestDAO);
} catch(Exception $ex) {
    $_SESSION['msg-error'] = $ex->getMessage();
    header("Location: " . $_SESSION["url_redirect_after_error_or_exception"]);
    unset($_SESSION["url_redirect_after_error_or_exception"]);
}