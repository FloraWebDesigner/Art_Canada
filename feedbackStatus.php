<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();

if(isset($_POST['Update_id'])){

$commentID = mysqli_real_escape_string($connect, $_POST['Update_id']);
$status = mysqli_real_escape_string($connect, $_POST['status']);

$query = "UPDATE comment SET `status` = '$status' WHERE `commentID` = '$commentID'";

mysqli_query($connect,$query);

   echo $query;

   header('location:feedbackTable.php');
   exit();    
}

?>

<h2 class="text-center mt-5 mb-3">Feedback Table Update</h2>

<?php
if(isset($_GET['id'])){

    $commentID = mysqli_real_escape_string($connect, $_GET['id']);
    $queryFb='SELECT *FROM comment WHERE commentID = "' . $commentID . '";';

    echo $commentID;
 $resultFb = mysqli_query($connect,$queryFb);
 $recordFb = mysqli_fetch_assoc($resultFb);

}
 ?>
<div class="row m-auto d-flex flex-row justify-content-between" style="width:65%;">
                <div class="border border-4 border-warning text-dark p-3 shadow">
                    <div class="row">
                        <div class="col-md-1 fs-3 text-center bg-warning"><?php echo $recordFb['facilityID']; ?></div>
                        <div class="col-md-7 fs-5 text-start d-flex align-items-center"><?php echo $recordFb['comment']; ?></div>
                        <form class="col-md-4 fs-5 text-center d-flex flex-row align-items-center justify-content-between text-capitalize" method="POST" action="feedbackStatus.php">
                        <input type="hidden" name="Update_id" value="<?php echo $recordFb['commentID']; ?>">
                        <div>
                        <label for="status"></label>
                            <select name="status">
                            <?php
                            $values = array('pending','in process','completed');
                            foreach ($values as $value) {
                                echo '<option value="' . $value . '"';
                                if (($recordFb['status']) === $value) {
                                    echo ' selected'; 
                                }
                                echo '>' . $value . '</option>';
                            }
                            ?>
                            </select>
                            </div>
                        <!--when I wrote
                        button type="submit" href="feedbaskStatus.php?Updated_id=<php echo $recordFb['commentID']; ?>" it does not work.
                        -->
                        <div class="fs-5 text-center d-flex align-items-center justify-content-center">
                            <button type="submit" class="btn btn-success text-capitalize me-2">Update</button>
                            <a type="button" class="btn btn-secondary text-capitalize" href="feedbackTable.php">Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>


            <?php
include('includes/footer.php');
?>