<?php
require_once __DIR__ . "/../../../model/DAO/RoomDAO.php";
require_once __DIR__ . "/../../../model/room/Room.php";

//Validate
$columns = array_map(function ($value) {
    $value = trim($value);
    $isValid = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return $isValid && in_array($isValid, ["number", "is_available", "id_type_room", "daily_price", "capacity"])? $isValid : "";
}, $_POST['columns'] ?? []);

$conditions = array_map(function ($value) {
    $value = trim($value);
    $isValid = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return $isValid && in_array($isValid, ["lt", "gt", "lte", "gte", "eq"])? $isValid : "";
}, $_POST['conditions'] ?? []);

$complements = array_map(function ($value) {
    $value = trim($value);
    $value = str_replace('.', '', $value);
    $value = str_replace(',', '.', $value);
    $isValid = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return $isValid || $isValid === "0"? $isValid : "";
}, $_POST['complements'] ?? []);

$columnsLength = count($columns);
$conditionsLength = count($conditions);
$coplementsLength = count($complements);

//Create Objetc
$room = new Room(0,0,0,0,0);

//Create DAO Object
$roomDAO = new RoomDAO($room, $connectDB);

//Execute Search
try{
    if(!($columns && $conditions && $complements)){
        throw new Exception("Não foi possível realizar a pesquisa, dados ou filtros faltantes.");
    }

    if(in_array("", $columns) || in_array("", $conditions) || in_array("", $complements)) {
        throw new Exception("Não foi possível realizar a pesquisa, dados incorretos ou faltantes.");
    }

    if($columnsLength !== $conditionsLength || $columnsLength !== $coplementsLength || $conditionsLength !== $coplementsLength) {
        throw new Exception("Dados insuficientes para realizar a pesquisa.");
    }

    $rooms = $roomDAO->customSearch($columns, $conditions, $complements);
} catch(Exception $exc){
    $_SESSION['msg-error'] = $exc->getMessage();
}

if($rooms === false){
   $_SESSION['msg-error'] = "Erro ao pesquisar quarto(s)!";
}

if($rooms === []){
   $_SESSION['msg-error'] = "Quarto(s) não encontrado(s)!";
} else{
    $_SESSION['msg-success'] = "Pesquisa realizada com sucesso!";
}