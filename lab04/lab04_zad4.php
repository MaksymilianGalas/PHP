
<form method="post">
    <label for="pytanie">Pytanie:</label>
    <input type="text" id="pytanie" name="pytanie" required><br><br>
    <label for="odp1">Odpowiedź 1:</label>
    <input type="radio" id="odp1" name="odpowiedz" value="odp1" required><br>
    <label for="odp2">Odpowiedź 2:</label>
    <input type="radio" id="odp2" name="odpowiedz" value="odp2" required><br><br>
    <input type="submit" name="submit" value="Głosuj">
</form>

<?php

if(isset($_COOKIE['glosowal'])){
    echo "Już głosowałeś!";
} else if(isset($_POST['submit'])){
    setcookie('glosowal', 'tak', time() + (86400 * 7), "/");
    $pytanie = $_POST['pytanie'];
    $odpowiedz = $_POST['odpowiedz'];
    echo "Dziękujemy za głosowanie!";
}
?>
<?php
