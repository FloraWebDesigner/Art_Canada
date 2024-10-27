<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');


?>
<div class="container mt-3">
<h1 class="text-center"><span class="bg-danger p-1 text-white me-1">Cultural and Art</span>Facility Overview</h1>
<div class="row">
    <div class="text-center text-success fs-5">Too much information? <button type="button"  onclick="getSearch()" class="btn btn-outline-success" id="searchInfo">Get Search<i class="fa-regular fa-hand-point-right mx-1"></i></button></div>
<div class="col-md-8 offset-md-4">
    <form class="fs-5 searchForm" method="GET" style="display:none;">
        <div class="row mb-2">
                <label for="prov" class="form-label">Select a <span class="text-primary ms-2">province</span>:</label>
                <select name="prov" class="w-50 ms-3">
                <option value="" disabled selected>--please select--</option>
                    <?php
                    $values = array('British Columbia','Ontario');
                    foreach($values as $value){
                        echo '<option value="' . $value . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
                <div class="row mb-2">
                    <label for="type" class="form-label">Select a <span class="text-primary ms-1">facility type</span>: </label>
                    <select name="type" class="w-50 ms-3">
                    <option value="" disabled selected>--please select--</option>
                        <?php
                        $values = array('gallery','museum','heritage or historic site','library or archives','theatre/performance and concert hall','art or cultural centre','festival site');
                        foreach($values as $value){
                            echo '<option class="p-2" value="' . $value . '">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="row mb-2">
                    <label for="place" class="form-label me-2">Search for a facility <span class="text-primary ms-1">by name</span></label>
                    <div class="d-flex flex-row align-items-center">
                        <input type="text" id="place" name="place" placeholder="please enter the facility name" class="form-control w-50 me-1 border border-dark">
                        <input type="submit" value="search" class="btn btn-warning px-4 py-0 fs-4">
                    </div>
                </div>
        
    </form>
    </div>
    </div>
    
    <?php 

$query = 'SELECT a.*, t.`ODCAF_Facility_Type`, p.Short_Prov, p.Prov_Terr,p.colorCode, s.`Data Provider`, s.`Link to Dataset`
              FROM `art_cultural_data` a
              LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID
              LEFT JOIN province p ON p.prov_id = a.Prov_ID
              LEFT JOIN source s ON s.`ProviderID` = a.Provider';

if (isset($_GET['place'])||isset($_GET['type'])||isset($_GET['prov'])) {

    $prov = isset($_GET['prov']) ? $_GET['prov'] : "*";
    $type = isset($_GET['type']) ? $_GET['type'] : "*";

    $WHERE = 'WHERE 1=1'; 
        if ($type !== "*") {
            $WHERE .= ' AND t.ODCAF_Facility_Type = "' . mysqli_real_escape_string($connect, $type) . '"';
        }

        if ($prov !== "*") {
            $WHERE .= ' AND p.Prov_Terr = "' . mysqli_real_escape_string($connect, $prov) . '"';
        }

        if (isset($_GET['place']) && $_GET['place'] !== '') {
            $WHERE .= ' AND a.Facility_Name LIKE "%' . mysqli_real_escape_string($connect, $_GET['place']) . '%"';
        }

        $query .= ' ' . $WHERE;
    }

   // echo $query; 
   $result = mysqli_query($connect, $query);
    ?>

<table class="table mt-3">
    <tr class="table-primary fs-5 myTable fw-semibold">
        <th class="col-md-2">Facility Name</th>
        <th class="col-md-1">Type</th>
        <th class="col-md-1">City</th>
        <th class="col-md-1">Province</th>
        <th class="col-md-4">Address</th>
        <th class="col-md-2">Operation</th>
    </tr>
    <tbody>
    <?php while ($record = mysqli_fetch_assoc($result)): ?>
        <tr class="fw-lighter fs-5 text-capitalize">
            <td><?php echo $record['Facility_Name']; ?></td>
            <td><?php echo $record['ODCAF_Facility_Type']; ?></td>
            <td><?php echo $record['City']; ?></td>
            <td><?php echo $record['Short_Prov']; ?></td>
            <td><?php echo $record['Source_Format_Address']; ?></td>
            <td>
                <a href="map.php?mapId=<?php echo $record['Index'] ?>" class="btn btn-warning w-100 fs-6">View Location<i class="fa-solid fa-map ms-2"></i></a>
                <?php
                if (isset($_SESSION['id'])) {
                    echo '<a href="facility-admin.php?review_id=' . $record['Index'] . '" class="btn btn-dark w-100 fs-6 mt-1">Admin Page<i class="fa-solid fa-server ms-3"></i></a>';
                }

                ?>
        </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
    </div>
    <?php
include('includes/footer.php');
?>