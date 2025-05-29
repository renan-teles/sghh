<?php

function formatCPF(string $cpf): string {
    $cpf = preg_replace('/\D/', '', $cpf);

    if (strlen($cpf) !== 11) {
        return $cpf;
    }

    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

function formatTelephone(string $telefone): string {
    $telefone = preg_replace('/\D/', '', $telefone);

    if (strlen($telefone) === 11) {
        return preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2$3-$4', $telefone);
    }

    if (strlen($telefone) === 10) {
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    }

    return $telefone;
}

function checkLogin(): void {
    if(!isset($_SESSION['receptionistData'])){
        header('Location: ../../index.php');
        exit;
    }
}