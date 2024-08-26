<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {       // Eliminazione di un lavoro
        $id = $_POST['id'];
        $sql = "DELETE FROM lavori WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['add'])) {    // Aggiunta di un lavoro
        $titolo = $_POST['titolo'];
        $contenuto = $_POST['contenuto'];
        $alt = $_POST['alt'];

        // Gestione dell'upload dell'immagine
        $target_dir = "immagini/";
        $target_file = $target_dir . basename($_FILES["immagine"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Controlla se il file è una vera immagine o un falso
        $check = getimagesize($_FILES["immagine"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Il file non è un'immagine.";
            $uploadOk = 0;
        }

        // Controlla la dimensione del file
        if ($_FILES["immagine"]["size"] > 500000) {
            echo "Il file è troppo grande.";
            $uploadOk = 0;
        }

        // Permetti solo certi formati di file
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sono permessi solo file JPG, JPEG, PNG & GIF.";
            $uploadOk = 0;
        }

        // Verifica se $uploadOk è impostato a 0 da un errore
        if ($uploadOk == 0) {
            echo "Spiacente, il tuo file non è stato caricato.";
        // se tutto è ok, prova a caricare il file
        } else {
            if (move_uploaded_file($_FILES["immagine"]["tmp_name"], $target_file)) {
                echo "Il file ". htmlspecialchars(basename($_FILES["immagine"]["name"])). " è stato caricato.";
                $img = $target_file;

                // Inserisci il record nel database
                $sql = "INSERT INTO lavori (titolo, contenuto, alt, immagine) VALUES ('$titolo', '$contenuto','$alt','$img')";
                $conn->query($sql);
            } else {
                echo "C'è stato un errore durante il caricamento del file.";
            }
        }
    } elseif (isset($_POST['update'])) { // Modifica di un lavoro
        $id = $_POST['id'];
        $titolo = $_POST['titolo'];
        $contenuto = $_POST['contenuto'];
        $alt = $_POST['alt'];
        
        $img = $_POST['immagine']; // Mantieni l'immagine corrente se non viene caricata una nuova

        if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "immagini";
            $target_file = $target_dir . basename($_FILES["immagine"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Controlla se il file è una vera immagine o un falso
            $check = getimagesize($_FILES["immagine"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "Il file non è un'immagine.";
                $uploadOk = 0;
            }

            // Controlla la dimensione del file
            if ($_FILES["immagine"]["size"] > 500000) {
                echo "Il file è troppo grande.";
                $uploadOk = 0;
            }

            // Permetti solo certi formati di file
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sono permessi solo file JPG, JPEG, PNG & GIF.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["immagine"]["tmp_name"], $target_file)) {
                    $img = $target_file; // Aggiorna l'immagine solo se il caricamento ha avuto successo
                } else {
                    echo "C'è stato un errore durante il caricamento del file.";
                }
            }
        }

        // Aggiorna il record nel database
        $sql = "UPDATE lavori SET titolo='$titolo', contenuto='$contenuto', alt='$alt', immagine='$img' WHERE id=$id";
        $conn->query($sql);
    }
}

$sql = "SELECT * FROM lavori";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Lavori</title>
    <link rel="stylesheet" href="database.css" type="text/css">
</head>
<body>
    <h2>Gestione Lavori</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Titolo</th>
            <th>Contenuto</th>
            <th>Alt</th>
            <th>Immagine</th>
            <th>Azione</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['titolo']; ?></td>
            <td><?php echo $row['contenuto']; ?></td>
            <td><?php echo $row['alt']; ?></td>
            <td><img src="<?php echo $row['immagine']; ?>" alt="<?php echo $row['alt']; ?>" style="max-width:100px;"></td>
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
    // Se è stato richiesto di modificare un lavoro, mostra il modulo di modifica
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM lavori WHERE id=$id";
        $result = $conn->query($sql);
        $lavoro = $result->fetch_assoc();
    ?>
    <h3>Modifica Lavoro</h3>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $lavoro['id']; ?>">
        
        <label for="titolo">Titolo:</label>
        <input type="text" id="titolo" name="titolo" value="<?php echo $lavoro['titolo']; ?>" required><br><br>
        
        <label for="contenuto">Contenuto:</label>
        <textarea id="contenuto" name="contenuto" required><?php echo $lavoro['contenuto']; ?></textarea><br><br>

        <label for="alt">Alt:</label>
        <textarea id="alt" name="alt" required><?php echo $lavoro['alt']; ?></textarea><br><br>
        
        <label for="immagine">Immagine Corrente:</label>
        <p><?php echo $lavoro['immagine']; ?></p>
        <label for="immagine">Carica Nuova Immagine:</label>
        <input type="file" id="immagine" name="immagine"><br><br>

        <input type="submit" name="update" value="Aggiorna">
    </form>
    <?php } ?>

    <h3>Aggiungi nuovo lavoro</h3>
    <form method="post" enctype="multipart/form-data">
        <label for="titolo">Titolo:</label>
        <input type="text" id="titolo" name="titolo" required><br><br>
        
        <label for="contenuto">Contenuto:</label>
        <textarea id="contenuto" name="contenuto" required></textarea><br><br>

        <label for="alt">Alt:</label>
        <textarea id="alt" name="alt" required></textarea><br><br>
        
        <label for="immagine">Carica Immagine:</label>
        <input type="file" id="immagine" name="immagine" required><br><br>
        
        <input type="submit" name="add" value="Aggiungi">
    </form>
</body>
</html>

<?php
$conn->close();
?>
