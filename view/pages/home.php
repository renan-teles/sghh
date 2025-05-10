<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH - Home</title>
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class='navbar navbar-expand-md shadow-sm'>
        <div class='container-md'>
            <h3 class="text-primary">SGHH</h3>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarNav'>
                <ul class='navbar-nav ms-auto'>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link active' href='./home.php'><i class='bi- me-1'></i>Home</a>
                    </li>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link' href='./accommodations.php'><i class='bi- me-1'></i>Hospedagens</a>
                    </li>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link' href='./guests.php'><i class='bi- me-1'></i>Hóspedes</a>
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

    <div class="container mt-5 mt-sm-0">
        <div class="row justify-content-center align-items-center" style="height: 90vh;">
            <div class="col d-flex justify-content-center mb-3">
                <div class="card" style="width: 20rem;">
                    <img src="../assets/img/calendario.png" class="card-img-top w-25 ms-auto me-auto mt-3" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">Hospedagens</h5>
                        <p class="card-text ">Gestão de Hospedagens</p>
                        <a href="./accommodations.php" class="btn btn-primary">Gerir Hospedagens</a>
                    </div>
                </div>
            </div>
            
            <div class="col d-flex justify-content-center mb-3">
                <div class="card" style="width: 20rem;">
                    <img src="../assets/img/hospede.png" class="card-img-top w-25 ms-auto me-auto mt-3" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">Hóspedes</h5>
                        <p class="card-text ">Gestão de Hóspedes.</p>
                        <a href="./guests.php" class="btn btn-primary">Gerir Hóspedes</a>
                    </div>
                </div>
            </div>
            
            <div class="col d-flex justify-content-center mb-3">
                <div class="card mb-5 mb-sm-0" style="width: 20rem;">
                    <img src="../assets/img/quarto.png" class="card-img-top w-25 ms-auto me-auto mt-3" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">Quartos</h5>
                        <p class="card-text ">Gestão de Quartos.</p>
                        <a href="./rooms.php" class="btn btn-primary">Gerir Quartos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modals-->
    <!-- Scrollable modal -->
    <div class="modal-dialog modal-dialog-scrollable">
        ...
    </div>

    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>