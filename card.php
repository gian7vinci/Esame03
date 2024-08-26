<?php
include 'database/config.php';
//-----------------------------------------------------------------------------------------------------------------------------------------
//FUNZIONE PER GENERARE IL DIV PRENDENDO I DATI DA UN DATABASE
function card_content($conn, $card_id)
{
    // Query SQL per ottenere i dati dal database
    $sql = "SELECT url, id, titolo, immagine, alt FROM lavori WHERE id = ?";
    
    // Prepara la query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $card_id);
    $stmt->execute();
    
    // Ottengo il risultato della query
    $result = $stmt->get_result();
    
    // Controllo se ci sono risultati
    if ($result->num_rows > 0) {
        // Recupero i dati come un array associativo
        $card = $result->fetch_assoc();
        
        // Costruisco la stringa HTML modificata per il DB------ I dati vengono sanitizzati usando `htmlspecialchars` per prevenire attacchi XSS.
        $str = '<div class="card">';
        $str .= '<a href="progetto.php?id=' . htmlspecialchars($card['id']) . '" id="' . htmlspecialchars($card['id']) . '" title="' . htmlspecialchars($card['titolo']) . '">
                    <img src="' . htmlspecialchars($card['immagine']) . '" alt="' . htmlspecialchars($card['alt']) . '">
                </a>';
        $str .= '</div>';
    } else {
        // Se non ci sono risultati, restituisco una card vuota o un messaggio di errore
        $str = '<div class="card">Dati non trovati.</div>';
    }
    
    // Chiude lo statement
    $stmt->close();
    
    return $str;
}


//-----------------------------------------------------------------------------------------------------------------------------------------
//FUNZIONE PER GENERARE IL DIV PRENDENDO I DATI DA UN JSON
/*
function card_content($card)
{

    $str = '<div class="card">';

    $str .= '<a href="' . $card->url . '" id="' . $card->id . '" title="' . $card->title . '">
                <img src="' . $card->img . '" alt="' . $card->alt . '">
            </a>';
    $str .= '</div>';

    return $str;
}
*/
