<?php
/**
 *	Template name: registration
 *
 *	The template for displaying Custom Page Template: No Sidebar.
 *
 *	@package WordPress
 *	@subpackage illdy
 */

    ?>
    <?php get_header();?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <section id="blog">
                    <?php
                    if(isset($_POST['regist'])) {
                        $random = $_POST['random'];
                        $email = $_POST['email'];
                        sendEmail($email, 'Registo AIS.SC', 'Aceda ao link seguinte para validar a sua conta 
                        http://' . $_SERVER['HTTP_HOST'] . '/confirmar-registo?id=' . $random);
                    }
                    if(isset($_POST['renew'])){
                        $random = $_POST['random'];
                        $email = $_POST['email'];
                        sendEmail($email, 'Renovar cotas AIS.SC', 'Aceda ao link seguinte para validar a renovação da sua conta
                        http://' . $_SERVER['HTTP_HOST'] . '/confirmar-registo?id=' . $random);
                    }
                    if(isset($_GET['id'])) {
                        $random = $_GET['id'];
                        ?>
                        <input id="randomValue" value="<?= $random ?>" type="hidden">
                        <h3 id="validateShow"></h3>
						<p>Não te esqueças que para a tua inscrição ser validada e passares a ter acesso a todas as vantagens de sócio, incluindo o login neste website, terás de proceder ao pagamento da(s) quota(s), junto de algum elemento da AIS.SC UMinho ou por transferência bancária.</p>
                        <ul>
                            <li> Proceder à transferência do valor correspondente para o IBAN: PT50 0035 0130 0000 5843 130 81 – Titular: AIS SC UMinho – Banco: CGD.</li>
                            <li> Enviar o comprovativo para aissc@dsi.uminho.pt com o assunto: Pagamento Sócio axxxxx.</li>
                            <li> Caso faças a transferência pelo site do teu banco, na descrição da mesma coloca o teu número de aluno para uma mais rápida identificação da transferência.</li>
                        </ul>
						<br>
                        <div id="giph-show"></div>
                        <br>
                        <script>validateUser($('#randomValue').val())</script>
                        <a href="<?php echo site_url() ?>" class="button" style="background-color: #1dafba;"><?php _e( 'Home', 'illdy' ) ?></a>
                        <?php
                    }
                    if(isset($_GET['foo'])){
                        ?>
                        <h3 id="validateFirst">Valide a sua conta no email que indicou</h3>
                        <a href="<?php echo site_url() ?>" class="button" style="background-color: #1dafba;"><?php _e( 'Home', 'illdy' ) ?></a>
                        <?php
                    }
                    if(isset($_GET['fo'])){
                        ?>
                        <h3 id="validateFirst">Valide a sua conta no email que indicou</h3>
                        <a href="<?php echo site_url() ?>" class="button" style="background-color: #1dafba;"><?php _e( 'Home', 'illdy' ) ?></a>
                        <?php
                    }
                    if(isset($_POST['forgot'])){
                        $random = $_POST['random'];
                        $email = $_POST['email'];
                        $id = $_POST['idAssociate'];
                        sendEmail($email, utf8_decode('Recuperar Password'),'Aceda ao seguinte link para criar uma nova password para a sua conta
                        http://' . $_SERVER['HTTP_HOST'] . '?reg=' . $random.'&ida='. $id);
                    }
                    ?>
                </section><!--/#blog-->
            </div><!--/.col-sm-12-->
        </div><!--/.row-->
    </div><!--/.container-->
    <?php get_footer();
?>