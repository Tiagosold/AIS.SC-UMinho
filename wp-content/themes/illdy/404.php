<?php
/**
 *	The template for dispalying the archive.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<section id="blog">
				<div class="row row-404">
					<div class="col-md-2 text-right">
						<span class="error-code"><?php _e( '404', 'illdy' ) ?></span>
					</div>
					<div class="col-md-10">
						<h2><?php _e( 'OOOPS!', 'illdy' ) ?></h2>
						<p><?php _e( 'Página que está a tentar aceder não existe ou não tem permissões para a visualizar!', 'illdy' ) ?></p>
						<a href="<?php echo site_url() ?>" class="button" style="background-color: #1dafba;"><?php _e( 'Home', 'illdy' ) ?></a>
					</div>
				</div>
			</section><!--/#blog-->
		</div><!--/.col-sm-7-->
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>