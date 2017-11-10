<?php
/**
 * Created by PhpStorm.
 * User: Vitor
 * Date: 24/04/2017
 * Time: 15:05
 */

require_once dirname(__FILE__) . '/../connection/dbconnect.php';
require_once dirname(__FILE__) . '/../../../../../wp-load.php';

function addEditEventss($params)
{
    $response = array();
    $connection = dbConnect();
    $id = $params['idTest'];
    $designation = $params['designation'];
    $startDate = $params['startDate'];
    $finishDate = $params['finishDate'];
    $place = $params['place'];
    $speaker = $params['speaker'];
    $price = $params['price'];
    $description = $params['description'];
    $typeEvent = $params['typeEvent'];
    $vacancies = $params['vacancies'];
    $pageID = $params['pageID'];
    $hours = $params['hours'];
    $duration = $params['duration'];
    $link = $params['link'];
    $associatePrice = $params['priceAssociate'];

    if ($id == '0') {
        $query = "INSERT INTO evento (designacao, data_inicio, local, orador, preco, descricao, idTipoEvento, data_fim, vagas, hora, duracao, link, preco_associado) 
        VALUES ('$designation', '$startDate', '$place', '$speaker', '$price', '$description', '$typeEvent', '$finishDate', '$vacancies', '$hours', '$duration', '$link','$associatePrice')";

}
    elseif ($id == '1') {
        $idEvent= $params['idEvent'];
        $query = "UPDATE evento SET designacao='$designation', data_inicio='$startDate', 
                  local='$place', orador='$speaker', preco='$price', descricao='$description', 
                  idTipoEvento='$typeEvent', data_fim='$finishDate', vagas='$vacancies', hora='$hours', duracao='$duration', link='$link', preco_associado='$associatePrice' WHERE idEvento='$idEvent'";
    }
    $result = mysqli_query($connection, $query);

    if ($result) {
        $idEv = mysqli_insert_id($connection);
        $response['cod'] = 201;
        $response['error'] = FALSE;
        $response['msg'] = "Created Successful";
        if($speaker == ''){
            $speaker = 'N/A';
        }
        if($id == '0'){
            global $wpdb;
            $wpdb->insert('wp_posts', array('post_title' => $designation,
                'post_content' => '<div class="col-sm-8"><div class="content"><img src="'.$link.'" style="width:100%;margin: 0 auto;" alt="" class="img-responsive"><br><p>'.$description.'</p><div style="text-align: center"><input type="button" style="width:25%" class="btn btn-default" value="Inscrição" id="save-registration">  <div id="regist-validate-msg" style="color:Green; font-size:75%; display:none"></div><div id="regist-error-msg" style="color:Red; font-size:75%; display:none"></div></div></div></div><div class="col-sm-4"><div class="content"><ul class="event-listing"><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon glyphicon-calendar"> </span>' .$startDate.'</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-time"> </span> '.$hours.'h</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-play-circle"> </span>' .$duration.' minutos</li><li style="list-style: none;" class="event-listing""> <span class="glyphicon glyphicon-map-marker"> </span> '.$place.'</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-euro"> </span>' .$associatePrice.'(Sócios)</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-euro"> </span>' .$price.'(Não Sócios)</li><li style="list-style: none;" class="event-listing"><span class="glyphicon glyphicon-user"> </span>' .$speaker.'</li><li style="list-style: none;" class="event-listing"><span class="glyphicon glyphicon-exclamation-sign"> </span>' .$vacancies.'(Vagas)</li></ul></div></div>
                <br><input id="event-id" type="hidden" value="'.$idEv.'">',
                'post_status' => 'publish', 'post_author' => 1, 'post_type' => 'page', 'post_name' => '?page_id='.$pageID, 'guid'=> 'http://' . $_SERVER['HTTP_HOST'] . '/'.$idEv));
            $idWP = $wpdb->insert_id;
            $query1 = "UPDATE evento SET pageID='$idWP' WHERE idEvento='$idEv'";
            mysqli_query($connection, $query1);
            $response['id'] = $idWP;
        }elseif($id == '1'){
            global $wpdb;
            $wpdb->update('wp_posts', array('post_title' => $designation,
                'post_content' => '<div class="col-sm-8"><div class="content"><img src="'.$link.'" style="width:100%;margin: 0 auto;" alt="" class="img-responsive"><br><p>'.$description.'</p><div style="text-align: center"><input type="button" style="width:25%" class="btn btn-default" value="Inscrição" id="save-registration">  <div id="regist-validate-msg" style="color:Green; font-size:75%; display:none"></div><div id="regist-error-msg" style="color:Red; font-size:75%; display:none"></div></div></div></div><div class="col-sm-4"><div class="content"><ul class="event-listing"><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon glyphicon-calendar"> </span>' .$startDate.'</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-time"> </span> '.$hours.'h</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-play-circle"> </span>' .$duration.' minutos</li><li style="list-style: none;" class="event-listing""> <span class="glyphicon glyphicon-map-marker"> </span> '.$place.'</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-euro"> </span>' .$associatePrice.'(Sócios)</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-euro"> </span>' .$price.'(Não Sócios)</li><li style="list-style: none;" class="event-listing"><span class="glyphicon glyphicon-user"> </span>' .$speaker.'</li><li style="list-style: none;" class="event-listing"><span class="glyphicon glyphicon-exclamation-sign"> </span>' .$vacancies.'(Vagas)</li></ul></div></div>
                <br><input id="event-id" type="hidden" value="'.$idEvent.'">',
                'post_status' => 'publish', 'post_author' => 1, 'post_type' => 'page', 'post_name' => '?page_id='.$pageID, 'guid'=> 'http://' . $_SERVER['HTTP_HOST'] . '/'.$idEvent), array('ID' => $pageID));
        }
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;
}

function getEvent($params){
    $response = array();
    $connection = dbConnect();

        $query = "SELECT * FROM tipoevento, evento Where evento.idTipoEvento= tipoevento.idTipoEvento";
        $result = mysqli_query($connection, $query);

    if ($result) {
        while ($event = mysqli_fetch_array($result)) {
            $response[] = $event;
        }$response['cod'] = 200;
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }

    mysqli_close($connection);
    return $response;
}

function typeEvent($params){
    $response = array();
    $connection = dbConnect();
    $id = $params['id'];

    if($id == 1) {
        $query = "SELECT * FROM tipoevento";
    }else {
        $idTipo = $params['typeEvent'];
        $query = "SELECT * FROM tipoevento Where idTipoEvento='$idTipo'";
    }
    $result= mysqli_query($connection, $query);

    if ($result) {
        while ($typeEvent = mysqli_fetch_array($result)) {
            $response[] = $typeEvent;

        }$response['cod'] = 200;
    } else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;

}

function deleteEvent($params){
    $response = array();
    $connection = dbConnect();

    $idEvent = $params['idEvent'];
    $query1 = "SELECT * FROM evento WHERE idEvento='$idEvent'";
    $result1 = mysqli_query($connection, $query1);
    if($result1){
        $page = mysqli_fetch_array($result1);
        $pageID = $page['pageID'];
    }
    $query = "DELETE FROM evento WHERE idEvento='$idEvent'";
    $result = mysqli_query($connection, $query);

    if($result){
        global $wpdb;
        $wpdb -> delete('wp_posts', array('ID'=>$pageID));
        $response['cod'] = 200;
        $response['error'] = FALSE;
        $response['msg'] = 'Deleted';
    }else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;
}

function addTypeEvent($params){
    $response = array();
    $connection = dbConnect();

    $desig = $params['desig'];
    $color = $params['color'];
    $id = $params['id'];

    if($id == 1) {
        $query = "INSERT INTO tipoevento (desig, color) VALUES ('$desig', '$color')";
    }elseif ($id == 2){
        $idTipo = $params['typeEvent'];
        $query = "UPDATE tipoevento SET desig='$desig', color='$color' WHERE idTipoEvento='$idTipo'";
    }
    $result = mysqli_query($connection, $query);

    if($result){
        $response['cod'] = 201;
        $response['error'] = FALSE;
        $response['msg'] = 'Event type created';
    }else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;
}

function deleteTypeEvent($params){
    $response = array();
    $connection = dbConnect();

    $id = $params['typeEvent'];

    $query = "DELETE FROM tipoevento WHERE idTipoEvento='$id'";
    $result = mysqli_query($connection, $query);

    if($result){
        $response['cod'] = 200;
        $response['error'] = FALSE;
        $response['msg'] = 'Deleted';
    }else {
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($connection);
    }
    mysqli_close($connection);
    return $response;
}

function changeRegistrations($params){
    $response = array();
    $conn = dbConnect();
    $idEvent = $params['idEvent'];
    $open = $params['open'];
    $startDate = $params['startDate'];
    $place = $params['place'];
    $speaker = $params['speaker'];
    $price = $params['price'];
    $description = $params['description'];
    $vacancies = $params['vacancies'];
    $pageID = $params['pageID'];
    $hours = $params['hours'];
    $duration = $params['duration'];
    $associatePrice = $params['priceAssociate'];
    $link = $params['link'];
    $query = "UPDATE evento SET aberto='$open' WHERE idEvento='$idEvent'";
    $result = mysqli_query($conn,$query);

    if($result){
        global $wpdb;
        if($open == 1){
            $wpdb->update('wp_posts',array('post_content' => '<div class="col-sm-8"><div class="content"><img src="'.$link.'" style="width:100%;margin: 0 auto;" alt="" class="img-responsive"><br><p>'.$description.'</p><div style="text-align: center"><input type="button" style="width:25%" class="btn btn-default" value="Inscrição" id="save-registration">  <div id="regist-validate-msg" style="color:Green; font-size:75%; display:none"></div><div id="regist-error-msg" style="color:Red; font-size:75%; display:none"></div></div></div></div><div class="col-sm-4"><div class="content"><ul class="event-listing"><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon glyphicon-calendar"> </span>' .$startDate.'</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-time"> </span> '.$hours.'h</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-play-circle"> </span>' .$duration.' minutos</li><li style="list-style: none;" class="event-listing""> <span class="glyphicon glyphicon-map-marker"> </span> '.$place.'</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-euro"> </span>' .$associatePrice.'(Sócios)</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-euro"> </span>' .$price.'(Não Sócios)</li><li style="list-style: none;" class="event-listing"><span class="glyphicon glyphicon-user"> </span>' .$speaker.'</li><li style="list-style: none;" class="event-listing"><span class="glyphicon glyphicon-exclamation-sign"> </span>' .$vacancies.'(Vagas)</li></ul></div></div>
                <br><input id="event-id" type="hidden" value="'.$idEvent.'">'), array('ID' => $pageID));
        }else {
            $wpdb->update('wp_posts',array('post_content' => '<div class="col-sm-8"><div class="content"><img src="'.$link.'" style="width:100%;margin: 0 auto;" alt="" class="img-responsive"><br><p>'.$description.'</p><div style="text-align: center"> <div id="regist-validate-msg" style="color:Green; font-size:75%; display:none"></div><div id="regist-error-msg" style="color:Red; font-size:75%; display:none"></div></div></div></div><div class="col-sm-4"><div class="content"><ul class="event-listing"><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon glyphicon-calendar"> </span>' .$startDate.'</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-time"> </span> '.$hours.'h</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-play-circle"> </span>' .$duration.' minutos</li><li style="list-style: none;" class="event-listing""> <span class="glyphicon glyphicon-map-marker"> </span> '.$place.'</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-euro"> </span>' .$associatePrice.'(Sócios)</li><li style="list-style: none;" class="event-listing"> <span class="glyphicon glyphicon-euro"> </span>' .$price.'(Não Sócios)</li><li style="list-style: none;" class="event-listing"><span class="glyphicon glyphicon-user"> </span>' .$speaker.'</li><li style="list-style: none;" class="event-listing"><span class="glyphicon glyphicon-exclamation-sign"> </span>' .$vacancies.'(Vagas)</li></ul></div></div>
                <br><input id="event-id" type="hidden" value="'.$idEvent.'">'), array('ID' => $pageID));
        }
        $response['cod'] = 201;
        $response['error'] = FALSE;
        $response['msg'] = 'Changed';
    }else{
        $response['cod'] = 500;
        $response['error'] = TRUE;
        $response['msg'] = mysqli_error($conn);
    }
    mysqli_close($conn);
    return $response;
}
