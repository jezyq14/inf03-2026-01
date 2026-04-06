<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "matura");

/* Skrypt 1 */
$sql1 = "SELECT DISTINCT a.przedmiot FROM arkusz a;";
$res1 = $mysqli->query($sql1);

$sql2 = "SELECT MIN(a.rok) as najstarszy, MAX(a.rok) as najmlodszy FROM arkusz a;";
$res2 = $mysqli->query($sql2)->fetch_assoc();

$sql3 = "SELECT w.maturzysta_id, AVG(w.punkty) AS wynik FROM wynik w GROUP BY w.maturzysta_id ORDER BY wynik DESC LIMIT 1;";
$res3 = $mysqli->query($sql3)->fetch_assoc();

$sql4 = "SELECT w.maturzysta_id, AVG(w.punkty) AS wynik FROM wynik w GROUP BY w.maturzysta_id ORDER BY wynik LIMIT 1;";
$res4 = $mysqli->query($sql4)->fetch_assoc();

/* Skrypt 2 */
$sql5 = "SELECT m.id, m.imie, m.nazwisko FROM maturzysta m WHERE m.szkola = 'T3' ORDER BY m.nazwisko;";
$res5 = $mysqli->query($sql5);

$mysqli->close();

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matura</title>

    <link rel="stylesheet" href="styl.css">
</head>

<body>
    <header class="header">
        <h1>System informacji dla maturzystów</h1>
    </header>

    <aside class="aside">
        <img src="ma.jpg" alt="Matura">
        <br>
        <img src="tu.jpg" alt="Matura">
        <br>
        <img src="ra.jpg" alt="Matura">
    </aside>

    <section class="first-section">
        <h3>Wybierz ucznia z listy:</h3>

        <!-- Skrypt 2 -->
        <?php while ($row = $res5->fetch_assoc()): ?>
            <p><a href="wynik.php?id=<?= $row["id"] ?>&imie=<?= $row["imie"] ?>&nazwisko=<?= $row["nazwisko"] ?>"><?= $row["id"] . ". " . $row["imie"] . " " . $row["nazwisko"] ?></a></p>
        <?php endwhile; ?>
    </section>

    <section class="second-section">
        <!-- Skrypt 1 -->
        <div class="second-section-block">
            <h4>Przedmioty</h4>
            <?php while ($row = $res1->fetch_assoc()) echo $row["przedmiot"] . " "; ?>
        </div>
        <div class="second-section-block">
            <h4>Lata</h4>
            <?= $res2["najstarszy"] ?> - <?= $res2["najmlodszy"] ?>
        </div>
        <div class="second-section-block">
            <h4>Najlepszy wynik</h4>
            <?= $res3["wynik"] ?>%
        </div>
        <div class="second-section-block">
            <h4>Najgorszy wynik</h4>
            <?= $res4["wynik"] ?>%
        </div>
    </section>

    <footer class="footer">
        <p>Stronę wykonał: 12345678909</p>
    </footer>
</body>

</html>