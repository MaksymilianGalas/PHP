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

// Retrieve a page number from the URL query string
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 5;
$offset = ($page - 1) * $recordsPerPage;

// Retrieve the desired page of car data from the database
$sql = "SELECT id, marka, model, cena, rok, opis FROM samochody LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);

// Display the car data on the homepage
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Marka: " . $row["marka"] . "<br>";
        echo "Model: " . $row["model"] . "<br>";
        echo '<a href="car.php?id=' . $row["id"] . '">Czytaj więcej</a>';
        echo "<hr>";
    }
} else {
    echo "No cars found.";
}

// Calculate the total number of pages for pagination
$sql = "SELECT COUNT(*) AS total FROM samochody";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalPages = ceil($row["total"] / $recordsPerPage);

// Display pagination links
if ($totalPages > 1) {
    if ($page > 1) {
        echo '<a href="index.php?page=' . ($page - 1) . '">Poprzednia strona</a> ';
    }

    if ($page < $totalPages) {
        echo '<a href="index.php?page=' . ($page + 1) . '">Następna strona</a>';
    }
}

// Close the database connection
$conn->close();
?>
