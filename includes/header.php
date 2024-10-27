<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cultural and Art Facilities in Canada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="public/style.css" rel="stylesheet">
    <script src="public/script.js"></script>
</head>
<body><!--Nav Bar--> 
<div class="container-fluid d-flex flex-column justify-content-between" style="min-height: 100vh;">   
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Cultural and Art Facilities in Canada</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="allFacility.php">Facility</a>
        </li>
        <?php 
        if(isset($_SESSION['id'])){
          echo '<li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="message.php">Message</a>
        </li>';
        }
        else{
          echo '<li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>';
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
<div class="row flex-grow-1">
<div class="col">