<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Prosty kalkulator</title>
</head>
<body>
<form method="get" action="zad1_2.php">
    <label>Liczba 1:</label>
    <input type="number" name="liczba1" required><br><br>
    <label>Liczba 2:</label>
    <input type="number" name="liczba2" required><br><br>
    <label>Działanie:</label>
    <select name="dzialanie">
        <option value="dodawanie">Dodawanie</option>
        <option value="odejmowanie">Odejmowanie</option>
        <option value="mnozenie">Mnożenie</option>
        <option value="dzielenie">Dzielenie</option>
    </select><br><br>
    <input type="submit" value="Oblicz">
</form>
</body>
</html>
