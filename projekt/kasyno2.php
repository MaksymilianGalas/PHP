<?php
session_start();

class CoinFlipGame {
    private $conn;
    private $money;
    private $outcome;

    public function __construct($conn, $money) {
        $this->conn = $conn;
        $this->money = $money;
        $this->outcome = '';
    }

    public function playGame($bet) {
        if ($bet > $this->money) {
            $this->outcome = "Insufficient balance. Please place a lower bet.";
        } else {
            $result = $this->flipCoin();

            if ($result == "win") {
                $this->money += $bet * 1.5;
                $this->outcome = "Congratulations! You won $bet! Your new balance is $this->money.";
            } else {
                $this->money -= $bet;
                $this->outcome = "Sorry, you lost $bet. Your new balance is $this->money.";
            }

            $this->updateBalance();
        }
    }

    private function flipCoin() {
        $coin = rand(0, 1);

        return $coin == 1 ? "win" : "lose";
    }

    private function updateBalance() {
        $login = $this->sanitizeInput($_SESSION['login']);
        $money = $this->sanitizeInput($this->money);

        $updateQuery = "UPDATE uzytkownicy SET money = '$money' WHERE login = '$login'";
        if ($this->conn->query($updateQuery) === FALSE) {
            echo "Error updating balance: " . $this->conn->error;
        }

        $_SESSION['balance'] = $this->money;
    }

    private function sanitizeInput($input) {
        return mysqli_real_escape_string($this->conn, $input);
    }

    public function getOutcome() {
        return $this->outcome;
    }

    public function getMoney() {
        return $this->money;
    }
}

$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27479";
$password = "Mak.Gala";
$dbname = "s27479";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['balance'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

$money = $_SESSION['balance'];
$outcome = '';

$game = new CoinFlipGame($conn, $money);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = $_POST['bet'];
    $game->playGame($bet);
    $outcome = $game->getOutcome();
    $money = $game->getMoney();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="">
<head>
    <title>Coin Flip Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        p {
            text-align: center;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="number"] {
            width: 100px;
        }

        input[type="submit"] {
            margin-top: 10px;
            padding: 6px 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .return-button {
            text-align: center;
            margin-top: 20px;
        }

        .return-button button {
            padding: 6px 12px;
            background-color: #ccc;
            color: #000;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1>Coin Flip Game</h1>
<p>Your current balance is <?php echo $money; ?></p>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="bet">Enter your bet:</label>
    <label>
        <input type="number" name="bet" min="1" required>
    </label><br>
    <input type="submit" value="Place Bet">
</form>
<p><?php echo $outcome; ?></p>

<div class="return-button">
    <button onclick="window.location.href='welcome.php'">Return to Welcome Page</button>
</div>

</body>
</html>
