<?php
session_start();

$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27479";
$password = "Mak.Gala";
$dbname = "s27479";

// Create a new database connection
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission
    $color = $_POST['color'];
    $bet = $_POST['bet'];

    // Check if the color is valid
    if ($color !== "black" && $color !== "red") {
        $outcome = "Invalid color! Please choose either 'black' or 'red'.";
    } else {
        // Check if the user has enough money to place the bet
        if ($bet > $money) {
            header("Location: kasyno1.php");
        } else {
            // Spin the wheel and generate a random color
            $colors = ["black", "red"];
            $spin = $colors[array_rand($colors)];

            // Random number generation
            $randomNumber = 0;
            if ($spin == 'red') {
                $randomNumber = getRandomNumberRed() + 360;
            } else {
                $randomNumber = getRandomNumberBlack() + 360;
            }

            // Determine the outcome
            if ($color == $spin) {
                $money += $bet * 2;
                $outcome = "Congratulations! You won $bet! Your new balance is $money.";
            } else {
                $money -= $bet;
                $outcome = "Sorry, you lost $bet. Your new balance is $money.";
            }

            // Update the balance in the session
            $_SESSION['balance'] = $money;

            // Update the balance in the database
            $login = sanitizeInput($_SESSION['login']);
            $updateQuery = "UPDATE uzytkownicy SET money = '$money' WHERE login = '$login'";
            if ($conn->query($updateQuery) === FALSE) {
                echo "Error updating balance: " . $conn->error;
            }
        }
    }
}

function sanitizeInput($input)
{
    global $conn;
    $input = trim($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

function getRandomNumberRed()
{
    $range1 = rand(210, 270);
    $range2 = rand(330, 359);
    $range3 = rand(90, 150);
    $range4 = rand(0, 30);
    $randomNumber = rand(1, 4);

    switch ($randomNumber) {
        case 1:
            return $range1;
        case 2:
            return $range2;
        case 3:
            return $range3;
        case 4:
            return $range4;
    }
}

function getRandomNumberBlack()
{
    $range1 = rand(30, 90);
    $range2 = rand(150, 210);
    $range3 = rand(270, 330);

    $randomNumber = rand(1, 4);

    switch ($randomNumber) {
        case 1:
            return $range1;
        case 2:
            return $range2;
        case 3:
            return $range3;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Roulette Game</title>
    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(<?php echo $randomNumber; ?>deg);
            }
        }

        .arrow {
            width: 0;
            height: 0;
            border: solid transparent;
            border-width: 10px;
            border-bottom-color: #000;
            position: relative;
            transform: rotate(180deg) translateX(-140px);
        }

        .roulette-wheel {
            width: 300px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .spin-animation {
            animation: spin 4s linear forwards;
        }

        .hidden {
            display: none;
        }
    </style>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var outcomeElement = document.getElementById('outcome');
            outcomeElement.classList.add('hidden');

            setTimeout(function () {
                outcomeElement.classList.remove('hidden');
                var balanceElement = document.getElementById('balance');
                balanceElement.classList.add('hidden');
            }, 4000);
        });
    </script>
</head>
<body>
<h1>Roulette Game</h1>
<p id="balance" class="hidden">Your current balance is <?php echo $money; ?></p>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="color">Choose a color:</label>
    <select name="color" required>
        <option value="black">Black</option>
        <option value="red">Red</option>
    </select><br>
    <label for="bet">Enter your bet:</label>
    <input type="number" name="bet" min="1" required><br>
    <input type="submit" value="Spin the wheel">
</form>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="submit" name="back" value="Back">
</form>
<div class="arrow"></div>
<div class="roulette-wheel spin-animation">
    <img src="roulette_wheel.png" alt="Roulette Wheel" width="300" height="300">
</div>
<p id="outcome" class="hidden"><?php echo $outcome; ?></p>
</body>
</html>
