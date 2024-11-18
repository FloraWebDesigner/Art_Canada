<?php

function secure(){
    //  if the login account exists, can go to index
    if(!isset($_SESSION['id'])){
    header('Location: index.php');
        die();
    }
}

function secureAdmin(){
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php');
            die();
        }
}

function secureRedirect(){
    if(isset($_SESSION['id'])&&($_SESSION['role']==='admin')){
        header('Location: admin-home.php');
            die();    
        }
        else if(isset($_SESSION['id'])&&($_SESSION['role']==='user')){
            header('Location: user-home.php');
            die();
        }
        else{
            header('Location: login.php');
            die();
        }
}