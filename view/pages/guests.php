<?php
    session_start();
    
    //Check Login
    require __DIR__ . "/../utils/utils.php";
    checkLogin();

    //Components
    include_once __DIR__ . "/../components/navbar.php";
    include_once __DIR__ . "/../components/message.php"; 

    //Search Data Controller
    require_once __DIR__ . "/../searchDataControllers/guests/controllerDataSearchGuests.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH - Gestão de Hóspedes</title>
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-brown">

    <?php showNavbar("guests"); ?>

    <div class="invisible p-5"></div>
    
    <div class="container-lg">
        <div class="col-12 shadow rounded p-4 bg-light mb-5">
            <div class="row mb-3">
                <div class="col-12 col-md text-center text-md-start">
                    <h2 id="title-page"><i class="bi-people me-2"></i>Gestão de Hóspedes</h2>
                </div>
                <div class="col-12 col-md text-center text-md-end mt-2 mt-md-0">
                    <button class="btn text-ligth btn-brown" type="button" data-bs-target="#modalAddGuest" data-bs-toggle="modal">
                        <i class="bi-person-fill-add me-1"></i>Cadastrar Hóspede
                    </button>
                </div>
            </div>

            <hr>

            <?php showMessage(); ?>

            <!-- SEARCH GUESTS -->
            <div class="accordion " id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class='bi-search me-1'></i>Pesquisa de Hóspedes
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form action="./guests.php?act=custom-search-guests" method="POST" id="formCustomSearchGuest">
                                <div class="row">
                                    <div class="col-sm-6 text-center text-sm-start">
                                        <h6>Pesquisar Hóspede(s): </h6>
                                    </div>
                                    <div class="col-sm-6 text-center text-sm-end mb-3 mb-sm-0">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                               <i class="bi-plus-circle"></i> Adicionar Filtros
                                            </button>
                                            <ul id="filtersDropdownMenu" class="dropdown-menu">
                                                <li><button id="filterSearchGuestName" class="btn btnAddFilter w-100" type='button'>Nome</button></li>
                                                <li><button id="filterSearchGuestEmail" class="btn btnAddFilter w-100" type='button'>Email</button></li>
                                                <li><button id="filterSearchGuestCPF" class="btn btnAddFilter w-100" type='button'>CPF</button></li>
                                                <li><button id="filterSearchGuestCPFResposible" class="btn btnAddFilter w-100" type='button'>CPF do Responsável</button></li>
                                                <li><button id="filterSearchGuestTelephone" class="btn btnAddFilter w-100" type='button'>Telefone</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="divFiltersSearch" class="col-12"></div> 
                                <div class="col-12 text-end mt-3">
                                    <button id="btnSubmitFormSearchGuests" type="submit" class="btn btn-primary"><i class='bi-search me-1'></i>Pesquisar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="col-12">
                <h4 class="mt-4">Hóspede(s) Pesquisado(s): </h4>
            </div>

            <!-- VIEW GUESTS -->
            <div class="col-12 mt-4">
                <?php if($guests): ?>
                    <div class="table-responsive">
                        <table class="table text-center align-middle table-sm table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="col-3">Nome</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">CPF do Responsável</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Nascimento</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($guests as $g): ?>
                                    <tr id='tr_<?=$g["id"];?>'>
                                        <th id='viewSearchNameGuest'><?= ucwords($g["name"]); ?></th>
                                        <td id='viewSearchEmailGuest'><?= $g["email"]; ?></td>
                                        <td id='viewSearchCpfGuest'><?= formatCPF($g["cpf"]); ?></td>
                                        <td id='viewSearchCpfResponsibleGuest'><?= formatCPF($g["cpf_responsible"] ?? ""); ?></td>
                                        <td id='viewSearchTelephoneGuest'><?= formatTelephone($g["telephone"]); ?></td>
                                        <td id='viewSearchDateBirthGuest'><?= date("d/m/Y", strtotime($g["date_birth"])); ?></td>
                                        <td>
                                            <button id='tr_<?= $g["id"]; ?>' class='btn btn-secondary btn-sm btn btnOpenModalEdit my-1 my-md-0' type='button' data-bs-target='#modalEditGuest' data-bs-toggle='modal'><i id='tr_<?= $g["id"]; ?>' class='bi-pencil-fill'></i></button>
                                            <button id='tr_<?= $g["id"] ;?>' class='btn btn-danger btn-sm btnOpenModalDelete my-1 my-md-0' type='button' data-bs-target='#modalDeleteGuest' data-bs-toggle='modal'><i id='tr_<?= $g["id"]; ?>' class='bi-trash-fill'></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <?php if(!$guests): ?>
                    <h5 class='mb-3'>Nenhum hóspede pesquisado ou encontrado.</h5>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <button id="btnTop" class="btn bg-light shadow-sm text-brown px-3 fs-2"><i class="bi-arrow-bar-up"></i></button>

    <!-- MODAL REGISTER GUEST -->
    <div class="modal fade" id="modalAddGuest" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalLabel"><i class="bi-person-fill-add me-1"></i>Cadastrar Hóspede</h1>
                    <button type="button" class="btn-close" id="btnCloseModalFormRegisterGuest" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form id="formRegisterGuest" action="../../controller/controllerGuest.php?act=register-guest" method="POST">
                        <div class="row row-cols-md-2">
                            <div class="col mb-3">
                                <label for="name_guest">Nome Completo:</label>
                                <input type="text" name="name_guest" id="name_guest" placeholder="Digite o nome completo do hóspede..." class="form-control">
                            </div>
                            <div class="col mb-3">
                                <label for="email_guest">Email:</label>
                                <input type="email" name="email_guest" id="email_guest" placeholder="Digite o email do hóspede..." class="form-control">
                            </div>
                            <div class="col mb-3">
                                <label for="cpf_guest">CPF:</label>
                                <input type="text" name="cpf_guest" id="cpf_guest" placeholder="Digite o CPF do hóspede..." class="form-control">
                            </div>

                            <div class="col mb-3">
                                <label for="cpf_responsible_guest">CPF do Responsável:</label>
                                <input type="text" name="cpf_responsible_guest" id="cpf_responsible_guest" placeholder="Digite o CPF do responsável do hóspede..." class="form-control">
                            </div>

                            <div class="col mb-3">
                                <label for="telephone_guest">Telefone:</label>
                                <input type="text" name="telephone_guest" id="telephone_guest" placeholder="Digite o telefone do hóspede..." class="form-control">
                            </div>
                            <div class="col  mb-3">
                                <label for="date_birth_guest">Data de Nascimento:</label>
                                <input type="date" name="date_birth_guest" id="date_birth_guest" placeholder="Digite o telefone do hóspede..." class="form-control">
                            </div>
                        </div>
                        <div class="col-12 text-end">
                            <button id="btnSubmitFormRegisterGuest" type="submit" class="btn text-ligth btn-brown">Cadastrar Hóspede</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

     <!-- MODAL EDIT GUEST -->
     <div class="modal fade" id="modalEditGuest" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalLabel"><i class="bi-person-fill-gear me-1"></i>Editar Hóspede</h1>
                    <button type="button" class="btn-close" id="btnCloseModalFormEditGuest" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditGuest" action="../../controller/controllerGuest.php?act=edit-guest" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name_guest">Nome:</label>
                                <input type="text" name="name_guest" id="name_guest" placeholder="Digite o nome do hóspede..." class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email_guest">Email:</label>
                                <input type="email" name="email_guest" id="email_guest" placeholder="Digite o email do hóspede..." class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cpf_guest">CPF:</label>
                                <input type="text" name="cpf_guest" id="cpf_guest" placeholder="Digite o CPF do hóspede..." class="form-control">
                            </div>
                            <div class="col mb-3">
                                <label for="cpf_responsible_guest">CPF do Responsável:</label>
                                <input type="text" name="cpf_responsible_guest" id="cpf_responsible_guest" placeholder="Digite o CPF do responsável do hóspede..." class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telephone_guest">Telefone:</label>
                                <input type="text" name="telephone_guest" id="telephone_guest" placeholder="Digite o telefone do hóspede..." class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_birth_guest">Data de Nascimento:</label>
                                <input type="date" name="date_birth_guest" id="date_birth_guest" class="form-control">
                            </div>
                        <div class="col-12 text-end">
                            <input type="hidden" id="guestId" name="guestId">
                            <button id="btnSubmitFormEditGuest" type="submit" class="btn btn-secondary">Editar Hóspede</button>
                        </div>
                    </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE GUEST -->
    <div class="modal fade" id="modalDeleteGuest" aria-hidden="true" aria-labelledby="modalDeleteGuestLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class="bi-person-fill-x me-1"></i>Deletar Hóspede?</h4>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <form id="formDeleteGuest" action="../../controller/controllerGuest.php?act=delete-guest" method="POST">
                        <input type="hidden" id="guestId" name="guestId">
                        <input type="hidden" id="guestCpf" name="cpf_guest">
                        <button id="btnDelete" class="btn btn-danger" type="submit">Deletar</button>
                    </form>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/js_pages/guests.js" type="module"></script>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>