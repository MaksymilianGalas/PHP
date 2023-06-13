<?php
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

// Check if the login form was submitted
if (isset($_POST['login_submit'])) {
    // Get the entered login and password
    $login = sanitizeInput($_POST['login']);
    $password = sanitizeInput($_POST['password']);

    // Hash the password (you should use a more secure hashing method)
    $hashedPassword = md5($password);

    // Prepare the SQL query to select the user
    $query = "SELECT * FROM uzytkownicy WHERE login = '$login' AND haslo = '$hashedPassword'";
    $result = $conn->query($query);

    // Check if the user was found
    if ($result->num_rows > 0) {
        // Fetch the user's balance from the database
        $user = $result->fetch_assoc();
        $balance = $user['money'];

        // Start the session and store the login and balance
        session_start();
        $_SESSION['login'] = $login;
        $_SESSION['balance'] = $balance;

        // Login successful, redirect to a different page
        header("Location: welcome.php");
        exit();
    } else {
        // User not found, display error message
        echo "Invalid login or password.";
    }
}

// Check if the register form was submitted
if (isset($_POST['register_submit'])) {
    // Get the entered login and password
    $login = sanitizeInput($_POST['register_login']);
    $password = sanitizeInput($_POST['register_password']);

    // Hash the password (you should use a more secure hashing method)
    $hashedPassword = md5($password);

    // Check if the user already exists
    $checkQuery = "SELECT * FROM uzytkownicy WHERE login = '$login'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "User already exists.";
    } else {
        // Create a new user and add balance
        $insertQuery = "INSERT INTO uzytkownicy (login, haslo, money) VALUES ('$login', '$hashedPassword', 1000)";
        if ($conn->query($insertQuery) === TRUE) {
            // Account created successfully, redirect to a different page
            session_start();
            $_SESSION['login'] = $login;
            header("Location: welcome.php");
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
}

// Update balance in the database if it has changed
if (isset($_SESSION['balance'])) {
    $newBalance = $_SESSION['balance'];
    $updateQuery = "UPDATE uzytkownicy SET money = '$newBalance' WHERE login = '$login'";
    if ($conn->query($updateQuery) === FALSE) {
        echo "Error updating balance: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login/Register</title>
</head>
<body>
<h2>Login</h2>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="login">Login:</label>
    <input type="text" name="login" id="login" required>
    <br><br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br><br>
    <input type="submit" name="login_submit" value="Login">
</form>

<h2>Register</h2>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="register_login">Login:</label>
    <input type="text" name="register_login" id="register_login" required>
    <br><br>
    <label for="register_password">Password:</label>
    <input type="password" name="register_password" id="register_password" required>
    <br><br>
    <input type="submit" name="register_submit" value="Register">
</form>
</body>
</html>
