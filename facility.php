<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

?>

<?php
if(isset($_GET['id'])){

$typeID = $_GET['id'];

$queryFacility = 'SELECT * FROM facilitytype WHERE type_id="' . $typeID . '";';
$resultFacility = mysqli_query($connect, $queryFacility);
$recordFacility = mysqli_fetch_assoc($resultFacility);

$query='SELECT a.*,t.`ODCAF_Facility_Type`,p.Short_Prov,p.colorCode, s.`Data Provider`, s.`Link to Dataset`
FROM`art_cultural_data` a
LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID
LEFT JOIN province p ON p.prov_id = a.Prov_ID
LEFT JOIN source s ON s.`ProviderID`=a.Provider
WHERE t.type_id="' . $typeID . '";';

$result = mysqli_query($connect, $query);
$record = mysqli_fetch_assoc($result);

}
?>
    <h2 class="fs-1 fw-bold text-center text-capitalize text-shadow mt-4">
        <span class="ms-2 bg-dark px-2" style="color:white;">Cultural and Art Facilities</span>
        <?php echo $recordFacility['ODCAF_Facility_Type']; ?></h2>
        <div class="container">
        <div class="text-center text-secondary mt-3">Classification Used and Assignment of Cultural and Art Facility Type</div>
        <div class="text-center fs-4 mb-4 text-secondary"><?php echo $recordFacility['description']; ?></div>
</div>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="row g-3"> 
    <? while($record = mysqli_fetch_assoc($result)): ?>
    <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-title text-capitalize fw-bolder p-2 text-center fs-4 text-dark" style="background:<?php echo $recordFacility['color']; ?>;"><?php echo $record['Source_Facility_Type']; ?>
        <span class="text-center rounded-3 px-2 fs-5 text-light fw-light" style="background:<?php echo $record['colorCode']; ?>;"><?php echo $record['Short_Prov']; ?></span></div>
            <div class="card-body text-capitalize px-3 pt-0">
                <div class="text fs-2 fw-bolder mb-3 text-center"><?php echo $record['Facility_Name']; ?></div>
                <div class="row">
                    <div class="col-md-8 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-row align-items-center fs-6">
                            <i class="fa-solid fa-city me-2"></i>
                            <div class="text"><?php echo $record['City']; ?></div>
                        </div>
                        <div class="d-flex flex-row align-items-center fs-6">
                            <i class="fa-solid fa-location-dot me-2"></i> 
                            <div class="text"><?php echo $record['Source_Format_Address']; ?></div>
                        </div>
                        <div class="d-flex flex-row align-items-center fs-6">
                            <i class="fa-solid fa-location-arrow me-2"></i>
                            <div class="text"><?php echo $record['Postal_Code']; ?></div>
                        </div>
                        <div class="d-flex flex-row align-items-center fs-6 mb-2">
                            <i class="fa-brands fa-sourcetree me-2"></i>
                            <div class="text">Source: <?php echo $record['Data Provider']; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">                  
                        <a href="<?php echo $record['Link to Dataset']; ?>" class="btn btn-primary w-100 mb-1"><i class="fa-solid fa-database me-1"></i>Review Dataset</a>                 
                        <a href="map.php?mapId=<?php echo $record['Index'] ?>" class="btn btn-warning w-100 mb-1"><i class="fa-solid fa-map me-1"></i>View Map</a>

                        <?php
                if(!(isset($_SESSION['id'])&&($_SESSION['role']==='admin'))) {

                    if($record['Status']==="close")
                    {
                        echo '<a href="#" class="btn btn-secondary w-100" disabled>Reservation Closed</a>';
                    }
                    else
                    {
                        echo '<a href="reservation.php?bookId=' . $record['Index'] . '" class="btn btn-success w-100" name="reservation">Book a reservation</a>';
                    }
                }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? endwhile;?>

    <?php

include('includes/footer.php');?>

    
