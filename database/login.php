<?php
require_once('config.php');

// Inizializzazione della variabile di errore
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se i parametri sono presenti
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Recupero e sanitizzazione dei dati inviati
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);

        // Preparazione della query SQL
        $sql_select = "SELECT id, username, password FROM utenti WHERE username = ?";
        if ($stmt = $conn->prepare($sql_select)) {
            // Associa i parametri e esegui la query
            $stmt->bind_param("s", $username);
            $stmt->execute();
            
            // Ottieni il risultato
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Verifica la password
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Password errata.";
                }
            } else {
                $error = "Username non trovato.";
            }
            
            // Chiudi la dichiarazione
            $stmt->close();
        } else {
            $error = "Errore nella preparazione della query.";
        }
    } else {
        $error = "Username o password non forniti.";
    }
}

// Chiudi la connessione
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="database.css" type="text/css">
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Accedi</button>
    </form>
    <?php if (!empty($error)) echo "<p>$error</p>"; ?>
</body>
</html>
