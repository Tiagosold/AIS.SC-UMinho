<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 31/03/2017
 * Time: 15:51
 */
require_once dirname(__FILE__) . '/../connection/dbconnect.php';

function changeAssociateState($params){
    $response = array();
    $idAssociate = $params['idAssociate'];
    $id = $params['id'];

    $connection = dbConnect();
    if($id == 1) {
        $query0 = "SELECT * FROM utilizador WHERE idUtilizador='$idAssociate'";
        $result0 = mysqli_query($connection,$query0) or die(mysqli_error($connection));
        if($result0){
            $quotas = mysqli_fetch_array($result0);
            $date = date('d-m-Y');
            $state = 1;
            $finalData = date('d-m-Y', strtotime('+ '.$quotas['numeroCotas'].' years'));
            $query = "UPDATE utilizador SET estado='$state', dataInicio='$date', dataFinal='$finalData', expirado='0' WHERE idUtilizador='$idAssociate';";
        }
    }elseif($id == 2){
        $image = $params['image'];
        $query = "UPDATE utilizador SET imagem='$image' WHERE idUtilizador='$idAssociate';";
    }elseif($id == 3){
        $query = "UPDATE utilizador SET expirado='1', numeroCotas='0' WHERE idUtilizador='$idAssociate';";
    }
    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));

    if($result){
        $response['cod'] = 200;
        $response['error'] = FALSE;
        $response['msg'] = 'All good';
    }else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
}

function getAssociates($params){
    $response = array();
    $id = $params['id'];
    $connection = dbConnect();
    if($id == 1) {
        $query = "Select * From utilizador, curso Where utilizador.idCurso = curso.idcurso and idTipoUtilizador = 2 and idUtilizador > 0";
    }elseif($id == 2) {
        $idAssociate = $params['idAssociate'];
        $query = "Select * From utilizador, curso Where utilizador.idCurso = curso.idcurso and idUtilizador = $idAssociate";
    }
    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));

    if ($result) {
        while ($associate = mysqli_fetch_array($result)) {
            $response[] = $associate;

        }$response['cod'] = 200;
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    return $response;
}

function renewQuotas($params){
    $response = array();

    $email = $params['email'];
    $pass = $params['pass'];
    $quotas = $params['quotas'];

    $connection = dbConnect();
    $query = "SELECT * FROM utilizador WHERE email='$email'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    if(mysqli_num_rows($result) === 1) {
        $fetch = mysqli_fetch_array($result);
        $state = $fetch['estado'];
        $expired = $fetch['expirado'];
        if ($state == 0 && $expired == 1) {
            $response['cod'] = 502;
            $response['error'] = TRUE;
            $response['msg'] = 'Profile being updated';
        } else {
            $dbPass = $fetch['password'];
            if (hash_equals($dbPass, crypt($pass, $dbPass))) {
                $queryQ = "UPDATE utilizador SET numeroCotas='$quotas', estado='0', validada='0' WHERE email='$email';";
                $resultQ = mysqli_query($connection, $queryQ) or die(mysqli_error($connection));
                if($resultQ){
                    $response['random'] = $fetch['random'];
                    $response['msg'] = "Profile updated";
                    $response['error'] = FALSE;
                    $response['cod'] = 201;
                }else {
                    $response['cod'] = 500;
                    $response['error'] = TRUE;
                    $response['msg'] = mysqli_error($connection);
                }
            } else {
                $response['cod'] = 501;
                $response['error'] = TRUE;
                $response['msg'] = 'Password didnt match';
            }
        }
    }
    else {
            $response['cod'] = 500;
            $response['error'] = TRUE;
            $response['msg'] = mysqli_error($connection);
        }

    mysqli_close($connection);
    return $response;
}