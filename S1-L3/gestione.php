<?php
session_start();


    $utenti = isset($_SESSION['utenti']) ? $_SESSION['utenti'] : array();

    if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['password'])) {
        $nuovoUtente = array(
            'nome' => $_POST['nome'],
            'cognome' => $_POST['cognome'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        );

        $utenti[] = $nuovoUtente;

        $_SESSION['utenti'] = $utenti;

        print_r($nuovoUtente);

    } else {
        $errormessage = '<h1>Errore: I campi richiesti non sono stati forniti correttamente.</h1>';
        echo $errormessage;
    }


// Debug: Visualizza l'array utenti
var_dump($_SESSION['utenti']);
?>