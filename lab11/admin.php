<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo '
        <form action="login.php" method="POST">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required><br>
            <label for="password1">Password:</label>
            <input type="password" id="password1" name="password1" required><br>
            <input type="submit" value="Login">
        </form>
        <form method="post" action="admin.php">
            <input type="submit" name="logout" value="session destroy (test)">
        </form>
    ';
} else {
    $user_id = $_SESSION['user_id'];

    $servername = "szuflandia.pjwstk.edu.pl";
    $username = "s27479";
    $password = "Mak.Gala";
    $dbname = "s27479";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $stmt = $conn->prepare("SELECT * FROM samochody WHERE uzytkownik_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "
        <table>
            <tr>
                <th>ID</th>
                <th>Marka</th>
                <th>Model</th>
                <th>Edit</th>
            </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['marka'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo '<td><a href="./edit_car.php?id=' . $row['id'] . '">Edit</a></td>';
            echo "</tr>";
        }
        echo "</table>";
        ?>

        <!DOCTYPE html>
        <html>
        <body>
        <form method="post" action="admin.php">
            <input type="submit" name="logout" value="Wyloguj">
        </form>
        <form method="get" action="add_car.php">
            <input type="submit" value="Add New Car">
        </form>
        </body>
        </html>
        <?php
    } else {
        echo "No cars found for the logged-in user.";
    }

    $conn = null;
}
?>

