<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['source']) && $_POST['source'] === 'index') {
    // $firmatari = isset($_SESSION['firmatari']) ? $_SESSION['firmatari'] : array();
    if (isset($_POST['nome']) && isset($_POST['cognome'])) {
        $nuovoFirmatario = array(
            'nome' => $_POST['nome'],
            'cognome' => $_POST['cognome']

        );
        $firmatari[] = $nuovoFirmatario;
        $_SESSION['firmatari'] = $firmatari;
        echo '<h1>Dati salvati nell\'array:</h1>';
        print_r($nuovoFirmatario);
        header("Location: index.php");
        exit();
    } else {
        echo '<h1>Errore: I campi richiesti non sono stati forniti correttamente.</h1>';
    }
} else {
    echo '<h1>Errore: Accesso non consentito.</h1>';
}

echo '<h1>Contenuto della Sessione:</h1>';
print_r($_SESSION['firmatari']);
?>
