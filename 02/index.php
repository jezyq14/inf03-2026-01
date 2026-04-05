<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "bazar");

/* Skrypt 1 */
$sql1 = "SELECT t.nazwa, t.plik FROM towar t LIMIT 10;";
$res1 = $mysqli->query($sql1);

/* Skrypt 2 */
$sql2 = "SELECT t.id, t.nazwa FROM towar t;";
$res2 = $mysqli->query($sql2);

/* Skrypt 3 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $quantity = $_POST["ilosc"];

    $sql3 = "SELECT t.rodzaj, t.nazwa, t.cena FROM towar t WHERE t.id = ?;";
    $stmt = $mysqli->prepare($sql3);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res3 = $stmt->get_result()->fetch_assoc();

    $cost = $res3["cena"] * $quantity;

    $sql4 = "INSERT INTO `zamowienie` (`id`, `id_towar`, `id_sklep`, `liczba_kg`) VALUES (NULL, ?, '2', ?);";
    $stmt = $mysqli->prepare($sql4);
    $stmt->bind_param("ii", $id, $quantity);
    $stmt->execute();
}

$mysqli->close();

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zdrowy bazarek</title>
    <link rel="stylesheet" href="styl.css">
</head>

<body>
    <header class="header">
        <h1>Zdrowy bazarek</h1>
    </header>

    <nav class="nav">
        <!-- Skrypt 1 -->
        <?php while ($row = $res1->fetch_assoc()): ?>
            <img src="<?= $row["plik"] ?>" alt="<?= $row["nazwa"] ?>">
        <?php endwhile; ?>
    </nav>

    <main class="main">
        <aside class="aside">
            <img src="market.png" alt="bazarek">
        </aside>

        <section class="section">
            <p>Wybierz owoc lub warzywo i podaj jego wagę:</p>
            <form action="index.php" method="post">
                <select name="id">
                    <!-- Skrypt 2 -->
                    <?php while ($row = $res2->fetch_assoc()): ?>
                        <option value="<?= $row["id"] ?>"><?= $row["nazwa"] ?></option>
                    <?php endwhile; ?>
                </select>
                <input type="number" name="ilosc">
                <button type="submit">Zamów</button>
            </form>
            <!-- Skrypt 3 -->
            <?php if (isset($res3)): ?>
                <p><?= $res3["rodzaj"] ?> <?= $res3["nazwa"] ?> wartość: <?= $cost ?> zł</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="footer">
        <p>Stronę opracował: 12345678909</p>
    </footer>
</body>

</html>