<?php

include('includes/config.php');
include('includes/connect.php');
include('includes/function.php');
include('includes/header.php');

secure();

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $id = mysqli_real_escape_string($connect, $id);

    $query = "DELETE FROM `user` WHERE `id` = $id";
    echo $query;
    mysqli_query($connect, $query);

    //sent_message('User has been deleted');
    header('adminTable.php');
}

?>

<h2 class="text-center mt-5 me-3">Administrator Table</h2>

<?php
$queryAdmin='SELECT *
FROM user';

 $resultAdmin = mysqli_query($connect,$queryAdmin);

 ?>
 <div class="container d-flex flex-row justify-content-center align-items-center mt-3">
<a href="message.php" class="btn btn-dark me-5">Back</a>
<a href="adminAdd.php" class="btn btn-dark ms-5">Add Administrator</a>
</div>
<div class="container d-flex flex-row flex-wrap mt-3 justify-content-center align-items-center">

    <? while($recordAdmin = mysqli_fetch_assoc($resultAdmin)): ?>
        <div class="border border-warning text-dark m-3" style="width:12rem;">
            <div class="fs-3 mb-2 text-center bg-warning w-100"><?php echo $recordAdmin['name']; ?></div>
            <div class="fs-5 text-center"><?php echo $recordAdmin['email']; ?></div>
                <div class="d-flex flex-row justify-content-evenly p-3">
                    <a href="adminEdit.php?edit_id=<?php echo $recordAdmin['id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="javascript:void(0);" onclick="confirmDeleteAdmin(<?php echo $recordAdmin['id']; ?>,'<?php echo $recordAdmin['name']; ?>')" class="btn btn-danger">Delete</a>
                </div>
        </div>
    <? endwhile;?>
    </div>

    <?php
include('includes/footer.php');
?>
