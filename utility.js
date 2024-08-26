/**
 * Questa classe contiene tutti i metodi fino ad oggi creati
 * @author Mario Rossi
 * @copyright 2024
 * @license LGPL
 * @version 1.0.0
 */

class utility {
    constructor() { }
    //--------------------------------------------------------------------------------------------
    /**
     * Verifica se il numero è pari
     * 
     * @param {string} stringa Stringa da controllare
     * @param {number} min Lunghezza minima
     * @param {number} min Lunghezza massima
     * @return {boolean}
     * 
     */
    controlla_range_stringa(stringa, min = null, max = null) {
        let rit = 0;
        const n = stringa.length;
        if (min != null && n < min) {
            rit++;
        }
        if (max != null && n > max) {
            rit++;
        }
        return (rit == 0);
    }


    //--------------------------------------------------------------------------------------------
    /**
            * Verifica se il numero è pari
            * 
            * @param {number} numero numero da verificare
            * @return boolean
            * 
           */

    controlla_se_pari(numero) {
        var ris = numero % 2;
        return ris === 0 ? true : false;
    }


    //--------------------------------------------------------------------------------------------
    /**
    * 
    * Funzione per creare un array di default
    * @param {number} Numero di elementi dell'array
    * @return array
    * 
    */

    crea_array_default(n_valori) {
        var arr = [];
        for (var i = 0; i < n_valori; i++) {
            var numero = genera_int_casuale(100);
            arr.push(numero);
        }
        return arr;
    }

    
    //--------------------------------------------------------------------------------------------
    /**
    * Genera intero casuale
    * @param {number} max numero massimo
    * @return {number}
    * 
    */
       genera_int_casuale(max) {
        max++;
        return Math.floor(Math.random() * max);
    }


    //--------------------------------------------------------------------------------------------
     /**
        * Trova il valore minore in array
        * 
        * @param {array.<number>} arr Array su cui effettuare la ricerca
        * @return {number}
        * 
        */
       
     min_in_array(arr) {
        /**
         * i 3 puntini spacchettano l'array e lo passano come parametri divisi da una virgola
         * Non funziona su IE vecchi
         */
        const min = Math.min(...arr);
        return min;
    }

    //--------------------------------------------------------------------------------------------
    /**
    * 
    * Funzione per estrapolare le querystring
    * @param {string} stringaQuerystring da cercare
    * @return string
    * 
    */

    query_string(stringa) {
        let valore = null;
        /**
         * L'interfaccia URLSearchParams definisce i metodi di utilità per lavorare con la stringa di query di un URL.
         * L'oggetto Proxy consente di creare un proxy per un altro oggetto, che può intercettare e ridefinire le operazioni fondamentali per quell'oggetto.
         * Uso Proxy perchè così elaboro la get in risposta da chiave=valore al suo valore
         * 
         * @see {https://developer.mozzilla.org/en-US/docs/Web/API/URLSearchParams}
         * @see {https://developer.mozzilla.org/en-US/docs/Web/Javascript/Reference/Global_Objects/Proxy}
         * 
        */
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (search_param, prop) => search_param.get(prop),
        });
        // Ritorna il valore di "stringa" se il link e "https://example.com/?stringa=valore"
        valore = params[stringa] != null ? params[stringa] : null; // "valore"
        return valore
    }



    //--------------------------------------------------------------------------------------------
    /**
    * 
    * Controlla se una mail è valida
    * 
    * @param {string} mail Email da validare
    * @return {boolean}
    * 
    */
    valida_email(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(mail)) {
            return true;
        } else {
            return false;
        }
    }
}