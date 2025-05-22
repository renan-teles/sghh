<?php
    session_start();

    //Components
    include_once __DIR__ . "/../components/navbar.php";
    include_once __DIR__ . "/../components/message.php"; 
    
    //Utils
    require_once __DIR__ . "/../utils/utils.php";

    //Search Data Controllers
    require_once __DIR__ . "/../searchDataControllers/rooms/controllerDataSearchRooms.php";
    require_once __DIR__ . "/../searchDataControllers/accommodations/controllerDataSearchAccommodations.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH - Gestão de Hospedagens</title>
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-brown">
    <?php showNavbar("hospedagens"); ?>
    <div class="container-lg mt-4">
        <div class="col-12 shadow rounded p-4 bg-light mb-5">
            <div class="row mb-3">
                <div class="col-12 col-md text-center text-md-start">
                    <h2><i class="bi-calendar-week me-2"></i>Gestão de Hospedagens</h2>
                </div>
            </div>
            
            <hr>

            <?php showMessage(); ?>

            <div class="col-12 my-4">
                <h5><i class='bi-search me-1'></i>Área de Pesquisa:</h5>
            </div>

            <!-- SEARCH ROOMS -->
            <div class="accordion mb-3" id="accordionSearchRooms">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class='bi-search me-1'></i>Pesquisa de Quartos
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionSearchRooms">
                        <div class="accordion-body">
                            <form action="./accommodations.php?act=custom-search-rooms" method="POST" id="formCustomSearchRooms">
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
                                <div id="divFiltersSearchRooms" clas="col-12"></div> 
                                <div class="col-12 text-end mt-3">
                                    <button id="btnSubmitCustomSearchRooms" type="submit" class="btn btn-primary"><i class='bi-search me-1'></i>Pesquisar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEARCH ACCOMMODAIONS -->
            <div class="accordion" id="accordionSearchAccommodations">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                            <i class='bi-search me-1'></i>Pesquisa de Hospedagens
                        </button>
                    </h2>
                    <div id="collapseTwo2" class="accordion-collapse collapse" data-bs-parent="#accordionSearchAccommodations">
                        <div class="accordion-body">
                            <form action="./accommodations.php?act=custom-search-accommodations" method="POST" id="formCustomSearchAccommodations">
                                <div class="row">
                                    <div class="col-sm-6 text-center text-sm-start">
                                        <h6>Pesquisar Hospedagem(s): </h6>
                                    </div>
                                    <div class="col-sm-6 text-center text-sm-end mb-3 mb-sm-0">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                               <i class="bi-plus-circle"></i> Adicionar Filtros
                                            </button>
                                            <ul id="filtersDropdownMenu" class="dropdown-menu">
                                                <li><button id="filterSearchAccommodationStatusAccommodation" class="btn btnAddFilter w-100" type='button'>St. de Hospedagem</button></li>
                                                <li><button id="filterSearchAccommodationStatusPayment" class="btn btnAddFilter w-100" type='button'>St. de Pagamento</button></li>
                                                <li><button id="filterSearchAccommodationNumberRoom" class="btn btnAddFilter w-100" type='button'>Número do Quarto</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="divFiltersSearchAccommodations"></div> 
                                <div class="col-12 text-center text-sm-end mt-3">
                                    <button id="btnSubmitCustomSearchAccommodations" type="submit" class="btn btn-primary"><i class='bi-search me-1'></i>Pesquisar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>

            <div class="col-12 my-4">
                <h5><i class="bi-eye me-1"></i>Área de Visualização:</h5>
            </div>

            <!-- VIEW ROOMS -->
            <div class="accordion mb-2" id="accordionViewRooms">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
                            <i class='bi-building me-1'></i>Quartos Pesquisados:
                        </button>
                    </h2>
                    <div id="collapseTwo3" class="accordion-collapse collapse show" data-bs-parent="#accordionViewRooms">
                        <div class="accordion-body">
                            <div class="col-12">
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
                                                    <th scope="col">Realizar Hospedagem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($rooms as $r): ?>
                                                    <tr id='tr_<?=$r["id"];?>'>
                                                        <th id='viewSearchNumberRoom'><?=$r["number"];?></th>
                                                        <td id='viewSearchTypeRoom'><?=ucfirst(strtolower($r["type_room"]));?></td>
                                                        <td id='viewSearchCapacityRoom'><?=$r["capacity"];?></td>
                                                        <td>R$<span id='viewSearchDailyPriceRoom' class="me-1"><?=number_format($r["daily_price"], 2, ",", ".");?></span></td>
                                                        <td id='viewSearchIsAvailable'><?=$r["is_available"] === "1"? "Disponível" : "Indisponível";?></td>
                                                        <td id='viewSearchfloorRoom'><?=$r["floor"];?></td>
                                                        <td>
                                                            <?php if($r['is_available'] === "1"): ?>
                                                                <button id='tr_<?=$r["id"];?>' class='btn btn-primary btn-sm btn btnOpenModalCreateAccmmodation my-1 my-sm-0' type='button' data-bs-target='#modalCreateAccomm' data-bs-toggle='modal'><i id='tr_<?=$r["id"];?>' class='bi-person-fill-add me-1'></i>Hospedar</button>
                                                            <?php endif; ?>
                                                            <?php if($r['is_available'] !== "1"): ?>
                                                                Indisponível
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif ?>
                                <?php if(!$rooms): ?>
                                    <h5 class='mb-3'>Nenhum quarto pesquisado ou encontrado.</h5>
                                <?php endif; ?>    
                            </div>  
                        </div>
                    </div>
                </div>
            </div>

            <!-- VIEW ACCOMMODATIONS -->
            <div class="accordion mt-3" id="accordionViewAccommodations">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo4" aria-expanded="false" aria-controls="collapseTwo4">
                            <i class='bi-calendar-week me-1'></i>Hospedagens Pesquisadas:
                        </button>
                    </h2>
                    <div id="collapseTwo4" class="accordion-collapse collapse show" data-bs-parent="#accordionViewAccommodations">
                        <div class="accordion-body">
                            <div class="col-12">
                                <?php if($accommodations): ?>
                                    <h6>Informações de Hospedagem: </h6>
                                    <div class="table-responsive mb-4">
                                        <table class="table text-center align-middle table-sm table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="col-3">Hóspede(s)</th>
                                                    <th scope="col" class="col-2">Inf. de Quarto</th>
                                                    <th scope="col">Checkin</th>
                                                    <th scope="col">Checkout</th>         
                                                    <th scope="col">St. de Hospedagem</th>         
                                                    <th scope="col">St. de Pagamento</th>         
                                                    <th scope="col" class="col-2">Valor Total</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($accommodations as $a) : ?>
                                                    <tr id='tr_<?=$a["id"];?>'>
                                                        <td>
                                                            <?php 
                                                                $guests = explode(', ', $a['guests']);
                                                                if($guests){
                                                                    foreach ($guests as $g) {
                                                                        $detailG = explode('- ', $g);
                                                                        echo "<span>" . $detailG[0] . "</span></br>";
                                                                        echo "<span>" . formatCPF($detailG[1]) . "</span></br>" ;
                                                                        echo "<span>" . formatTelephone($detailG[2]) . "</span></br></br>";
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                $room = explode(', ', $a["room"]);
                                                                if($room){
                                                                    foreach ($room as $r) {
                                                                        $detailR = explode('- ', $r);
                                                                        echo "Número: <span id='viewSearchNumberRoom'>" . $detailR[0] . "</span></br>";
                                                                        echo "Capacidade: <span id='viewSearchCapacityRoom'>" . $detailR[1] . "</span></br>" ;
                                                                        echo "Diária: R$<span id='viewSearchDailyPriceRoom'>" . number_format($detailR[2], 2, ",", ".") . "</span>";
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td id='viewSearchDateCheckin'><?= date("d/m/Y", strtotime($a["date_checkin"])); ?></td>
                                                        <td id='viewSearchDateCheckout'><?= date("d/m/Y", strtotime($a["date_checkout"])); ?></td>
                                                        <td><?= ucfirst(strtolower($a['status_accommodation'])); ?></td>
                                                        <td><?=ucfirst(strtolower($a['status_payment']));?></td>
                                                        <td>R$<span id='viewSearchTotalValue'><?= number_format($a["total_value"], 2,",","."); ?><span></td>
                                                        <td>
                                                            <?php if(strtolower($a['status_accommodation']) === "ativa"): ?>
                                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Ações
                                                                </button>
                                                                <ul id="optionsAccommMenu" class="dropdown-menu">
                                                                    <li class="mb-1 mb-md-2">
                                                                        <button id='tr_<?=$a["id"];?>' class='btn btn-outline-success btn-sm btnOpenModalEnd my-1 my-sm-0 w-100' type='button' data-bs-target='#modalEndAccomm' data-bs-toggle='modal'><i class="bi-building-fill-check me-1"></i>Finalizar</button>
                                                                    </li>
                                                                    <li class="mb-1 mb-md-2">
                                                                        <button id='tr_<?=$a["id"];?>' class='btn btn-outline-secondary btn-sm btnOpenModalEdit my-1 my-sm-0 w-100' type='button' data-bs-target='#modalEditAccomm' data-bs-toggle='modal'><i class="bi-building-fill-gear me-1"></i>Editar</button>
                                                                    </li>
                                                                    <li>
                                                                        <button id='tr_<?=$a["id"];?>' class='btn btn-outline-danger btn-sm btnOpenModalCanceled my-1 my-sm-0 w-100' type='button' data-bs-target='#modalCanceledAccomm' data-bs-toggle='modal'><i class="bi-building-fill-x me-1"></i>Cancelar</button>
                                                                    </li>
                                                                </ul>  
                                                            <?php endif; ?>
                                                            <?php if(strtolower($a['status_accommodation']) !== "ativa"): ?>
                                                                Indisponíveis
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif ?>
                                <?php if(!$accommodations): ?>
                                    <h5>Nenhuma hospedagem pesquisada ou encontrada.</h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CREATE ACCOMMODATION -->
    <div class="modal fade" id="modalCreateAccomm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalLabel"><i class="bi-person-fill-add me-1"></i>Realizar Hospedagem</h1>
                    <button type="button" class="btn-close" id="btnCloseModalFormCreateAccommodations" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form id="formCreateAccommodation" action="../../controller/controllerAccommodation.php?act=register-accommodation" method="POST">
                        <div class="row">
                            <div class="col-12">
                                <h6><i class="bi-building me-1"></i>Informações Sobre o Quarto: </h6>
                            </div>
                           
                            <div class="col-md-4 mb-4 mb-md-5">
                                <label for="number_room">Número:</label>
                                <input type="number" name="number_room" id="number_room" class="form-control" readonly>
                            </div>
                            
                            <div class="col-md-4 mb-4 mb-md-5">
                                <label for="capacity_room">Capacidade:</label>
                                <input type="number" name="capacity_room" id="capacity_room" class="form-control" readonly>
                            </div>
                            
                            <div class="col-md-4 mb-4 mb-md-5">
                                <label for="daily_price_room">Preço da Diária:</label>
                                <input type="text" name="daily_price_room" id="daily_price_room" class="form-control" readonly>
                            </div>
                            
                            <div class="col-12">
                                <h6><i class="bi-calendar-week me-1"></i>Informações Sobre a Hospedagem: </h6>  
                            </div>                     

                            <div class="col-md-6 mb-3">
                                <label for="date_checkin">Data de Entrada:</label>
                                <input type="date" name="date_checkin" id="date_checkin" placeholder="Digite o andar do quarto..." class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_checkout">Data de Saída:</label>
                                <input type="date" name="date_checkout" id="date_checkout" placeholder="Digite o andar do quarto..." class="form-control">
                            </div>

                            <div class="col-md-12 mb-4 mb-md-5">
                               <span>Valor Estimado da Hospedagem: <strong id="valueTotalDays">R$0,00</strong></span>
                            </div>
                           
                            <div class="col-md-6 mb-3">
                                <h6><i class="bi-person me-1"></i>Informações Sobre os Hóspedes: </h6>  
                            </div>

                            <div class="col-md-6 text-end mb-3">
                                <button id='btnAddCpfGuest' type="button" class="btn btn-success"><i class="bi-plus-circle"></i></button>
                            </div>

                            <div id="divContainerCpfGuests" class="col-12"></div>
         
                            <div class="col-md-12 mt-2 text-end">
                                <input type="hidden" id="roomId" name="roomId">
                                <button id="btnSubmitFormCreateAccommodation" type="submit" class="btn btn-primary">Realizar Hospedagem</button>
                            </div>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
   
    <!-- MODAL EDIT ACCOMMODATION -->
    <div class="modal fade" id="modalEditAccomm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalLabel"><i class="bi-building-fill-gear me-1"></i>Editar Hospedagem</h1>
                    <button type="button" class="btn-close" id="btnCloseModalFormEditAccommodation" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form id="formEditAccommodation" action="../../controller/controllerAccommodation.php?act=edit-accommodation" method="POST">
                        <div class="row">
                            <div class="col-12">
                                <h6><i class="bi-building me-1"></i>Informações Sobre o Quarto: </h6>
                            </div>
                           
                            <div class="col-md-4 mb-5">
                                <label for="number_room">Número:</label>
                                <input type="text" name="number_room" id="number_room" class="form-control" readonly>
                            </div>
                            
                            <div class="col-md-4 mb-5">
                                <label for="capacity_room">Capacidade:</label>
                                <input type="text" name="capacity_room" id="capacity_room" class="form-control" readonly>
                            </div>
                            
                            <div class="col-md-4 mb-5">
                                <label for="daily_price_room">Preço da Diária:</label>
                                <input type="text" name="daily_price_room" id="daily_price_room" class="form-control" readonly>
                            </div>
                            
                            <div class="col-12">
                                <h6><i class="bi-calendar-week me-1"></i>Informações Sobre a Hospedagem: </h6>  
                            </div>                     

                            <div class="col-md-6 mb-3">
                                <label for="date_checkin">Data de Entrada:</label>
                                <input type="date" name="date_checkin" id="date_checkin" placeholder="Digite o andar do quarto..." class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_checkout">Data de Saída:</label>
                                <input type="date" name="date_checkout" id="date_checkout" placeholder="Digite o andar do quarto..." class="form-control">
                            </div>

                            <div class="col-md-12 mb-5">
                               <span>Valor Estimado da Hospedagem: <strong id="valueTotalDays">R$0,00</strong></span>
                            </div>
                           
                            <div class="col-md-12 text-end">
                                <input type="hidden" id="accommId" name="accommodationId">
                                <button id="btnSubmitFormEditAccommodation" type="submit" class="btn btn-secondary">Editar Hospedagem</button>
                            </div>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CANCELED ACCOM -->
    <div class="modal fade" id="modalCanceledAccomm" aria-hidden="true" aria-labelledby="modalCanceledAccommLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class="bi-building-fill-x me-1"></i>Cancelar Hospedagem?</h4>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <form id="formCanceledAccommodation" action="../../controller/controllerAccommodation.php?act=cancel-accommodation" method="POST">
                        <input type="hidden" id="accommId" name="accommodationId">
                        <button id="btnCancel" class="btn btn-danger" type="submit">Cancelar</button>
                    </form>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Não Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL END ACCOM -->
    <div class="modal fade" id="modalEndAccomm" aria-hidden="true" aria-labelledby="modalEndAccommLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class="bi-building-fill-check me-1"></i>Finalizar Hospedagem?</h4>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    <form id="formEndAccommodation" action="../../controller/controllerAccommodation.php?act=end-accommodation" method="POST">
                        <input type="hidden" id="accommId" name="accommodationId">
                        <button id="btnEnd" class="btn btn-success" type="submit">Finalizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/js_pages/accommodations.js" type="module"></script>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>