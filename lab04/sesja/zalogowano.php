<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // The user is logged in, allow access to the page
    echo '<b><p>Zalogowano</p></b>';
    echo '<a href="wyloguj.php">Wyloguj</a>';
} else {
    // The user is not logged in, redirect to the login page
    header("location: stronka.php");
    exit;
}