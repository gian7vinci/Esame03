<?php

ini_set("auto_detect_line_endings", true); // Per il fine linea su MAC
require_once('database/config.php');
require_once('Utility.php');
require_once('content.php');

use mie_classi\utility as UT;
//--------------------------------------------------------------------------
//nav e footer
$nav = "nav.json";
$foot = "footer.json";
$add = "address.json";
//$work = "lavori.json";
$arr_nav = json_decode(UT::leggi_testo($nav));
$arr_add = json_decode(UT::leggi_testo($add));
$arr_foot = json_decode(UT::leggi_testo($foot));
//$arr_work = json_decode(UT::leggi_testo($work));
$selezionato = UT::richiesta_http("selezionato");
$selezionato = ($selezionato == null) ? 1 : $selezionato; // link di default

$scelto = UT::richiesta_http("id");
$scelto = ($scelto == null) ? 1 : $scelto;
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progetto</title>
    <link rel="icon" href="immagini\favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/nav_footer.min.css" type="text/css">
    <link rel="stylesheet" href="css/progetto.min.css" type="text/css">
</head>

<body>

    <!--nav-->


    <nav class="hamburger-menu">
        <input id="controllo" type="checkbox">
        <label class="label-controllo" for="controllo">
            <span></span>
        </label>
        <img class="logo_img" src="immagini/logo1.jpg" alt="Logo">
        <ul id="menu">
            <?php
            foreach ($arr_nav as $link) {
                $n = $link->id;
                $classe_selezionato = ($n == $selezionato) ? ' class="selezionato"' : '';
                printf('<li %s><a href="%s?selezionato=%u" title="%s" >%s</a></li>', $classe_selezionato, $link->url, $link->id, $link->nome, $link->title);
            }
            ?>
        </ul>
    </nav>

    <!--work-->
    <div class="spacer"></div>
    <?php
    
// Verifica se l'ID del progetto è passato nell'URL
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];

    // Query per ottenere i dettagli del progetto con l'ID specificato
    $sql = "SELECT id FROM lavori WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $project_id); // "i" indica che il parametro è un intero
    $stmt->execute();
    $result = $stmt->get_result();

    // Controlla se è stato trovato un progetto
    if ($result->num_rows > 0) {
        // Recupera il progetto e mostra il contenuto
        $row = $result->fetch_assoc();
        echo progetto($conn, $row['id']);
    } else {
        echo "Progetto non trovato.";
    }

    // Chiude lo statement
    $stmt->close();
} else {
    echo "ID del progetto non fornito.";
}

// Chiude la connessione
$conn->close();
?>




    <!--footer-->

    <footer class="footer">
        <section class="rigaFooter">
            <div class="contatto">
                <p>Contatti</p>
                <address>
                    <ul>
                        <?php
                        foreach ($arr_add as $link) {
                            $n = $link->id;
                            $classe_selezionato = ($n == $selezionato) ? ' class="selezionato"' : '';
                            printf('<li %s><a href="%s?selezionato=%u" title="%s" >%s</a></li>', $classe_selezionato, $link->url, $link->id, $link->nome, $link->title);
                        }
                        ?>
                    </ul>
                </address>
            </div>
        </section>
        <ul class="privacy">
            <li>
                <a href="https://www.iubenda.com/privacy-policy/62510373" class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe " title="Privacy Policy ">Privacy Policy</a>
                <script type="text/javascript">
                    (function(w, d) {
                        var loader = function() {
                            var s = d.createElement("script"),
                                tag = d.getElementsByTagName("script")[0];
                            s.src = "https://cdn.iubenda.com/iubenda.js";
                            tag.parentNode.insertBefore(s, tag);
                        };
                        if (w.addEventListener) {
                            w.addEventListener("load", loader, false);
                        } else if (w.attachEvent) {
                            w.attachEvent("onload", loader);
                        } else {
                            w.onload = loader;
                        }
                    })(window, document);
                </script>
            </li>
            <li>
                <a href="https://www.iubenda.com/privacy-policy/62510373/cookie-policy" class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe " title="Cookie Policy ">Cookie Policy</a>
                <script type="text/javascript">
                    (function(w, d) {
                        var loader = function() {
                            var s = d.createElement("script"),
                                tag = d.getElementsByTagName("script")[0];
                            s.src = "https://cdn.iubenda.com/iubenda.js";
                            tag.parentNode.insertBefore(s, tag);
                        };
                        if (w.addEventListener) {
                            w.addEventListener("load", loader, false);
                        } else if (w.attachEvent) {
                            w.attachEvent("onload", loader);
                        } else {
                            w.onload = loader;
                        }
                    })(window, document);
                </script>
            </li>
        </ul>
    </footer>
</body>

</html>