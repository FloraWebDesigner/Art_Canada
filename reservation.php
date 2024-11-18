<?php
include('includes/config.php');
include('includes/connect.php');
include('includes/header.php');

// Initialize variables for submitted data
$submittedData = null;

// Check if the form is submitted
if (isset($_POST['add-reservation'])) {

    if(!isset($_SESSION['id'])){
        header('location: login.php');
        exit();  
    }

    $facilityID = $_POST['id'];
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $reservationDate = $_POST['reservationDate'];
    $groupSize = $_POST['groupSize'];
    $userId=$_SESSION['id'];

    // Construct the SQL query to insert the data
    $bookingQuery = "INSERT INTO booking (`name`, `email`, `facilityID`, `reservation_date`, `group_members`,`userId`) VALUES (
        '" . mysqli_real_escape_string($connect, $Name) . "',
        '" . mysqli_real_escape_string($connect, $Email) . "',
        '" . mysqli_real_escape_string($connect, $facilityID) . "',
        '" . mysqli_real_escape_string($connect, $reservationDate) . "',
        '" . mysqli_real_escape_string($connect, $groupSize) . "',
        '" . mysqli_real_escape_string($connect, $userId) . "'
    )";

    // Execute the query
    if (mysqli_query($connect, $bookingQuery)) {
        // After successfully submitting, store the data for display
        $submittedData = [
            'Name' => $Name,
            'Email' => $Email,
            'Group Size' => $groupSize,
            'Reservation Date' => $reservationDate
        ];
        echo "<script>alert('Your reservation has been successfully submitted. Thank you for choosing our facility.');</script>";

        header('location: user-home.php');
        exit();   
    } else {
        echo "<script>alert('Error: Could not submit your reservation. Please try again later.');</script>";
    }
}

// Check for a delete request via GET parameter
if (isset($_GET['facilityID'])) {
    $facilityID = intval($_GET['facilityID']); // sanitize the ID

    // Delete query to remove the record from the booking table
    $deleteQuery = "DELETE FROM booking WHERE facilityID = '$facilityID'";

    if (mysqli_query($connect, $deleteQuery)) {

        echo "<script>alert('Reservation has been deleted successfully.');</script>";
    } else {
        // If the deletion fails, show an error message
        echo "<script>alert('Error deleting reservation. Please try again.');</script>";
    }
}


// Fetch the facility data based on bookId
if (isset($_GET['bookId'])) {
    $query = 'SELECT a.*, t.`ODCAF_Facility_Type`, p.Short_Prov, p.colorCode, s.`Data Provider`, s.`Link to Dataset`, s.`Last Updated`
              FROM `art_cultural_data` a
              LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID
              LEFT JOIN province p ON p.prov_id = a.Prov_ID
              LEFT JOIN source s ON s.ProviderID = a.Provider
              WHERE a.Index = "' . $_GET['bookId'] . '";';
    $result = mysqli_query($connect, $query);
    $record = mysqli_fetch_assoc($result);
}
?>

<div class="container">
    <h2 class="text-center mt-3">Book a Reservation - <span class="text-danger fw-bolder"><?php echo $record['Facility_Name']; ?></span><i class="fa-regular fa-hand-point-down ms-2"></i>
</h2>
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2 d-flex flex-column align-items-center">
            <div class="facility-info">
                <div class="row fs-5">
                    <!-- Facility Details -->
                    <div class="col-md-3 text-end">City</div>
                    <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['City']; ?></div>
                    <div class="col-md-3 text-end">Address</div>
                    <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Source_Format_Address']; ?></div>
                    <div class="col-md-3 text-end">Facility Type</div>
                    <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Source_Facility_Type']; ?></div>
                    <div class="col-md-3 text-end">Post Code</div>
                    <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Postal_Code']; ?></div>
                </div>
            </div>
            <div class="row mt-4 w-75 ms-4">
            <!-- Form to Book a Reservation -->
                <form method="post" class="rounded-3 border border-secondary bg-light p-3 fs-5">
                   <?php
                    if(!isset($_SESSION['id'])){ ?>
                    <div class="mb-1 text-warning text-center fs-4">You are not logged in, please click
                        <a class="mx-1" href="login.php">here</a>
                        <span>to log in</span>
                    </div>
                    <?php
                    } ?>
                    <div class="mb-1">
                        <label for="Name" class="form-label">Your Name</label>
                        <input type="text" class="form-control fs-5" id="Name" name="Name" required>
                    </div>
                    <div class="mb-1">
                        <label for="Email" class="form-label">Your Email</label>
                        <input type="text" class="form-control fs-5" id="Email" name="Email" required>
                    </div>
                    <div class="mb-1">
                        <label for="groupSize" class="form-label">The number of people in your group</label>
                        <input type="number" class="form-control fs-5" id="groupSize" name="groupSize" min="1" max="100" required>
                    </div>
                    <div class="mb-1">
                        <label for="reservationDate" class="form-label">Please select your reservation date</label>
                        <input type="date" class="form-control fs-5" id="reservationDate" name="reservationDate" required>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <input type="hidden" name="id" value="<?php echo $record['Index']; ?>">
                        <button type="submit" class="btn btn-dark col-md-5 me-3 fs-5" name="add-reservation">Submit<i class="fa-regular fa-paper-plane ms-3"></i></button>
                        <a class="btn btn-dark col-md-5 fs-5" href="facility.php?id=<?php echo $record['Facility_TypeID']; ?>" class="btn btn-outline-primary">Cancel</a>
                    </div>
                </form>
            </div>
</div>

       
    </div>
</div>

</div>

<?php
include('includes/footer.php');
?>
