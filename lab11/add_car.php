<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $cena = $_POST['cena'];
    $rok = $_POST['rok'];
    $opis = $_POST['opis'];

    $servername = "szuflandia.pjwstk.edu.pl";
    $username = "s27479";
    $password = "Mak.Gala";
    $dbname = "s27479";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


    $stmt = $conn->prepare("SELECT MAX(id) as max_id FROM samochody");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $next_id = $result['max_id'] + 1;

    $stmt = $conn->prepare("INSERT INTO samochody (id, uzytkownik_id, marka, model, cena, rok, opis) VALUES (:id, :user_id, :marka, :model, :cena, :rok, :opis)");
    $stmt->bindParam(':id', $next_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':marka', $marka);
    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':cena', $cena);
    $stmt->bindParam(':rok', $rok);
    $stmt->bindParam(':opis', $opis);
    $stmt->execute();

    echo "Car added successfully.";

    $conn = null;
}
?>

<!DOCTYPE html>
<html>
<body>
<h2>Add New Car</h2>
<form action="" method="POST">
    <label for="marka">Marka:</label>
    <input type="text" id="marka" name="marka" required><br>
    <label for="model">Model:</label>
    <input type="text" id="model" name="model" required><br>
    <label for="cena">Cena:</label>
    <input type="text" id="cena" name="cena" required><br>
    <label for="rok">Rok:</label>
    <input type="text" id="rok" name="rok" required><br>
    <label for="opis">Opis:</label>
    <textarea id="opis" name="opis" required></textarea><br>
    <input type="submit" value="Add Car">
</form>
</body>
</html>
