<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

if(isset($_POST['addUser'])){
    // form name attribute
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Handle the profile picture upload
    $prof_pic = null; // Default to NULL if no file uploaded

    if (isset($_FILES['prof_pic']) && $_FILES['prof_pic']['error'] == 0) {
        // Image upload logic
        $file_tmp_name = $_FILES['prof_pic']['tmp_name'];
        $file_name = $_FILES['prof_pic']['name'];
        $file_size = $_FILES['prof_pic']['size'];
        $file_type = $_FILES['prof_pic']['type'];

        // Check if the file is an image
        if (in_array($file_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            // Read the file and store it as a BLOB
            $prof_pic = addslashes(file_get_contents($file_tmp_name));
        } else {
            // Handle non-image file types if necessary
            echo "Only image files are allowed.";
        }
    }

    // Insert query including the profile picture
    $query = "INSERT INTO user (`name`, `email`, `password`, `prof_pic`) VALUES (
        '" . mysqli_real_escape_string($connect, $name) . "',
        '" . mysqli_real_escape_string($connect, $email) . "',
        '" . mysqli_real_escape_string($connect, $password) . "',
        '" . $prof_pic . "'
    )";

    mysqli_query($connect, $query);
    echo "<script>alert('Registration was successful, please log in again!');</script>";

    header('Location:login.php');
    die();
}

?>

<div class="row mt-3">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-center fw-bolder">
                <span class="text-primary me-2">Register</span> 
                Form</h2>
            <form method="post" enctype="multipart/form-data">
            <div class="mb-1">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" require>   
            </div>
            <div class="mb-1">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" require>
            </div>
            <div class="mb-1">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" require>
            </div>
            <!-- Upload Profile Picture -->
            <div class="mb-3">
                <label for="prof_pic" class="form-label">Upload Profile Picture</label>
                <input type="file" class="form-control" id="prof_pic" name="prof_pic" accept="image/*">
            </div>
            <div class="text-danger my-2">Already have an account yet? Click 
                <a class="mx-1" href="login.php">here</a>
                    <span>to login</span>
            </div>
            <div class="row justify-content-center mt-3">
                <button type="submit" class="btn btn-dark col-md-5 me-3" name="addUser">Submit</button>
                <a class="btn btn-dark col-md-5" href="index.php">Stay Logged Out</a>
            </div>
        </form>
            </div>