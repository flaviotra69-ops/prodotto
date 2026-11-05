<?php
// Iniziamo ogni esercizio con l'Inizializzazione delle variabili
$prodotto= ""; //valore che inserisce l'utente
$prezzo = ""; //valore che inserisce l'utente
$sconto = ""; //valore che inserisce l'utente
$errori = []; // array che avrà tutti gli errori
$prezzofinale= 0; // prezzo dopo lo sconto
$risparmio = 0; // la quantità di soldi che viene risparmiata
$fascia = ""; // rappresenta la categoria dello sconto
$calcoloeseguito = false; // indica se il calcolo è stato eseguito correttamente

// una volta che l'utente ha premuto il tasto "Calcola" dovranno essere eseguite più operazioni
if ($_SERVER["REQUEST_METHOD"] == "POST") { // metodo utilizzato per inviare la richiesta alla pagina
    $prodotto= trim($_POST["prodotto"]); // eliminiamo lo spazio all'Inizio e alla fine del prodotto e recuperiamo il valore dal campo del FORM (Il valore viene recuperato da name e non id)
    $prezzo = trim($_POST["prezzo"]); // eliminiamo lo spazio all'Inizio e alla fine del prezzo e recuperiamo il valore dal campo del FORM (Il valore viene recuperato da name e non id)
    $sconto = trim($_POST["sconto"]); // eliminiamo lo spazio all'Inizio e alla fine dello sconto e recuperiamo il valore dal campo del FORM (Il valore viene recuperato da name e non id)


    // Controllare il valore del prodotto, prezzo e sconto come richiesto
    // prodotto
    if ($prodotto == "") { // controlliamo se il prodotto dovesse essere vuoto
        $errori["prodotto"] = "Il prodotto è obbligatorio"; // Il prodotto non può essere vuoto, quindi scriviamo errore all'Interno dell'array errori
    }
    // controlliamo prima se il prodotto è vuoto, dopo la lunghezza del prodotto
    elseif (mb_strlen($prodotto) > 30){ // controlliamo la massima lunghezza della stringa
        $errori["prodotto"] = "Il prodotto non può superare 30 caratteri"; //Il prodotto non può superare 30 caratteri di lunghezza, quindi scriviamo errore all'Interno dell'array errori
    }
    //prezzo
    if (!is_numeric($prezzo) || $prezzo <= 0) { // controlliamo che il prezzo sia un numero, oppure se il prezzo dovesse essere maggiore di zero
        $errori["prezzo"] = "Il prezzo deve essere un numero maggiore di zero"; //Il prezzo non può essere una stringa, oppure un valore uguale a zero e negativo, quindi scriviamo errore all'Interno dell'array errori
    }
    //sconto
    if (!is_numeric($sconto) || $sconto != (int)$sconto){ // verifichiamo che lo sconto sia un valore numero (is_numeric) e controlliamo che lo sconto non abbia valori decimali
        $errori["sconto"] = "Lo sconto dovrebbe essere un numero intero"; //Lo sconto non può essere una stringa, quindi scriviamo errore all'Interno dell'array errori
    }
    elseif ($sconto < 1 || $sconto > 90) { // controlliamo che lo sconto sia compreso tra 1 e 90
        $errori["sconto"] = "Lo sconto deve essere compreso tra 1 e 90"; //Lo sconto non può essere minore di uno, oppure maggiore di 90, quindi scriviamo errore all'Interno dell'array errori
    }

    // Effettuare il Calcolo
    if (empty($errori)){
        $risparmio = $prezzo * $sconto/ 100; // ciò che risparmiamo, applicando lo sconto
        $prezzofinale = $prezzo - $risparmio; //il prezzo finale è dato dalla differenza tra il prezzo e lo sconto
        $calcoloeseguito = true; // scriviamo che il calcolo è stato eseguito correttamente
    }

    // Attribuiamo la fascia dello sconto
    // in base al valore Determiniamo la fascia di quest utlimo
    if ($calcoloeseguito) {
        if( $sconto < 20){
            $fascia = "PICCOLO";
        }
        else if( $sconto < 50){
            $fascia = "BUONO";
        }
        else{
            $fascia= "SUPER";
        }
    }

    //Salviamo ciò che viene scritto all'Interno di un file CSV
    // Salvataggio del calcolo nel file
    if ($calcoloeseguito) { // Controlla se il calcolo è stato eseguito correttamente
        $file = fopen("log.csv", "a"); // Apre il file log.csv per aggiungere nuovi dati
        if ($file != false) {
            if (filesize("log.csv") == 0) {   // Controlla se il file è vuoto
                // Scrive i nomi delle colonne nel file
                fputcsv($file, ["data", "prodotto", "prezzo", "sconto", "risparmio", "prezzo_finale", "fascia"], ";");
            }
            fputcsv($file, [ // Scrive i dati del calcolo nel file
                date("Y-m-d H:i:s"),
                $prodotto,
                $prezzo,
                $sconto,
                $risparmio,
                $prezzofinale,
                $fascia
            ], ";");
            fclose($file);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Calcolatore di sconto</title>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <h1>Calcolatore di sconto</h1>
    <!-- FORM -->
    <form method="post" action="index.php"> <!-- Crea il modulo -->
        <label for="prodotto">Prodotto</label> <!-- Etichetta prodotto -->
        <input type="text" id="prodotto" name="prodotto" value="<?= htmlspecialchars($prodotto) ?>"
        <?php if (isset($errori["prodotto"])) { // Controlla se esiste un errore
            echo 'class="errore"'; // Evidenzia il campo
        } ?>
        <?php if (isset($errori["prodotto"])) { // Controlla se esiste un errore ?>
            <p class="msg-errore"><?= $errori["prodotto"] ?></p> <!-- Mostra l'errore -->
        <?php } ?>
        <label for="prezzo">Prezzo</label> <!-- Etichetta prezzo -->
        <input type="text" id="prezzo" name="prezzo" value="<?= htmlspecialchars($prezzo) ?>"
        <?php if (isset($errori["prezzo"])) { // Controlla se esiste un errore
            echo 'class="errore"'; // Evidenzia il campo
        } ?> >
        <?php if (isset($errori["prezzo"])) { // Controlla se esiste un errore ?>
            <p class="msg-errore"><?= $errori["prezzo"] ?></p> <!-- Mostra l'errore -->
        <?php } ?>
        <label for="sconto">Sconto</label> <!-- Etichetta sconto -->
        <input type="text" id="sconto" name="sconto" value="<?= htmlspecialchars($sconto) ?>"
        <?php if (isset($errori["sconto"])) { // Controlla se esiste un errore
            echo 'class="errore"'; // Evidenzia il campo
        } ?> >
        <?php if (isset($errori["sconto"])) { // Controlla se esiste un errore ?>
            <p class="msg-errore"><?= $errori["sconto"] ?></p> <!-- Mostra l'errore -->
        <?php } ?>
        <button type="submit">Calcola</button> <!-- Invia il modulo -->
    </form>

    <!-- RISULTATO -->
    <?php if ($calcoloeseguito) { // Controlla se il calcolo è stato eseguito ?>
        <div class="risultato <?= strtolower($fascia) ?>"> <!-- Mostra il risultato con il colore della fascia -->
            <h2>Risultato</h2> <!-- Titolo del risultato -->
            <p>Prodotto: <?= htmlspecialchars($prodotto) ?></p> <!-- Mostra il prodotto -->
            <p>Prezzo finale: <?= number_format($prezzofinale, 2, ",", ".") ?></p> <!-- Mostra il prezzo finale -->
            <p>Risparmio: <?= number_format($risparmio, 2, ",", ".") ?></p> <!-- Mostra il risparmio -->
            <p>Fascia dello sconto: <?= $fascia ?></p> <!-- Mostra la fascia -->
        </div>
    <?php } ?>

</body>
</html>