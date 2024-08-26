<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) { //Eliminazione di un utente
        $id = $_POST['id'];
        $sql = "DELETE FROM utenti WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['add'])) { //Aggiunta di un utente
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO utenti (username, password) VALUES ('$username', '$password')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) { //Modifica di un utente
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Se la password è stata cambiata, aggiorna anche la password
        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE utenti SET username='$username', password='$password' WHERE id=$id";
        } else {
            $sql = "UPDATE utenti SET username='$username' WHERE id=$id";
        }

        $conn->query($sql);
    }
}

$sql = "SELECT * FROM utenti";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Utenti</title>
    <link rel="stylesheet" href="database.css" type="text/css">
</head>
<body>
    <h2>Gestione Utenti</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Azioni</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="submit" name="delete" value="Elimina">
                </form>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="submit" name="edit" value="Modifica">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <?php
    // Se è stato richiesto di modificare un utente, mostra il modulo di modifica
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM utenti WHERE id=$id";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
    ?>
    <h3>Modifica utente</h3>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br><br>
        
        <label for="password">Password (lascia vuoto per non modificare):</label>
        <input type="password" id="password" name="password"><br><br>
            
        <input type="submit" name="update" value="Aggiorna">
    </form>
    <?php } ?>

    <h3>Aggiungi nuovo utente</h3>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
            
        <input type="submit" name="add" value="Aggiungi">
    </form>
</body>
</html>

<?php
// Chiude la connessione
$conn->close();
?>
