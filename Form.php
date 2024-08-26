<?php

ini_set("auto_detect_line_endings", true); // Per il fine linea su MAC

require_once('Utility.php');
include 'database/config.php';

use mie_classi\utility as UT;
//--------------------------------------------------------------------------
//nav e footer
$nav = "nav.json";
$foot = "footer.json";
$add = "address.json";
$arr_nav = json_decode(UT::leggi_testo($nav));
$arr_add = json_decode(UT::leggi_testo($add));
$arr_foot = json_decode(UT::leggi_testo($foot));
//--------------------------------------------------------------------------
//form
$selezionato = UT::richiesta_http("selezionato");
$selezionato = ($selezionato == null) ? 1 : $selezionato; // link di default

$inviato = UT::richiesta_http("inviato");
$inviato = ($inviato == null || $inviato != 1) ? false : true;

/**
 * Validazione dati PHP
 */


if ($inviato) {
    $valido = 0;
    //Recupero i dati
    $nome = UT::richiesta_http("nome");
    $cognome = UT::richiesta_http("cognome");
    $email = UT::richiesta_http("email");
    $telefono = UT::richiesta_http("telefono");
    $testo = UT::richiesta_http("testo");

    $cls_errore = ' class="errore"';


    //VALIDO I DATI
    if (($nome != "") && (strlen($nome) <= 25)) {
        $cls_errore_nome = "";
    } else {
        $valido++;
        $cls_errore_nome = $cls_errore;
        $nome = "";
    }

    if (($cognome != "") && UT::controlla_range_stringa($cognome, 0, 25)) {
        $cls_errore_cognome = "";
    } else {
        $valido++;
        $cls_errore_cognome = $cls_errore;
        $cognome = "";
    }

    if (($email != "") && UT::controlla_range_stringa($email, 10, 100) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $cls_errore_email = "";
    } else {
        $valido++;
        $cls_errore_email = $cls_errore;
        $email = "";
    }

    if (($telefono != "") && UT::controlla_range_stringa($telefono, 5, 20)) {
        $cls_errore_telefono = "";
    } else {
        $valido++;
        $cls_errore_telefono = $cls_errore;
        $telefono = "";
    }


    if (($testo != "") && UT::controlla_range_stringa($testo, 10, 500)) {
        $cls_errore_testo = "";
    } else {
        $valido++;
        $cls_errore_testo = $cls_errore;
        $testo = "";
    }

    $inviato = ($valido == 0) ? true : false;
} else {
    $nome = "";
    $cognome = "";
    $email = "";
    $telefono = "";
    $testo = "";

    $cls_errore_nome = "";
    $cls_errore_cognome = "";
    $cls_errore_email = "";
    $cls_errore_telefono = "";
    $cls_errore_testo = "";
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatti</title>
    <link rel="icon" href="immagini\favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/nav_footer.min.css" type="text/css">
    <link rel="stylesheet" href="css/form.min.css" type="text/css">
    <script type="application/javascript" src="utility.js"></script>
    <script type="application/javascript">
        const UT = new utility();
        window.onload = function() {
            const form = document.getElementById("form");
            const bott = document.getElementById("conferma");
            /**
             * Validazione dati Javascript
             */
            bott.onclick = function() {
                //-----------------------------------------------------------------------------------------------------
                //Controllo Nome
                console.log("submit");
                let valido = 0;
                const nome = document.getElementById("nome").value;
                const lb_nome = document.getElementById("lb_nome");

                valido_nome = nome != null && nome != "" && UT.controlla_range_stringa(nome, 0, 25) ? 0 : 1;
                valido += valido_nome;

                console.log("VALIDO", valido_nome);
                if (valido_nome > 0) {
                    lb_nome.classList.add("errore");

                    console.log(lb_nome, "ramo1", nome);
                } else {
                    lb_nome.classList.remove("errore");

                    console.log(lb_nome, "ramo2", nome);
                }

                //-----------------------------------------------------------------------------------------------------
                //Controllo Cognome
                const cognome = document.getElementById("cognome").value;
                const lb_cognome = document.getElementById("lb_cognome");
                valido_cognome = cognome != null && cognome != "" && UT.controlla_range_stringa(cognome, 0, 25) ? 0 : 1;
                valido += valido_cognome;

                console.log("VALIDO", valido_cognome);
                if (valido_cognome > 0) {
                    lb_cognome.classList.add("errore");

                    console.log(lb_cognome, "ramo1", cognome);
                } else {
                    lb_cognome.classList.remove("errore");

                    console.log(lb_cognome, "ramo2", cognome);
                }
                //-----------------------------------------------------------------------------------------------------
                //Controllo Email
                const email = document.getElementById("email").value;
                const lb_email = document.getElementById("lb_email");
                valido_email = email != null && email != "" && UT.controlla_range_stringa(email, 10, 40) ? 0 : 1;
                valido += valido_email;

                console.log("VALIDO", valido_email);
                if (valido_email > 0) {
                    lb_email.classList.add("errore");

                    console.log(lb_email, "ramo1", email);
                } else {
                    lb_email.classList.remove("errore");

                    console.log(lb_email, "ramo2", email);
                }
                //-----------------------------------------------------------------------------------------------------
                //Controllo Telefono
                const telefono = document.getElementById("telefono").value;
                const lb_telefono = document.getElementById("lb_telefono");
                valido_telefono = telefono != null && telefono != "" && UT.controlla_range_stringa(telefono, 5, 20) ? 0 : 1;
                valido += valido_telefono;

                console.log("VALIDO", valido_telefono);
                if (valido_telefono > 0) {
                    lb_telefono.classList.add("errore");

                    console.log(lb_telefono, "ramo1", telefono);
                } else {
                    lb_telefono.classList.remove("errore");

                    console.log(lb_telefono, "ramo2", telefono);
                }


                //-----------------------------------------------------------------------------------------------------
                //Controllo testo
                const testo = document.getElementById("testo").value;
                const lb_testo = document.getElementById("lb_testo");
                valido_testo = testo != null && testo != "" && UT.controlla_range_stringa(testo, 0, 500) ? 0 : 1;
                valido += valido_testo;

                console.log("VALIDO", valido_testo);
                if (valido_testo > 0) {
                    lb_testo.classList.add("errore");

                    console.log(lb_testo, "ramo1", testo);
                } else {
                    lb_testo.classList.remove("errore");

                    console.log(lb_testo, "ramo2", testo);
                }
            }

        };
    </script>
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


    <!--form-->
    <div class="spacer"></div>

    <?php
    if (!$inviato) {
    ?>

        <h1>Contatti</h1>

        <div class="form-section">

            <div class="form">
                <form action="form.php?inviato=1" method="POST" novalidate>
                    <h3>Compila il form per richiedere informazioni</h3>
                    <h4>Inserisci i tuoi dati</h4>
                    <fieldset>
                        <div><label for="nome" <?php echo $cls_errore_nome; ?>>Nome <span>*</span></label></div>
                        <input type="text" name="nome" placeholder="Nome" id="nome" required maxlength="25" value="<?php echo htmlspecialchars($nome); ?>">

                        <div><label for="cognome" <?php echo $cls_errore_cognome; ?>>Cognome</label></div>
                        <input type="text" name="cognome" placeholder="Cognome" id="cognome" required maxlength="40" value="<?php echo htmlspecialchars($cognome); ?>">

                        <div><label for="email" <?php echo $cls_errore_email; ?>>Email <span>*</span></label></div>
                        <input type="email" name="email" placeholder="Email" id="email" required maxlength="40" minlength="10" value="<?php echo htmlspecialchars($email); ?>">

                        <div><label for="tel" <?php echo $cls_errore_telefono; ?>>Numero di telefono</label></div>
                        <input type="tel" name="telefono" placeholder="Telefono" id="telefono" minlength="5" maxlength="20" value="<?php echo htmlspecialchars($telefono); ?>">

                        <div><label for="testo" <?php echo $cls_errore_testo; ?>>Testo <span>*</span></label></div>
                        <textarea name="testo" id="testo" placeholder="Testo" required><?php echo htmlspecialchars($testo); ?></textarea>

                        <div><label for="terms">Accetto i termini e le condizioni</label></div>
                        <div style="padding: 10px;">
                            <input type="checkbox" id="terms" name="terms" required>
                            <a href="https://www.iubenda.com/privacy-policy/62510373" class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe " title="Privacy Policy ">Visualizza termini e condizioni</a>
                            <input type="submit" value="Invia" style="padding: 5px;">
                        </div>
                        <button type="submit" id="conferma">Invia</button>
                    </fieldset>
                </form>

            </div>

        </div>

    <?php
    } else {
        if ($inviato) {
            $stmt = $conn->prepare("INSERT INTO Contatti (nome, cognome, email, telefono, testo) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nome, $cognome, $email, $telefono, $testo);

            if ($stmt->execute()) {
                echo "<br>" . str_repeat("-", 30) . "<br>Modulo inviato correttamente<br>";
            } else {
                echo "<br>" . str_repeat("-", 30) . "<br>Problema nell'invio del modulo<br>";
            }

            $stmt->close();
        }

        $conn->close();
    }
    ?>

    <div class="spacer"></div>

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