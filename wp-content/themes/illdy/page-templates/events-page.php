<?php
/**
 *    Template name: events
 *
 * @package WordPress
 * @subpackage illdy
 */
?>
<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <section id="blog">
                    <div class="container">
                        <div class="row">
                            <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
                                <?php
                                if(isset($_SESSION['idType']) && ($_SESSION['idType']==2)){
                                    ?>
                                    <p style="color:red;"><a href="/lista-de-inscricoes" style="color:red;">Siga este link para ver a lista de eventos em que está inscrito!</a></p>
                                    <?php
                                }
                                ?>
                                <ul id="event-list" class="event-list">
                                </ul>
                                <script>showEvents()</script>
                            </div>
                        </div>
                    </div>
                    <div id="check-events"></div>
                </section><!--/#blog-->
            </div><!--/.col-sm-12-->
        </div><!--/.row-->
    </div><!--/.container-->
<?php get_footer(); ?>