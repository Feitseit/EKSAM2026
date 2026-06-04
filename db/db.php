<?php
$host = "10.0.51.10";
$dbname = "kasutajatugi";
$user = "kasutajatugi";
$pass = "Kasutaja2026!";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
die("Ühendus ebaõnnestus: " . $conn->Connect_error);
}
?>
