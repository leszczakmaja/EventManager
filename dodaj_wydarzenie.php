<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("Błąd połączenia: ".mysqli_connect_error());

if(isset($_POST['dodaj'])) {
    $nazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);
    $opis = mysqli_real_escape_string($conn, $_POST['opis']);
    $data = mysqli_real_escape_string($conn, $_POST['data']);
    $godzina = mysqli_real_escape_string($conn, $_POST['godzina']);
    $limit_miejsc = (int)$_POST['limit_miejsc'];
    $typ = mysqli_real_escape_string($conn, $_POST['typ']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn,"INSERT INTO Wydarzenia (nazwa, opis, data, godzina, limit_miejsc, typ, status)
                        VALUES ('$nazwa','$opis','$data','$godzina',$limit_miejsc,'$typ','$status')");
    header("Location: wydarzenia.php");
    exit;
}
?>

<html>
<head><meta charset="utf-8"><title>Dodaj wydarzenie</title></head>
<link rel="stylesheet" href="strona.css">
<body>
<h2>Dodaj wydarzenie</h2>

<div class="card">
<form method="post">
Nazwa: <input type="text" name="nazwa" required>
Opis: <input type="text" name="opis" required>
Data: <input type="date" name="data" required>
Godzina: <input type="time" name="godzina" required>
Limit miejsc: <input type="number" name="limit_miejsc" required>
Typ: <input type="text" name="typ" required>
Status: <input type="text" name="status" required>
<input type="submit" name="dodaj" value="Dodaj">
</form>
</div>

<a href="wydarzenia.php" class="powrot-btn">Powrót</a>
</body>
</html>
