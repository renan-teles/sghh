<?php

function showTrRoom($room): void{
    $id = $room["id"];
    $number = $room["number"];
    $capacity = $room["capacity"];
    $typeRoom = $room["type"];
    $dailyPrice = $room["daily_price"];
    $floor = $room["floor"];
    $isAvailable = $room["is_available"] == "1"? "Disponível": "Indisponível";
    echo (
        "
        <tr id='tr_$id'>
            <th scope='row' id='numberRoom'>$number</th>
                <td id='typeRoom'>$typeRoom</td>
                <td id='capacityRoom'>$capacity</td>
                <td id='dailyPriceRoom'>". number_format($dailyPrice, 2, ",", ".")  ."</td>
                <td id='isAvailable'>$isAvailable</td>
                <td id='floorRoom'>$floor</td>
                <td>
                    <button id='tr_$id' class='btn btn-secondary btn-sm btn btnOpenModalEdit my-1 my-sm-0' type='button' data-bs-target='#modalEditRoom' data-bs-toggle='modal'><i id='tr_$id' class='bi-pencil-fill'></i></button>
                    <button id='tr_$id' class='btn btn-danger btn-sm btnOpenModalDelete my-1 my-sm-0' type='button' data-bs-target='#modalDeleteRoom' data-bs-toggle='modal'><i id='tr_$id' class='bi-trash-fill'></i></button>
                </td>
        </tr>
        "
    );
}