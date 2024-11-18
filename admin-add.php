<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secureAdmin();

if(isset($_POST['addAdmin'])){
    // form name attribute
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
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
    $query = "INSERT INTO user (`name`, `email`, `password`, `role`,`prof_pic`) VALUES (
        '" . mysqli_real_escape_string($connect, $name) . "',
        '" . mysqli_real_escape_string($connect, $email) . "',
        '" . mysqli_real_escape_string($connect, $password) . "',
        '" . mysqli_real_escape_string($connect, $role) . "',
        '" . $prof_pic . "'
    )";

    mysqli_query($connect, $query);

    header('location: admin-list.php');
    exit();
}

?>

<div class="container">
    <h3 class="text-center text-secondary">Add an Administrator</h3>
</div>

<div class="row justify-content-center mb-3">
    <div class="col-md-4 card bg-dark-subtle text-dark p-4 shadow">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-1">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">   
            </div>
            <div class="mb-1">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-1">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select id="role" name="role" class="form-control">
                <option value="user" selected>User</option>
                <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Upload Profile Picture -->
            <div class="mb-3">
                <label for="prof_pic" class="form-label">Upload Profile Picture</label>
                <input type="file" class="form-control" id="prof_pic" name="prof_pic" accept="image/*">
            </div>

            <div class="row justify-content-center">
                <button type="submit" class="btn btn-dark col-md-5 me-3" name="addAdmin">Submit</button>
                <a class="btn btn-dark col-md-5" href="admin-list.php">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php
include('includes/footer.php');
?>
