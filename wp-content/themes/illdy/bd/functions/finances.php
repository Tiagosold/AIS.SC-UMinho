<?php
/**
 * Created by PhpStorm.
 * User: Vitor
 * Date: 28/06/2017
 * Time: 23:23
 */

require_once dirname(__FILE__) . '/../connection/dbconnect.php';

function addEditTransaction($params){
    $response = array();
    $connection = dbConnect();
    $id = $params['id'];
    $description = $params['description'];
    $transactionDate = $params['transactionDate'];
    $value = $params['value'];
    $typeAccount = $params['typeAccount'];
    $typeMovement = $params['typeMovement'];

    if($id == '0'){
        $query = "INSERT INTO movimento (descricao, dataMovimento, 
                  valor, tipoConta, tipoMovimento) 
                  VALUES ('$description', '$transactionDate', '$value', '$typeAccount', '$typeMovement')";
    }else{
        $response['cod'] = 502;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    if ($id == '1'){
        $idTransaction = $params['idTransaction'];
        $query = "UPDATE movimento SET descricao='$description', 
                    dataMovimento='$transactionDate', valor='$value', tipoConta='$typeAccount', tipoMovimento='$typeMovement' 
                    WHERE idMovimento='$idTransaction'";
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

function getTransactions($params){
    $response = array();
    $id = $params['id'];
    $connection = dbConnect();
    if($id == 1){
        $query = "SELECT * FROM Conta,tipoMovimento, movimento Where Conta.idConta= tipoConta and tipoMovimento.idtipoMovimento = tipoMovimento";
    } if($id == 2){
        $idTransaction = $params['idTransaction'];
        $query = "SELECT * FROM movimento WHERE idMovimento = '$idTransaction'";
    } if($id == 3){
        $query = "SELECT * FROM movimento WHERE tipoConta= 1";
    } if($id == 4) {
        $query = "SELECT * FROM movimento WHERE tipoConta= 2";
    }
    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));

    if ($result) {
        while ($transaction = mysqli_fetch_array($result)) {
            $response[] = $transaction;
        }$response['cod'] = 200;
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;

}

function deleteTransactions($params) {
    $response = array();

    $idTransaction = $params['idTransaction'];
    $connection = dbConnect();
    $query = "DELETE FROM movimento WHERE idMovimento = '$idTransaction'";
    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));

    if ($result) {
        $response['cod'] = 200;
        $response['error'] = FALSE;
        $response['msg'] = 'Deleted transaction';
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;

}

