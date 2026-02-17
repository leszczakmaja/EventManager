<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("Błąd połączenia: ".mysqli_connect_error());

$id = isset($_GET['id_uczestnika']) ? (int)$_GET['id_uczestnika'] : 0;

if(isset($_POST['zmien'])) {
    $imie = mysqli_real_escape_string($conn,$_POST['imie']);
    $nazwisko = mysqli_real_escape_string($conn,$_POST['nazwisko']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $telefon = mysqli_real_escape_string($conn,$_POST['telefon']);

    mysqli_query($conn,"UPDATE Uczestnicy
                        SET imie='$imie', nazwisko='$nazwisko', email='$email', telefon='$telefon'
                        WHERE id_uczestnika=$id");
    header("Location: uczestnicy.php");
    exit;
}

// pobranie danych uczestnika
$result = mysqli_query($conn,"SELECT * FROM Uczestnicy WHERE id_uczestnika=$id");
$row = mysqli_fetch_assoc($result);
?>
<html>
<head><meta charset="utf-8"><title>Edytuj uczestnika</title></head>
<link rel="stylesheet" href="strona.css">
<body>
<h2>Edytuj uczestnika</h2>
<div class="card">
<form method="post">
Imię: <input type="text" name="imie" value="<?php echo $row['imie']; ?>" required><br>
Nazwisko: <input type="text" name="nazwisko" value="<?php echo $row['nazwisko']; ?>" required><br>
Email: <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>
Telefon: <input type="text" name="telefon" value="<?php echo $row['telefon']; ?>"><br>
<input type="submit" name="zmien" value="Zapisz zmiany">
</form>
</div>
<a href="uczestnicy.php" class="powrot-btn">Powrót</a>
</body>
</html>
