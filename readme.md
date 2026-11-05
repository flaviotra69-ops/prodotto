# Descrizione

Questo progetto consiste nella realizzazione di un calcolatore di sconto utilizzando PHP, HTML e CSS.

Il programma permette di inserire il nome di un prodotto, il suo prezzo e la percentuale di sconto. Dopo aver premuto il pulsante "Calcola", viene mostrato il prezzo finale, il risparmio ottenuto e la categoria dello sconto.

# File utilizzati

- CSS per sistemare l'aspetto grafico.
- PHP per controllare i dati e svolgere i calcoli.
- CSV per salvare i risultati.

# File del progetto

- index.php: contiene il codice principale del programma.
- stile.css: contiene la parte grafica della pagina.
- log.csv: serve per salvare i calcoli effettuati.
- README.md: contiene una breve descrizione del progetto.

# Controlli dei dati

Il programma controlla che:

- Il nome del prodotto non sia vuoto e non superi 30 caratteri.
- Il prezzo sia un numero maggiore di zero.
- Lo sconto sia un numero intero compreso tra 1 e 90.

Se vengono inseriti dei valori sbagliati, vengono mostrati dei messaggi di errore sotto i rispettivi campi.

# Calcolo dello sconto

Il programma calcola prima il risparmio e successivamente sottrae questo valore dal prezzo iniziale, ottenendo il prezzo finale.

In base alla percentuale di sconto vengono assegnate tre categorie:

- PICCOLO: sconto inferiore al 20%.
- BUONO: sconto dal 20% al 49%.
- SUPER: sconto dal 50% in poi.

# Salvataggio dei dati

Ogni volta che viene effettuato un calcolo, i dati vengono salvati nel file log.csv. In questo modo è possibile conservare le informazioni relative ai calcoli effettuati.
