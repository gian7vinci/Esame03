<?php

ini_set("auto_detect_line_endings", true); // Per il fine linea su MAC
require_once('database/config.php');
require_once('Utility.php');
require_once('card.php');

use mie_classi\utility as UT;
//--------------------------------------------------------------------------
//nav e footer
$nav = "nav.json";
$foot = "footer.json";
$add = "address.json";
//$lav = "lavori.json"; metodo per prelevare dati da json dei lavori
$arr_nav = json_decode(UT::leggi_testo($nav));
$arr_add = json_decode(UT::leggi_testo($add));
$arr_foot = json_decode(UT::leggi_testo($foot));
//$arr_lav = json_decode(UT::leggi_testo($lav)); metodo per prelevare dati da json dei lavori

$selezionato = UT::richiesta_http("selezionato");

$selezionato = ($selezionato == null) ? 1 : $selezionato; // link di default
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lavori</title>
    <link rel="icon" href="immagini\favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/nav_footer.min.css" type="text/css">
    <link rel="stylesheet" href="css/form.min.css" type="text/css">
    <link rel="stylesheet" href="css/lavori.min.css" type="text/css">
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

    <!--card lavori-->

    <div class="spacer"></div>


    <h1>I miei lavori</h1>

    <div class="lavori">

        <?php

        // 3. Query per Recuperare Tutti gli ID delle Card
        $sql = "SELECT id FROM lavori";
        $result = $conn->query($sql);

        // 4. Iterazione sugli ID e Creazione delle Card
        if ($result->num_rows > 0) {
            foreach ($result as $row) {
                // Chiama la funzione card_content per ogni ID
                echo card_content($conn, $row['id']);
            }
        } else {
            echo "Nessuna card trovata.";
        }

        // Chiude la connessione
        $conn->close();

        ?>

    </div>

    <!--footer-->

    <footer class="footer" style="margin: 0;">
        <div class="rigaFooter">
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

        </div>
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