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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission
    $action = $_POST['action'];

    if ($action === "start") {
        startBlackjack();
    } elseif ($action === "hit") {
        hitCard();
    } elseif ($action === "stand") {
        endGame();
    }
}

function startBlackjack()
{
    global $conn, $money, $outcome;
    $bet = $_POST['bet'];

    // Check if the user has enough money to place the bet
    if ($bet > $money) {
        header("Location: blackjack.php");
    } else {
        // Update the balance in the session
        $money -= $bet;
        $_SESSION['balance'] = $money;

        // Update the balance in the database
        $login = sanitizeInput($_SESSION['login']);
        $updateQuery = "UPDATE uzytkownicy SET money = '$money' WHERE login = '$login'";
        if ($conn->query($updateQuery) === FALSE) {
            echo "Error updating balance: " . $conn->error;
        }

        // Deal two initial cards to the player
        $playerCards = dealInitialCards();
        $playerScore = calculateScore($playerCards);

        // Deal two initial cards to the dealer
        $dealerCards = dealInitialCards();
        $dealerScore = calculateScore($dealerCards);

        // Check for blackjack
        if ($playerScore == 21) {
            $money += $bet * 2.5;
            $outcome = "Blackjack! You won $bet. Your new balance is $money.";
            endGame();
        } else {
            $_SESSION['player_cards'] = $playerCards;
            $_SESSION['dealer_cards'] = $dealerCards;
            $_SESSION['bet'] = $bet;
            $_SESSION['player_score'] = $playerScore;
            $_SESSION['dealer_score'] = $dealerScore;
        }
    }
}

function hitCard()
{
    $playerCards = $_SESSION['player_cards'];
    $playerScore = $_SESSION['player_score'];

    // Deal one additional card to the player
    $newCard = dealCard();
    $playerCards[] = $newCard;
    $playerScore = calculateScore($playerCards);

    if ($playerScore > 21) {
        endGame();
    } else {
        $_SESSION['player_cards'] = $playerCards;
        $_SESSION['player_score'] = $playerScore;
    }
}

function endGame()
{
    $servername = "szuflandia.pjwstk.edu.pl";
    $username = "s27479";
    $password = "Mak.Gala";
    $dbname = "s27479";
    $conn = new mysqli($servername, $username, $password, $dbname);
    global $money, $outcome;
    $playerCards = $_SESSION['player_cards'];
    $dealerCards = $_SESSION['dealer_cards'];
    $playerScore = $_SESSION['player_score'];
    $dealerScore = $_SESSION['dealer_score'];
    $bet = $_SESSION['bet'];

    // Dealer's turn
    while ($dealerScore < 17) {
        $newCard = dealCard();
        $dealerCards[] = $newCard;
        $dealerScore = calculateScore($dealerCards);
    }

    // Determine the outcome
    if ($dealerScore > 21 || $playerScore > $dealerScore) {
        $money += $bet * 2;
        $outcome = "Congratulations! You won $bet. Your new balance is $money.";
    } elseif ($playerScore < $dealerScore) {
        $outcome = "Sorry, you lost $bet. Your new balance is $money.";
    } else {
        $money += $bet;
        $outcome = "It's a tie. Your new balance is $money.";
    }

    // Update the balance in the session
    $_SESSION['balance'] = $money;

    // Update the balance in the database
    $login = sanitizeInput($_SESSION['login']);
    $updateQuery = "UPDATE uzytkownicy SET money = '$money' WHERE login = '$login'";
    if ($conn->query($updateQuery) === FALSE) {
        echo "Error updating balance: " . $conn->error;
    }

    // Clear session data
    unset($_SESSION['player_cards']);
    unset($_SESSION['dealer_cards']);
    unset($_SESSION['bet']);
    unset($_SESSION['player_score']);
    unset($_SESSION['dealer_score']);
}

function sanitizeInput($input)
{
    global $conn;
    $input = trim($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

function dealInitialCards()
{
    $cards = [];
    $cards[] = dealCard();
    $cards[] = dealCard();
    return $cards;
}

function dealCard()
{
    $cardTypes = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    $cardSuits = ['clubs', 'diamonds', 'hearts', 'spades'];
    $randomType = array_rand($cardTypes);
    $randomSuit = array_rand($cardSuits);
    $card = $cardTypes[$randomType] . '_' . $cardSuits[$randomSuit] . '.png';
    return $card;
}

function calculateScore($cards)
{
    $score = 0;
    $aceCount = 0;

    foreach ($cards as $card) {
        $cardType = substr($card, 0, strpos($card, '_'));

        if ($cardType == 'A') {
            $score += 11;
            $aceCount++;
        } elseif (in_array($cardType, ['K', 'Q', 'J'])) {
            $score += 10;
        } else {
            $score += intval($cardType);
        }
    }

    while ($score > 21 && $aceCount > 0) {
        $score -= 10;
        $aceCount--;
    }

    return $score;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blackjack Game</title>
    <style>
        .cards {
            display: flex;
            flex-wrap: wrap;
        }

        .card {
            width: 100px;
            height: 150px;
            margin: 5px;
        }

        .balance {
            margin-bottom: 10px;
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
<h1>Blackjack Game</h1>
<p id="balance" class="balance">Your current balance is <?php echo $money; ?></p>
<div class="cards">
    <?php foreach ($_SESSION['player_cards'] as $card) : ?>
        <img class="card" src="cards/<?php echo $card; ?>" alt="Card">
    <?php endforeach; ?>
</div>
<p>Your score: <?php echo $_SESSION['player_score']; ?></p>
<div class="cards">
    <?php foreach ($_SESSION['dealer_cards'] as $card) : ?>
        <img class="card" src="cards/<?php echo $card; ?>" alt="Card">
    <?php endforeach; ?>
</div>
<p>Dealer's score: <?php echo $_SESSION['dealer_score']; ?></p>
<p id="outcome" class="hidden"><?php echo $outcome; ?></p>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="submit" name="hit" value="Hit">
    <input type="submit" name="stand" value="Stand">
</form>
<form method="POST" action="welcome.php">
    <input type="submit" name="back" value="Back">
</form>
</body>
</html>
