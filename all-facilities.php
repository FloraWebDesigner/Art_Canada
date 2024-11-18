<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');



$isFiltered = !empty($_GET['place']) || !empty($_GET['type']) || !empty($_GET['prov']);
// update status
if(isset($_SESSION['id'])&&($_SESSION['role']==='admin')) {
    if (isset($_POST['change-status'])) {
        echo 'Form submitted';
        $id = $_POST['status_id'];
        $currStatus = $_POST['status'];

        $updatedStatus = ($currStatus === "open") ? "close" : "open";
        
        $id = mysqli_real_escape_string($connect, $id);
        $updatedStatus = mysqli_real_escape_string($connect, $updatedStatus);

        $queryUpdate = "UPDATE `art_cultural_data` 
                        SET `Status` = '$updatedStatus' 
                        WHERE `Index` = '$id'"; 

if (mysqli_query($connect, $queryUpdate)) {

    $place = isset($_GET['place']) ? $_GET['place'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $prov = isset($_GET['prov']) ? $_GET['prov'] : '';
    $page = isset($_GET['page']) ? $_GET['page'] : 1;  

    $redirectUrl = 'Location: all-facilities.php?page=' . ($page) . '&place=' . urlencode($place) . '&type=' . urlencode($type) . '&prov=' . urlencode($prov);

    header($redirectUrl);
}
}}

?>
<div class="container mt-3">
<h1 class="text-center"><span class="bg-danger p-1 text-white me-1">Cultural and Art</span>Facility Overview</h1>
<div class="row mt-2">
    <div class="text-center text-success fs-5">Too much information? 
        <button type="button"  onclick="getSearch()" class="btn btn-outline-success me-2" id="searchInfo">Get Search<i class="fa-regular fa-hand-point-right mx-1"></i></button>
        <?php if ($isFiltered): ?>
                <button type="button" class="btn btn-outline-secondary" onclick="console.log('Button Clicked'); clearSearch(event)">Clear Search</button>
            <?php endif; ?>
    </div>
<div class="col-md-4 offset-md-4">
    <form class="fs-5 searchForm" method="GET" style="display:none;">
        <div class="row mb-2">
            <label for="prov" class="form-label">Select a <span class="text-primary ms-2">province</span>:</label>
            <select name="prov" class="w-100 mb-1">
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
            <select name="type" class="w-100">
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
            <div class="d-flex flex-row align-items-center mb-2">
                <input type="text" id="place" name="place" placeholder="please enter the facility name" class="form-control w-100 border border-dark me-2"> <input type="submit" value="Search" class="btn btn-warning py-1 fs-5">
            </div>
        </div>
        
        
    </form>
    </div>
    </div>
    
    <?php 

    // add pagination
    $start = 0;
    $items_per_page=20;

    $place = isset($_GET['place']) ? $_GET['place'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $prov = isset($_GET['prov']) ? $_GET['prov'] : '';

    $query = 'SELECT a.*, t.`ODCAF_Facility_Type`, p.Short_Prov, p.Prov_Terr,p.colorCode, s.`Data Provider`, s.`Link to Dataset`
          FROM `art_cultural_data` a
          LEFT JOIN facilitytype t ON t.type_id = a.Facility_TypeID
          LEFT JOIN province p ON p.prov_id = a.Prov_ID
          LEFT JOIN source s ON s.`ProviderID` = a.Provider';

        $WHERE = 'WHERE 1=1';

if (isset($_GET['place']) && $_GET['place'] !== '') {
    $place = $_GET['place'];
    $WHERE .= ' AND a.Facility_Name LIKE "%' . mysqli_real_escape_string($connect, $place) . '%"';
}

if (isset($_GET['type']) && $_GET['type'] !== '') {
    $type = $_GET['type'];
    $WHERE .= ' AND t.ODCAF_Facility_Type = "' . mysqli_real_escape_string($connect, $type) . '"';
}

if (isset($_GET['prov']) && $_GET['prov'] !== '') {
    $prov = $_GET['prov'];
    $WHERE .= ' AND p.Prov_Terr = "' . mysqli_real_escape_string($connect, $prov) . '"';
}

    $query .= ' ' . $WHERE . ' ORDER BY CAST(a.Index AS UNSIGNED) ASC';
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1; 
        }
        
    $start = ($page - 1) * $items_per_page;     

    $queryWithLimit = $query . ' LIMIT ' . $start . ', ' . $items_per_page;
    

    $resultFull = mysqli_query($connect, $query);  
    $result = mysqli_query($connect, $queryWithLimit); 
    
    $num_rows = mysqli_num_rows($resultFull);
    $num_pages = ceil($num_rows / $items_per_page);
    
    ?>

<div class="d-flex flex-row justify-content-center align-items-center mt-3">

    <nav aria-label="Page navigation example">
        <ul class="pagination my-0">
            <li class="page-item">
                <a class="page-link" href="?page=1&place=<?php echo urlencode($place); ?>&type=<?php echo urlencode($type); ?>&prov=<?php echo urlencode($prov); ?>" aria-label="First">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item">
                <?php if ($page > 1): ?>
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&place=<?php echo urlencode($place); ?>&type=<?php echo urlencode($type); ?>&prov=<?php echo urlencode($prov); ?>" aria-label="Previous">&lt;</a>
                <?php else: ?>
                    <a class="page-link" href="#" aria-label="Previous" class="text-secondary disabled">&lt;</a>
                <?php endif; ?>
            </li>
            <li class="page-item">
                <select class="page-link" aria-label="Select page" onchange="window.location.href=this.value;">
                    <?php for ($i = 1; $i <= $num_pages; $i++): ?>
                        <option value="?page=<?php echo $i; ?>&place=<?php echo urlencode($place); ?>&type=<?php echo urlencode($type); ?>&prov=<?php echo urlencode($prov); ?>" <?php if ($i == $page) echo 'selected'; ?>>Page <?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </li>
            <li class="page-item">
                <?php if ($page < $num_pages): ?>
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&place=<?php echo urlencode($place); ?>&type=<?php echo urlencode($type); ?>&prov=<?php echo urlencode($prov); ?>" aria-label="Next">&gt;</a>
                <?php else: ?>
                    <a class="page-link" href="#" aria-label="Next" class="disabled">&gt;</a>
                <?php endif; ?>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $num_pages; ?>&place=<?php echo urlencode($place); ?>&type=<?php echo urlencode($type); ?>&prov=<?php echo urlencode($prov); ?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="page-info ms-3 text-secondary">
        Show <?php echo $page; ?> of <?php echo $num_pages; ?> (<?php echo $num_rows; ?> totals)
    </div>
</div>






<table class="table mt-3">
    <tr class="table-primary fs-5 myTable fw-semibold">
        <th class="col-md-1">Index</th>
        <th class="col-md-2">Facility Name</th>
        <th class="col-md-1">Type</th>
        <th class="col-md-1">City</th>
        <th class="col-md-1">Province</th>
        <?php
        if(!(isset($_SESSION['id'])&&($_SESSION['role']==='admin'))) {
        echo '<th class="col-md-4">Address</th>';
            }?>
        <?php
        if(isset($_SESSION['id'])&&($_SESSION['role']==='admin')) {
        echo '<th class="col-md-3">Address</th>
              <th class="col-md-1">Status</th>';
            }?>
        <th class="col-md-2">Operation</th>
    </tr>
    <tbody>
    <?php while ($record = mysqli_fetch_assoc($result)): ?>
        <tr class="fw-lighter fs-5 text-capitalize">
        <td><?php echo $record['Index']; ?></td>
            <td><?php echo $record['Facility_Name']; ?></td>
            <td><?php echo $record['ODCAF_Facility_Type']; ?></td>
            <td><?php echo $record['City']; ?></td>
            <td><?php echo $record['Short_Prov']; ?></td>
            <td><?php echo $record['Source_Format_Address']; ?></td>
            <?php
        if(isset($_SESSION['id'])&&($_SESSION['role']==='admin')) {
            echo '<td>' . $record['Status'] . '</td>';
        } ?>
            <td>
                <a href="map.php?mapId=<?php echo $record['Index'] ?>" class="btn btn-warning w-100 fs-6 mb-1">View Location<i class="fa-solid fa-map ms-2"></i></a>
                <?php
                if(!(isset($_SESSION['id'])&&($_SESSION['role']==='admin'))) {

                    if($record['Status']==="close")
                    {
                        echo '<a href="#" class="btn btn-secondary w-100 mb-1" disabled>Reservation Closed</a>';
                    }
                    else
                    {
                        echo '<a href="reservation.php?bookId=' . $record['Index'] . '" class="btn btn-success w-100 mb-1" name="reservation">Book a reservation</a>';
                    }
                }?>
                <?php
                if(isset($_SESSION['id'])&&($_SESSION['role']==='admin')) {                    
                    echo '
                    <form method="post">
                        <input type="hidden" name="status" value="'. $record['Status']. '">
                        <input type="hidden" name="status_id" value="' . $record['Index'] .'">
                        <button type="submit" name="change-status" class="btn btn-primary w-100 fs-6 mb-1">Change Status<i class="fa-solid fa-server ms-3"></i></button>
                    </form>
                    <a href="facility-admin.php?review_id=' . $record['Index'] . '" class="btn btn-dark w-100 fs-6">Admin Page<i class="fa-solid fa-server ms-3"></i></a>';
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