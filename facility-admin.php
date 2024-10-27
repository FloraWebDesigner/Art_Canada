<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $id = mysqli_real_escape_string($connect, $id);
    $query = "DELETE FROM `art_cultural_data` WHERE `Index` = $id";
    mysqli_query($connect, $query);

if (isset($_GET['commentID'])){
    echo "<script>
    if (confirm('The item has been removed successfully. Do you want to update the status of #" . $id . " Facility for the user request?')) {
        window.location.href='feedbackStatus.php?id=" . $id . "';
    }
        else{
        window.location.href='allFacility.php';
}
</script>";
}

header('Location: allFacility.php');
exit();
}


?>

<h2 class="text-center">Facility Profile

<?php 
if(isset($_GET['review_id'])){
    // echo $_GET['review_id'];
    $facilityID=mysqli_real_escape_string($connect, $_GET['review_id']);
// echo $facilityID;
if (isset($_GET['commentID']) && $_GET['commentID'] !== "undefined") {
    $commentID = mysqli_real_escape_string($connect, $_GET['commentID']);
} else {
    $commentID = 0;
}

    $queryCurr='SELECT a.*,t.`ODCAF_Facility_Type`,p.Short_Prov,p.colorCode, s.`Data Provider`, s.`Link to Dataset`,s.`Last Updated`
    FROM`art_cultural_data` a
    LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID
    LEFT JOIN province p ON p.prov_id = a.Prov_ID
    LEFT JOIN source s ON s.`ProviderID`=a.Provider
    WHERE a.Index="' . $facilityID . '";';

$resultCurr = mysqli_query($connect,$queryCurr);

if ($resultCurr && mysqli_num_rows($resultCurr) > 0) {
    $record = mysqli_fetch_assoc($resultCurr);
} else {
    echo '<div class="text-center my-3">The Facility of No.' . $_GET['review_id'] . ' has been removed from the system.</div>
    <div class="m-auto d-flex flex-row justify-content-between mb-3" style="width:60%;">
        <a href="feedbackTable.php" class="btn btn-dark" style="width:10rem;">Go Back</a>
        <a href="allFacility.php" class="btn btn-dark" style="width:10rem;">Review Published List</a>
    </div>';
    exit; 
}
}

?>
<?php
if ($commentID) {
    echo '<span class="mx-1" style="color:' . $record['colorCode'] . '">Review</span> by Feedback# "' . $commentID . '"</h2>';
} else {
    echo '<span class="ms-1" style="color:' . $record['colorCode'] . '">Review</span></h2>';
}
?>
<div class="col-md-6 m-auto d-flex flex-row justify-content-between align-items-center">
    <div class="text-start">
        <div class="fs-5">Data Provider:
            <span class="ms-2"><?php echo $record['Data Provider']; ?></div>
        <div class="fs-5 mb-3">Last Updated:
            <span class="ms-2"><?php echo $record['Last Updated']; ?></div>
    </div>
    <div class="text-end">
        <a href="feedbackTable.php" class="btn btn-warning">Feedback<i class="fa-regular fa-comment-dots ms-2"></i></a>
        <a href="allFacility.php" class="btn btn-primary">Facility<i class="fa-solid fa-list ms-2"></i></a>
        <a href="facility-adminEdit.php?edit_id=<?php echo $record['Index']; 
        if (isset($commentID)) {
            echo '&commentID=' . $commentID;
        }
        ?>" class="btn btn-success">Edit</a>
        <button type="button" onclick="confirmDeleteFacilityCard(<?php echo $record['Index']; ?>,'<?php echo $record['Facility_Name']; ?>')" class="btn btn-danger">Delete</a>
</div>
</div>

<div class="col-md-6 rounded-3 border border-secondary border-4 bg-primary-subtle pe-5 pb-5 pt-3 m-auto shadow">
    <div class="text-center fs-2 fw-bold text-danger mb-3"><?php echo $record['Facility_Name']; ?></div>
        <div class="row fs-5">
            <div class="col-md-3 text-end">City</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['City']; ?></div>
            <div class="col-md-3 text-end">Address</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Source_Format_Address']; ?></div>          
            <div class="col-md-3 text-end">Facility Type</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['ODCAF_Facility_Type']; ?></div>
            <div class="col-md-3 text-end">Source Type</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Source_Facility_Type']; ?></div>
            <div class="col-md-3 text-end">Post Code</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Postal_Code']; ?></div>
            <div class="col-md-3 text-end">Map - Latitude</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Latitude']; ?></div>
            <div class="col-md-3 text-end">Map - Longitude</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Longitude']; ?></div>
            <div class="d-flex align-items-center">
            <div class="col-md-3 text-end pe-4">Link to Dataset</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize fs-6"><?php echo $record['Link to Dataset']; ?></div>
        </div>         
    </div>
</div>

<?php
include('includes/footer.php');
?>