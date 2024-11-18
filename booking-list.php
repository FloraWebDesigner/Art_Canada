<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secureAdmin();

if(isset($_POST['change-status'])){

    $id = $_POST['id'];
    $currStatus = $_POST['status'];
    if($currStatus==="open")
    {$updatedStatus="close";}
    else{
        $updatedStatus="open";
    }
 
    $id = mysqli_real_escape_string($connect, $id);
    $updatedStatus = mysqli_real_escape_string($connect, $updatedStatus);

    $queryUpdate = "UPDATE `art_cultural_data` 
                    SET `Status` = '$updatedStatus' 
                    WHERE `Index` = '$id'"; 

    if (mysqli_query($connect, $queryUpdate)) {

        header('Location: booking-list.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}

?>


<?php

$query = "SELECT b.*, a.`Facility_Name`, a.`Status` , a.`Index`
FROM booking b
LEFT JOIN `art_cultural_data` a ON a.`Index` = b.`facilityID`";

 $result = mysqli_query($connect,$query);
 $record = mysqli_fetch_assoc($result);

?>

<h2 class="text-center">Control the Visitors</h2>
<div class="container d-flex flex-row justify-content-center align-items-center mt-3">
    <a href="admin-home.php" class="btn btn-primary me-5">Back</a>
    <a href="all-facilities.php" class="btn btn-primary ms-5">Check All Facilities</a>
</div>
<table class="table mt-3">
    <tr class="table-primary fs-5 myTable fw-semibold">
        <th class="col-md-2">Facility Name</th>
        <th class="col-md-1">Reservation Date</th>
        <th class="col-md-1">Num_of_People</th>
        <th class="col-md-1">Name</th>
        <th class="col-md-1">Email</th>
        <th class="col-md-1">Status</th>
        <th class="col-md-2">Operation</th>
    </tr>
    <tbody>
    <?php while ($record = mysqli_fetch_assoc($result)): ?>
        <tr class="fw-lighter fs-5 text-capitalize">
        <td><?php echo $record['Facility_Name']; ?></td>
            <td><?php echo $record['reservation_date']; ?></td>
            <td><?php echo $record['group_members']; ?></td>
            <td><?php echo $record['name']; ?></td>
            <td><?php echo $record['email']; ?></td>
            <td><?php echo $record['Status']; ?></td>
            <td>
                <form method="post" action="booking-list.php">
                    <input type="hidden" name="status" value="<?php echo $record['Status']; ?>">
                    <input type="hidden" name="id" value="<?php echo $record['Index']; ?>">
                    <button type="submit" name="change-status" class="btn btn-warning fs-6 w-100 mb-2">Change the status of Reservation</button>
            </form>
            </div>

        </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php
include('includes/footer.php');
?>

