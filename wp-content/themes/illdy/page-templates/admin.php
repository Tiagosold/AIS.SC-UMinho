<?php
/**
 *    Template name: Administrador
 *
 * @package WordPress
 * @subpackage illdy
 */
require_once 'wp-content/themes/illdy/session.php';
confirm_admin();
// Pear Mail Library
require_once "wp-content/themes/illdy/Mail-1.4.0/Mail.php";
include "wp-content/themes/illdy/Mail-1.4.0/mime.php";
?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Área Admin</title>
    <!-- Bootstrap core CSS -->
    <link href="/wp-content/themes/illdy/layout/css/bootstrap.min.css" rel="stylesheet">
    <link href="/wp-content/themes/illdy/layout/css/style-admin.css" rel="stylesheet">
    <link href="/wp-content/themes/illdy/js/jquery_ui/jquery-ui.css" rel="stylesheet">
    <link href="/wp-content/themes/illdy/layout/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="/wp-content/themes/illdy/layout/css/bootstrap-year-calendar.min.css" rel="stylesheet">
    <link href="/wp-content/themes/illdy/layout/css/buttons.dataTables.min.css" rel="stylesheet">
    <script src="/wp-content/themes/illdy/jsautoload/jquery-1.11.2.min.js"></script>
	<script src="/wp-content/themes/illdy/js/jquery.form.js"></script>
    <script src="/wp-content/themes/illdy/js/bootstrap.min.js"></script>
    <script src="/wp-content/themes/illdy/js/mbootstrap-year-calendar.min.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/mbootstrap-confirmation.min.js"></script>
    <script src="/wp-content/themes/illdy/js/jquery.dataTables.min.js"></script>
    <script src="/wp-content/themes/illdy/js/dataTables.buttons.min.js"></script>
    <script src="/wp-content/themes/illdy/js/buttons.print.min.js"></script>
    <script src="/wp-content/themes/illdy/js/jszip.min.js"></script>
    <script src="/wp-content/themes/illdy/js/buttons.html5.min.js"></script>
    <script src="/wp-content/themes/illdy/js/jquery_ui/jquery-ui.js"></script>
    <script src="/wp-content/themes/illdy/js/vAdmin.js"></script>
    <script src="/wp-content/themes/illdy/js/partner.js"></script>
    <script src="/wp-content/themes/illdy/js/events.js"></script>
    <script src="/wp-content/themes/illdy/js/finances.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vassociate.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vfunctions.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vregistrations.js"></script>
	    <script src="/wp-content/themes/illdy/jsautoload/vlogin.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">AIS UMinho</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Dashboard</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Bem vindo, Admin</a></li>
                <li><a href="wp-content/themes/illdy/session.php?logout">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<script>updateLayout();</script>
<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
                    <small>Gestão Núcleo de Estudantes de Sistemas de Informação</small>
                </h1>
            </div>
            <div class="col-md-2">
                <div class="dropdown create">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Visualizar Saldo
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a type="button" data-toggle="modal" data-target="#addPage"></a></li>
                        <li><a href="#" id="banc-acc">Conta Bancaria</a></li>
                        <li><a href="#" id="safe-acc">Conta Cofre</a></li>
                        <li><a href="#" id="total-acc">Saldo Total</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="/admin" class="list-group-item active main-color-bg">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
                    </a>
                    <a href="#" id="partners-view" class="list-group-item"><span class="glyphicon glyphicon-star"
                                                                                 aria-hidden="true"></span> Parcerias
                        <span
                        <button id="add-partner-button" class="badge" style="float: right; border: none" type="button">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                    </a>
                    <a href="#" id="events-view" class="list-group-item">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Eventos</a>
                    <a href="#" id="associate_view" class="list-group-item"><span class="glyphicon glyphicon-user"
                                                                                  aria-hidden="true"></span> Sócios </a>
                    <a href="#" id="transactions-view" class="list-group-item"><span class="glyphicon glyphicon-eur" aria-hidden="true"></span> Finanças
                        <button id="add-transaction-button" class="badge" style="float: right; border: none" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></a>
                </div>


            </div>
            <div class="col-md-9">
                <!-- Website Overview -->
                <div class=panel-default">
                    <div class="panel-heading main-color-bg">
                        <h3 class="panel-title">Website Overview</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3">
                            <div class="well dash-box">
                                <h2><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span
                                            id="users-count"></span></h2>
                                <h4>Sócios</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well dash-box">
                                <h2><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span
                                            id="partners-count"></span></h2>
                                <h4>Parcerias</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well dash-box">
                                <h2><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> <span
                                            id="event-count"></span></h2>
                                <h4>Eventos</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well dash-box">
                                <h2><span class="glyphicon glyphicon-eur" aria-hidden="true"></span><span id="balance-count"></span></h2>
                                <h4><span id="balance-total">Saldo Total</span></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Partners -->
                <div class="panel panel-default" id="open-partners">
                    <div class="panel-heading" id="partners-heading"><h3 class="panel-title">Parceiros</h3></div>
                    <div class="panel-body" id="partners-body"></div>
                </div>

                <!-- Registrations -->
                <div class="panel panel-default" id="open-registrations">
                    <div class="panel-heading" id="registration-heading">
                    </div>
                    <div class="panel-body" id="registration-body">
                    </div>
                </div>

                <!-- Latest Users -->
                <div class="panel panel-default" id="open-associates">
                    <div class="panel-heading" id="panel-heading"><h3 class="panel-title">Sócios</h3>
                    </div>
                    <div class="panel-body" id="panel-body">
                    </div>
                </div>

                <!-- Transactions -->
                <div class="panel panel-default" id="open-transactions">
                    <div class="panel-heading" id="transactions-heading"><h3 class="panel-title">Movimentos</h3></div>
                    <div class="panel-body" id="transactions-body">
                    </div>
                </div>

                <!--Calendar for events-->
                <div class="panel panel-default" id='calendar-appears'>
                    <div class="panel-heading"><h3 class="panel-title">Calendário</h3></div>
                    <div class="panel-body">
                        <div id="calendar" class="calendar">
                        </div>
                    </div>

                    <!-- Modal to add type Event-->
                    <div id="type-event-modal" class="modal fade" style="padding-right: 16px;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Tipo Evento</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal">
                                        <input type="hidden" name="type-event-index">
                                        <div class="form-group">
                                            <label for="min-date" class="col-sm-4 control-label">Designação</label>
                                            <div id="desigmsg" style="color:Red; font-size:75%; display:none"></div>
                                            <div class="col-sm-7" id="type-edit">
                                                <select id="type-event-desig" name="type-event-desig" type="text"
                                                        class="form-control"></select>
                                                <input id="type-event-desig-in" name="type-event-desig-in" type="text"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="min-date" class="col-sm-4 control-label">Cor</label>
                                            <div class="col-sm-2">
                                                <input name="type-event-color" id="type-event-color" type="color"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-default" id="show-event-modal">Voltar</a>
                                    <a type="button" class="btn btn-danger" id="delete-type-event">Eliminar</a>
                                    <a type="button" class="btn btn-warning" id="edit-type-event">Editar</a>
                                    <a type="button" class="btn btn-primary" id="create-type-event">Criar</a>
                                    <button type="button" class="btn btn-primary" id="save-type-event">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for adding event-->
                    <div id="event-modal" class="modal fade" style="padding-right: 16px;">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title pull-left">Evento</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="event-index">
                                    <input type="hidden" name="event-page-id">
                                    <input type="hidden" name="event-open">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label for="min-date" class="col-sm-4 control-label">Designação</label>
                                            <div id="eventmsg" style="color:Red; font-size:75%; display:none"></div>
                                            <div class="col-sm-7">
                                                <input name="event-name" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="locationmsg" style="color:Red; font-size:75%; display:none"></div>
                                            <label for="min-date" class="col-sm-4 control-label">Local</label>
                                            <div class="col-sm-7">
                                                <input name="event-location" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="speakermsg" style="color:Red; font-size:75%; display:none"></div>
                                            <label for="min-date" class="col-sm-4 control-label">Orador
                                                (Opcional)</label>
                                            <div class="col-sm-7">
                                                <input name="event-speaker" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="priceAmsg" style="color:Red; font-size:75%; display:none"></div>
                                            <label for="min-date" class="col-sm-4 control-label">Preço(Sócio)</label>
                                            <div class="col-sm-7">
                                                <input name="event-price-associate" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="pricemsg" style="color:Red; font-size:75%; display:none"></div>
                                            <label for="min-date" class="col-sm-4 control-label">Preço(Não
                                                Sócio)</label>
                                            <div class="col-sm-7">
                                                <input name="event-price" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="descriptionmsg"
                                                 style="color:Red; font-size:75%; display:none"></div>
                                            <label for="min-date" class="col-sm-4 control-label">Descrição</label>
                                            <div class="col-sm-7">
                                                <input name="event-description" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="vacanciesmsg" style="color:Red; font-size:75%; display:none"></div>
                                            <label for="min-date" class="col-sm-4 control-label">Vagas</label>
                                            <div class="col-sm-7">
                                                <input name="event-vacancies" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="hoursmsg" style="color:Red; font-size:75%; display:none"></div>
                                            <label for="min-date" class="col-sm-4 control-label">Hora
                                                (Ex.15;15:30)</label>
                                            <div class="col-sm-7">
                                                <input name="event-hour" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="durationmsg" style="color:Red; font-size:75%; display:none"></div>
                                            <label for="min-date" class="col-sm-4 control-label">Duração (Em
                                                minutos)</label>
                                            <div class="col-sm-7">
                                                <input name="event-duration" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="min-date" class="col-sm-4 control-label">Link Imagem
                                                (Opcional)</label>
                                            <div class="col-sm-7">
                                                <input name="event-link" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                         <span>
                                                <a href="#" class="btn btn-sm btn-info" id="add-type-button">
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </a>
                                            </span>
                                            <label for="min-date" class="col-sm-4 control-label">Tipo Evento</label>
                                            <div class="col-sm-7">
                                                <div id="typemsg" style="color:Red; font-size:75%; display:none"></div>

                                                <select id="event-type" name="event-type" type="text"
                                                        class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="min-date" class="col-sm-4 control-label">Data</label>
                                            <div class="col-sm-7">
                                                <div class="input-group input-daterange" data-provide="datepicker">
                                                    <input id="teste" name="event-start-date" type="text"
                                                           class="form-control">
                                                    <span class="input-group-addon">até</span>
                                                    <input name="event-end-date" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-warning" id="close-registrations"
                                            style="display:none">Fechar Inscrições
                                    </button>
                                    <button type="button" class="btn btn-warning" id="open-regist" style="display:none">
                                        Abrir Inscrições
                                    </button>
                                    <button type="button" class="btn btn-primary" id="save-event">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--
    <footer id="footer">
      <p>Copyright AdminStrap, &copy; 2017</p>
    </footer>
-->
<!-- Modals -->

<div id="update-modal" class="modal fade" style="padding-right: 16px;">
     <div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Editar Sócio</h4>
              </div>
			   <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <input type="hidden" id="hiddenID">
                            <label for="min-date" class="col-sm-4 control-label">Email</label>
                            <div id="update-email-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="update-email" name="update-email" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Nome</label>
                            <div id="update-name-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="update-name" name="update-name" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Telemóvel</label>
                            <div id="update-phone-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="update-phone" name="update-phone" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">NºEstudante</label>
                            <div id="update-number-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="update-number" name="update-number" type="text" class="form-control">
                            </div>
                        </div>
						<div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Data Inicial</label>
                            <div id="idatemsg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="initial_date" name="initial_date" type="text" class="form-control">
                            </div>
                        </div>
						<div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Data Final</label>
                            <div id="fdatemsg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="final_date" name="final_date" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Ano</label>
                            <div id="yearmsg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <select id="year_register" placeholder="Ano" name="ano">
									<option value="0">Ano que frequenta</option>
									<option value="1">1º</option>
									<option value="2">2º</option>
									<option value="3">3º</option>
									<option value="4">4º</option>
									<option value="5">5º</option>
								</select>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Curso</label>
                            <div id="coursemsg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                               <select id="course_register" name="curso">
									<option value="0">Selecione o curso que frequenta</option>
									<option value="1">MIEGSI</option>
									<option value="2">MIEGSI-PL</option>
									<option value="3">MSI</option>
									<option value="4">PDTSI</option>
								</select>
                            </div>
                        </div>
                    </form>
                </div>
				<div class="modal-footer">
                    <a type="button" class="btn btn-default" data-dismiss="modal">Voltar</a>
                    <button type="button" class="btn btn-primary" id="update">
                        Editar
                    </button>
                </div>
			</div>
	</div>
</div>

<!-- edit partners form !-->
<div id="partner-modal" class="modal fade" style="padding-right: 16px;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Parceiros</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="partner-index">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="min-date" class="col-sm-4 control-label">Designação</label>
                        <div id="partner-msg-name" style="color:Red; font-size:75%; display:none"></div>
                        <div class="col-sm-7">
                            <input name="partner-name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="partner-msg-startDate" style="color:Red; font-size:75%; display:none"></div>
                        <div id="partner-msg-finishDate" style="color:Red; font-size:75%; display:none"></div>
                        <label for="min-date" class="col-sm-4 control-label">Data</label>
                        <div class="col-sm-7">
                            <div class="input-group input-daterange" data-provide="datepicker">
                                <input name="partner-start-date" type="text" class="form-control">
                                <span class="input-group-addon">até</span>
                                <input name="partner-end-date" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min-date" class="col-sm-4 control-label">Observações</label>
                        <div id="partner-msg-observation" style="color:Red; font-size:75%; display:none"></div>
                        <div class="col-sm-7">
                            <input name="partner-observation" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="partner-msg-amount" style="color:Red; font-size:75%; display:none"></div>
                        <label for="min-date" class="col-sm-4 control-label">Montante</label>
                        <div class="col-sm-7">
                            <input name="partner-amount" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="partner-msg-benefits" style="color:Red; font-size:75%; display:none"></div>
                        <label for="min-date" class="col-sm-4 control-label">Prestações</label>
                        <div class="col-sm-7">
                            <input name="partner-benefits" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="partner-msg-image" style="color:Red; font-size:75%; display:none"></div>
                        <label for="min-date" class="col-sm-4 control-label">Imagem</label>
                        <div class="col-sm-7">
                            <input name="partner-image" type="text" class="form-control">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete-partner">Eliminar</button>
                <button type="button" class="btn btn-primary" id="save-partner">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- edit Transactions form !-->
<div id="transaction-modal" class="modal fade" style="padding-right: 16px;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Transações</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="transaction-index">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="min-date" class="col-sm-4 control-label">Descrição</label>
                        <div id="transaction-msg-description" style="color:Red; font-size:75%; display:none"></div>
                        <div class="col-sm-7">
                            <input name="transaction-description" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="transaction-msg-date" style="color:Red; font-size:75%; display:none"></div>
                        <label for="min-date" class="col-sm-4 control-label">Data Movimento</label>
                        <div class="col-sm-7">
                            <div class="input-group input-daterange" data-provide="datepicker">
                                <input name="transaction-date" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min-date" class="col-sm-4 control-label">Montante (ex:300.50)</label>
                        <div id="transaction-msg-value" style="color:Red; font-size:75%; display:none"></div>

                        <div class="col-sm-7">
                            <input name="transaction-value" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="transaction-msg-account" style="color:Red; font-size:75%; display:none"></div>
                        <label for="min-date" class="col-sm-4 control-label">Conta</label>
                        <div class="col-sm-7">
                            <select name="transaction-account" type="text" class="form-control">
                                <option value="1">Cofre</option>
                                <option value="2">Bancário</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="transaction-msg-type" style="color:Red; font-size:75%; display:none"></div>
                        <label for="min-date" class="col-sm-4 control-label">Tipo Movimento</label>
                        <div class="col-sm-7">
                            <select name="transaction-type" type="text" class="form-control">
                                <option value="1">Débito</option>
                                <option value="2">Crédito</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="delete-transaction">Eliminar</button>
                <button type="button" class="btn btn-primary" id="save-transaction">Guardar</button>
            </div>
        </div>
    </div>

</div>

<div id="dialogOK" title=""></div>
<?php
if(isset($_POST['validate'])){
    $email = $_POST['email'];
    sendEmail($email, 'Conta Validada', 'A sua conta foi validada pelo administrador, já pode iniciar sessão no Website  http://' . $_SERVER['HTTP_HOST']);
}
?>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>
