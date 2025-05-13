<?php
function showNavbar($active): void {
    echo (
        "
        <nav class='navbar navbar-expand-md shadow-sm bg-light'>
            <div class='container-md'>
                <h3 class='text-primary'>SGHH</h3>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
            <div class='collapse navbar-collapse' id='navbarNav'>
                <ul class='navbar-nav ms-auto'>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link ". ($active === "home"? "active" : "") ."' href='./home.php'><i class='bi- me-1'></i>Home</a>
                    </li>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link ". ($active === "hospedagens"? "active" : "") ."' href='./accommodations.php'><i class='bi- me-1'></i>Hospedagens</a>
                    </li>
                    <li class='nav-item me-md-2 mt-1 mt-md-0'>
                        <a class='nav-link ". ($active === "hospedes"? "active" : "") ."' href='./guests.php'><i class='bi-people me-1'></i>Hóspedes</a>
                    </li>
                    <li class='nav-item me-md-2 mb-3 mb-md-0'>
                        <a class='nav-link ". ($active === "quartos"? "active" : "") ."' href='./rooms.php'><i class='bi-building me-1'></i>Quartos</a>
                    </li>
                    <li class='nav-item ms-md-2 ms-auto'>
                        <a class='btn btn-danger' href='../../control/controlUser.php?act=logout-user'><i class='bi-box-arrow-in-left me-1'></i>Sair</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        "
    );
}
?>