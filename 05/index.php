<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "zgloszenia");

/* Skrypt 1 */
$status = isset($_POST["status"]) ? $_POST["status"] : "policjant";

$sql1 = "SELECT p.id, p.imie, p.nazwisko FROM personel p WHERE p.status = ?";
$stmt = $mysqli->prepare($sql1);
$stmt->bind_param("s", $status);
$stmt->execute();
$res1 = $stmt->get_result();

/* Skrypt 2 */
$sql2 = "SELECT p.id, p.nazwisko FROM personel p WHERE p.id NOT IN (SELECT r.id_personel FROM rejestr r);";
$res2 = $mysqli->query($sql2);

/* Skrypt 3 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];

    $sql3 = "INSERT INTO `rejestr` (`id`, `data`, `id_personel`, `id_pojazd`) VALUES (NULL, CURRENT_DATE(), ?, '14');";
    $stmt = $mysqli->prepare($sql3);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$mysqli->close();

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZGŁOSZENIA</title>

    <link rel="stylesheet" href="styl.css">
</head>

<body>
    <header class="header">
        <h1>Zgłoszenia wydarzeń</h1>
    </header>

    <main class="main">
        <section class="left-section">
            <h2>Personel</h2>

            <form action="index.php" method="post">
                <input type="radio" name="status" id="policjant" value="policjant" checked>
                <label for="policjant">Policjant</label>

                <input type="radio" name="status" id="ratownik" value="ratownik">
                <label for="ratownik">Ratownik</label>

                <button type="submit">Pokaż</button>
            </form>

            <!-- Skrypt 1 -->
            <h3>Wybrano opcję: <?= $status ?></h3>
            <table>
                <thead>
                    <th>Id</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                </thead>
                <tbody>
                    <?php while ($row = $res1->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row["id"] ?></td>
                            <td><?= $row["imie"] ?></td>
                            <td><?= $row["nazwisko"] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
        <section class="right-section">
            <h2>Nowe zgłoszenie</h2>
            <ol>
                <!-- Skrypt 2 -->
                <?php while ($row = $res2->fetch_assoc()): ?>
                    <li><?= $row["id"] . " " . $row["nazwisko"] ?></li>
                <?php endwhile; ?>
            </ol>

            <form action="index.php" method="post">
                <label for="id">Wybierz id osoby z listy: </label>
                <input type="text" name="id" id="id">

                <button type="submit">Dodaj zgłoszenie</button>
            </form>
        </section>
    </main>

    <footer class="footer">
        <p>Stronę wykonał: 12345678909</p>
    </footer>
</body>

</html>