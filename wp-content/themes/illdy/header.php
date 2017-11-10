<?php
/**
 *    The template for displaying the header.
 *
 * @package    WordPress
 * @subpackage illdy
 */
?>
<?php
$logo_id = get_theme_mod('custom_logo');
$logo_image = wp_get_attachment_image_src($logo_id, 'full');
$text_logo = get_theme_mod('illdy_text_logo', __('Illdy', 'illdy'));
$jumbotron_general_image = get_theme_mod('illdy_jumbotron_general_image', esc_url(get_template_directory_uri() . '/layout/images/front-page/front-page-header.png'));
$jumbotron_single_image = get_theme_mod('illdy_jumbotron_enable_featured_image', false);
$jumbotron_parallax_enable = get_theme_mod('illdy_jumbotron_enable_parallax_effect', true);
$preloader_enable = get_theme_mod('illdy_preloader_enable', 1);

$style = '';

if (get_option('show_on_front') == 'page' && is_front_page()) {
    if ($jumbotron_general_image) {
        $style = 'background-image: url(' . esc_url($jumbotron_general_image) . ');';
    }
} else if ((is_single() || is_page()) && $jumbotron_single_image == true) {

    global $post;
    if (has_post_thumbnail($post->ID)) {
        $style = 'background-image: url(' . esc_url(get_the_post_thumbnail_url($post->ID, 'full')) . ');';
    } else {
        $style = 'background-image: url(' . get_header_image() . ');';
    }
} else {
    $style = 'background-image: url(' . get_header_image() . ');';
}

$url = get_theme_mod('header_image', get_theme_support('custom-header', 'default-image'));

// append the parallax effect
if ($jumbotron_parallax_enable == true) {
    $style .= 'background-attachment: fixed;';
}

if ((is_single() || is_page() || is_archive()) && get_theme_mod('illdy_archive_page_background_stretch') == 2) {
    $style .= 'background-size:contain;background-repeat:no-repeat;';
}
require_once 'session.php';
include "wp-content/themes/illdy/Mail-1.4.0/Mail.php";
include "wp-content/themes/illdy/Mail-1.4.0/mime.php";
require_once 'wp-content/themes/illdy/bd/functions/associate.php';

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ($preloader_enable == 1): ?>
    <div class="pace-overlay"></div>
<?php endif; ?>
<header id="header"
        class="<?php if (get_option('show_on_front') == 'page' && is_front_page()): echo 'header-front-page';
        else: echo 'header-blog'; endif; ?>" style="<?php echo $style ?>">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-xs-8">

                    <?php if (!empty($logo_image)) { ?>
                        <?php echo '<a href="' . esc_url(home_url()) . '"><img src="' . esc_url($logo_image[0]) . '" /></a>'; ?>
                    <?php } else { ?>
                        <?php if (get_option('show_on_front') == 'page') { ?>
                            <a href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr($text_logo); ?>"
                               class="header-logo"><?php echo esc_html($text_logo); ?></a>
                        <?php } else { // front-page option ?>
                            <a href="<?php echo esc_url(home_url()); ?>"
                               title="<?php echo esc_attr(get_bloginfo('name')); ?>"
                               class="header-logo"><?php echo esc_html(get_bloginfo('name')); ?></a>
                        <?php } ?>
                    <?php } ?>

                </div><!--/.col-sm-2-->
                <div class="col-sm-9 col-xs-4">
                    <nav class="header-navigation">
                        <?php
                        if (!isset($_SESSION['idType'])) {
                            wp_nav_menu(array(
                                'theme_location' => 'primary-menu',
                                'menu' => '',
                                'container' => false,
                                'menu_class' => 'clearfix',
                                'menu_id' => '',
                            ));
                        } else {
                            wp_nav_menu(array(
                                'theme_location' => 'new-menu',
                                'menu' => '',
                                'container' => false,
                                'menu_class' => 'clearfix',
                                'menu_id' => '',
                            ));
                        }
                        ?>
                    </nav>
                    <button class="open-responsive-menu"><i class="fa fa-bars"></i></button>
                </div><!--/.col-sm-10-->
            </div><!--/.row-->
        </div><!--/.container-->
    </div><!--/.top-header-->
    <nav class="responsive-menu">
        <ul>
            <?php
            if (!isset($_SESSION['idType'])) {
                wp_nav_menu(array(
                    'theme_location' => 'primary-menu',
                    'menu' => '',
                    'container' => '',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => '',
                    'menu_id' => '',
                    'items_wrap' => '%3$s',
                ));
            } else {
                wp_nav_menu(array(
                    'theme_location' => 'new-menu',
                    'menu' => '',
                    'container' => '',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => '',
                    'menu_id' => '',
                    'items_wrap' => '%3$s',
                ));
            }
            ?>
        </ul>
    </nav><!--/.responsive-menu-->
    <!-- Login interface -->
    <div id="loginJQ" style="display:none">
        <div class="row main">
            <div class="main-login main-center">
                <h1 class="title">Iniciar Sessão</h1>
                <form class="form-horizontal" method="post" action="#">
                    <div class="form-group">
                        <label for="email" class="cols-sm-2 control-label">Email</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                                   aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="email" id="email"
                                       placeholder="Introduz o teu email"/>
                            </div>
                            <div id="lemailmsg" style="color:Red; font-size:75%; display:none"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="cols-sm-2 control-label">Password</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                                   aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Introduz a password"/>
                            </div>
                            <div id="lpasswordmsg" style="color:Red; font-size:75%; display:none"></div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <button id="login" type="button" class="btn btn-primary btn-lg btn-block login-button">Iniciar
                            Sessão
                        </button>
                    </div>
                    <div class="login-register">
                        <a href="#" class="registarJQ">Registar</a>
                    </div>
                    <div class="login-register">
                        <a href="#" class="forgotJQ">Esqueceu-se da Password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Forgot Password Interface -->
    <div id="forgotJQ" style="display:none">
        <div class="row main">
            <div class="main-login main-center">
                <h1 class="title">Esqueceu-se da Password</h1>
                <form class="form-horizontal" method="post" action="#">
                    <div class="form-group">
                        <label for="email" class="cols-sm-2 control-label">Email</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                                   aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="email" id="email_forgot"
                                       placeholder="Introduz o teu email"/>
                            </div>
                            <div id="femailmsg" style="color:Red; font-size:75%; display:none"></div>
                            <div id="fconfirmmsg" style="color:green; font-size:75%; display:none"></div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <button id="forgot" type="button" class="btn btn-primary btn-lg btn-block login-button">Enviar
                        </button>
                    </div>
                    <div class="login-register">
                        <a href="#" class="header-button-one">Iniciar Sessão</a>
                    </div>
                    <div class="login-register">
                        <a href="#" class="registarJQ">Registar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Registration interface -->
    <div id="registarJQ" style="display:none">
        <div class="row main">
            <div class="main-login main-center1">
                <h1 class="title">Registo</h1>
                <form class="form-horizontal" method="post" action="#">
                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Nome</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="complete_name" id="complete_name"
                                       placeholder="Introduz o teu nome"/>
                            </div>
                            <div id="namemsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="cols-sm-2 control-label">Email</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                                   aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="email" id="email_register"
                                       placeholder="Introduz o teu Email"/>
                            </div>
                            <div id="emailmsg" style="color:Red; font-size:75%; display:none">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="cols-sm-2 control-label">Password</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                                   aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="password" id="password_register"
                                       placeholder="Introduz uma password"/>
                            </div>
                            <div id="passwordmsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm" class="cols-sm-2 control-label">Confirmar Password</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                                   aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="confirm_password"
                                       id="confirm_password" placeholder="Confirme a sua password"/>
                            </div>
                            <div id="confirmmsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Telemóvel</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone fa" aria-hidden="true"></i></span>
                                <input type="tel" class="form-control" name="regist_phone" id="regist_phone"
                                       placeholder="Introduz o teu número de telemóvel"/>
                            </div>
                            <div id="phonemsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Curso</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-graduation-cap fa"
                                                                   aria-hidden="true"></i></span>
                                <select id="course_register" name="curso">
                                    <option value="0">Selecione o curso que frequenta</option>
                                    <option value="1">MIEGSI</option>
                                    <option value="2">MIEGSI-PL</option>
                                    <option value="3">MSI</option>
                                    <option value="4">PDTSI</option>
                                </select>
                            </div>
                            <div id="coursemsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Número de Estudante</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-graduation-cap fa"
                                                                   aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="student_number" id="student_number"
                                       placeholder="Introduz o teu número de estudante"/>
                            </div>
                            <div id="studentmsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Ano</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar fa"
                                                                   aria-hidden="true"></i></span>
                                <select id="year_register" placeholder="Ano" name="ano">
                                    <option value="0">Ano que frequenta</option>
                                </select>
                            </div>
                            <div id="yearmsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Quotas</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                <select id="quotas" placeholder="NºCotas" name="quotas">
                                    <option value="0">Número de quotas</option>
                                </select>
                            </div>
                            <div id="quotasmsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>
                    <div id="confirmsg" style="color:green; font-size:50%; display:none"></div>
                    <div class="form-group ">
                        <button id="registo" type="button" class="btn btn-primary btn-lg btn-block login-button">
                            Registar
                        </button>
                    </div>
                    <div class="login-register">
                        <a href="#" class="header-button-one">Iniciar Sessão</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Quotas Interface-->
    <div id="quotasJQ" style="display:none">
        <div class="row main">
            <div class="main-login main-center">
                <h1 class="title">Renovar Cotas</h1>
                <form class="form-horizontal" method="post" action="#">
                    <div class="form-group">
                        <label for="email" class="cols-sm-2 control-label">Email</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                                   aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="email" id="email-quotas"
                                       placeholder="Introduz o teu email"/>
                            </div>
                            <div id="qemailmsg" style="color:Red; font-size:75%; display:none"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="cols-sm-2 control-label">Password</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                                   aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="password" id="password-quotas"
                                       placeholder="Introduz a password"/>
                            </div>
                            <div id="qpasswordmsg" style="color:Red; font-size:75%; display:none"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Quotas</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                <select id="quotas-renew" name="quotas-renew">
                                    <option value="0">Selecione o número de cotas</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div id="quotasmsg" style="color:Red; font-size:50%; display:none"></div>
                        </div>
                    </div>
                    <div id="qerrormsg" style="color:Red; font-size:75%; display:none"></div>
                    <div id="qokmsg" style="color:Green; font-size:75%; display:none"></div>
                    <div class="form-group ">
                        <button id="renew" type="button" class="btn btn-primary btn-lg btn-block login-button">Renovar
                            Cotas
                        </button>
                    </div>
                    <div class="login-register">
                        <a class="payment-go" href="#">Pagamento</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xs-offset-1 col-sm-offset-3 col-md-offset-3 col-lg-offset-4">
                <!-- User profile  -->
                <div class="panel panel-info" id="profile-information">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3" align="center">
                                <div id="image-place"></div>
                                <br>
                                <form method="post" enctype="multipart/form-data">
                                    <label class="btn btn-default btn-file" style="font-size:small">
                                        Imagem <input name="file-selected" type="file" style="display:none">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152"/>
                                    </label>
                                    <p id="image-selected"></p>
                                    <button data-original-title="Confirmar imagem" type="submit"
                                            onsubmit="submitImage();" style="display: none;" data-toggle="tooltip"
                                            class="btn btn-sm btn-success" id="change-image"><i
                                                class="glyphicon glyphicon-ok"></i></button>
                                </form>
                                <?php
                                if (isset($_FILES['file-selected'])) {
                                    $uploadfile = $_FILES["file-selected"]["tmp_name"];
                                    $folder = "wp-content/themes/illdy/uploads/";
                                    $validate = getimagesize($uploadfile);
                                    $allowedExts = array("gif", "jpeg", "jpg", "png");
                                    $extension = end(explode(".", $_FILES["file-selected"]["name"]));
                                    if ((($_FILES["file-selected"]["type"] == "image/gif")
                                            || ($_FILES["file-selected"]["type"] == "image/jpeg")
                                            || ($_FILES["file-selected"]["type"] == "image/jpg")
                                            || ($_FILES["file-selected"]["type"] == "image/png"))
                                        && ($_FILES['file-selected']['error'] != 2)
                                        && in_array($extension, $allowedExts)
                                        && ($validate[0] != 0)
                                    ) {
                                        move_uploaded_file($_FILES["file-selected"]["tmp_name"], $folder . $_FILES["file-selected"]["name"]);
                                        $params = array();
                                        $params['id'] = 2;
                                        $params['idAssociate'] = $_SESSION['idAssociate'];
                                        $params['image'] = $_FILES["file-selected"]["name"];
                                        changeAssociateState($params);
                                        $_SESSION['image'] = $_FILES["file-selected"]["name"];
                                    }
                                }
                                ?>
                            </div>
                            <div class=" col-md-9 col-lg-9 ">
                                <table id='userTable' class="table table-user-information">
                                    <tbody id="userBody">
                                    <div id="dialog-associate" title="Atualização"></div>
                                    </tbody>
                                </table>
                                <!--
                                                        <a href="#" class="btn btn-primary">My Sales Performance</a>
                                                        <a href="#" class="btn btn-primary">Team Sales Performance</a>
                                                        -->
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a href="wp-content/themes/illdy/session.php?logout" data-original-title="Logout"
                           data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i
                                    class="glyphicon glyphicon-remove"></i></a>
                        <span id="edit-clear" class="pull-right">
                            <a data-original-title="Editar perfil" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-warning" id="edit-button"><i class="glyphicon glyphicon-edit"></i></a>
                        </span>
                        <span id="confirm-info" class="pull-right">
                    <button data-original-title="Confirmar mudanças" data-toggle="confirmation"
                            class="btn btn-sm btn-success" id="confirm-button"><i
                                class="glyphicon glyphicon-ok"></i></button>
                    <button data-original-title="Perfil" data-toggle="tooltip" class="btn btn-sm btn-info"
                            id="profile-again"><i class="glyphicon glyphicon-user"></i></button>
                </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input id="hiddenAssociateId" type="hidden" value="<?= $_SESSION['idAssociate'] ?>">
    <input id="hiddenControl" type="hidden" value="foo">
    <input type="hidden" id="expired-session" value="<?= $_SESSION['expired'] ?>">
    <div id="image-upload">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" id="upload_file" name="upload_file"/>
            <input type="submit" name='submit_image' value="Upload Image"/>
        </form>
    </div>
    <div id="registration-modal" class="modal fade" style="padding-right: 16px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Inscrição</h4>
                </div>
                <div class="modal-body">
				<p>Nota: Caso seja sócio, inicie sessão na plataforma para se inscrever. Esta caixa de inscrição é destinada apenas para não sócios!</p>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <input type="hidden" id="event-id-reg">
                            <label for="min-date" class="col-sm-4 control-label">Nome</label>
                            <div id="regist-name-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="regist-name" name="regist-name" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Número Aluno</label>
                            <div id="regist-number-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="regist-number" name="regist-number" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Email</label>
                            <div id="regist-email-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="regist-email" name="regist-email" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Telemóvel</label>
                            <div id="regist-phone-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <input id="regist-phone" name="regist-phone" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="min-date" class="col-sm-4 control-label">Ano</label>
                            <div id="regist-year-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                                <select id="year-event-regist" placeholder="Ano" name="ano">
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
                            <div id="course-year-msg" style="color:Red; font-size:75%; display:none"></div>
                            <div class="col-sm-7" id="type-edit">
                               <select id="course-event-regist" name="curso">
                                    <option value="0">Selecione o curso que frequenta</option>
                                    <option value="MIEGSI">MIEGSI</option>
                                    <option value="MIEGSI-PL">MIEGSI-PL</option>
                                    <option value="MSI">MSI</option>
                                    <option value="PDTSI">PDTSI</option>
									<option value="Outro">Outro</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-default" data-dismiss="modal">Voltar</a>
                    <button type="button" class="btn btn-primary" id="save-user-registration">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $_SESSION['idType'] ?>" id="user-type">
    <?php
    if (get_option('show_on_front') == 'page' && is_front_page()):
        get_template_part('sections/front-page', 'bottom-header');
    else:
        get_template_part('sections/blog', 'bottom-header');
    endif;
    ?>
    <script src="/wp-content/themes/illdy/jsautoload/jquery.js"></script>
    <script src="/wp-content/themes/illdy/js/jquery.form.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/lbootstrap.min.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vfunctions.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vlogin.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/mbootstrap-confirmation.min.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/mbootstrap-year-calendar.min.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vassociate.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vjquery.dataTables.min.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vpayment.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/vregistrations.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/zdataTables.buttons.min.js"></script>
    <script src="/wp-content/themes/illdy/jsautoload/zzbuttons.print.min.js"></script>
    <link href="/wp-content/themes/illdy/js/jquery_ui/jquery-ui.css" rel="stylesheet">
    <link href="/wp-content/themes/illdy/layout/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="/wp-content/themes/illdy/layout/css/bootstrap-year-calendar.min.css" rel="stylesheet">
    <link href="/wp-content/themes/illdy/layout/css/buttons.dataTables.min.css" rel="stylesheet">
    <script src="/wp-content/themes/illdy/js/jquery_ui/jquery-ui.js"></script>
</header><!--/#header-->

