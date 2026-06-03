<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["admin"])) {
    header("Location: admin.php");
    exit;
}

if (isset($_POST["add_request"])) {
    $nimi = trim($_POST["nimi"]);
    $osakond = trim($_POST["osakond"]);
    $kontakt = trim($_POST["kontakt"]);
    $probleem = trim($_POST["probleem"]);

    if ($nimi != "" && $osakond != "" && $kontakt != "" && $probleem != "") {
        $stmt = $conn->prepare("INSERT INTO poordumised (nimi, osakond, kontakt, probleem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nimi, $osakond, $kontakt, $probleem);
        $stmt->execute();
    }

    header("Location: admin_panel.php");
    exit;
}

if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $conn->query("DELETE FROM poordumised WHERE id=$id");
    header("Location: admin_panel.php");
    exit;
}

if (isset($_POST["update_status"])) {
    $id = intval($_POST["id"]);
    $staatus = $_POST["staatus"];

    $stmt = $conn->prepare("UPDATE poordumised SET staatus=? WHERE id=?");
    $stmt->bind_param("si", $staatus, $id);
    $stmt->execute();

    header("Location: admin_panel.php");
    exit;
}

$result = $conn->query("SELECT * FROM poordumised ORDER BY lisatud DESC");
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Admin paneel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h2>Pöördumiste haldus</h2>

    <h4>Lisa uus pöördumine</h4>

    <form method="post" class="mb-4">
        <input type="hidden" name="add_request" value="1">

        <div class="mb-2">
            <input type="text" name="nimi" class="form-control" placeholder="Nimi" required>
        </div>

        <div class="mb-2">
            <input type="text" name="osakond" class="form-control" placeholder="Osakond" required>
        </div>

        <div class="mb-2">
            <input type="text" name="kontakt" class="form-control" placeholder="Kontakt" required>
        </div>

        <div class="mb-2">
            <textarea name="probleem" class="form-control" placeholder="Probleemi kirjeldus" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Lisa pöördumine</button>
    </form>

    <table class="table table-bordered table-striped">

        <tr>
            <th>ID</th>
            <th>Nimi</th>
            <th>Osakond</th>
            <th>Kontakt</th>
            <th>Probleem</th>
            <th>Staatus</th>
            <th>Lisatud</th>
            <th>Tegevused</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>

        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= htmlspecialchars($row["nimi"]) ?></td>
            <td><?= htmlspecialchars($row["osakond"]) ?></td>
            <td><?= htmlspecialchars($row["kontakt"]) ?></td>
            <td><?= htmlspecialchars($row["probleem"]) ?></td>

            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $row["id"] ?>">

                    <select name="staatus" class="form-select">
                        <option value="Uus" <?= $row["staatus"] == "Uus" ? "selected" : "" ?>>Uus</option>
                        <option value="Töös" <?= $row["staatus"] == "Töös" ? "selected" : "" ?>>Töös</option>
                        <option value="Lahendatud" <?= $row["staatus"] == "Lahendatud" ? "selected" : "" ?>>Lahendatud</option>
                    </select>

                    <button type="submit" name="update_status" class="btn btn-sm btn-primary mt-1">
                        Salvesta
                    </button>
                </form>
            </td>

            <td><?= $row["lisatud"] ?></td>

            <td>
                <a href="?delete=<?= $row["id"] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Kas kustutada pöördumine?')">
                   Kustuta
                </a>
            </td>
        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>
