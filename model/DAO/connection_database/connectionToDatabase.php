<?php
require_once __DIR__ . '/hostdb.php';
require_once __DIR__ . '/PDOConnection.php';

$dsn = "mysql:host=$databaseHost; dbname=$databaseName";
$userDB = $databaseUser;
$passDB = $databasePass;

//PDO Connection
$pdoConnection = new PDOConnection($dsn, $userDB, $passDB);

//Connect to Database
try{
    $pdoConnection->connect();
} catch(Exception $ex){
    $_SESSION['msg-error'] = $ex->getMessage();
    header("Location: ../view/pages/home.php");
    exit;
}