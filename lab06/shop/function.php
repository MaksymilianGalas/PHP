<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function dodaj($id) {
    if (!isset($_SESSION['koszyk'])) {
        $_SESSION['koszyk'] = array();
    }

    if (isset($_SESSION['koszyk'][$id])) {
        $_SESSION['koszyk'][$id]++;
    } else {
        $_SESSION['koszyk'][$id] = 1;
    }
}
function usun($id) {
    if (isset($_SESSION['koszyk'][$id])) {
        if ($_SESSION['koszyk'][$id] > 1) {
            $_SESSION['koszyk'][$id]--;
        } else {
            unset($_SESSION['koszyk'][$id]);
        }
    }
}
function wyczysc() {
    unset($_SESSION['koszyk']);
    session_destroy();
    dodaj(1);
    usun(1);
}
?>
