<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("Błąd połączenia: ".mysqli_connect_error());

$id = isset($_GET['id_rejestracji']) ? (int)$_GET['id_rejestracji'] : 0;

// Pobranie danych rejestracji
$result = mysqli_query($conn, "SELECT * FROM Rejestracje WHERE id_rejestracji=$id");
$row = mysqli_fetch_assoc($result);

// Aktualizacja rejestracji
if(isset($_POST['zmien'])) {
    $id_uczestnika = (int)$_POST['id_uczestnika'];
    $id_wydarzenia = (int)$_POST['id_wydarzenia'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn,"UPDATE Rejestracje
                        SET id_uczestnika=$id_uczestnika, id_wydarzenia=$id_wydarzenia, status='$status'
                        WHERE id_rejestracji=$id");
    header("Location: strona.php");
    exit;
}

// Pobranie listy uczestników i wydarzeń do formularza
$uczestnicy = mysqli_query($conn,"SELECT * FROM Uczestnicy ORDER BY nazwisko");
$wydarzenia = mysqli_query($conn,"SELECT * FROM Wydarzenia ORDER BY nazwa");
?>

<html>
<head><meta charset="utf-8"><title>Edytuj rejestrację</title></head>
<link rel="stylesheet" href="strona.css">
<body>

<h2>Edytuj rejestrację</h2>
<div class="card">
<form method="post">
    <label>Uczestnik:</label>
    <select name="id_uczestnika" required>
        <?php while($u = mysqli_fetch_assoc($uczestnicy)) {
            $selected = $u['id_uczestnika']==$row['id_uczestnika'] ? 'selected' : '';
            echo '<option value="'.$u['id_uczestnika'].'" '.$selected.'>'.$u['imie'].' '.$u['nazwisko'].'</option>';
        } ?>
    </select>

    <label>Wydarzenie:</label>
    <select name="id_wydarzenia" required>
        <?php while($w = mysqli_fetch_assoc($wydarzenia)) {
            $selected = $w['id_wydarzenia']==$row['id_wydarzenia'] ? 'selected' : '';
            echo '<option value="'.$w['id_wydarzenia'].'" '.$selected.'>'.$w['nazwa'].'</option>';
        } ?>
    </select>

    <label>Status:</label>
    <input type="text" name="status" value="<?php echo htmlspecialchars($row['status']); ?>" required>

    <input type="submit" name="zmien" value="Zapisz zmiany">
</form>
</div>

<a href="strona.php" class="powrot-btn">Powrót</a>

</body>
</html>
