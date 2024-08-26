<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM contatti WHERE id=$id";
        $conn->query($sql);
    }
}

$sql = "SELECT * FROM contatti ORDER BY data_invio DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Contatti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Gestione Contatti</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Email</th>
            <th>Telefono</th>
            <th>Testo</th>
            <th>Data Invio</th>
            <th>Azione</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nome']; ?></td>
            <td><?php echo $row['cognome']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['telefono']; ?></td>
            <td><?php echo nl2br($row['metestossaggio']); ?></td>
            <td><?php echo $row['data_invio']; ?></td>
            <td>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="submit" name="delete" value="Elimina">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
