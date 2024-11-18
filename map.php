<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/header.php');

?>

<div class="container-fluid myMap">              
<?php
if (isset($_GET['mapId'])) {
    $map_id = mysqli_real_escape_string($connect, $_GET['mapId']);
    $query = "SELECT a.*, t.`ODCAF_Facility_Type` FROM art_cultural_data a LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID WHERE a.`Index`='$map_id' LIMIT 1";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        $givenLocation = [$record['Facility_Name'], $record['Latitude'], $record['Longitude']];

        $type_id = $record['Facility_TypeID'];
        $queryMapList = "SELECT * FROM art_cultural_data WHERE `Facility_TypeID`='$type_id'";
        $resultMapList = mysqli_query($connect, $queryMapList);

        if ($resultMapList && mysqli_num_rows($resultMapList) > 0) {
            $locations = [];
            while ($recordMapList = mysqli_fetch_assoc($resultMapList)) {
                $locations[] = [
                    'Facility_Name' => $recordMapList['Facility_Name'],
                    'Latitude' => $recordMapList['Latitude'],
                    'Longitude' => $recordMapList['Longitude']
                ];
            }
        }
    }
}
?>
<h3 class="text-center text-dark pt-3"><?php echo $record['Facility_Name'];?></h3>
    <div class="row mb-2">
        <div class="col-sm-6 offset-sm-3 d-flex flex-row justify-content-evenly">
            <a href="facility.php?id=<?php echo $record['Facility_TypeID']; ?>" class="btn btn-outline-primary" style="width:10rem;">back</a> 
            <a href="javascript:void(0);" id="showMapButton" class="btn btn-outline-primary" style="width:10rem;">See All</a>
            <a href="reservation.php?bookId=<?php echo $record['Index'] ?>" class="btn btn-outline-primary" name="reservation" style="width:10rem;">Book a reservation</a>    
        </div>
    </div>
<div class="d-flex justify-content-center align-items-center">
    <?php 
    $Facility_Name = urlencode($record['Facility_Name']);
    ?>

    <iframe id="oneLocation"
        width="650"
        height="400"
        class="shadow"
        style="border:0"
        loading="lazy"
        allowfullscreen
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps/embed/v1/place?key=<?php echo MAP_KEY; ?>
            &q=<?php echo $Facility_Name; ?>">
    </iframe>
    <div id="allLocations" style="display:none; height: 500px; width: 100%;" class="mb-3">
    </div>
</div>




</div>
  <?php 
        include('includes/footer.php');
    ?>
<!-- https://console.cloud.google.com/google/maps-apis/credentials?authuser=0&project=profound-matter-426003-q8 -->

<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("allLocations"), {
            center: { lat: 56.1304, lng: -106.3468 }, // Canada center
            zoom: 4,  
            mapTypeId: 'roadmap',
        });
        const allLocations = document.getElementById("allLocations");
        const oneLocation = document.getElementById("oneLocation");
        let viewBtn = document.getElementById("showMapButton");
        viewBtn.addEventListener('click', function() {
            if(allLocations.style.display === "none")
        {
            allLocations.style.display = "block";            
            oneLocation.style.display = "none"; 
            viewBtn.innerHTML="See One";
            getAllLocations(map);
        }
        else{
            allLocations.style.display = "none";
            oneLocation.style.display = "block";
            viewBtn.innerHTML="See All";
            return;
        }
           
        });
    }
    function getAllLocations(map) {
        const locations = <?php echo json_encode($locations); ?>;
        const bounds = new google.maps.LatLngBounds();
        locations.forEach(location => {
            const latitude = parseFloat(location.Latitude);
            const longitude = parseFloat(location.Longitude);

            if (!isNaN(latitude) && !isNaN(longitude) && Math.abs(latitude) <= 90 && Math.abs(longitude) <= 180) {
                const position = new google.maps.LatLng(latitude, longitude);
                bounds.extend(position);

                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: location.Facility_Name
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `<h4>${location.Facility_Name}</h4><p>Latitude: ${latitude}, Longitude: ${longitude}</p>`
                });

                marker.addListener('click', function () {
                    infoWindow.open(map, marker);
                });
            }
        });

        map.setCenter({ lat: 56.1304, lng: -106.3468 }); 
        map.setZoom(4);
       
        google.maps.event.addListenerOnce(map, 'bounds_changed', function () {
            let zoomLevel = map.getZoom();
            if (zoomLevel > 10) {  
                map.setZoom(10);
            }
        });
    }
    
</script>
<!-- Google Maps API script, passing `callback=initMap` to load the map -->
<script 
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo MAP_KEY; ?>&libraries=places,marker&callback=initMap" 
    async 
    defer>
</script>