<?php
/**
 *    The template for displaying the testimonials section in front page.
 *
 * @package WordPress
 * @subpackage illdy
 */
?>
<?php
if (current_user_can('edit_theme_options')) {
    $general_title = get_theme_mod('illdy_testimonials_general_title', __('Testimonials', 'illdy'));
    $general_background_image = get_theme_mod('illdy_testimonials_general_background_image', '');
    $number_of_posts = get_theme_mod('illdy_testimonials_number_of_posts', absint(4));
} else {
    $general_title = get_theme_mod('illdy_testimonials_general_title');
    $general_background_image = get_theme_mod('illdy_testimonials_general_background_image');
    $number_of_posts = get_theme_mod('illdy_testimonials_number_of_posts', absint(4));
}

if (isset($_GET['reg'])){
    ?>
	<script>newPass();</script>
    <input type="hidden" value="<?=$_GET['ida']?>" id="idNewPass">
    <input type="hidden" value="<?=$_GET['reg']?>" id="randomNewPass">
    <div id="newPassJQ">
    <a class="close" href="#"><img src="/wp-content/themes/illdy/layout/images/close.png"
                                   alt="" style="width:80px;height:80px"></a>
    <h3 class="loginh1">Nova Password</h3>
    <p class="status"></p>
    <input id="new-password-create" placeholder="Nova Password" type="password" name="password">
    <div id="password-new-msg" style="color:Red; font-size:75%; display:none"></div>
    <input id="new-password-confirm" placeholder="Confirmar Password" type="password" name="confirm_password">
    <div id="confirm-new-msg" style="color:Red; font-size:75%; display:none"></div>
        <div id="nconfirmmsg" style="color:green; font-size:75%; display:none"></div>
    <input id="newPass" type="button" value="Enviar" name="newPass">
</div>
<?php
}
?>


<div id="dialogOK" title=""></div>
<!-- Login layout-->
<!--
<div id="loginJQ">
    <a class="close" href="#"><img src="/wordpress/wp-content/themes/illdy/layout/images/close.png"
                                   alt="" style="width:80px;height:80px"></a>
    <h3 class="loginh1">Iniciar Sessão</h3>
    <p class="status"></p>
    <input id="email" type="email" name="email" placeholder="Email" required>
    <div id="lemailmsg" style="color:Red; font-size:75%; display:none"></div>
    <input id="password" placeholder="Password" type="password" name="password" style=";" required>
    <div id="lpasswordmsg" style="color:Red; font-size:75%; display:none"></div>
    <input id="login" type="button" value="Login" name="login">
    <a class="registarJQ" href="#">Registar</a>
    <a class="forgotJQ" href="#">Esqueceu-se da password?</a>
</div>
-->
<!-- Forget Password layout-->
<!--
<div id="forgotJQ">
    <a class="close" href="#"><img src="/wordpress/wp-content/themes/illdy/layout/images/close.png"
                                   alt="" style="width:80px;height:80px"></a>
    <h6 class="loginh1">Esqueceu-se da password</h6>
    <p class="status"></p>
    <input id="email_forgot" type="email" name="email" placeholder="Email" required>
    <div id="femailmsg" style="color:Red; font-size:75%; display:none"></div>
    <div id="fconfirmmsg" style="color:green; font-size:75%; display:none"></div>
    <input id="forgot" type="button" value="Enviar" name="forgot">
    <a class="header-button-one" href="#">Iniciar Sessão</a>
    <a class="registarJQ" href="#">Registar</a>
</div>-->

<!-- Regist layout-->
<!--
<div id="registarJQ">
    <a class="close" href="#"><img src="/wordpress/wp-content/themes/illdy/layout/images/close.png"
                                   alt="" style="width:80px;height:80px"></a>
    <h3 class="loginh1">Registar</h3>
    <p class="status"></p>
    <input id="email_register" type="email" name="email" placeholder="Endereço de email">
    <div id="emailmsg" style="color:Red; font-size:75%; display:none">
</div>
<input id="complete_name" type="text" name="complete_name" placeholder="Nome completo">
<div id="namemsg" style="color:Red; font-size:50%; display:none"></div>
<input id="password_register" placeholder="Password" type="password" name="password">
<div id="passwordmsg" style="color:Red; font-size:50%; display:none"></div>
<input id="confirm_password" placeholder="Confirmar Password" type="password" name="confirm_password">
<div id="confirmmsg" style="color:Red; font-size:50%; display:none"></div>
<input id="regist_phone" placeholder="Número de Telemóvel" type="tel" name="tel">
<div id="phonemsg" style="color:Red; font-size:50%; display:none"></div>
<div class="select-style">
    <select id="user_type">
        <option value="0">Tipo de utilizador</option>
        <option value="2">Sócio</option>
        <option value="3">Ex-aluno</option>
    </select>
</div>
    <div id="usermsg" style="color:Red; font-size:50%; display:none"></div>
<p></p>
<div class="select-style">
    <select id="course_register" name="curso">
        <option value="0">Selecione o curso que frequenta</option>
        <option value="1">MIEGSI</option>
        <option value="2">MIEGSI-PL</option>
        <option value="3">MSI</option>
        <option value="4">PDTSI</option>
    </select>
</div>
    <div id="coursemsg" style="color:Red; font-size:50%; display:none"></div>
<div class="hidden-div">
    <input id="student_number" type="text" name="student_number" placeholder="Número de estudante">
    <div id="studentmsg" style="color:Red; font-size:50%; display:none"></div>
    <p></p>
    <div class="select-style">
        <select id="year_register" placeholder="Ano" name="ano">
            <option value="0">Ano que frequenta</option>
        </select>
    </div>
    <div id="yearmsg" style="color:Red; font-size:50%; display:none"></div>

    <p></p>
    <div class="select-style">
        <select id="quotas" placeholder="NºCotas" name="quotas">
            <option value="0">Número de quotas</option>
        </select>
    </div>
    <div id="quotasmsg" style="color:Red; font-size:50%; display:none"></div>
</div>
    <div id="confirmsg" style="color:green; font-size:50%; display:none"></div>
    <input id="registo" type="button" value="Registar" name="registo">
    <?//php echo do_shortcode('[qpp]'); ?>
<a class="header-button-one" href="#">Iniciar Sessão</a>
</div>
-->

<!--
<div id="quotasJQ">
    <a class="close" href="#"><img src="/wordpress/wp-content/themes/illdy/layout/images/close.png"
                                   alt="" style="width:80px;height:80px"></a>
    <h3 class="loginh1">Renovar</h3>
    <p class="status"></p>
    <input id="email-quotas" type="email" name="email" placeholder="Email" required>
    <div id="qemailmsg" style="color:Red; font-size:75%; display:none"></div>
    <input id="password-quotas" placeholder="Password" type="password" name="password" required>
    <div id="qpasswordmsg" style="color:Red; font-size:75%; display:none"></div>
    <div class="select-style">
        <select id="quotas-renew" name="quotas-renew">
            <option value="0">Selecione o número de cotas</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div id="qerrormsg" style="color:Red; font-size:75%; display:none"></div>
    <div id="qokmsg" style="color:Green; font-size:75%; display:none"></div>
    <input id="renew" type="button" value="Renovar" name="renew">
    <a class="payment-go" href="#">Pagamento</a>
</div>
-->
<div id="paymentJQ">
     <a class="close" href="#"><img src="/wp-content/themes/illdy/layout/images/close.png"
                                   alt="" style="width:80px;height:80px"></a>
    <h3 class="loginh1">Pagamento</h3>
    <p class="status"></p>
    <ul>
        <li> Proceder à transferência do valor correspondente para o IBAN: PT50 0035 0130 0000 5843 130 81 – Titular: AIS SC UMinho – Banco: CGD.</li>
        <li> Enviar o comprovativo para aissc@dsi.uminho.pt com o assunto: Pagamento Sócio axxxxx.</li>
        <li> Caso faças a transferência pelo site do teu banco, na descrição da mesma coloca o teu número de aluno para uma mais rápida identificação da transferência.</li>
    </ul>
    
    <div id="perrormsg" style="color:Red; font-size:75%; display:none"></div>
    <div id="pokmsg" style="color:Green; font-size:75%; display:none"></div>
    <a class="header-button-two" href="#">Renovar</a>
</div>

<section id="testimonials" class="front-page-section"
         style="<?php if ($general_background_image): echo 'background-image: url(' . esc_url($general_background_image) . ')'; endif; ?>">
    <?php if ($general_title):?>
        <div class="section-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h3><?php echo do_shortcode(wp_kses_post($general_title)); ?></h3>
                    </div><!--/.col-sm-12-->
                </div><!--/.row-->
            </div><!--/.container-->
        </div><!--/.section-header-->
    <?php endif; ?>
    <div class="section-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 no-padding">
                    <div class="testimonials-carousel owl-carousel-enabled">
                        <?php
                        if (is_active_sidebar('front-page-testimonials-sidebar')):
                            dynamic_sidebar('front-page-testimonials-sidebar');
                        elseif (current_user_can('edit_theme_options') & defined("ILLDY_COMPANION")):
                            $the_widget_args = array(
                                'before_widget' => '<div class="widget_illdy_testimonial">',
                                'after_widget' => '</div>',
                                'before_title' => '',
                                'after_title' => ''
                            );

                            the_widget('Illdy_Widget_Testimonial', 'name=' . __('Jane Smith', 'illdy') . '&image=' . get_template_directory_uri() . '/layout/images/front-page/front-page-testimonial-1.jpg&testimonial=' . __('Awesome theme with great design and helpfull support. If you do not know how to code your own WordPress theme, but you still want a good-looking website for your business, Illdy might be exactly what you need. It is a slick theme with a lot of of features to choose from. You can customize whatever section you  want and you can rest assure that no matter what device your website is viewed on it looks  great.', 'illdy'), $the_widget_args);
                            the_widget('Illdy_Widget_Testimonial', 'name=' . __('Jane Smith', 'illdy') . '&image=' . get_template_directory_uri() . '/layout/images/front-page/front-page-testimonial-1.jpg&testimonial=' . __('Awesome theme with great design and helpfull support. If you do not know how to code your own WordPress theme, but you still want a good-looking website for your business, Illdy might be exactly what you need. It is a slick theme with a lot of of features to choose from. You can customize whatever section you  want and you can rest assure that no matter what device your website is viewed on it looks  great.', 'illdy'), $the_widget_args);
                            the_widget('Illdy_Widget_Testimonial', 'name=' . __('Jane Smith', 'illdy') . '&image=' . get_template_directory_uri() . '/layout/images/front-page/front-page-testimonial-1.jpg&testimonial=' . __('Awesome theme with great design and helpfull support. If you do not know how to code your own WordPress theme, but you still want a good-looking website for your business, Illdy might be exactly what you need. It is a slick theme with a lot of of features to choose from. You can customize whatever section you  want and you can rest assure that no matter what device your website is viewed on it looks  great.', 'illdy'), $the_widget_args);
                        endif;
                        ?>

                    </div><!--/.testimonials-carousel.owl-carousel-enabled-->
                </div><!--/.col-sm-10.col-sm-offset-1.no-padding-->
            </div><!--/.row-->
        </div><!--/.container-->
    </div><!--/.section-content-->
</section><!--/#testimonials.front-page-section-->
