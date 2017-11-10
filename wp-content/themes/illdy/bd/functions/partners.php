<?php
/**
 * Created by PhpStorm.
 * User: Vitor
 * Date: 02/05/2017
 * Time: 21:47
 */

require_once dirname(__FILE__) . '/../connection/dbconnect.php';


function addEditPartner($params){
    $response = array();
    $connection = dbConnect();
    $id = $params['id'];
    $namePartner = $params['namePartner'];
    $startDate = $params['startDate'];
    $endDate = $params['endDate'];
    $observations = $params['observation'];
    $amount = $params['amount'];
    $benefits = $params['benefits'];
    $image = $params['image'];

    if($id == '0'){
        $query = "INSERT INTO parceria (nomeParceiro, dataInicio, 
                  dataFim, observacoes, montante, prestacoes, imagem) 
                  VALUES ('$namePartner', '$startDate', '$endDate', '$observations', '$amount', '$benefits', '$image')";
    }else{
        $response['cod'] = 502;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
        if ($id == '1'){
            $idPartner = $params['idPartner'];
            $query = "UPDATE parceria SET nomeParceiro='$namePartner', 
                    dataInicio='$startDate', dataFim='$endDate', observacoes='$observations', montante='$amount', prestacoes='$benefits', imagem='$image' 
                    WHERE idParceria='$idPartner'";
        }

    $result = mysqli_query($connection, $query);
    if ($result) {
        $response['cod'] = 201;
        $response['error'] = FALSE;
        $response['msg'] = 'all good';
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }

    mysqli_close($connection);
    return $response;

    }

function getPartners($params){
    $response = array();
    $id = $params['id'];
    $connection = dbConnect();
    if($id == 1){
            $query = "SELECT * FROM parceria";
    } if($id == 2){
        $idPartner = $params['idPartner'];
        $query = "SELECT * FROM parceria WHERE idParceria = '$idPartner'";
    }
    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));

    if ($result) {
        while ($partners = mysqli_fetch_array($result)) {
            $response[] = $partners;
        }$response['cod'] = 200;
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;

}
function deletePartners ($params){
    $response = array();

    $idPartner = $params['idPartner'];
    $connection = dbConnect();
    $query = "DELETE FROM parceria WHERE idParceria = '$idPartner'";
    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));

    if ($result) {
        while ($partners = mysqli_fetch_array($result)) {
            $response[] = $partners;
        }$response['cod'] = 200;
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;


}