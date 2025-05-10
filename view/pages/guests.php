<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH - Gestão Hóspedes</title>
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray">
    <nav class='navbar navbar-expand-md shadow-sm'>
        <div class='container-md'>
            <h3 class="text-primary">SGHH</h3>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarNav'>
                <ul class='navbar-nav ms-auto'>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link' href='./home.php'><i class='bi- me-1'></i>Home</a>
                    </li>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link' href='./accommodations.php'><i class='bi- me-1'></i>Hospedagens</a>
                    </li>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link active' href='./guests.php'><i class='bi- me-1'></i>Hóspedes</a>
                    </li>
                    <li class='nav-item me-md-2 mb-3 mb-md-0'>
                        <a class='nav-link' href='./rooms.php'><i class='bi- me-1'></i>Quartos</a>
                    </li>
                    <li class='nav-item ms-md-2 ms-auto'>
                        <a class='btn btn-danger' href='../../control/controlUser.php?act=logout-user'><i class='bi-box-arrow-in-left me-1'></i>Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="col-12 shadow-sm rounded p-4 bg-light">
            <div class="row mb-3">
                <div class="col-12 col-md text-center text-md-start">
                    <h2><i class="bi-c me-2"></i>Gestão de Hóspedes</h2>
                </div>
                <div class="col-12 col-md text-center text-md-end mt-2 mt-md-0">
                    <button class="btn btn-primary" type="button" data-bs-target="#modalAddGuest" data-bs-toggle="modal">
                        <i class="bi-cart- me-1"></i>Cadastrar Hóspede
                    </button>
                </div>
            </div>
 
            <hr>
   
            <form method="POST" class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar hóspede por..." aria-label="Text input with radio button">
                <div class="input-group-text">
                    <input class="form-check-input mt-0 me-2" name="search_by" type="radio" id="search_by_cpf" value="cpf" aria-label="Radio button for following text input" checked>
                    <label for="search_by_cpf">CPF</label>
                </div>
                <div class="input-group-text">
                    <input class="form-check-input mt-0 me-2" name="search_by" type="radio" id="search_by_name" value="cpf" aria-label="Radio button for following text input">
                    <label for="search_by_name">Nome</label>
                </div>
                <button type="submit" class="btn btn-primary" type="button" id="button-addon2"><i class='bi-search me-1'></i></button>
            </form>

            <hr>

            <div class="col-12">
                <h5>Não há hóspedes cadastrados.</h5>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAddGuest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Hóspede</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>