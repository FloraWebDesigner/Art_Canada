<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secureAdmin();

if(isset($_POST['editAdmin'])){

   $id = $_POST['id'];
   $name = $_POST['name'];
   $email = $_POST['email'];
   $role = $_POST['role'];

   // Start the update query
   $query = "UPDATE `user` SET 
   `name`='" . mysqli_real_escape_string($connect, $name) . "',
   `email` ='" . mysqli_real_escape_string($connect, $email) . "',
   `role` ='" . mysqli_real_escape_string($connect, $role) . "'";

   // Only update password if it's been provided
   if(!empty($_POST['password'])) { 
       $password = md5($_POST['password']);
       $query .= ", `password` = '" . mysqli_real_escape_string($connect, $password) . "'";
   }

   // Handle the profile picture upload
   if (isset($_FILES['prof_pic']) && $_FILES['prof_pic']['error'] == 0) {
        $file_tmp_name = $_FILES['prof_pic']['tmp_name'];
        $file_name = $_FILES['prof_pic']['name'];
        $file_size = $_FILES['prof_pic']['size'];
        $file_type = $_FILES['prof_pic']['type'];

        if (in_array($file_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            
            $prof_pic = addslashes(file_get_contents($file_tmp_name));
            $query .= ", `prof_pic` = '" . $prof_pic . "'";
        } else {
            
            echo "Only image files are allowed.";
        }
   }

   $query .= " WHERE `id` = '" . mysqli_real_escape_string($connect, $id) . "'";

   // Execute the query
   mysqli_query($connect, $query);

   // Redirect after successful edit
   header('location: admin-list.php');
   exit();    
}

?>

<div class="container">
    <h3 class="text-center text-Primary">Edit an Administrator</h3>
</div>

<?php
// Fetch the existing record from the database
$query = "SELECT * FROM user WHERE id='" . mysqli_real_escape_string($connect, $_GET['edit_id']) . "' LIMIT 1";
$result = mysqli_query($connect, $query);
$record = mysqli_fetch_assoc($result);
?>

<div class="row justify-content-center mb-3">
    <div class="col-md-4 card bg-light text-dark p-4 shadow">
        <form method="post" action="admin-edit.php" enctype="multipart/form-data">
            <div class="mb-1">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $record['name']; ?>">   
            </div>
            <div class="mb-1">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $record['email']; ?>">
            </div>
            <div class="mb-1">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="user" <?php if ($record['role'] == 'user') echo 'selected'; ?>>User</option>
                    <option value="admin" <?php if ($record['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="prof_pic" class="form-label">Upload Profile Picture</label>
                <input type="file" class="form-control" id="prof_pic" name="prof_pic" accept="image/*">
            </div>

            <div class="row justify-content-center">
                <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                <button type="submit" class="btn btn-dark col-md-5 me-3" name="editAdmin">Submit</button>
                <a class="btn btn-dark col-md-5" href="admin-list.php">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php
include('includes/footer.php');
?>
