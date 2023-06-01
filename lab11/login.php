<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST['login'];
    $password1 = $_POST['password1'];

    $servername = "szuflandia.pjwstk.edu.pl";
    $username = "s27479";
    $password = "Mak.Gala";
    $dbname = "s27479";
    $conn = new mysqli($servername, $username, $password, $dbname);

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id FROM uzytkownicy WHERE login = '$login' AND haslo = '$password1'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];

        echo "dziala";
        header("Location: admin.php");
        exit();
    } else {
        session_destroy();
        echo "niedziala";
        header("Location: admin.php");
        exit();
    }

    $conn->close();
}
?>
