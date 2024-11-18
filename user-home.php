<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $id = mysqli_real_escape_string($connect, $id);

    $query = "DELETE FROM `booking` WHERE `id` = $id";
    echo $query;
    mysqli_query($connect, $query);

    //sent_message('User has been deleted');
    header('user-home.php');
}


?>

<div class="container d-flex flex-row justify-content-center mt-3">
<h2 class="me-1">Welcome back,</h2>

<?php

$queryUser='SELECT *
FROM user';

 $resultUser = mysqli_query($connect,$queryUser);
 $recordUser = mysqli_fetch_assoc($resultUser);

 $id = $_SESSION['id'];
 $queryUser .= " WHERE `id` = '$id'";
 $resultCurrUser = mysqli_query($connect,$queryUser);
 $recordCurrUser = mysqli_fetch_assoc($resultCurrUser);

 $queryBooking = "SELECT b.*, a.`Facility_Name`, a.`Source_Format_Address` 
                 FROM booking b
                 LEFT JOIN `art_cultural_data` a ON a.`Index` = b.`facilityID`
                 WHERE b.`userId` = '" . $_SESSION['id'] . "'";
 $result = mysqli_query($connect,$queryBooking);
//  $record = mysqli_fetch_assoc($result);

 ?>

 <h2 class="text-primary"><?php echo  $recordCurrUser['name'];?></h2>
</div>
 <div class="border border-warning text-dark m-3 d-flex flex-row justify-content-center align-items-center mx-auto" style="width:20rem;">            
            <div class="text-center mt-2">
                <?php
                    if (!empty($recordCurrUser['prof_pic'])) {
                        //outputing the image from database
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($recordCurrUser['prof_pic']) . '" alt="Profile Picture" style="width: 10rem; height: 10rem; object-fit: cover;border-radius: 5%;">';
                    } else {                        
                        //if there is no profile pic, the default picture is shown
                        echo '<img src="public/img/default-pic.jpg" alt="Default Profile Picture" style="width: 10rem; height: 10rem; object-fit: cover; border-radius: 5%;">';
                    }
                ?>
            </div>
            <div class="d-flex flex-column">
            <div class="fs-3 mb-2 text-center bg-warning"><?php echo $recordCurrUser['name']; ?></div>
            <div class="fs-5 text-center"><?php echo $recordCurrUser['email']; ?></div>
            <div class="d-flex flex-row justify-content-evenly p-3">
                <a href="user-edit.php?edit_id=<?php echo $recordCurrUser['id']; ?>" class="btn btn-primary">Edit</a>
            </div>
        </div>
                </div>
<div class="row mt-5">
    <div class="col-md-10 offset-md-1 text-center row">
        <div class="d-flex flex-row justify-content-between align-items-center">
        <div class="row fs-3">Reservation Overview</div>
        <a href="all-facilities.php" class="btn btn-primary">Book a reservation</a> 
</div>
    <table class="table mt-3">
    <tr class="table-primary fs-5 myTable fw-semibold">
        <th class="col-md-2">Facility Name</th>
        <th class="col-md-4">Address</th>
        <th class="col-md-2">Reservation Date</th>
        <th class="col-md-1">Num_of_People</th>
        <th class="col-md-1">Name</th>
        <th class="col-md-1">Email</th>
        <th class="col-md-1">Operation</th>
    </tr>
    <tbody>
    <?php while ($record = mysqli_fetch_assoc($result)): ?>
        <tr class="fw-lighter fs-5 text-capitalize">
        <td><?php echo $record['Facility_Name']; ?></td>
        <td><?php echo $record['Source_Format_Address']; ?></td>
            <td><?php echo $record['reservation_date']; ?></td>
            <td><?php echo $record['group_members']; ?></td>
            <td><?php echo $record['name']; ?></td>
            <td><?php echo $record['email']; ?></td>

            <td>
                <a href="reservation-edit.php?bookId=<?php echo $record['id'] ?>" class="btn btn-warning fs-6 w-100 mb-2">Edit</a>
                <a href="javascript:void(0);" onclick="confirmDeleteBooking(<?php echo $record['id']; ?>, '<?php echo $record['Facility_Name']; ?>','<?php echo $record['reservation_date']; ?>')" class="btn btn-danger w-100">Delete</a>
            </div>

        </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>