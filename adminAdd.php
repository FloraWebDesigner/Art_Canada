<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();

if(isset($_POST['addAdmin'])){
    // form name attribute
    $name=$_POST['name'];
    //echo $schoolName;
    $email=$_POST['email'];
    $password = md5($_POST['password']);


    $query = "INSERT INTO user (`name`, `email`,`password`) VALUES (
        '" . mysqli_real_escape_string($connect, $name) . "',
        '" . mysqli_real_escape_string($connect, $email) . "',
        '" . mysqli_real_escape_string($connect, $password) . "'
        )";
        
        mysqli_query($connect,$query);
    
        header('location:adminTable.php');
        exit();
        
    }
    ?>

    <div class="container">
      <h3 class="text-center text-secondary">Add an Administrator</h1>
</div>
<div class="row justify-content-center mb-3">
    <div class="col-md-4 card bg-dark-subtle text-dark p-4 shadow">
    <form method="post">
        <div class="mb-1">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">   
        </div>
        <div class="mb-1">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control">
    </div>
        <div class="row justify-content-center">
        <button type="submit" class="btn btn-dark col-md-5 me-3" name="addAdmin">Submit</button>
        <a class="btn btn-dark col-md-5" href="adminTable.php">Cancel</a>
        </div>
</div>
</div>

<?php
include('includes/footer.php');
?>



