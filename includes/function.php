<?php

function secure(){
    //  if the login account exists, can go to index
    if(!isset($_SESSION['id'])){

    header('Location: index.php');
        die();

    }
}