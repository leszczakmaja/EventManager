<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("Błąd połączenia: ".mysqli_connect_error());

$id = isset($_GET['id_wydarzenia']) ? (int)$_GET['id_wydarzenia'] : 0;

// Aktualizacja
if(isset($_POST['zmien'])) {
    $nazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);
    $opis = mysqli_real_escape_string($conn, $_POST['opis']);
    $data = mysqli_real_escape_string($conn, $_POST['data']);
    $godzina = mysqli_real_escape_string($conn, $_POST['godzina']);
    $limit_miejsc = (int)$_POST['limit_miejsc'];
    $typ = mysqli_real_escape_string($conn, $_POST['typ']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn,"UPDATE Wydarzenia
                        SET nazwa='$nazwa', opis='$opis', data='$data', godzina='$godzina',
                            limit_miejsc=$limit_miejsc, typ='$typ', status='$status'
                        WHERE id_wydarzenia=$id");
    header("Location: wydarzenia.php");
    exit;
}

// Pobranie danych wydarzenia
$result = mysqli_query($conn,"SELECT * FROM Wydarzenia WHERE id_wydarzenia=$id");
$row = mysqli_fetch_assoc($result);
?>

<html>
<head><meta charset="utf-8"><title>Edytuj wydarzenie</title></head>
<link rel="stylesheet" href="strona.css">
<body>
<h2>Edytuj wydarzenie</h2>

<div class="card">
<form method="post">
Nazwa: <input type="text" name="nazwa" value="<?php echo $row['nazwa']; ?>" required>
Opis: <input type="text" name="opis" value="<?php echo $row['opis']; ?>" required>
Data: <input type="date" name="data" value="<?php echo $row['data']; ?>" required>
Godzina: <input type="time" name="godzina" value="<?php echo $row['godzina']; ?>" required>
Limit miejsc: <input type="number" name="limit_miejsc" value="<?php echo $row['limit_miejsc']; ?>" required>
Typ: <input type="text" name="typ" value="<?php echo $row['typ']; ?>" required>
Status: <input type="text" name="status" value="<?php echo $row['status']; ?>" required>
<input type="submit" name="zmien" value="Zapisz zmiany">
</form>
</div>

<a href="wydarzenia.php" class="powrot-btn">Powrót</a>
</body>
</html>
