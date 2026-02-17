<?php
include 'autoryzacja.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) 
    or die("Błąd połączenia: ".mysqli_connect_error());

// USUWANIE rejestracji
if(isset($_GET['potwierdz'])) {
    $id = (int)$_GET['potwierdz'];
    mysqli_query($conn,"DELETE FROM Rejestracje WHERE id_rejestracji=$id");
    header("Location: strona.php");
    exit;
}

// Obsługa wyszukiwania
$szukaj = '';
if(isset($_GET['szukaj'])) {
    $szukaj = mysqli_real_escape_string($conn, $_GET['szukaj']);
}

// Pobranie listy rejestracji z filtrem
$sql = "
SELECT R.id_rejestracji, U.imie, U.nazwisko, W.nazwa, R.status
FROM Rejestracje R
JOIN Uczestnicy U ON R.id_uczestnika=U.id_uczestnika
JOIN Wydarzenia W ON R.id_wydarzenia=W.id_wydarzenia
";
if($szukaj != '') {
    $sql .= " WHERE U.imie LIKE '%$szukaj%' OR U.nazwisko LIKE '%$szukaj%' OR W.nazwa LIKE '%$szukaj%' OR R.status LIKE '%$szukaj%'";
}
$sql .= " ORDER BY R.id_rejestracji";

$result = mysqli_query($conn, $sql);
?>

<html>
<head>
<meta charset="utf-8">
<title>Rejestracje</title>
<link rel="stylesheet" href="strona.css">
</head>
<body>

<!-- MENU -->
<div class="menu">
    <div class="menu-links">
        <a href="strona.php" class="active">Rejestracje</a>
        <a href="uczestnicy.php">Uczestnicy</a>
        <a href="wydarzenia.php">Wydarzenia</a>
    </div>

    <!-- WYSZUKIWARKA W MENU -->
    <form method="get" class="menu-search">
        <input type="text" name="szukaj" placeholder="Szukaj po uczestniku, wydarzeniu lub statusie..." value="<?php echo htmlspecialchars($szukaj); ?>">
        <input type="submit" value="Szukaj">
    </form>
</div>

<h2>Lista rejestracji</h2>

<!-- DODAWANIE REJESTRACJI -->
<form action="dodaj_rejestracja.php" method="get" style="margin-bottom:15px;">
    <input type="submit" value="Dodaj rejestrację">
</form>

<table>
<tr>
<th>Uczestnik</th>
<th>Wydarzenie</th>
<th>Status</th>
<th>Akcje</th>
</tr>

<?php
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>'.$row['imie'].' '.$row['nazwisko'].'</td>';
        echo '<td>'.$row['nazwa'].'</td>';
        echo '<td>'.$row['status'].'</td>';
        echo '<td>';
        echo '<a href="zmien_rejestracje.php?id_rejestracji='.$row['id_rejestracji'].'">edytuj</a> ';

        if(isset($_GET['usun']) && $_GET['usun']==$row['id_rejestracji'])
            echo '<a href="strona.php?potwierdz='.$row['id_rejestracji'].'">potwierdź</a>';
        else
            echo '<a href="strona.php?usun='.$row['id_rejestracji'].'">usuń</a>';

        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">Brak wyników</td></tr>';
}
?>
</table>

</body>
</html>
