<?php
$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27479";
$password = "Mak.Gala";
$dbname = "s27479";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the car ID from the URL query string
$carId = $_GET["id"];

// Retrieve the car data from the database
$sql = "SELECT id, marka, model, cena, rok, opis FROM samochody WHERE id = $carId";
$result = $conn->query($sql);

// Display the car data on the car detail page
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "ID: " . $row["id"] . "<br>";
    echo "Marka: " . $row["marka"] . "<br>";
    echo "Model: " . $row["model"] . "<br>";
    echo "Cena: " . $row["cena"] . "<br>";
    echo "Rok: " . $row["rok"] . "<br>";
    echo "Opis: " . $row["opis"] . "<br>";
    echo '<a href="index.php">Powrót</a>';
} else {
    echo "Car not found.";
}

// Close the database connection
$conn->close();
?>

