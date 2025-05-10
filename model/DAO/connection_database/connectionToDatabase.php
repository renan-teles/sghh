<?php
require_once __DIR__ . './hostdb.php';
require_once __DIR__ . './PDOConnection.php';
require_once __DIR__ . './ConnectDB.php';

//PDO Connection
$dsn = "mysql:host=$databaseHost; dbname=$databaseName";
$userDB = $databaseUser;
$passDB = $databasePass;
$pdoConn = new PDOConnection($dsn, $userDB, $passDB);

//ConnectDB
$connectDB = new ConnectDB($pdoConn);

//Connect to Database
try{
    $connectDB->connect();
} catch(Exception $ex){
    $_SESSION['msg-error'] = $ex->getMessage();
    header("Location: ../view/pages/rooms.php");
    exit;
}
