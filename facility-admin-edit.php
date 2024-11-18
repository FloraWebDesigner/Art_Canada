<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secureAdmin();

if(isset($_POST['update_id'])){

    $updateID = mysqli_real_escape_string($connect, $_POST['update_id']);

    $province = mysqli_real_escape_string($connect, $_POST['province']);
    $city = mysqli_real_escape_string($connect, $_POST['city']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $type = mysqli_real_escape_string($connect, $_POST['type']);
    $postalCode = mysqli_real_escape_string($connect, $_POST['postalCode']);
    $Latitude = mysqli_real_escape_string($connect, $_POST['Latitude']);
    $Longitude = mysqli_real_escape_string($connect, $_POST['Longitude']);
    $link = mysqli_real_escape_string($connect, $_POST['link']);


    $queryProv = "SELECT prov_id FROM province WHERE Short_Prov = '$province'";
    $resultProv = mysqli_query($connect, $queryProv);
    if (mysqli_num_rows($resultProv) > 0) 
    {
        $recordProv = mysqli_fetch_assoc($resultProv);
        $Prov_ID = $recordProv['prov_id'];
    }
    else
    {
        // insert a new province item
        $queryAddProv = "INSERT INTO province (Short_Prov) VALUES ('$province')";
        $resultAddProv = mysqli_query($connect, $queryAddProv);
        $Prov_ID = mysqli_insert_id($connect);
    }

    $queryType = "SELECT type_id FROM facilitytype WHERE ODCAF_Facility_Type = '$type'";
    $resultType = mysqli_query($connect, $queryType);
    if (mysqli_num_rows($resultType) > 0) 
    {
        $recordType = mysqli_fetch_assoc($resultType);
        $Facility_TypeID = $recordType['type_id'];
    }
    else
    {
        // insert a new type
        $queryAddType = "INSERT INTO facilitytype (ODCAF_Facility_Type) VALUES ('$type')";
        $resultAddType = mysqli_query($connect, $queryAddType);
        $Facility_TypeID = mysqli_insert_id($connect);
    }

    $queryLink = "SELECT ProviderID FROM source WHERE `Link to Dataset`='$link'";
    $resultLink = mysqli_query($connect, $queryLink);
    if (mysqli_num_rows($resultLink) > 0) 
    {
        $recordLink = mysqli_fetch_assoc($resultLink);
        $Provider = $recordLink['ProviderID'];
    }
    else
    {
        // insert a new link
        $queryAddLink = "INSERT INTO source (`Link to Dataset`) VALUES ('$link')";
        $resultAddLink = mysqli_query($connect, $queryAddLink);
        $Provider = mysqli_insert_id($connect);  
    }

    $queryFacility = "UPDATE `art_cultural_data` SET 
    `Prov_ID`='" . $Prov_ID . "',
    `City` ='" . mysqli_real_escape_string($connect, $city) . "',
    `Source_Format_Address` ='" . mysqli_real_escape_string($connect, $address) . "',
    `Facility_TypeID` ='" . $Facility_TypeID . "',
    `Postal_Code` ='" . mysqli_real_escape_string($connect, $postalCode) . "',
    `Latitude` ='" . mysqli_real_escape_string($connect, $Latitude) . "',
    `Longitude` ='" . mysqli_real_escape_string($connect, $Longitude) . "',
    `Provider` ='" . $Provider . "'WHERE `Index` = '$updateID'";

    $result = mysqli_query($connect, $queryFacility);
    if (!$result) 
    {
        die("Database query failed: " . mysqli_error($connect));
    }
        header('Location: facility-admin.php?review_id=' . $updateID);
        exit();   
       
 
}

?>

<h2 class="text-center">Facility
<?php
if(isset($_GET['edit_id'])){
 
    $queryCurr='SELECT a.*,t.`ODCAF_Facility_Type`,p.Short_Prov,p.colorCode, s.`Data Provider`, s.`Link to Dataset`,s.`Last Updated`
    FROM`art_cultural_data` a
    LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID
    LEFT JOIN province p ON p.prov_id = a.Prov_ID
    LEFT JOIN source s ON s.`ProviderID`=a.Provider
    WHERE a.Index="' . mysqli_real_escape_string($connect, $_GET['edit_id']) . '";';

$resultCurr = mysqli_query($connect,$queryCurr);
$record = mysqli_fetch_assoc($resultCurr);

}
?>

<span class="ms-1" style="color:<?php echo $record['colorCode']; ?>;">Edit</span></h2>
<div class="col-md-6 rounded-3 border border-secondary border-4 bg-primary-subtle pe-5 pb-5 pt-3 m-auto shadow">
    <div class="text-center fs-2 fw-bold text-danger mb-1"><?php echo $record['Facility_Name']; ?></div>
        <form class="row fs-5 p-3" method="post" action="facility-admin-edit.php">

        <div class="mb-1 ms-4">
            <?php
        $values = array("ON", "BC");

    echo '<label for="province" class="form-label">Province</label>
            <select name="province" class="form-control">';
    
    foreach ($values as $value) {
        echo '<option value="' . $value . '"'; 
        if (($record['Short_Prov']) === $value) {
            echo ' selected'; 
        }
        echo '>' . $value . '</option>';
    }

    echo '  </select>
          </div>';

?>

        <div class="mb-1 ms-4">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo $record['City'];?>">   
        </div>
        <div class="mb-1 ms-4">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $record['Source_Format_Address'];?>">   
        </div>

        <div class="mb-1 ms-4">
            <?php
        $values = array("gallery", "museum","heritage or historic site","library or archives","theatre/performance and concert hall","art or cultural centre","festival site");

    echo '<label for="type" class="form-label">Facility Type</label>
            <select name="type" class="form-control">';
    
    foreach ($values as $value) {
        echo '<option value="' . $value . '"'; 
        if (($record['ODCAF_Facility_Type']) === $value) {
            echo ' selected'; 
        }
        echo '>' . $value . '</option>';
    }

    echo '  </select>
          </div>';

?>

        <div class="mb-1 ms-4">
            <label for="postalCode" class="form-label">Post Code</label>
            <input type="text" class="form-control" id="postalCode" name="postalCode" value="<?php echo $record['Postal_Code'];?>">   
        </div>
        <div class="mb-1 ms-4">
            <label for="Latitude" class="form-label">Map - Latitude</label>
            <input type="text" class="form-control" id="Latitude" name="Latitude" value="<?php echo $record['Latitude'];?>">   
        </div>
        <div class="mb-1 ms-4">
            <label for="Longitude" class="form-label">Map - Longitude</label>
            <input type="text" class="form-control" id="Longitude" name="Longitude" value="<?php echo $record['Latitude'];?>">   
        </div>
        <div class="mb-3 ms-4">
            <label for="link" class="form-label">Link to Dataset</label>
            <input type="text" class="form-control" id="link" name="link" value="<?php echo $record['Link to Dataset'];?>">   
        </div>
        <input type="hidden" name="update_id" value="<?php echo $record['Index'] ?>">
        <button type="submit" class="btn btn-success mb-2 ms-4">Update</button>
        <a href="facility-admin.php?review_id=<?php echo $record['Index']?>" class="btn btn-secondary mb-2 ms-4"><i class="fa-solid fa-arrow-left me-2"></i>Cancel</a>
        <a href="all-facilities.php" class="btn btn-primary ms-4">Go to Facility List<i class="fa-solid fa-list ms-2"></i></a>
        </div>
        </div>         
</form>
</div>

<?php
include('includes/footer.php');

      
?>