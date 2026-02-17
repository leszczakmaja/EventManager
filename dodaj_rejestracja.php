<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("Błąd połączenia: ".mysqli_connect_error());

// Dodawanie rejestracji
if(isset($_POST['dodaj'])) {
    $id_uczestnika = (int)$_POST['id_uczestnika'];
    $id_wydarzenia = (int)$_POST['id_wydarzenia'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn,"INSERT INTO Rejestracje (id_uczestnika,id_wydarzenia,status)
                        VALUES ($id_uczestnika, $id_wydarzenia, '$status')");
    header("Location: strona.php");
    exit;
}

// Pobranie listy uczestników i wydarzeń do formularza
$uczestnicy = mysqli_query($conn,"SELECT * FROM Uczestnicy ORDER BY nazwisko");
$wydarzenia = mysqli_query($conn,"SELECT * FROM Wydarzenia ORDER BY nazwa");
?>

<html>
<head><meta charset="utf-8"><title>Dodaj rejestrację</title></head>
<link rel="stylesheet" href="strona.css">
<body>

<h2>Dodaj rejestrację</h2>
<div class="card">
<form method="post">
    <label>Uczestnik:</label>
    <select name="id_uczestnika" required>
        <option value="">-- wybierz --</option>
        <?php while($u = mysqli_fetch_assoc($uczestnicy)) {
            echo '<option value="'.$u['id_uczestnika'].'">'.$u['imie'].' '.$u['nazwisko'].'</option>';
        } ?>
    </select>

    <label>Wydarzenie:</label>
    <select name="id_wydarzenia" required>
        <option value="">-- wybierz --</option>
        <?php while($w = mysqli_fetch_assoc($wydarzenia)) {
            echo '<option value="'.$w['id_wydarzenia'].'">'.$w['nazwa'].'</option>';
        } ?>
    </select>

    <label>Status:</label>
    <input type="text" name="status" placeholder="np. potwierdzona / oczekująca" required>

    <input type="submit" name="dodaj" value="Dodaj rejestrację">
</form>
</div>

<a href="strona.php" class="powrot-btn">Powrót</a>

</body>
</html>
