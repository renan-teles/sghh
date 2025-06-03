<?php //sticky-top
function showNavbar($active): void {
    echo (
        "
        <nav class='navbar navbar-expand-lg shadow-sm bg-light fixed-top'>
            <div class='container-lg'>
               
                <a class='navbar-brand text-brown' href='./home.php'><span class='h3'>SGHH</span></a>

                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>

                <div class='collapse navbar-collapse' id='navbarNav'>
                <ul class='navbar-nav ms-auto'>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link ". ($active === "home"? "active" : "") ."' href='./home.php'><i class='bi-house me-1'></i>Página Inicial</a>
                    </li>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link ". ($active === "accommodations"? "active" : "") ."' href='./accommodations.php'><i class='bi-calendar-week me-1'></i>Hospedagens</a>
                    </li>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link ". ($active === "guests"? "active" : "") ."' href='./guests.php'><i class='bi-people me-1'></i>Hóspedes</a>
                    </li>
                    <li class='nav-item me-md-2 mb-3 mb-md-0'>
                        <a class='nav-link ". ($active === "rooms"? "active" : "") ."' href='./rooms.php'><i class='bi-building me-1'></i>Quartos</a>
                    </li>
                    <li class='nav-item me-md-2 mb-3 mb-md-0'>
                        <a class='nav-link ". ($active === "panel-receptionist"? "active" : "") ."' href='./panel-receptionist.php'><i class='bi-person-vcard me-1'></i>Painel</a>
                    </li>
                    <li class='nav-item ms-lg-2 ms-auto'>
                        <a class='btn btn-danger' href='../../controller/controllerReceptionist.php?act=logout-receptionist'><i class='bi-box-arrow-in-left me-1'></i>Sair</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        "
    );
}
?>