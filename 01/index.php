<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "samochody");

$sql1 = 'SELECT p.marka, p.model, p.cena, k.nazwa, k.doplata FROM pojazdy p JOIN kolory k ON p.kolor = k.id WHERE p.model = "alfa"';
$res1 = $mysqli->query($sql1);

$sql2 = 'SELECT p.marka, p.model, p.cena FROM pojazdy p ORDER BY RAND() LIMIT 2;';
$result = $mysqli->query($sql2);
for ($res2 = array(); $row = $result->fetch_assoc(); $res2[] = $row);

$mysqli->close();

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfigurator samochodów</title>

    <link rel="stylesheet" href="styl.css">
</head>

<body>
    <header class="header">
        <h1>Serwis konfiguracji samochodów</h1>
    </header>

    <nav class="nav">
        <h2>Samochody</h2>
        <h2>Konfigurator</h2>
        <h2>Kontakt</h2>
    </nav>

    <main class="main">
        <section class="section-left">
            <table>
                <!-- Skrypt 1 -->
                <?php while ($row = $res1->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row["marka"] ?></td>
                        <td><?= $row["model"] ?></td>
                        <td><?= $row["nazwa"] ?></td>
                        <td><?= $row["cena"] + $row["doplata"] ?></td>
                    </tr>
                <?php endwhile ?>
            </table>
        </section>

        <section class="section-center">
            <table>
                <thead>
                    <th colspan="2">Konfiguracja</th>
                    <th>Cena</th>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">
                            <img src="a1.jpg" alt="Konfiguracja 1">
                        </td>
                    </tr>
                    <!-- Skrypt 2 -->
                    <tr>
                        <td>Marka</td>
                        <td><?= $res2[0]["marka"] ?></td>
                        <td rowspan="2"><?= $res2[0]["cena"] ?></td>
                    </tr>
                    <tr>
                        <td>Model</td>
                        <td><?= $res2[0]["model"] ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img src="a2.jpg" alt="Konfiguracja 2">
                        </td>
                    </tr>
                    <!-- Skrypt 2 -->
                    <tr>
                        <td>Marka</td>
                        <td><?= $res2[1]["marka"] ?></td>
                        <td rowspan="2"><?= $res2[1]["cena"] ?></td>
                    </tr>
                    <tr>
                        <td>Model</td>
                        <td><?= $res2[1]["model"] ?></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="section-right">
            <h3>111 222 444</h3>
            <img src="a3.png" alt="Samochód">
        </section>
    </main>

    <footer class="footer">
        <p>Stronę wykonał: 12345678909</p>
    </footer>
</body>

</html>