<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("Błąd połączenia: ".mysqli_connect_error());

// USUWANIE uczestnika
if(isset($_GET['potwierdz'])) {
    $id = (int)$_GET['potwierdz'];
    mysqli_query($conn,"DELETE FROM Uczestnicy WHERE id_uczestnika=$id");
    header("Location: uczestnicy.php");
    exit;
}

// Obsługa wyszukiwania
$szukaj = '';
if(isset($_GET['szukaj'])) {
    $szukaj = mysqli_real_escape_string($conn, $_GET['szukaj']);
}

// Pobranie listy uczestników z filtrem
$sql = "SELECT * FROM Uczestnicy";
if($szukaj != '') {
    $sql .= " WHERE imie LIKE '%$szukaj%' OR nazwisko LIKE '%$szukaj%' OR email LIKE '%$szukaj%'";
}
$sql .= " ORDER BY nazwisko";

$result = mysqli_query($conn,$sql);
?>

<html>
<head>
<meta charset="utf-8">
<title>Uczestnicy</title>
<link rel="stylesheet" href="strona.css">
</head>
<body>

<!-- MENU Z WYSZUKIWARKĄ -->
<div class="menu">
    <div class="menu-links">
        <a href="strona.php">Rejestracje</a>
        <a href="uczestnicy.php" class="active">Uczestnicy</a>
        <a href="wydarzenia.php">Wydarzenia</a>
    </div>

    <form method="get" class="menu-search">
        <input type="text" name="szukaj" placeholder="Szukaj po imieniu, nazwisku lub email..." value="<?php echo htmlspecialchars($szukaj); ?>">
        <input type="submit" value="Szukaj">
    </form>
</div>

<h2>Lista uczestników</h2>

<!-- Dodawanie uczestnika -->
<form action="dodaj_uczestnika.php" method="get" style="margin-bottom:15px;">
    <input type="submit" value="Dodaj uczestnika">
</form>

<table>
<tr>
<th>Imię</th><th>Nazwisko</th><th>Email</th><th>Telefon</th><th>Akcje</th>
</tr>

<?php
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>'.$row['imie'].'</td>';
        echo '<td>'.$row['nazwisko'].'</td>';
        echo '<td>'.$row['email'].'</td>';
        echo '<td>'.$row['telefon'].'</td>';
        echo '<td>';
        echo '<a href="zmien_uczestnika.php?id_uczestnika='.$row['id_uczestnika'].'">edytuj</a>';
        echo '<a href="uczestnicy.php?potwierdz='.$row['id_uczestnika'].'" onclick="return confirm(\'Na pewno chcesz usunąć tego uczestnika?\')">usuń</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">Brak wyników</td></tr>';
}
?>
</table>

</body>
</html>
