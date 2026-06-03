<?php
require_once 'db.php';

$teade = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nimi = trim($_POST["nimi"]);
    $osakond = trim($_POST["osakond"]);
    $kontakt = trim($_POST["kontakt"]);
    $probleem = trim($_POST["probleem"]);

    if ($nimi != "" && $osakond != "" && $kontakt != "" && $probleem != "") {
        $stmt = $conn->prepare("INSERT INTO poordumised (nimi, osakond, kontakt, probleem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nimi, $osakond, $kontakt, $probleem);
        $stmt->execute();
        $teade = "Pöördumine on edukalt salvestatud.";
    } else {
        $teade = "Kõik väljad on kohustuslikud.";
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Kasutajatugi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="bg-primary text-white text-center p-5">
    <h1>Kasutajatugi</h1>
    <p>Ettevõtte IT-probleemide esitamise keskkond</p>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Kasutajatugi</a>
        <div class="navbar-nav">
            <a class="nav-link" href="index.php">Avaleht</a>
            <a class="nav-link" href="kkk.php">KKK</a>
            <a class="nav-link" href="kontaktid.php">Kontaktid</a>
            <a class="nav-link" href="admin.php">Admin</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <h2>Avaleht</h2>
    <p>Siin saad esitada IT-probleemi kasutajatoele.</p>

    <?php if ($teade != ""): ?>
        <div class="alert alert-info"><?php echo $teade; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nimi</label>
            <input type="text" name="nimi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Osakond</label>
            <input type="text" name="osakond" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kontakt</label>
            <input type="text" name="kontakt" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Probleemi kirjeldus</label>
            <textarea name="probleem" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Saada pöördumine</button>
    </form>

</div>

</body>
</html>
