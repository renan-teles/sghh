<?php
    session_start();

    //Components
    include_once __DIR__ . "/../components/navbar.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGHH - Home</title>
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body class="bg-img">

    <?php showNavbar("home"); ?>

    <div class="container-lg mt-5 mt-lg-0">
        <div class="row justify-content-center align-items-center" style="height: 100dvh;">
            <div class="col d-flex justify-content-center mb-3">
                <div class="card shadow-lg" style="width: 20rem;">
                    <img src="../assets/img/calendario.png" class="card-img-top w-25 ms-auto me-auto mt-3" alt="...">
                    <div class="card-body text-center shadow-lg">
                        <h5 class="card-title">Hospedagens</h5>
                        <p class="card-text px-3" style="text-align: justify;">
                            Controle completo das reservas, acompanhando check-ins, check-outs, disponibilidade de quartos e dados dos hóspedes de forma prática e organizada.
                        </p>
                        <a href="./accommodations.php" class="btn text-ligth btn-brown">Gerir Hospedagens</a>
                    </div>
                </div>
            </div>
            
            <div class="col d-flex justify-content-center mb-3">
                <div class="card shadow-lg" style="width: 20rem;">
                    <img src="../assets/img/hospede.png" class="card-img-top ms-auto me-auto mt-3" alt="..." style="width: 80px;">
                    <div class="card-body text-center shadow-lg">
                        <h5 class="card-title">Hóspedes</h5>
                        <p class="card-text px-3" style="text-align: justify;">
                            Registre, atualize e consulte as informações dos hóspedes com facilidade, mantendo um histórico completo de dados pessoais para um gerenciamento mais eficiente.
                        </p>
                        <a href="./guests.php" class="btn text-ligth btn-brown">Gerir Hóspedes</a>
                    </div>
                </div>
            </div>
            
            <div class="col d-flex justify-content-center mb-3">
                <div class="card mb-5 mb-lg-0 shadow-lg" style="width: 20rem;">
                    <img src="../assets/img/quarto.png" class="card-img-top w-25 ms-auto me-auto mt-3" alt="...">
                    <div class="card-body text-center shadow-lg">
                        <h5 class="card-title">Quartos</h5>
                        <p class="card-text px-3" style="text-align: justify;">
                            Organize e administre os quartos, definindo tipos, capacidades, preços e outras informações para garantir um controle eficiente de quartos.
                        </p>
                        <a href="./rooms.php" class="btn text-ligth btn-brown">Gerir Quartos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>