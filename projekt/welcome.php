<?php
session_start();

// Database connection details
$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27479";
$password = "Mak.Gala";
$dbname = "s27479";

$paramValue = isset($_GET['param']) ? $_GET['param'] : '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($input)
{
    global $conn;
    $input = trim($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

$login = sanitizeInput($_SESSION['login']);
$selectQuery = "SELECT money FROM uzytkownicy WHERE login = '$login'";


$result = $conn->query($selectQuery);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $money = $row['money'];
} else {
    $money = 0;
}

$currentTime = time();
$lastClickTime = isset($_COOKIE['last_click_time']) ? (int)$_COOKIE['last_click_time'] : 0;
$elapsedTime = $currentTime - $lastClickTime;
$allowClick = $elapsedTime >= 30;

if (isset($_POST['add_balance']) && $allowClick) {
    $money += 50;
    setcookie('last_click_time', $currentTime, time() + 30);

    $updateQuery = "UPDATE uzytkownicy SET money = '$money' WHERE login = '$login'";
    if ($conn->query($updateQuery) === FALSE) {
        echo "Error updating balance: " . $conn->error;
    }
}


if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}


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
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?param=value">
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
    <a href="kasyno3.php">
        <img src="image3.jpg" alt="Image 3">
    </a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("balance").textContent = "<?php echo $money; ?>";
    });
</script>
</body>
</html>
