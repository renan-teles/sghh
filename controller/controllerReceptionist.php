<?php
session_start();

//Connection to Database
require_once __DIR__ . '/../model/DAO/connection_database/connectionToDatabase.php';

//Requires
require_once __DIR__ . '/../model/DAO/ReceptionistDAO.php';
require_once __DIR__ . '/../model/receptionist/Receptionist.php';
require_once __DIR__ . '/actions-business-rules/receptionist/DeleteReceptionist.php';
require_once __DIR__ . '/actions-business-rules/receptionist/EditNameAndEmailReceptionist.php';
require_once __DIR__ . '/actions-business-rules/receptionist/EditPasswordReceptionist.php';
require_once __DIR__ . '/actions-business-rules/receptionist/LoginReceptionist.php';
require_once __DIR__ . '/actions-business-rules/receptionist/LogoutReceptionist.php';
require_once __DIR__ . '/actions-business-rules/receptionist/RegisterReceptionist.php';
require_once __DIR__ . '/validate.php';

//Url Redirect
$_SESSION['url_redirect_after_error_or_exception'] = "";

//Get Action
$action = $_GET['act'] ?? '';

//Names Actions
$actionsNames = [
    'delete-receptionist',
    'edit-name-and-email-receptionist',
    'edit-password-receptionist',
    'login-receptionist',
    'logout-receptionist',
    'register-receptionist'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames)){
    if(isset($_SESSION['receptionistData'])){
        unset($_SESSION['receptionistData']);
    }
    header('Location: ../index.php');
    exit;
}

//Get Form Data
$nameReceptionist = $_POST['name_receptionist'] ?? '';
$emailReceptionist = $_POST['email_receptionist'] ?? '';
$passwordReceptionist = $_POST['password_receptionist'] ?? '';
$newPasswordReceptionist = $_POST['new_password_receptionist'] ?? '';

//Create Objects 
$receptionist = new Receptionist(0, $nameReceptionist, $emailReceptionist, $passwordReceptionist, $newPasswordReceptionist);

//Set ID
if($action !== 'register-receptionist' && $action !== 'login-receptionist'){
    $receptionistData = $_SESSION['receptionistData'] ?? [];
   
    if(!$receptionistData){
        header('Location: ../index.php');
        exit;
    }

    $receptionist->setId($receptionistData['id']);
}

//Create DAO Object
$receptionistDAO = new ReceptionistDAO($receptionist, $pdoConnection);

//Actions
$actions = [
    $actionsNames[0] => new DeleteReceptionist(),
    $actionsNames[1] => new EditNameAndEmailReceptionist(),
    $actionsNames[2] => new EditPasswordReceptionist(),
    $actionsNames[3] => new LoginReceptionist(),
    $actionsNames[4] => new LogoutReceptionist(),
    $actionsNames[5] => new RegisterReceptionist()
];

//Execute Action
try{
    $actions[$action]->execute($receptionistDAO);
} catch(Exception $ex){
    $_SESSION['msg-error'] = $ex->getMessage();
    header("Location: " . $_SESSION["url_redirect_after_error_or_exception"]);
    unset($_SESSION["url_redirect_after_error_or_exception"]);
}