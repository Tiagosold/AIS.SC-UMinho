<?php

try {
    $params = $_POST;

    $object = $params['object'];

    $function = $params['function'];




    /*
     * condição para verificar se o objecto passado como post existe, caso exista
     * faz o seu include, se não existir lança uma Exeption
     */
    if (file_exists(dirname(__FILE__) . "/functions/{$object}.php") == FALSE) {
        $response['msg'] = "the requested object don't exist!";
        $response['cod'] = 400;
        http_response_code(400);
        $response['error'] = TRUE;
        echo json_encode($response);
        return;
    } else {

        require_once dirname(__FILE__) . "/functions/{$object}.php";
    }

    // condição para verificar se a função passada como post existe, se não existir lança uma Exeption
    if (function_exists($function) == FALSE) {
        $response['msg'] = "the requested function don't exist!";
        $response['error'] = TRUE;
        $response['cod'] = 400;
        http_response_code(400);

        echo json_encode($response);
        return;
    }

    $response = $function($params);  //passa o que a função chamada retornar para a variavel resultado
    // passa para o formato JSon o que a função pedida retorna 
    $httpCod = $response['cod'];
    http_response_code($httpCod);
    unset($response['cod']);

    echo json_encode($response);
} catch (Exception $ex) {
    $response['msg'] = $ex->getMessage();
    $response['error'] = TRUE;
    $response['cod'] = $ex->getCode();
    http_response_code($ex->getCode());

    echo json_encode($response);
}


