<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $car_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $servername = "szuflandia.pjwstk.edu.pl";
    $username = "s27479";
    $password = "Mak.Gala";
    $dbname = "s27479";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $stmt = $conn->prepare("SELECT * FROM samochody WHERE id = :id AND uzytkownik_id = :user_id");
    $stmt->bindParam(':id', $car_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $marka = $row['marka'];
        $model = $row['model'];
        $cena = $row['cena'];
        $rok = $row['rok'];
        $opis = $row['opis'];

        echo '
            <form action="" method="POST">
                <input type="hidden" name="id" value="' . $car_id . '">
                <label for="marka">Marka:</label>
                <input type="text" id="marka" name="marka" value="' . $marka . '" required><br>
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="' . $model . '" required><br>
                <label for="cena">Cena:</label>
                <input type="text" id="cena" name="cena" value="' . $cena . '" required><br>
                <label for="rok">Rok:</label>
                <input type="text" id="rok" name="rok" value="' . $rok . '" required><br>
                <label for="opis">Opis:</label>
                <textarea id="opis" name="opis" required>' . $opis . '</textarea><br>
                <input type="submit" value="Zapisz">
            </form>
        ';
    } else {
        echo "You are not authorized to edit this car.";
    }

    $conn = null;
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {

    $car_id = $_POST['id'];
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

    $stmt = $conn->prepare("UPDATE samochody SET marka = :marka, model = :model, cena = :cena, rok = :rok, opis = :opis WHERE id = :id AND uzytkownik_id = :user_id");
    $stmt->bindParam(':id', $car_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':marka', $marka);
    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':cena', $cena);
    $stmt->bindParam(':rok', $rok);
    $stmt->bindParam(':opis', $opis);
    $stmt->execute();

    echo "Car details updated successfully.";

    $conn = null;
}
?>
