<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 01/06/2017
 * Time: 16:45
 */

require_once dirname(__FILE__) . '/../connection/dbconnect.php';

function addRegistration($params){
    $conn = dbConnect();
    $response = array();

    $id = $params['id'];
    $idEvent = $params['idEvent'];

    if($id == 0){
        $idUser = $params['idAssociate'];
        $query1 = "SELECT * FROM inscricao WHERE Evento_idEvento='$idEvent' and Utilizador_idUtilizador='$idUser'";
        $result1 = mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1) === 0){
			$date = date('Y/m/d');
            $query = "INSERT INTO inscricao (Evento_idEvento, Utilizador_idUtilizador, estado,dataInscricao, socio) 
                  VALUES ('$idEvent', '$idUser', '1', '$date', 'S')";
        }else {
            $response['cod'] = 502;
            $response['error'] = TRUE;
            $response['msg'] = 'Already registered';
            return $response;
        }

    }elseif ($id == 1){
        $name = $params['name'];
        $number = $params['number'];
        $email = $params['email'];
        $phone = $params['phone'];
        $year = $params['year'];
		$course = $params['course'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query1 = "SELECT * FROM inscricao WHERE Evento_idEvento='$idEvent' and email='$email'";
            $result1 = mysqli_query($conn,$query1);
            if(mysqli_num_rows($result1)===0){
				$date = $date = date('Y/m/d');
                $query = "INSERT INTO inscricao (Evento_idEvento, Utilizador_idUtilizador, estado, nome, email, numeroAluno, telemovel, ano, curso, dataInscricao, socio) 
                  VALUES ('$idEvent', '0', '0', '$name', '$email', '$number', '$phone','$year','$course','$date', 'N')";
            }else{
                $response['cod'] = 502;
                $response['error'] = TRUE;
                $response['msg'] = 'Already registered';
                return $response;
            }
        }else {
            $response['cod'] = 501;
            $response['error'] = TRUE;
            $response['msg'] = 'Email not validated';
            return $response;
        }
    }

    $result = mysqli_query($conn, $query);
    if($result){
        $response['cod'] = 201;
        $response['error'] = FALSE;
        $response['msg'] = "Registration Successful";
    }else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($conn);
    }
    mysqli_close($conn);
    return $response;
}

function getRegistrations($params){
    $response = array();
    $conn = dbConnect();
    $idEvent = $params['idEvent'];
    $query = "SELECT i.*, u.nomeUtilizador,u.numeroAluno as num, u.email as mail, u.telemovel as tel, u.ano as an, u.idCurso as idCurso FROM inscricao i, utilizador u Where i.Evento_idEvento = '$idEvent' and i.Utilizador_idUtilizador=u.idUtilizador ";
    $result = mysqli_query($conn,$query);

    if($result){
        while ($registration = mysqli_fetch_array($result)) {
            $response[] = $registration;
        }$response['cod'] = 200;
    }else{
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($conn);
    }
    mysqli_close($conn);
    return $response;
}

function changePaymentState($params){
    $response = array();
    $conn = dbConnect();
    $idEvent = $params['idEvent'];
    $id = $params['id'];
    $state = $params['state'];
    if($id == 0){
        $idAssociate = $params['idAssociate'];
        $query = "UPDATE inscricao SET estado='$state' WHERE Evento_idEvento='$idEvent' and Utilizador_idUtilizador='$idAssociate'";
    }elseif($id == 1) {
        $email = $params['email'];
        $query = "UPDATE inscricao SET estado='$state' WHERE Evento_idEvento='$idEvent' and email='$email'";
    }
    $result = mysqli_query($conn,$query);
    if($result){
        $response['cod'] = 201;
        $response['error'] = FALSE;
        $response['msg'] = "Successfull changed";
    }else{
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($conn);
    }
    mysqli_close($conn);
    return $response;
}

function deleteRegistration($params){
    $response = array();
    $conn = dbConnect();
    $idEvent = $params['idEvent'];
    $id = $params['id'];
    if($id == 0){
        $idAssociate = $params['idAssociate'];
        $query = "DELETE FROM inscricao WHERE Evento_idEvento='$idEvent' and Utilizador_idUtilizador='$idAssociate'";
    }elseif ($id == 1){
        $email = $params['email'];
        $query = "DELETE FROM inscricao WHERE Evento_idEvento='$idEvent' and email='$email'";
    }
    $result = mysqli_query($conn,$query);
    if($result){
        $response['cod'] = 200;
        $response['error'] = FALSE;
        $response['msg'] = "Successfull deleted";
    }else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($conn);
    }
    mysqli_close($conn);
    return $response;
}

function checkRegistration($params){
    $response = array();
    $conn = dbConnect();

    $idAssociate = $params['idAssociate'];
    $query = "SELECT e.designacao, i.Evento_idEvento, i.estado, i.dataInscricao, e.data_inicio, e.aberto From inscricao i, evento e Where i.Utilizador_idUtilizador>0 and i.Evento_idEvento=e.idEvento and i.Utilizador_idUtilizador in 
              (SELECT idUtilizador From utilizador Where i.Utilizador_idUtilizador='$idAssociate')";
    $result = mysqli_query($conn,$query);

    if($result){
        while ($registration = mysqli_fetch_array($result)) {
            $response[] = $registration;
        }
        $response['cod'] = 200;
    }else {
        $response['cod'] = 404;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($conn);
    }
    mysqli_close($conn);
    return $response;
}



