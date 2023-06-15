<?php

$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27479";
$password = "Mak.Gala";
$dbname = "s27479";

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

if (isset($_POST['login_submit'])) {
    $login = sanitizeInput($_POST['login']);
    $password = sanitizeInput($_POST['password']);
    $hashedPassword = md5($password);

    $query = "SELECT * FROM uzytkownicy WHERE login = '$login' AND haslo = '$hashedPassword'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $balance = $user['money'];
        session_start();
        $_SESSION['login'] = $login;
        $_SESSION['balance'] = $balance;
        header("Location: welcome.php");
        exit();
    } else {
        $loginError = "Invalid login or password.";
    }
}

if (isset($_POST['register_submit'])) {
    $login = sanitizeInput($_POST['register_login']);
    $password = sanitizeInput($_POST['register_password']);

    $hashedPassword = md5($password);

    $checkQuery = "SELECT * FROM uzytkownicy WHERE login = '$login'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $registerError = "User already exists.";
    } else {
        $insertQuery = "INSERT INTO uzytkownicy (login, haslo, money) VALUES ('$login', '$hashedPassword', 1000)";
        if ($conn->query($insertQuery) === TRUE) {
            session_start();
            $_SESSION['login'] = $login;
            header("Location: welcome.php");
            exit();
        } else {
            $registerError = "Error: " . $insertQuery . "<br>" . $conn->error;
            error_log($registerError, 3, "errors.log"); //zapisanie bledu do pliku
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login/Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if (isset($loginError)) { ?>
            <div class="error"><?php echo $loginError; ?></div>
        <?php } ?>
        <div class="form-group">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <input type="submit" name="login_submit" value="Login">
    </form>
</div>

<div class="container">
    <h2>Register</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if (isset($registerError)) { ?>
            <div class="error"><?php echo $registerError; ?></div>
        <?php } ?>
        <div class="form-group">
            <label for="register_login">Login:</label>
            <input type="text" name="register_login" id="register_login" required>
        </div>
        <div class="form-group">
            <label for="register_password">Password:</label>
            <input type="password" name="register_password" id="register_password" required>
        </div>
        <input type="submit" name="register_submit" value="Register">
    </form>
</div>
</body>
</html>
