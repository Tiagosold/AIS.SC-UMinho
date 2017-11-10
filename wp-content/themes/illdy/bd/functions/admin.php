<?php
/**
 * Created by PhpStorm.
 * User: Vitor
 * Date: 18/04/2017
 * Time: 18:52
 */

require_once dirname(__FILE__) . '/../connection/dbconnect.php';

function getSiteInfo($params){
    $response = array();
    $conn= dbConnect();

    $query= "SELECT (Select count(*) From utilizador u Where u.expirado = 0 and idTipoUtilizador = 2) AS users, (Select count(*) From evento) AS events,(Select count(*) From parceria) As partners";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    if($result){
        while ($count = mysqli_fetch_array($result)) {
            $response[] = $count;
        }
        $response['cod'] = 200;
        $response['error'] = FALSE;
        $response['msg'] = 'all good';
    }else{
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($conn);
    }
    mysqli_close($conn);
    return $response;
}

