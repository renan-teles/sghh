<?php
    session_start();

    //Components
    include_once __DIR__ . "/../components/navbar.php";
    include_once __DIR__ . "/../components/message.php"; 
    
    //Search Data Controller
    require_once __DIR__ . "/../searchDataControllers/rooms/controllerDataSearchRooms.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH - Gestão de Quartos</title>
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray">
    <?php showNavbar("quartos"); ?>
    <div class="container mt-5">
        <div class="col-12 shadow-sm rounded p-4 bg-light mb-5">
            <div class="row mb-3">
                <div class="col-12 col-md text-center text-md-start">
                    <h2><i class="bi-building me-2"></i>Gestão de Quartos</h2>
                </div>
                <div class="col-12 col-md text-center text-md-end mt-2 mt-md-0">
                    <button class="btn btn-primary" type="button" data-bs-target="#modalAddRoom" data-bs-toggle="modal">
                        <i class="bi-building-fill-add me-1"></i>Cadastrar Quarto
                    </button>
                </div>
            </div>
            <hr>
            <?php showMessage(); ?>
            <div class="accordion " id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class='bi-search me-1'></i>Pesquisa de Quartos
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form action="./rooms.php?act=custom-search-rooms" method="POST" id="formCustomSearchRooms">
                                <div class="row">
                                    <div class="col-md-6 text-center text-md-start">
                                        <h6>Pesquisar Quarto(s): </h6>
                                    </div>
                                    <div class="col-md-6 text-center text-md-end mb-3 mb-md-0">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                               <i class="bi-plus-circle"></i> Adicionar Filtros
                                            </button>
                                            <ul id="filtersDropdownMenu" class="dropdown-menu">
                                                <li><button id="filterNumber" class="btn btnAddFilter w-100" type='button'>Número</button></li>
                                                <li><button id="filterCapacity" class="btn btnAddFilter w-100" type='button'>Capacidade</button></li>
                                                <li><button id="filterDailyPrice" class="btn btnAddFilter w-100" type='button'>Preço da Diária</button></li>
                                                <li><button id="filterTypeRoom" class="btn btnAddFilter w-100" type='button'>Tipo de Quarto</button></li>
                                                <li><button id="filterAvailability" class="btn btnAddFilter w-100" type='button'>Disponibilidade</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="divFiltersSearch"></div> 
                                <div class="col-12 text-center text-md-end mt-3">
                                    <button id="btn_submit" type="submit" class="btn btn-primary"><i class='bi-search me-1'></i>Pesquisar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <h4 class="mt-4">Quarto(s) Pesquisado(s): </h4>
            <div class="col-12 mt-4">
                <div class="table-responsive">
                <table class="table text-center align-middle table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Capacidade</th>
                            <th scope="col">Preço da Diária (R$)</th>
                            <th scope="col">Disponibilidade</th>
                            <th scope="col">Andar</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($rooms){
                                foreach ($rooms as $r) {
                        ?>
                            <tr id='tr_<?=$r["id"];?>'>
                                <th scope='row' id='numberRoom'><?=$r["number"];?></th>
                                <td id='typeRoom'><?=$r["type"];?></td>
                                <td id='capacityRoom'><?=$r["capacity"];?></td>
                                <td><span id='dailyPriceRoom' class="me-1"><?= number_format($r["daily_price"], 2, ",", "."); ?></span>R$</td>
                                <td id='isAvailable'><?= $r["is_available"] === "1"? "Disponível" : "Indisponível";?></td>
                                <td id='floorRoom'><?=$r["floor"];?></td>
                                <td>
                                    <button id='tr_<?=$r["id"];?>' class='btn btn-secondary btn-sm btn btnOpenModalEdit my-1 my-sm-0' type='button' data-bs-target='#modalEditRoom' data-bs-toggle='modal'><i id='tr_<?=$r["id"];?>' class='bi-pencil-fill'></i></button>
                                    <button id='tr_<?=$r["id"];?>' class='btn btn-danger btn-sm btnOpenModalDelete my-1 my-sm-0' type='button' data-bs-target='#modalDeleteRoom' data-bs-toggle='modal'><i id='tr_<?=$r["id"];?>' class='bi-trash-fill'></i></button>
                                </td>
                            </tr>
                        <?php
                                }
                            } else{
                                echo "<h5 class='mb-3'>Nenhum quarto pesquisado ou encontrado.</h5>";
                            }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD ROOM -->
    <div class="modal fade" id="modalAddRoom" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalLabel"><i class="bi-building-fill-add me-1"></i>Cadastrar Quarto</h1>
                    <button type="button" class="btn-close" id="btnClose1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form id="formAddRoom" action="../../controller/controllerRoom.php?act=register-room" method="POST">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="number_room">Número:</label>
                            <input type="number" name="number_room" id="number_room" placeholder="Digite o número do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="floor_room">Andar:</label>
                            <input type="number" name="floor_room" id="floor_room" placeholder="Digite o andar do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="capacity_room">Capacidade:</label>
                            <input type="number" name="capacity_room" id="capacity_room" placeholder="Digite a capacidade do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="daily_price_room">Preço da Diária:</label>
                            <input type="text" name="daily_price_room" id="daily_price_room" placeholder="Digite o preço da diária do quarto..." class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="type_room">Tipo:</label>
                            <select class="form-select" name="type_room" id="type_room" aria-label="Default select example">
                                <option value="1" selected>Simples</option>
                                <option value="2">Suíte</option>
                                <option value="3">Luxuoso</option>
                            </select>
                        </div>
                        <div class="col-12 text-end">
                            <button id="btn_submit" type="submit" class="btn btn-primary">Cadastrar Quarto</button>
                        </div>
                    </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

     <!-- MODAL EDIT ROOM -->
     <div class="modal fade" id="modalEditRoom" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalLabel"><i class="bi-building-fill-gear me-1"></i>Editar Quarto</h1>
                    <button type="button" class="btn-close" id="btnClose2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form id="formEditRoom" action="../../controller/controllerRoom.php?act=edit-room" method="POST">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="number_room">Número:</label>
                            <input type="number" name="number_room" id="number_room" placeholder="Digite o número do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="floor_room">Andar:</label>
                            <input type="number" name="floor_room" id="floor_room" placeholder="Digite o andar do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="capacity_room">Capacidade:</label>
                            <input type="number" name="capacity_room" id="capacity_room" placeholder="Digite a capacidade do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="daily_price_room">Preço da Diária (R$):</label>
                            <input type="text" name="daily_price_room" id="daily_price_room" placeholder="Digite o preço da diária do quarto..." class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="type_room">Tipo:</label>
                            <select class="form-select" name="type_room" id="type_room" aria-label="Default select example">
                                <option value="1">Simples</option>
                                <option value="2">Suíte</option>
                                <option value="3">Luxuoso</option>
                            </select>
                        </div>
                        <div class="col-12 text-end">
                            <input type="hidden" id="roomId" name="roomId">
                            <button id="btn_submit" type="submit" class="btn btn-primary">Editar Quarto</button>
                        </div>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE ROOM -->
    <div class="modal fade" id="modalDeleteRoom" aria-hidden="true" aria-labelledby="modalDeleteRoomLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class="bi-building-fill-x me-1"></i>Excluir Quarto?</h4>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    <form id="formDeleteRoom" action="../../controller/controllerRoom.php?act=delete-room" method="POST">
                        <input type="hidden" id="roomId" name="roomId">
                        <button id="btnDelete" class="btn btn-danger" type="submit">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/js_pages/rooms.js" type="module"></script>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>