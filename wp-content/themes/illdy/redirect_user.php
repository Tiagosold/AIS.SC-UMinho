<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 08/04/2017
 * Time: 17:13
 */
require_once 'session.php';

if((isset($_SESSION['idType'])) && ($_SESSION['idType'] == 1)) {
    redirect('/admin');
}elseif((isset($_SESSION['idType'])) && ($_SESSION['idType'] == 2)){
    redirect('/');
}else {
    redirect('/');
}