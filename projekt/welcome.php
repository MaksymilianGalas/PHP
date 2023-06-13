<?php
session_start();

// Database connection details
$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27479";
$password = "Mak.Gala";
$dbname = "s27479";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitizeInput($input)
{
    global $conn;
    $input = trim($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

// Fetch balance from the database
$login = sanitizeInput($_SESSION['login']);
$selectQuery = "SELECT money FROM uzytkownicy WHERE login = '$login'";


$result = $conn->query($selectQuery);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $money = $row['money'];
} else {
    $money = 0;
}

// Check if the button was clicked and enough time has passed since the last click
$currentTime = time();
$lastClickTime = isset($_COOKIE['last_click_time']) ? (int)$_COOKIE['last_click_time'] : 0;
$elapsedTime = $currentTime - $lastClickTime;
$allowClick = $elapsedTime >= 30;

// Increase balance if the button was clicked and enough time has passed
if (isset($_POST['add_balance']) && $allowClick) {
    $money += 50;
    setcookie('last_click_time', $currentTime, time() + 30);

    // Update balance in the database
    $updateQuery = "UPDATE uzytkownicy SET money = '$money' WHERE login = '$login'";
    if ($conn->query($updateQuery) === FALSE) {
        echo "Error updating balance: " . $conn->error;
    }
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .image-container img {
            width: 200px;
            height: 200px;
            margin: 20px;
            transition: transform 0.3s ease;
        }

        .image-container img:hover {
            transform: scale(1.1);
        }

        .balance {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        .logout {
            position: fixed;
            top: 10px;
            left: 10px;
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        .add-balance {
            position: fixed;
            top: 10px;
            left: 100px;
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }
    </style>
</head>
<body>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <button class="logout" type="submit" name="logout">Logout</button>
    <div class="balance">Your balance: <span id="balance"><?php echo $money; ?></span></div>
    <button class="add-balance" type="submit" name="add_balance" <?php if (!$allowClick) echo 'disabled'; ?>>
        Add Balance
    </button>
</form>
<div class="image-container">
    <a href="kasyno1.php">
        <img src="image1.jpg" alt="Image 1">
    </a>
    <a href="kasyno2.php">
        <img src="image2.jpg" alt="Image 2">
    </a>
    <a href="https://example.net">
        <img src="image3.jpg" alt="Image 3">
    </a>
</div>

<script>
    // Update balance on page load
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("balance").textContent = "<?php echo $money; ?>";
    });
</script>
</body>
</html>
