<?php
/**
 *    Template name: registrations-page
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
                    <?php
                        if(isset($_SESSION['idType']) && ($_SESSION['idType']==2)) {
                            ?>
                            <div class="panel panel-default" id="associate-registrations">
                                <div class="panel-heading" id="associate-heading">
                                </div>
                                <div class="panel-body" id="associate-body">
                                </div>
                                <script>getRegistrationsAssociate()</script>
                            </div>
                            <?php
                        }
                            ?>
                </section><!--/#blog-->
            </div><!--/.col-sm-12-->
        </div><!--/.row-->
    </div><!--/.container-->
<?php get_footer(); ?>