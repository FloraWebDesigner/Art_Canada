<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();


?>

<div class="container d-flex flex-row justify-content-center mt-3">
<h2 class="me-1">Welcome back,</h2>

<?php
$queryAdmin='SELECT *
FROM user';

 $resultAdmin = mysqli_query($connect,$queryAdmin);
 $recordAdmin = mysqli_fetch_assoc($resultAdmin);

$queryFeedback='SELECT *
FROM comment';
 $resultFeedback = mysqli_query($connect,$queryFeedback);
 $recordFeedback = mysqli_fetch_assoc($resultFeedback);

 $queryFacility='SELECT *
FROM art_cultural_data';
 $resultFacility = mysqli_query($connect,$queryFacility);
 $recordFacility = mysqli_fetch_assoc($resultFacility);

 ?>

<h2 class="text-primary"><?php echo $recordAdmin['name'];?></h2>
</div>
<div class="row mt-5">
    <div class="col-md-6 offset-md-3 text-center row">
        <div class="col-md-4 p-3 adminCard">
            <a href="adminTable.php" class="text-dark">
                <i class="fa-solid fa-user fs-1 mt-3 position-relative"></i>
                <div class="d-flex flex-row align-items-center justify-content-center">
                    <div class="card-title me-1">Manage User System</div>
                    <span class="badge text-bg-primary"><?php echo mysqli_num_rows($resultAdmin); ?></span>
                </div>
            </a>
        </div>
        <div class="col-md-4 p-3 adminCard">
            <a href="feedbackTable.php" class="text-dark">
                <i class="fa-solid fa-envelope fs-1 mt-3"></i>
                <div class="d-flex flex-row align-items-center justify-content-center">
                    <div class="card-title me-1">Manage Feedback</div>
                    <span class="badge text-bg-danger"><?php echo mysqli_num_rows($resultFeedback); ?></span>
                </div>
            </a>
        </div>
        <div class="col-md-4 p-3 adminCard">
            <a href="allFacility.php" class="text-dark">
                <i class="fa-solid fa-database fs-1 mt-3"></i>
                <div class="d-flex flex-row align-items-center justify-content-center">
                    <div class="card-title me-1">Manage Facilities</div>
                    <span class="badge text-bg-primary"><?php echo mysqli_num_rows($resultFacility); ?></span>
                </div>
            </a>
        </div>
</div>




</div>
<?php 
        include('includes/footer.php');
    ?>