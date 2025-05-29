<?php

require_once __DIR__ . "/../Action.php";

class LogoutReceptionist implements Action {
    public function execute(ClassDAO $receptionistDAO): void {
        session_destroy();
        header('Location: ../index.php');
        exit;
    }
}