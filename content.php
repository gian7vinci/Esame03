<?php
include 'database/config.php';
//-----------------------------------------------------------------------------------------------------------------------------------------
//FUNZIONE PER GENERARE IL DIV PRENDENDO I DARTI DA UN DATABASE

function progetto($conn, $progetto_id)
{
    // Query SQL per ottenere i dati dal database
    $sql = "SELECT immagine, alt, titolo, contenuto FROM lavori WHERE id = ?";
    
    // Preparo la query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $progetto_id);
    $stmt->execute();
    
    // Ottengo il risultato della query
    $result = $stmt->get_result();
    
    // Controllo se ci sono risultati
    if ($result->num_rows > 0) {
        // Recupero i dati come un array associativo
        $work = $result->fetch_assoc();
        
        // Costruisco la stringa HTML adattata al DB------ I dati vengono sanitizzati usando `htmlspecialchars` per prevenire attacchi XSS.
        $str = '<div class="work">';
        $str .= '<div class="work-image">
                    <img src="' . htmlspecialchars($work['immagine']) . '" alt="' . htmlspecialchars($work['alt']) . '">
                </div>';
        $str .= '<div class="work-text">
                    <h1>' . htmlspecialchars($work['titolo']) . '</h1><br>
                    <p>' . htmlspecialchars($work['contenuto']) . '</p>
                </div>';
        $str .= '</div>';
    } else {
        // Se non ci sono risultati, restituisco un messaggio di errore
        $str = '<div class="work">Progetto non trovato.</div>';
    }
    
    // Chiude lo statement
    $stmt->close();

    
    
    return $str;
}



    //-----------------------------------------------------------------------------------------------------------------------------------------
//FUNZIONE PER GENERARE IL DIV PRENDENDO I DATI DA UN JSON
/*
function progetto($work)
{

    $str = '<div class="work">';

    $str .= '<div class="work-image">
                <img src="'.$work->immagine.'" alt="'.$work->alt.'">
            </div>';
    $str .= '<div class="work-text">
                <h1>'.$work->titolo.'</h1><br>
                <p>'.$work->contenuto.'</p>
            </div>'; 
    $str .= '</div>';

    return $str;
}
*/