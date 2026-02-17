<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("Błąd połączenia: ".mysqli_connect_error());

// USUWANIE wydarzenia
if(isset($_GET['potwierdz'])) {
    $id = (int)$_GET['potwierdz'];
    mysqli_query($conn,"DELETE FROM Wydarzenia WHERE id_wydarzenia=$id");
    header("Location: wydarzenia.php");
    exit;
}

// Obsługa wyszukiwania
$szukaj = '';
if(isset($_GET['szukaj'])) {
    $szukaj = mysqli_real_escape_string($conn, $_GET['szukaj']);
}

// Pobranie listy wydarzeń z filtrem
$sql = "SELECT * FROM Wydarzenia";
if($szukaj != '') {
    $sql .= " WHERE nazwa LIKE '%$szukaj%' OR opis LIKE '%$szukaj%' OR typ LIKE '%$szukaj%' OR status LIKE '%$szukaj%'";
}
$sql .= " ORDER BY data, godzina";

$result = mysqli_query($conn, $sql);
?>

<html>
<head>
<meta charset="utf-8">
<title>Wydarzenia</title>
<link rel="stylesheet" href="strona.css">
</head>
<body>

<!-- MENU Z WYSZUKIWARKĄ -->
<div class="menu">
    <div class="menu-links">
        <a href="strona.php">Rejestracje</a>
        <a href="uczestnicy.php">Uczestnicy</a>
        <a href="wydarzenia.php" class="active">Wydarzenia</a>
    </div>

    <form method="get" class="menu-search">
        <input type="text" name="szukaj" placeholder="Szukaj po nazwie, opisie, typie lub statusie..." value="<?php echo htmlspecialchars($szukaj); ?>">
        <input type="submit" value="Szukaj">
    </form>
</div>

<h2>Lista wydarzeń</h2>

<!-- Dodawanie wydarzenia -->
<form action="dodaj_wydarzenie.php" method="get" style="margin-bottom:15px;">
    <input type="submit" value="Dodaj wydarzenie">
</form>

<table>
<tr>
<th>Nazwa</th>
<th>Opis</th>
<th>Data</th>
<th>Godzina</th>
<th>Limit miejsc</th>
<th>Typ</th>
<th>Status</th>
<th>Akcje</th>
</tr>

<?php
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>'.$row['nazwa'].'</td>';
        echo '<td>'.$row['opis'].'</td>';
        echo '<td>'.$row['data'].'</td>';
        echo '<td>'.$row['godzina'].'</td>';
        echo '<td>'.$row['limit_miejsc'].'</td>';
        echo '<td>'.$row['typ'].'</td>';
        echo '<td>'.$row['status'].'</td>';
        echo '<td>';
        echo '<a href="zmien_wydarzenie.php?id_wydarzenia='.$row['id_wydarzenia'].'">edytuj</a>';
        echo '<a href="wydarzenia.php?potwierdz='.$row['id_wydarzenia'].'" onclick="return confirm(\'Na pewno chcesz usunąć to wydarzenie?\')">usuń</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="8">Brak wyników</td></tr>';
}
?>
</table>

</body>
</html>
