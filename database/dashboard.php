<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="database.css" type="text/css">
</head>
<body>
    <h2>Benvenuto nella Dashboard</h2>
    <ul>
        <li><a href="gestione_utenti.php">Gestione Utenti</a></li>
        <li><a href="gestione_lavori.php">Gestione Lavori</a></li>
        <li><a href="gestione_contatti.php">Gestione Contatti</a></li>

    </ul>
</body>
</html>
