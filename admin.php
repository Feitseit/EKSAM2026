<?php
session_start();
require_once 'db.php';

$teade = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kasutajanimi = $_POST["kasutajanimi"];
    $parool = $_POST["parool"];

    $stmt = $conn->prepare("SELECT * FROM administraator WHERE kasutajanimi = ? AND parool = ?");
    $stmt->bind_param("ss", $kasutajanimi, $parool);
    $stmt->execute();
    $tulemus = $stmt->get_result();

    if ($tulemus->num_rows == 1) {
        $_SESSION["admin"] = $kasutajanimi;
        header("Location: admin_panel.php");
        exit;
    } else {
        $teade = "Vale kasutajanimi või parool.";
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="bg-primary text-white text-center p-5">
    <h1>Kasutajatugi</h1>
</div>

<div class="container mt-4">
    <h2>Administraatori sisselogimine</h2>

    <?php if ($teade != ""): ?>
        <div class="alert alert-danger"><?php echo $teade; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Kasutajanimi</label>
            <input type="text" name="kasutajanimi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Parool</label>
            <input type="password" name="parool" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Logi sisse</button>
    </form>
</div>

</body>
</html>
