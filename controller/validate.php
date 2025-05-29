<?php

function validateAction(string $currentAction, array $actionsNames): bool {
    if (!$currentAction) {
        return false;
    }
    if (!in_array($currentAction, $actionsNames)) {
        return false;
    }
    return true;
}

function filter_input_float(string $value): float {
    try{
        $value = number_format(floatval($value), 2, ".",",");
        return floatval($value);
    } catch(Exception $exc){
        return 0.0;
    }
}

function validateCPF(string $cpf): bool {
    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($c = 0; $c < $t; $c++) {
            $soma += $cpf[$c] * (($t + 1) - $c);
        }
        $digito = ((10 * $soma) % 11) % 10;
        if ($cpf[$t] != $digito) {
            return false;
        }
    }

    return true;
}

function validateTelephone(string $telefone): bool {
    if (!in_array(strlen($telefone), [10, 11])) {
        return false;
    }

    if (!ctype_digit($telefone)) {
        return false;
    }

    if (strlen($telefone) == 11 && $telefone[2] !== '9') {
        return false;
    }

    if (strlen($telefone) == 10 && !in_array($telefone[2], ['2', '3', '4', '5'])) {
        return false;
    }
 
    return true;
}

function validateName(string $name): bool {
    return preg_match("/^[A-Za-zÀ-ÿ\s]{3,}$/", $name);
}

function validateDate(string $date): bool {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return false;
    }

    [$year, $month, $day] = explode('-', $date);

    return checkdate((int)$month, (int)$day, (int)$year);
}

function validatePassword(string $password): bool {
    return strlen($password) >= 7 && preg_match('/^[\p{L}\p{N}]+$/u', $password);
}

function validateDiffOfDays(){

}