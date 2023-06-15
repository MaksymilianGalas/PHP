<?php
session_start();

$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27479";
$password = "Mak.Gala";
$dbname = "s27479";


$conn = new mysqli($servername, $username, $password, $dbname);

if (!isset($_SESSION['balance'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

$money = $_SESSION['balance'];
$outcome = "";

if (isset($_POST['back'])) {
    header("Location: welcome.php");
    exit();
}
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prediction = $_POST['prediction'];


    if ($prediction < 1 || $prediction > 6) {
        $outcome = "Invalid prediction! Please choose a number between 1 and 6.";
    } else {
        $bet = $_POST['bet'];


        if ($bet > $money) {
            header("Location: kasyno1.php");
            exit();
        }


        $diceRoll = mt_rand(1, 6);


        if ($prediction == $diceRoll) {
            $money += $bet * 6;
            $outcome = "Congratulations! You predicted the correct number ($prediction). You won $" . $bet * 6 . "! Your new balance is $money.";
        } else {
            $money -= $bet;
            $outcome = "Sorry, the dice rolled $diceRoll. You lost $bet. Your new balance is $money.";
        }

        $_SESSION['balance'] = $money;

        $login = sanitizeInput($_SESSION['login']);
        $updateQuery = "UPDATE uzytkownicy SET money = '$money' WHERE login = '$login'";
        if ($conn->query($updateQuery) === FALSE) {
            echo "Error updating balance: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dice Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .container label {
            display: block;
            margin-bottom: 10px;
        }

        .container input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .container button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .container .outcome {
            margin-top: 20px;
            padding: 10px;
            background-color: #eafaea;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<h1>Dice Game</h1>
<div class="container">
    <form method="POST">
        <label for="prediction">Choose a number (1-6):</label>
        <input type="number" name="prediction" id="prediction" min="1" max="6">

        <label for="bet">Enter your bet:</label>
        <input type="number" name="bet" id="bet" min="1" step="1">

        <button type="submit">Roll the Dice</button>
        <button type="submit" name="back">Back</button>
    </form>


    <div class="outcome">
        <?php echo $outcome; ?>
    </div>
</div>
</body>
</html>
