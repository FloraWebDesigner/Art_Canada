<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/header.php');

if(isset($_POST['addComment'])){
    $facilityID=$_POST['id'];
    $correctInfo=$_POST['correctInfo'];
    $Name=$_POST['Name'];
    $Email=$_POST['Email'];

    $queryComment = "INSERT INTO comment (`name`, `email`,`facilityID`,`comment`,`status`) VALUES (
        '" . mysqli_real_escape_string($connect, $Name) . "',
        '" . mysqli_real_escape_string($connect, $Email) . "',
        '" . mysqli_real_escape_string($connect, $facilityID) . "',
        '" . mysqli_real_escape_string($connect, $correctInfo) . "',
        'pending'
        )";
        
        mysqli_query($connect,$queryComment);

        echo "<script>alert('Your comment has been submitted successfully, thanks for your attention. You will be redirected back to the home page'); window.location.href='index.php';</script>";

        exit();
        
    }




?>

<div class="container">
    <h2 class="text-center mt-3">Report a Mistake<i class="fa-regular fa-hand-point-down ms-2"></i></h2>
    <div class="row mt-4">
<?php

if(isset($_GET['reportId'])){
$query='SELECT a.*,t.`ODCAF_Facility_Type`,p.Short_Prov,p.colorCode, s.`Data Provider`, s.`Link to Dataset`,s.`Last Updated`
FROM`art_cultural_data` a
LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID
LEFT JOIN province p ON p.prov_id = a.Prov_ID
LEFT JOIN source s ON s.`ProviderID`=a.Provider
WHERE a.Index="' . $_GET['reportId'] . '";';
$result = mysqli_query($connect, $query);
$record = mysqli_fetch_assoc($result);
}
?>
<div class="col-md-6">
    <div class="text-center fs-2 fw-bold text-danger mb-3"><?php echo $record['Facility_Name']; ?></div>
        <div class="row fs-5">
            <div class="col-md-3 text-end">City</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['City']; ?></div>
            <div class="col-md-3 text-end">Address</div>
            <div class="col-md-9 text-center border-bottom border-dark-subtle text-capitalize"><?php echo $record['Source_Format_Address']; ?></div>
            <div class="col-md-3 text-end">Facility Type</div>
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
<div class="col-md-6">

<div class="container mt-3 mx-5">
<form method="post" class="rounded-3 border border-secondary bg-light p-3" style="width:80%;">
        <div class="mb-1">
            <label for="Name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="Name" name="Name" required>
        </div>
        <div class="mb-1">
            <label for="Email" class="form-label">Your Email</label>
            <input type="text" class="form-control" id="Email" name="Email" required>
        </div>
        <div class="mb-1">
            <label for="correctInfo" class="form-label">Please indicate which part of the information is incorrect and correct it</label>
            <textarea class="form-control" id="correctInfo" name="correctInfo" required></textarea>
        </div>
        <div class="row justify-content-center">
        <input type="hidden" name="id" value="<?php echo $record['Index']; ?>">
        <button type="submit" class="btn btn-dark col-md-5 me-3" name="addComment">Submit<i class="fa-regular fa-paper-plane ms-3"></i></button>
        <a class="btn btn-dark col-md-5" href="facility.php?id=<?php echo $record['Facility_TypeID']; ?>" class="btn btn-outline-primary">Cancel</a>
        </div>
</form>
</div>
</div>
<p class="border border-dark bg-info-subtle p-2 my-4 me-5">The above information is for <span class="text-center px-2 text-dark bg-warning"><?php echo $record['Facility_Name']; ?></span>, and since this data was last updated on <span class="text-center px-2 text-dark bg-warning"><?php echo $record['Last Updated']; ?></span>, it is possible that there is an error. You are welcome to correct it at any time, please fill in the relevant information, we will verify it when we receive it and update it if the information is true, thank you for your attention.</p> 
</div>

<?php 
        include('includes/footer.php');
    ?>