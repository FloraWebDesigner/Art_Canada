<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');

if(isset($_POST['email']))
// submit the POST form
{
    $query = 'SELECT *
    FROM user
    WHERE email = "'.$_POST['email'].'"
    AND password = "'.md5($_POST['password']).'"
    LIMIT 1';

    $result=mysqli_query($connect,$query);

    if(mysqli_num_rows($result)){

        $record=mysqli_fetch_assoc($result);

        $_SESSION['id']=$record['id'];
        $_SESSION['email']=$_POST['email'];

        header('Location: message.php');

        die();
    }

}

include('includes/header.php');

?>
    <div class="row mt-3">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-center fw-bolder">
                <span class="text-primary me-2">Admin</span> 
                Login</h2>
            <form method="post">
            <div>
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" class="form-control">
            </div>
            <div>
                <label for="password"class="form-label">Password</label>
                <input type="text" name="password" class="form-control">
            </div>
            <div class="row justify-content-center mt-3">
            <input type="submit" class="btn btn-dark col-md-5 me-3" name="login">
            <a class="btn btn-dark col-md-5" href="index.php">Stay Logged Out</a>
            </div>

            </form>
        </div>

<?php
include('includes/footer.php');
?>