<?php

namespace mie_classi;


class utility
{

    //----------------------------------------------------------------------------------------
    /**
     * Funzione per controllare se una stringa sta all'interno di un range
     * 
     * @param string $stringa stringa da controllare
     * @param integer $min lungheza minima
     * @param integer $max lungheza massima
     * @return boolean
     * 
     */

    public static function controlla_range_stringa($stringa, $min = null, $max = null)
    {
        $rit = 0;
        $n = strlen($stringa);
        if ($min != null && $n < $min) {
            $rit++;
        }
        if ($max != null && $n > $max) {
            $rit++;
        }
        return ($rit == 0);
    }
    //----------------------------------------------------------------------------------------
    /**
     * Funzione per leggere del testo in un file
     * 
     * @param string $file nome del file
     * @return boolean|string
     * 
     */
    public static function leggi_testo($file)
    {
        $rit = false;
        if (!$fp = fopen($file, 'r')) {
            echo "Non posso aprire il file $file<br>";
        } else {
            if (is_readable($file) === false) {
                echo "il file $file non è leggibile<br>";
            } else {
                $rit = fread($fp, filesize($file));
            }
        }
        fclose($fp);
        return $rit;
    }
    //----------------------------------------------------------------------------------------
    /**
     * Funzione per leggere del testo in un file CSV
     * 
     * @param string $file nome del file
     * @return boolean|array
     * 
     */
    public static function leggi_testo_csv($file)
    {
        $rit = false;
        $riga = 0;
        if (!$fp = fopen($file, 'r')) {
            echo "Non posso aprire il file $file<br>";
        } else {
            if (is_readable($file) === false) {
                echo "il file $file non è leggibile<br>";
            } else {
                while (($data = fgetcsv($fp, null, ";")) !== false) {
                    $rit[$riga] = $data;
                    $riga++;
                }
            }
        }
        fclose($fp);
        return $rit;
    }
    //----------------------------------------------------------------------------------------
    /**
     * 
     * Funzione per estrarre dal $_POST o dal $_GET la proprietà richiesta
     * 
     * @param string Proprietà da ricercare
     * @return string|null  
     * 
     */
    public static function richiesta_http($str)
    {
        $rit = null;
        if ($str !== null) {
            if (isset($_POST[$str])) {
                $rit = $_POST[$str];
            } elseif (isset($_GET[$str])) {
                $rit = $_GET[$str];
            }
        }
        return $rit;
    }
    //----------------------------------------------------------------------------------------
    /**
     * funzione per scrivere del testo in un file
     * 
     * @param string $file nome del file
     * @param string $stringa testo da inserire
     * @return boolean
     */

    public static function scrivi_testo($file, $str, $commenta = false)
    {
        $rit = false;
        if (!$fp = fopen($file, 'a')) {
            echo "non posso aprire il file $file<br>";
        } else {
            if (is_writable($file) === false) {
                echo "il file $file non è scrivibile<br>";
            } else {
                if (!fwrite($fp, $str)) {
                    echo "non posso scrivere il file $file<br>";
                } else {
                    if ($commenta) echo "Operazione completata! ho scritto $str nel file $file<br>";
                    $rit = true;
                }
            }
        }
        fclose($fp);
        return $rit;
    }

    //}

    //----------------------------------------------------------------------------------------
    //FUNZIONE PER CREARE LA CARD

    function card_content($card)
    {
    
        $str = '<div class="card">';
    
        $str .= '<a href="'.$card->url.'" id="'.$card->id.'" title="'.$card->title.'">
                    <img src="'.$card->img.'" alt="'.$card->alt.'">
                </a>';
        $str .= '</div>';
    
        return $str;
    }
    
 //----------------------------------------------------------------------------------------
    //FUNZIONE PER CREARE LA PAGINA PROGETTO

    function progetto($work)
    {
    
        $str = '<div class="work">';
    
        $str .= '<div class="work-image">
                    <img src="'.$work->img.'" alt="'.$work->alt.'">
                </div>';
        $str .= '<div class="work-text">
                    <h2>"'.$work->title.'"</h2><br>
                    <p>"'.$work->content.'"</p>
                </div>'; 
        $str .= '</div>';
    
        return $str;
    }

}

define("COMMENTA", true);
