<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Firma la petizione!</title>
</head>
<body style="background-color:#E9AF79">


<?php
 session_start();

 if (isset($_SESSION['firmatari']) && is_array($_SESSION['firmatari']) && !empty($_SESSION['firmatari'])) {
    
    $firmatari = $_SESSION['firmatari'];
 };
 
?>
<div class="container">
<h1 class="text-center m-0">ABBIAMO BISOGNO ANCHE DEL TUO AIUTO, PRIMA CHE SIA TROPPO TARDI!</h1>
</div>

<div class="container">
<form method="POST" action="gestione.php" enctype="multipart/form-data">
    <input type="hidden" name="source" value="index">
<div class="form-group">
    <label for="InputName">Nome</label>
    <input type="text" class="form-control" id="InputName" placeholder="Nome" name="nome">
  </div>
  <div class="form-group">
    <label for="InputSurName">Cognome</label>
    <input type="text" class="form-control" id="InputSurName" placeholder="Cognome" name="cognome">
  </div>
  <div class="form-group">
    <label for="InputEmail">Email</label>
    <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Email" name="email">
    <small id="emailHelp" class="form-text text-muted">Non condivideremo la tua email con nessuno!</small>
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Accetti di firmare la petizione?</label>
  </div>
  <button type="submit" class="btn btn-success">Invia</button>
  
</form>
</div>

<div class="container mt-3">
    <h3>I nostri firmatari</h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Cognome</th>
    </tr>
  </thead>
  <tbody>
  <?php
    if ($firmatari) {
        foreach($firmatari as $indice => $persona) {
            echo "<tr><th scope='row'>". ($indice + 1) ."</th><td>". $persona['nome'] . "</td><td>" . $persona['cognome'] . "</td></tr>";
        }
    } else {
        echo "Nessun firmatario disponibile.";
    }
?>

  </tbody>
</table>
</div>

</body>
</html>