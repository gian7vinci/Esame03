<?php
$host = 'localhost'; //$host = '31.11.39.165';
$user = 'root'; //$user = 'Sql1808099';
$password = ''; //$password = 'Xboxonex95!';// Inserisci la tua password
$database = 'Sito_personale'; //$database = 'Sql1808099_1';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}
?>
