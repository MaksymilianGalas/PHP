<?php
$login = 'admin';
$haslo = '1234';

if ($_GET["login"] == $login && $_GET["haslo"] == $haslo) {
    session_start();
    $_SESSION['loggedin'] = true;
    header("Location: zalogowano.php");
} else {
    echo "Błędny login lub hasło. ";
    echo '<a href="stronka.php">Spróbuj ponownie</a>';
    unset($_SESSION["loggedin"]);
    session_destroy();
}

