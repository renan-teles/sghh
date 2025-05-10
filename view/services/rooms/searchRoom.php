<?php

require_once __DIR__ . "/../../../model/DAO/RoomDAO.php";
require_once __DIR__ . "/../../../model/room/Room.php";

$json = filter_input(INPUT_GET, 'n', FILTER_UNSAFE_RAW);
$data = $json ? json_decode($json, true) : [];

// Create Object
$room = new Room(0, 0, 0, 0, 0);

// Create DAO Object
$roomDAO = new RoomDAO($room, $connectDB);

try {
    if (!isset($data['n']) || filter_var($data['n'], FILTER_VALIDATE_INT) === false) {
        throw new Exception("Parâmetro inválido!");
    }

    $rooms = $roomDAO->searchByNumber($data['n']);
} catch (Exception $ex) {
    $_SESSION['msg-error'] = $ex->getMessage();
}

if($rooms === false){
    $_SESSION['msg-error'] = "Erro ao pesquisar quarto(s)!";
}
 
if($rooms === []){
    $_SESSION['msg-error'] = "Quarto(s) não encontrado(s)!";
}   