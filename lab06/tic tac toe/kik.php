<?php
session_start();

if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 9, '');
    $_SESSION['player'] = 'X';
    $_SESSION['winner'] = '';
}

if (isset($_GET['reset'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['square'])) {
    $square = $_GET['square'];
    if ($_SESSION['board'][$square] == '') {
        $_SESSION['board'][$square] = $_SESSION['player'];
        if ($_SESSION['player'] == 'X') {
            $_SESSION['player'] = 'O';
        } else {
            $_SESSION['player'] = 'X';
        }
    }
    $_SESSION['winner'] = check_winner($_SESSION['board']);
}

function check_winner($board) {
    $winning_patterns = array(
        array(0, 1, 2),
        array(3, 4, 5),
        array(6, 7, 8),
        array(0, 3, 6),
        array(1, 4, 7),
        array(2, 5, 8),
        array(0, 4, 8),
        array(2, 4, 6)
    );

    foreach ($winning_patterns as $pattern) {
        $line = $board[$pattern[0]] . $board[$pattern[1]] . $board[$pattern[2]];
        if ($line == 'XXX') {
            return 'X';
        } elseif ($line == 'OOO') {
            return 'O';
        }
    }
    if (array_search('', $board) === false) {
        return 'tie';
    }
    return '';
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1></h1>
<p>Player <?php echo $_SESSION['player']; ?>'s turn</p>
<table border="1" cellpadding="10">
    <?php for ($i = 0; $i < 3; $i++) : ?>
        <tr>
            <?php for ($j = 0; $j < 3; $j++) : ?>
                <?php $square = $i * 3 + $j; ?>
                <td>
                    <?php if ($_SESSION['board'][$square] != '') : ?>
                        <?php echo $_SESSION['board'][$square]; ?>
                    <?php else : ?>
                        <a href="?square=<?php echo $square; ?>"><?php echo "_"; ?></a>
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
</table>
<br>
<?php if ($_SESSION['winner'] != '') : ?>
    <p>Player <?php echo $_SESSION['winner']; ?> wins!</p>
    <a href="?reset">Play again</a>
<?php endif; ?>
</body>
</html>