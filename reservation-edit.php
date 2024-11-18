<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();

if(isset($_POST['edit_id'])){

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $id = $_POST['edit_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $group_members = $_POST['groupSize'];
    $reservation_date = $_POST['reservationDate'];
 
    // Start the update query
    $query = "UPDATE `booking` SET 
    `group_members`='" . mysqli_real_escape_string($connect, $group_members) . "',
    `email` ='" . mysqli_real_escape_string($connect, $email) . "',
    `name` ='" . mysqli_real_escape_string($connect, $name) . "',
    `reservation_date` ='" . mysqli_real_escape_string($connect, $reservation_date) ."'WHERE `id` = '" . mysqli_real_escape_string($connect, $id) . "'";

   // Execute the query
   mysqli_query($connect, $query);

   // Redirect after successful edit
   header('location: user-home.php');
   exit();    
}



?>

<?php


// Fetch the existing record from the database
$query = "SELECT b.*,a.Facility_Name FROM booking b
LEFT JOIN `art_cultural_data` a ON a.`Facility_TypeID` = b.`facilityID`
WHERE id='" . mysqli_real_escape_string($connect, $_GET['bookId']) . "' LIMIT 1";
$result = mysqli_query($connect, $query);
$submittedData = mysqli_fetch_assoc($result);
?>

    <h2 class="text-center mt-3">Reservation details for  <?php echo isset($submittedData['Facility_Name']) ? htmlspecialchars($submittedData['Facility_Name']) : 'No facility provided'; ?></h2>

    <form method="post" class="rounded-3 border border-secondary bg-light p-3 mx-auto" style="width:70%;">
    <div class="mb-1">
        <label for="Name" class="form-label text-start fs-5">Name</label>
        <input type="text" class="form-control" id="Name" name="name" value="<?php echo isset($submittedData['name']) ? htmlspecialchars($submittedData['name']) : ''; ?>" required>
    </div>
    <div class="mb-1">
        <label for="Email" class="form-label text-start fs-5">Email</label>
        <input type="text" class="form-control" id="Email" name="email" value="<?php echo isset($submittedData['email']) ? htmlspecialchars($submittedData['email']) : ''; ?>" required>
    </div>
    <div class="mb-1">
        <label for="groupSize" class="form-label text-start fs-5">Number of people in your group</label>
        <input type="number" class="form-control" id="groupSize" name="groupSize" value="<?php echo isset($submittedData['group_members']) ? htmlspecialchars($submittedData['group_members']) : ''; ?>" min="1" max="100" required>
    </div>
    <div class="mb-3">
        <label for="reservationDate" class="form-label text-start fs-5">Reserved Date</label>
        <input type="date" class="form-control" id="reservationDate" name="reservationDate" value="<?php echo isset($submittedData['reservation_date']) ? htmlspecialchars($submittedData['reservation_date']) : ''; ?>" required>
    </div>
    <div class="row justify-content-center">
                <input type="hidden" name="edit_id" value="<?php echo $submittedData['id']; ?>">
                <button type="submit" class="btn btn-dark col-md-5 me-3" name="edit-booking">Submit</button>
                <a class="btn btn-dark col-md-5" href="user-home.php">Cancel</a>
            </div>
</form>

