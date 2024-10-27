<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/header.php');

?>

<div class="container-fluid myMap">              
        <?php
        if(isset($_GET['mapId'])){
        $query = "SELECT * FROM art_cultural_data WHERE `Index`='" . mysqli_real_escape_string($connect, $_GET['mapId']) . "' LIMIT 1";
        $map_id = $_GET['mapId'];
        $result = mysqli_query($connect,$query);
        $record = mysqli_fetch_assoc($result);
        }
        ?>
        <h3 class="text-center text-dark pt-3"><?php echo $record['Facility_Name'];?></h3>
    <div class="row mb-2">
        <div class="col-sm-3 offset-sm-3 text-start">
            <a href="facility.php?id=<?php echo $record['Facility_TypeID']; ?>" class="btn btn-outline-primary" style="width:10rem;">back</a>      
        </div>
        <div class="col-sm-3 text-end">
            <a href="report.php?reportId=<?php echo $record['Index'] ?>" class="btn btn-outline-primary" style="width:10rem;">Report a Mistake</a>      
        </div>
    </div>
<div class="d-flex justify-content-center align-items-center">
<?php 
$Facility_Name = urlencode($record['Facility_Name']);
?>

<iframe
width="650"
  height="400"
  class="shadow"
  style="border:0"
  loading="lazy"
  allowfullscreen
  referrerpolicy="no-referrer-when-downgrade"
  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBT6Af-eNN9bDfnoBtQ9SZJXlIFC08ea2U
    &q=<?php echo $Facility_Name; ?>">
  </iframe>
</div>
</div>
  <?php 
        include('includes/footer.php');
    ?>
<!-- https://console.cloud.google.com/google/maps-apis/credentials?authuser=0&project=profound-matter-426003-q8 -->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5XKVr1XfdmI2Kt4bDArBiOc1P67GS6F8&libraries=maps,marker&v=beta"
    defer
></script>