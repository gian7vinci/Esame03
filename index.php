<?php
require_once('Utility.php');

use mie_classi\utility as UT;
//--------------------------------------------------------------------------
//nav e footer
$nav = "nav.json";
$foot = "footer.json";
$add = "address.json";
$arr_nav = json_decode(UT::leggi_testo($nav));
$arr_add = json_decode(UT::leggi_testo($add));
$arr_foot = json_decode(UT::leggi_testo($foot));

$selezionato = UT::richiesta_http("selezionato");
$selezionato = ($selezionato == null) ? 1 : $selezionato; // link di default
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="icon" href="immagini\favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/nav_footer.min.css" type="text/css">
    <link rel="stylesheet" href="css/index.min.css" type="text/css">
    <script type="text/javascript"> //BANNER COOCKIES POLICY    
        var _iub = _iub || [];
        _iub.csConfiguration = {
            "siteId": 3741713,
            "cookiePolicyId": 62510373,
            "lang": "it"
        };
    </script>
    <script type="text/javascript" src="https://cs.iubenda.com/autoblocking/3741713.js"></script>
    <script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>
</head>

<body>
    <!--nav-->


    <nav class="hamburger-menu">
        <input id="controllo" type="checkbox">
        <label class="label-controllo" for="controllo">
            <span></span>
        </label>
        <img  class="logo_img" src="immagini/logo1.jpg" alt="Logo">
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

    <div class="spacer"></div>

    <div class="presentazione">
        <div class="testo">
            <h1>Ciao mi chiamo <span class="viola">Vinci Giovanni</span></h1>
            <h1>e sono un <span class="viola">Full Stack Developer</span></h1>
            <h3 style="margin-top: 60px;">Mi occupo di creazione di siti web <span class="viola">responsive</span> e <br> dinamici lato <span class="viola">Front-End</span> e <span class="viola">Back-End.</span></h3>
            <h4 style="margin-top: 60px;">
                Creerò per te una piattaforma credibile e attraente che convincerà gli utenti a sceglierti! <br>
                Il mio obiettivo è il tuo successo online.
            </h4>
            <button class="bottone"><a href="Form.php" title="Contattami">Contattami ora</a></button>
        </div>
        <div class="personale"><img src="immagini/img_pers.JPG" title="Questo sono io!"></div>
    </div>

<div class="spacer"></div>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2>Cosa posso fare per te</h2>
            <div class="services-grid">
                <div class="service-item">
                    <i class="fas fa-search"></i>
                    <h3>Ottimizzazione SEO</h3>
                    <p>Miglioro la visibilità del tuo sito sui motori di ricerca.</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-paint-brush"></i>
                    <h3>Web Design</h3>
                    <p>Progetto design moderni e user-friendly per il tuo sito.</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-code"></i>
                    <h3>Front-End Development</h3>
                    <p>Creo interfacce interattive e responsive.</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-server"></i>
                    <h3>Back-End Development</h3>
                    <p>Sviluppo sistemi robusti e scalabili.</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-camera"></i>
                    <h3>Fotografia</h3>
                    <p>Fornisco immagini professionali per il tuo brand.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="skills">
        <div class="container">
            <h2>Le mie competenze</h2>
            <div class="skills-grid">
                <div class="skill-item">
                    <img src="immagini/img_html.png" alt="HTML">
                    <p>HTML</p>
                </div>
                <div class="skill-item">
                    <img src="immagini/img_css.png" alt="CSS">
                    <p>CSS</p>
                </div>
                <div class="skill-item">
                    <img src="immagini/img_js.png" alt="JavaScript">
                    <p>JavaScript</p>
                </div>
                <div class="skill-item">
                    <img src="immagini/img_php.png" alt="PHP">
                    <p>PHP</p>
                </div>
                <div class="skill-item">
                    <img src="immagini/img_mysql.png" alt="MySQL">
                    <p>MySQL</p>
                </div>
                <div class="skill-item">
                    <img src="immagini/img_git.png" alt="Git">
                    <p>Git</p>
                </div>
                <div class="skill-item">
                    <img src="immagini/img_Ps.png" alt="Photoshop">
                    <p>Photoshop</p>
                </div>
                <div class="skill-item">
                    <img src="immagini/img_figma.png" alt="Figma">
                    <p>Figma</p>
                </div>
            </div>
        </div>
    </section>

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