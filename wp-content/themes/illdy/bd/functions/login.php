<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 20/03/2017
 * Time: 23:32
 */

require_once dirname(__FILE__) . '/../connection/dbconnect.php';

function validateLogin($params)
{
    $response = array();
    $email = $params['email'];
    $conn = dbConnect();
    $id = $params['id'];
    $query = "SELECT * FROM utilizador WHERE email='$email'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($result) === 1) {
        $fetch = mysqli_fetch_array($result);
        $email = $fetch['email'];
        if ($id == 0) {
            $pass = $params['password'];
            $dbPass = $fetch['password'];
            $idType = $fetch['idTipoUtilizador'];
            $idAssociate = $fetch['idUtilizador'];
            $expired = $fetch['expirado'];
            $state = $fetch['estado'];
            $finalDate = $fetch['dataFinal'];
            $image = $fetch['imagem'];
            //     $name = $fetch['name'];
            //     $lastName = $fetch['lastName'];
           //if ($dbPass === $pass) {
            if(hash_equals($dbPass, crypt($pass, $dbPass))){
                if ($fetch['estado'] == 1) {
                    if ($fetch['validada'] == 0) {
                        $response['msg'] = "Account not validated";
                        $response['error'] = TRUE;
                        $response['cod'] = 403;
                    } else {
                        $response['msg'] = "validation success";
                        $response['error'] = FALSE;
                        $response['idType'] = $idType;
                        $response['email'] = $email;
                        $response['idAssociate'] = $idAssociate;
                        $response['cod'] = 200;
                        $response['expired'] = $expired;
                        $response['state'] = $state;
                        $response['finalDate'] = $finalDate;
                        $response['image'] = $image;
                    }
                } else {
                    $response['msg'] = "Account not confirmed";
                    $response['error'] = TRUE;
                    $response['cod'] = 405;
                }
            } else {
               $response['password'] = $dbPass;
               $response['pass'] = crypt($pass, $dbPass);
                $response['msg'] = "validation fail";
                $response['error'] = TRUE;
                $response['cod'] = 404;
            }
        } elseif ($id == 1) {
            $random = $fetch['random'];
            $response['random'] = $random;
            $response['msg'] = "Email successfull retrieved";
            $response['error'] = FALSE;
            $response['cod'] = 200;
            $response['email'] = $email;
            $response['idAssociate'] = $fetch['idUtilizador'];
        } else {
            $response['msg'] = "Nenhum ID";
            $response['error'] = FALSE;
            $response['cod'] = 401;
        }
    } else {
        $response['msg'] = "validation fail";
        $response['error'] = TRUE;
        $response['cod'] = 401;

    }
    mysqli_close($conn);
    return $response;
}

function validateUser($params)
{
    $response = array();
    $random = $params['random'];
    $conn = dbConnect();
    $query = "UPDATE utilizador SET validada='1' WHERE random='$random';";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if ($result) {
        $response['cod'] = 201;
        $response['error'] = FALSE;
        $response['msg'] = 'Validated';
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($conn);
    }
    mysqli_close($conn);
    return $response;
}

function addEditAssociate($params)
{
    $response = array();
    $connection = dbConnect();
    $id = $params['id'];
    $email = $params['email'];
    $phone = $params['phone'];
    $course = $params['course'];
    $year = $params['year'];
    $name = $params['name'];
    $student_number = $params['student_number'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if ($id === '0') {
            $teste = "SELECT * From utilizador Where email='$email' or numeroAluno = '$student_number' and numeroAluno != ''";
            $resultTest = mysqli_query($connection, $teste);
            if (mysqli_num_rows($resultTest) === 0) {
                $quotas = $params['quotas'];
                $password = $params['password'];
                $hashed = encryptPassword($password);
                $random = $params['random'];
                $query = "INSERT INTO utilizador (password, email, telemovel,ano,idCurso,"
                    . " numeroCotas, idTipoUtilizador, estado, dataFinal, nomeUtilizador, numeroAluno, dataInicio, validada, random) "
                    . "VALUES ('$hashed', '$email', '$phone','$year','$course', '$quotas', '2', '0', '-', '$name', '$student_number', '-', '0', '$random')";
            } else {
                $response['cod'] = 502;
                $response['error'] = TRUE;
                $response['msg'] = mysqli_error($connection);
                return $response;
            }
        } elseif ($id === '2') {
            $idAssociate = $params['idAssociate'];
            $initialDate = $params['initialDate'];
            $finalDate = $params['finalDate'];
            $query = "UPDATE utilizador SET numeroAluno='$student_number', nomeUtilizador='$name', email='$email', telemovel='$phone', 
                ano='$year', dataFinal='$finalDate', idCurso='$course', dataInicio='$initialDate' WHERE idUtilizador='$idAssociate';";
        } elseif ($id === '1'){
            $idAssociate = $params['idAssociate'];
            $query = "UPDATE utilizador SET numeroAluno='$student_number', nomeUtilizador='$name', email='$email', telemovel='$phone', 
            ano='$year', idCurso='$course' WHERE idUtilizador='$idAssociate';";
        }
        $result = mysqli_query($connection, $query);
        if ($result) {
            $response['cod'] = 201;
            $response['error'] = FALSE;
            $response['msg'] = mysqli_insert_id();
        } else {
            $response['cod'] = 500;
            $response['error'] = TRUE;
            $response['msg'] = mysqli_error($connection);
        }

    } else {
        $response['cod'] = 501;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;
}

function changePassword($params)
{
    $response = array();
    $conn = dbConnect();
    $random = $params['random'];
    $password = $params['password'];
    $idAssociate = $params['idAssociate'];

    $query = "Select * From utilizador Where idUtilizador = '$idAssociate' and random = '$random'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) === 1) {
        $hashed = encryptPassword($password);
        $queryUpdate = "UPDATE utilizador SET password='$hashed' WHERE idUtilizador='$idAssociate' and random = '$random'";
        $resultUpdate = mysqli_query($conn, $queryUpdate) or die(mysqli_error($conn));
        if ($resultUpdate) {
            $response['cod'] = 201;
            $response['error'] = FALSE;
            $response['msg'] = 'Password changed';
        } else {
            $response['cod'] = 501;
            $response['error'] = TRUE;
            $response['msg'] = 'Error updating';
        }

    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = 'No user with that id and random';
    }

    mysqli_close($conn);
    return $response;
}


function encryptPassword($password)
{
// A higher "cost" is more secure but consumes more processing power
    $cost = 10;

// Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
//    $salt = random_bytes(5);
// Prefix information about the hash so PHP knows how to verify it later.
// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf("$2a$%02d$", $cost) . $salt;

// Value:
// $2a$10$eImiTXuWVxfM37uY4JANjQ==

// Hash the password with the salt
    $hash = crypt($password, $salt);
    return $hash;
}

/*
function encryptPassword($password)
{
// A higher "cost" is more secure but consumes more processing power
    $cost = 10;

// Create a random salt
//    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
    $salt1 = random_bytes(16);
    $salt = bin2hex($salt1);
// Prefix information about the hash so PHP knows how to verify it later.
// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    //   $salt = sprintf("$2a$%02d$", $cost) . $salt;

// Value:
// $2a$10$eImiTXuWVxfM37uY4JANjQ==

// Hash the password with the salt
    $hash = crypt($password, $salt);
    return $hash;
}
*/