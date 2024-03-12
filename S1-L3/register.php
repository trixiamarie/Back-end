<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Register</title>
</head>

<body>

<?php
 session_start();
 
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light p-3">
  <a class="navbar-brand" href="#">Hello</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
    </ul>
  </div>
</nav>
<form method="POST" class="container mt-3" style="width: 25rem;" action="gestione.php" enctype="multipart/form-data">
<h3 class="text-center mt-3">Register</h3>
        <!-- Name input -->
            <div class="form-outline mb-4">
            <input type="text" id="name" class="form-control" name="nome"/>
            <label class="form-label" for="name">Name</label>
        </div>

         <!-- Surname input -->
         <div class="form-outline mb-4">
            <input type="text" id="surname" class="form-control" name="cognome"/>
            <label class="form-label" for="surname">Surname</label>
        </div>

        <!-- Email input -->
        <div class="form-outline mb-4">
            <input type="email" id="email" class="form-control" name="email"/>
            <label class="form-label" for="email">Email address</label>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <input type="password" id="password" class="form-control" name="password"/>
            <label class="form-label" for="password">Password</label>
        </div>

        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">
            <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                    <label class="form-check-label" for="form2Example31"> Accept terms and conditions</label>
                </div>
            </div>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block mb-4">Register</button>

    </form>

   
</body>

</html>