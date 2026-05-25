# Elys Book Archive

Mini progetto backend sviluppato in PHP e MySQL per gestire un archivio personale di libri e note di lettura.

## 🚀 Features

- **Visualizzazione:** Mostra la lista dei libri salvati nell'archivio.
- **Inserimento rapido:** Form dedicato per aggiungere nuovi titoli e note.
- **Architettura:** Struttura CRUD di base operante su database relazionale.
- **Ambiente locale:** Configurato e testato per girare su stack MAMP.

## 🛠️ Tecnologie Utilizzate

- **Backend:** PHP 8.x
- **Database:** MySQL
- **Frontend:** HTML5, CSS3
- **Ambiente di sviluppo:** MAMP, Git & GitHub

## 🎯 Obiettivo del Progetto

Questo progetto nasce come semplice esercizio pratico backend per comprendere meglio:
- La connessione nativa tra PHP e database relazionali (tramite l'estensione `mysqli`).
- La gestione e la sanificazione dei dati inviati tramite form (richieste `POST`).
- La scrittura di query SQL fondamentali (SELECT, INSERT, DELETE).
- Il flusso logico di un'applicazione CRUD (Create, Read, Update, Delete).

## 📦 Struttura del Progetto

```txt
elys-book-archive/
├── database/
│   └── schema.sql        # Dump del database per la creazione delle tabelle
├── connection.php        # Configurazione e connessione a MySQL
├── index.php             # Homepage con la lista dei libri (Read)
├── create.php            # Form di inserimento (Create)
├── store.php             # Script PHP di elaborazione dati e salvataggio
└── README.md