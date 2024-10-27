<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

?>
<div class="container-fluid home d-flex justify-content-center align-items-center">
    <div class="home-dark d-flex flex-column justify-content-center align-items-center p-5">
        <h2 class="text-center text-white">Cultural and Art Facilities in Canada</h2>
        <p class="text-center text-light mb-4" style="width:65%;">The cultural and art facilities are facilities wherein the primary activity is of a cultural nature or is related to the arts.The database (ODCAF) is a database of cultural and art facilities released as open data.</p>
        <a href="https://www.statcan.gc.ca/en/lode/databases/odcaf" class="btn btn-light">View Data Source</a>
    </div>
</div>
<?php
// $query='SELECT a.*,t.`ODCAF_Facility_Type`,p.Prov_Terr, s.`Data Provider`
// FROM`art_cultural_data` a
// LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID
// LEFT JOIN province p ON p.prov_id = a.Prov_ID
// LEFT JOIN source s ON s.`ProviderID`=a.Provider';
$queryByFacility='SELECT 
    t.*,
    COUNT(a.Facility_TypeID) AS typeCount,
    (COUNT(a.Facility_TypeID) / total.total_count) * 100 AS percentage
FROM 
    facilitytype t
JOIN 
    art_cultural_data a ON a.Facility_TypeID = t.type_id
JOIN 
    (SELECT COUNT(*) AS total_count FROM art_cultural_data) AS total
GROUP BY 
    t.type_id, t.ODCAF_Facility_Type, t.color, t.description,total.total_count';

$result = mysqli_query($connect,$queryByFacility);
 ?>
<div class="container-fluid">
<div class="row">
<?php while($record = mysqli_fetch_assoc($result)): ?>
        <a class="d-flex flex-column py-3 shadow myFacility" style="background:<?php echo $record['color']; ?>; height:12rem;width:14.25%;" href="facility.php?id=<?php echo $record['type_id']; ?>">
            <div class="fs-1 fw-bolder mb-2 text-dark"><?php echo number_format($record['percentage'], 2); ?>%</div>        
            <div class="text-capitalize fs-4 text-dark"><?php echo $record['ODCAF_Facility_Type']; ?></div>           
</a>
    <?php endwhile; ?>
</div>
</div>


<?php

include('includes/footer.php');?>