<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();

?>

<h2 class="text-center mt-5 mb-3">Feedback Table by Facility ID</h2>

<?php
$queryFb='SELECT *
FROM comment';

 $resultFb = mysqli_query($connect,$queryFb);

 ?>
<div class="m-auto d-flex flex-row justify-content-between mb-3" style="width:60%;">
<a href="message.php" class="btn btn-dark" style="width:10rem;">Go Back</a>
<a href="allFacility.php" class="btn btn-dark" style="width:10rem;">Review Published List</a>
</div>
<div class="row m-auto" style="width:65%;">
    <?php while ($recordFb = mysqli_fetch_assoc($resultFb)): ?>
        <form action="facility-admin.php" method="GET" class="col-md-12 mb-3 border border-4 border-warning shadow myComment">
            <input type="hidden" name="commentID" value="<?php echo $recordFb['commentID']; ?>">
            <input type="hidden" name="review_id" value="<?php echo $recordFb['facilityID']; ?>">
            <button type="submit" style="background: none; border: none; padding: 0; width: 100%;">
                <div class="d-flex flex-row align-items-center p-2">
                    <div class="fs-3 bg-warning p-1 text-dark text-center"><?php echo $recordFb['facilityID']; ?></div>
                    <div class="flex-grow-1 fs-5 text-dark ms-3"><?php echo $recordFb['comment']; ?></div>
                    <div class="ms-3 fs-5">
                        <a href="feedbackStatus.php?id=<?php echo $recordFb['commentID']; ?>" class="btn btn-outline-dark text-capitalize" onclick="event.stopPropagation();"><?php echo $recordFb['status']; ?></a>
                    </div>
                </div>
            </button>
        </form>
    <?php endwhile; ?>
</div>

<?php
include('includes/footer.php');
?>