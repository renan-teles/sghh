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
    if (is_null($value)) {
        return 0.0;
    }
    $value = str_replace('.', '', $value);
    $value = str_replace(',', '.', $value);
    if (is_numeric($value)) {
        return floatval($value);
    }
    return 0.0;
}


// function validateLogin(): void
// {
//     if(!isset($_SESSION['userData']))
//     {
//         header('Location: ../../index.php');
//         exit;
//     }
// }