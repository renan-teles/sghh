<?php
function showMessage(): void {
    if (isset($_SESSION['msg-error'])){
        echo "<div class='alert alert-danger text-center' role='alert'><i class='bi-exclamation-triangle-fill me-2'></i>". $_SESSION['msg-error'] ."</div>"; 
        unset($_SESSION['msg-error']);
    }
    if (isset($_SESSION['msg-success'])){
        echo "<div class='alert alert-success text-center' role='alert'><i class='bi-check-circle-fill me-2'></i>". $_SESSION['msg-success'] ."</div>"; 
        unset($_SESSION['msg-success']);
    }
}
?>