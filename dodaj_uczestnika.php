<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("Błąd połączenia: ".mysqli_connect_error());

if(isset($_POST['dodaj'])) {
    $imie = mysqli_real_escape_string($conn, $_POST['imie']);
    $nazwisko = mysqli_real_escape_string($conn, $_POST['nazwisko']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefon = mysqli_real_escape_string($conn, $_POST['telefon']);

    mysqli_query($conn,"INSERT INTO Uczestnicy (imie,nazwisko,email,telefon)
                        VALUES ('$imie','$nazwisko','$email','$telefon')");
    header("Location: uczestnicy.php");
    exit;
}
?>
<html>
<head><meta charset="utf-8"><title>Dodaj uczestnika</title></head>
<link rel="stylesheet" href="strona.css">
<body>
<h2>Dodaj uczestnika</h2>
<div class="card">
<form method="post">
Imię: <input type="text" name="imie" required><br>
Nazwisko: <input type="text" name="nazwisko" required><br>
Email: <input type="email" name="email" required><br>
Telefon: <input type="text" name="telefon"><br>
<input type="submit" name="dodaj" value="Dodaj" class="dodaj-btn">
</form>
</div>
<a href="uczestnicy.php" class="powrot-btn">Powrót</a>
</body>
</html>
