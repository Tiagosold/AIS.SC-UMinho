<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if (isset($_GET['idType'])) {
        $email = $_GET['email'];
        $id = $_GET['idType'];
        $idAssociate = $_GET['idAssociate'];
        $expired = $_GET['expired'];
        $image = $_GET['image'];
        $_SESSION['email'] = $email;
        $_SESSION['idType'] = $id;
        $_SESSION['idAssociate'] = $idAssociate;
        $_SESSION['expired'] = $expired;
        $_SESSION['image'] = $image;
}

if (isset($_GET['logout'])) {
    session_destroy();
    $url = '/';
    header("Location: $url");
}

function confirm_admin() {
    if ($_SESSION['idType'] != 1) {
        redirect('/404.php');
    }
}

function confirmAssociate(){
    if($_SESSION['idType'] != 2){
        redirect('/../404.php');
    }
}

function redirect($url){
    header("Location: $url");
}

