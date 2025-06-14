<?php
    session_start();

    //Check Login
    require __DIR__ . "/../utils/utils.php";
    checkLogin();

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
<body>
    <?php showNavbar("rooms"); ?>

    <div class="invisible p-5"></div>

    <div class="container-lg mt-3">
        <div class="col-12 px-2 px-sm-5 mb-5 pb-3">
            <div class="row mb-3">
                <div class="col-12 col-md text-center text-md-start">
                    <h2 id="title-page"><i class="bi-building me-2"></i>Gestão de Quartos</h2>
                </div>
                <div class="col-12 col-md text-center text-md-end mt-2 mt-md-0">
                    <button class="btn text-ligth btn-brown" type="button" data-bs-target="#modalAddRoom" data-bs-toggle="modal">
                        <i class="bi-building-fill-add me-1"></i>Cadastrar Quarto
                    </button>
                </div>
            </div>

            <hr>

            <?php showMessage(); ?>

            <!-- SEARCH ROOMS -->
            <div class="accordion " id="accordionSearhRoom">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class='bi-search me-1'></i>Pesquisa de Quartos
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionSearhRoom">
                        <div class="accordion-body">
                            <form action="./rooms.php?act=custom-search-rooms" method="POST" id="formCustomSearchRooms">
                                <div class="row">
                                    <div class="col-sm-6 text-center text-sm-start">
                                        <h6>Pesquisar Quarto(s): </h6>
                                    </div>
                                    <div class="col-sm-6 text-center text-sm-end mb-3 mb-sm-0">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                               <i class="bi-plus-circle"></i> Adicionar Filtros
                                            </button>
                                            <ul id="filtersDropdownMenu" class="dropdown-menu">
                                                <li><button id="filterSearchRoomNumber" class="btn btnAddFilter w-100" type='button'>Número</button></li>
                                                <li><button id="filterSearchRoomCapacity" class="btn btnAddFilter w-100" type='button'>Capacidade</button></li>
                                                <li><button id="filterSearchRoomDailyPrice" class="btn btnAddFilter w-100" type='button'>Preço da Diária</button></li>
                                                <li><button id="filterSearchRoomTypeRoom" class="btn btnAddFilter w-100" type='button'>Tipo de Quarto</button></li>
                                                <li><button id="filterSearchRoomAvailability" class="btn btnAddFilter w-100" type='button'>Disponibilidade</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="divFiltersSearch"></div> 
                                <div class="col-12 text-end mt-3">
                                    <button id="btnSubmitFormCustomSearchRoom" type="submit" class="btn btn-primary"><i class='bi-search me-1'></i>Pesquisar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            
            <div class="col-12">
                <h4 class="mt-4">Quarto(s) Pesquisado(s): </h4>
            </div>
            
            <!-- VIEW ROOMS -->
            <div class="col-12 mt-4">
                <?php if($rooms): ?>
                    <div class="table-responsive">
                        <table class="table text-center align-middle table-sm table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nº</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Capacidade</th>
                                    <th scope="col">Preço da Diária</th>
                                    <th scope="col">Disponibilidade</th>
                                    <th scope="col">Andar</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rooms as $r): ?>
                                    <tr id='tr_<?= $r["id"]; ?>'>
                                        <th id='viewSearchNumberRoom'><?= $r["number"]; ?></th>
                                        <td id='viewSearchTypeRoom'><?= ucfirst(strtolower($r["type_room"])); ?></td>
                                        <td id='viewSearchCapacityRoom'><?= $r["capacity"]; ?></td>
                                        <td>R$<span id='viewSearchDailyPriceRoom' class="me-1"><?= number_format($r["daily_price"], 2, ",", "."); ?></span></td>
                                        <td id='viewSearchAvailabilityRoom'><?= ucfirst(strtolower($r["availability_room"])); ?></td>
                                        <td id='viewSearchFloorRoom'><?= $r["floor"]; ?></td>
                                        <td>
                                            <?php if(strtolower($r['availability_room']) !== 'ocupado'): ?>
                                                <button id='tr_<?=$r["id"];?>' class='btn btn-secondary btn-sm btn btnOpenModalEdit my-1 my-md-0' type='button' data-bs-target='#modalEditRoom' data-bs-toggle='modal'><i id='tr_<?=$r["id"];?>' class='bi-pencil-fill'></i></button>
                                                <button id='tr_<?=$r["id"];?>' class='btn btn-danger btn-sm btnOpenModalDelete my-1 my-md-0' type='button' data-bs-target='#modalDeleteRoom' data-bs-toggle='modal'><i id='tr_<?=$r["id"];?>' class='bi-trash-fill'></i></button>
                                            <?php endif; ?>
                                            <?php if(strtolower($r['availability_room']) === 'ocupado'): ?>
                                                Indiponíveis
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <?php if(!$rooms): ?>
                    <h5 class='mb-3'>Nenhum quarto pesquisado ou encontrado.</h5>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <button id="btnTop" class="btn bg-light shadow-sm text-brown px-3 fs-2"><i class="bi-arrow-bar-up"></i></button>

    <!-- MODAL REGISTER ROOM -->
    <div class="modal fade" id="modalAddRoom" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalLabel"><i class="bi-building-fill-add me-1"></i>Cadastrar Quarto</h1>
                    <button type="button" class="btn-close" id="btnCloseFormRegisterRoom" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form id="formRegisterRoom" action="../../controller/controllerRoom.php?act=register-room" method="POST">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="number_room">Número:</label>
                            <input type="text" name="number_room" id="number_room" placeholder="Digite o número do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="floor_room">Andar:</label>
                            <input type="text" name="floor_room" id="floor_room" placeholder="Digite o andar do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="capacity_room">Capacidade:</label>
                            <input type="text" name="capacity_room" id="capacity_room" placeholder="Digite a capacidade do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="daily_price_room">Preço da Diária:</label>
                            <input type="text" name="daily_price_room" id="daily_price_room" placeholder="Digite o preço da diária do quarto..." class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="availability_room">Disponibilidade:</label>
                            <select class="form-select" name="availability_room" id="availability_room" aria-label="Default select example">
                                <option value="1" selected>Disponível</option>
                                <option value="3">Indiponível</option>
                            </select>
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
                            <button id="btnSubmitFormRegisterRoom" type="submit" class="btn text-ligth btn-brown">Cadastrar Quarto</button>
                        </div>
                    </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

     <!-- MODAL EDIT ROOM -->
     <div class="modal fade" id="modalEditRoom" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalLabel"><i class="bi-building-fill-gear me-1"></i>Editar Quarto</h1>
                    <button type="button" class="btn-close" id="btnCloseModalFormEditRoom" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form id="formEditRoom" action="../../controller/controllerRoom.php?act=edit-room" method="POST">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="number_room">Número:</label>
                            <input type="text" name="number_room" id="number_room" placeholder="Digite o número do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="floor_room">Andar:</label>
                            <input type="text" name="floor_room" id="floor_room" placeholder="Digite o andar do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="capacity_room">Capacidade:</label>
                            <input type="text" name="capacity_room" id="capacity_room" placeholder="Digite a capacidade do quarto..." class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="daily_price_room">Preço da Diária (R$):</label>
                            <input type="text" name="daily_price_room" id="daily_price_room" placeholder="Digite o preço da diária do quarto..." class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="availability_room">Disponibilidade:</label>
                            <select class="form-select" name="availability_room" id="availability_room" aria-label="Default select example">
                                <option value="1" selected>Disponível</option>
                                <option value="3">Indiponível</option>
                            </select>
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
                            <button id="btnSubmitFormEditRoom" type="submit" class="btn btn-secondary">Editar Quarto</button>
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
                    <h4><i class="bi-building-fill-x me-1"></i>Deletar Quarto?</h4>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <form id="formDeleteRoom" action="../../controller/controllerRoom.php?act=delete-room" method="POST">
                        <input type="hidden" id="roomId" name="roomId">
                        <input type="hidden" id="roomNumber" name="number_room">
                        <button id="btnDelete" class="btn btn-danger" type="submit">Deletar</button>
                    </form>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/js_pages/rooms.js" type="module"></script>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>