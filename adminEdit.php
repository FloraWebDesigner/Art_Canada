<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();

if(isset($_POST['editAdmin'])){

   $id= $_POST['id'];
   $name=$_POST['name'];
   $email=$_POST['email'];

   $query = "UPDATE `user` SET 
   `name`='" . mysqli_real_escape_string($connect, $name) . "',
   `email` ='" . mysqli_real_escape_string($connect, $email) . "'";

   // only the user changes the password, run the below
   if(!empty($_POST['password']))
   { 
       $password = md5($_POST['password']);
       $query .= ", `password` = '" . mysqli_real_escape_string($connect, $password) . "'";
   }

   $query .= " WHERE `id` = '" . mysqli_real_escape_string($connect, $id) . "';";

   mysqli_query($connect,$query);

   echo $query;
   echo mysqli_error($connect);

   //set_message('A new user has been added');
   header('location:adminTable.php');
   exit();    
}




?>

<div class="container">
      <h3 class="text-center text-Primary">Edit an Administrator</h1>
</div>

<?php
$query = "SELECT * FROM user WHERE id='" . mysqli_real_escape_string($connect, $_GET['edit_id']) . "' LIMIT 1";

 $result = mysqli_query($connect,$query);
 $record = mysqli_fetch_assoc($result);
 ?>

<div class="row justify-content-center mb-3">
    <div class="col-md-4 card bg-light text-dark p-4 shadow">
    <form method="post" action="adminEdit.php">
        <div class="mb-1">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $record['name'];?>">   
        </div>
        <div class="mb-1">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $record['email'];?>">
        </div>
        <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control">
    </div>
        <div class="row justify-content-center">
        <input type="hidden" name="id" value="<?php echo $record['id'] ?>">
        <button type="submit" class="btn btn-dark col-md-5 me-3" name="editAdmin">Submit</button>
        <a class="btn btn-dark col-md-5" href="adminTable.php">Cancel</a>
        </div>

</div>
</div>

<?php
include('includes/footer.php');
?>

