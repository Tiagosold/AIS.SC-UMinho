<?php
/**
 *    Template name: agenda
 *
 * @package WordPress
 * @subpackage illdy
 */
?>
<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <p style="font-size: 20px;margin-top: 20px">Caso pretenda inscrever-se num evento, clique com o botão direito no Evento e selecione "Inscrição".</p>
            <p style="font-size: 18px;padding-bottom: 15px"><a href="/inscricoes">Para obter mais informações sobre os eventos disponíveis, clique aqui.</a></p>
			<h4>Pagamento:</h4>
            <p>Não te esqueças que para a tua inscrição ser validada terás de proceder ao pagamento da mesma, junto de algum elemento da AIS.SC UMinho ou por transferência bancária.</p>
                        <ul>
                            <li> Proceder à transferência do valor correspondente para o IBAN: PT50 0035 0130 0000 5843 130 81 – Titular: AIS SC UMinho – Banco: CGD.</li>
                            <li> Enviar o comprovativo para aissc@dsi.uminho.pt com o assunto: Pagamento Inscrição - Nome da Atividade.</li>
                            <li> Caso faças a transferência pelo site do teu banco, na descrição da mesma coloca o teu número de aluno para uma mais rápida identificação da transferência.</li>
                        </ul>
            <?php
            if(isset($_SESSION['idType']) && ($_SESSION['idType']==2)){                ?>
                <p><a href="/lista-de-inscricoes" style="color:red;">Siga este link para ver a lista de eventos que está inscrito!</a></p>
                <?php
            }
            ?>
                            <!--Calendar for events-->
                            <div class="panel panel-default" id='calendar-appears'">
                            <div class="panel-heading">Calendário</div>
                            <div class="panel-body" id="body-calendar">
                                <div id="calendar" class="calendar">
                                </div>
                            </div>
        </div>
                            <script>agenda()</script>
        </div><!--/.row-->
    </div><!--/.container-->
<?php get_footer(); ?>