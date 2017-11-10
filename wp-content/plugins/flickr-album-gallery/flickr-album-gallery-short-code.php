<?php
add_shortcode( 'FAG', 'FlickerAlbumGalleryShortCode' );
function FlickerAlbumGalleryShortCode( $Id ) {

    ob_start();
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'fag-bootstrap-min-js', plugins_url('js/bootstrap.min.js', __FILE__ ), array('jquery'), false, true );
	wp_enqueue_script( 'fag-imagesloaded-pkgd-min-js', plugins_url('js/imagesloaded.pkgd.min.js', __FILE__ ), array('jquery'), false, true );
	wp_enqueue_script( 'fag-jquery-blueimp-gallery-min-js', plugins_url('js/jquery.blueimp-gallery.min.js', __FILE__ ), array('jquery'), false, true );
	wp_enqueue_script( 'fag-bootstrap-image-gallery-min-js', plugins_url('js/bootstrap-image-gallery.min.js', __FILE__ ), array('jquery'), false, true );
	wp_enqueue_script( 'fag-flickr-jquery-js', plugins_url('js/flickr-jquery.js', __FILE__ ), array('jquery'), false, true );
	
	//CSS
	wp_enqueue_style('fag-bootstrap-min-css', FAG_PLUGIN_URL.'css/bootstrap.min.css');
	wp_enqueue_style('fag-blueimp-gallery-min-css', FAG_PLUGIN_URL.'css/blueimp-gallery.min.css');
	wp_enqueue_style('fag-site-css', FAG_PLUGIN_URL.'css/site.css');
	wp_enqueue_style('fag-font-awesome-latest', FAG_PLUGIN_URL.'css/font-awesome-latest/css/font-awesome.min.css');
	
	if(isset($Id['id'])) {
		/**
		 * Load All Flickr Album Gallery Custom Post Type
		 */
			$FAG_CPT_Name = "fa_gallery";
			$AllGalleries = array(  'p' => $Id['id'], 'post_type' => $FAG_CPT_Name, 'orderby' => 'ASC', 'post_staus' => 'publish');
			$loop = new WP_Query( $AllGalleries );
			
			while ( $loop->have_posts() ) : $loop->the_post();
				/**
				 * Get All Photos from Gallery Details Post Meta
				 */
					$ID = get_the_ID();
					$FAG_Albums = unserialize(get_post_meta( $ID, 'fag_settings', true));
					foreach($FAG_Albums as $FAG_Album) {
						
						$FAG_API_KEY = $FAG_Album['fag_api_key'];
						$FAG_Album_ID = $FAG_Album['fag_album_id'];
						$FAG_Show_Title = $FAG_Album['fag_show_title'];
						$FAG_Custom_CSS = $FAG_Album['fag_custom_css'];
						?>
						<style>
						<?php echo $FAG_Custom_CSS; ?>
						
						.flickr-img-responsive {
							width:100% !important;
							height:auto !important;
							display:block !important;
						}
						.LoadingImg img {
							max-width: 45px;
							max-height: 45px;
							box-shadow:  none;
						}
						.weblizar-flickr-div{
						padding:10px;
						}
						@media (max-width: 786px){
							.col-md-3 {
								width:49.9%;
								float:left;
							}
						}
						.play-pause {
							display: none !important;
						}
						.gallery<?php echo $ID; ?> {
							overflow:hidden;
						}
						</style>
						<script type="text/javascript">
						jQuery(function() {
							// Engage gallery.
							jQuery('.gallery<?php echo $ID; ?>').flickr({
								apiKey: '<?php echo  $FAG_API_KEY; ?>',
								photosetId: '<?php echo $FAG_Album_ID; ?>'
							});
						});
						</script>

						
						<div class="gallery<?php echo $ID; ?>">
							<!-- Gallery Thumbnails -->
							<?php if($FAG_Show_Title == "yes") { ?>
							<h3 style="border-bottom: 1px solid;"><?php echo ucwords(get_the_title($ID)); ?></h3>
							<?php } ?>
							<div class="row">
								<div class="col-xs-12 spinner-wrapper">
									<div class="LoadingImg"><img src="<?php echo FAG_PLUGIN_URL."img/loading.gif"; ?>" /></div>
								</div>
								<div align="center" class="gallery-container"></div>
							</div>
						</div>
						<?php
					}// end of foreach
			endwhile;
			?>
			
			<!-- Blueimp gallery -->
			<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
				<div class="slides"></div>
				<h3 class="title"></h3>
				<a class="prev">‹</a>
				<a class="next">›</a>
				<a class="close">×</a>
				<a class="play-pause"></a>
				<ol class="indicator"></ol>
				<div class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" aria-hidden="true">&times;</button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body next"></div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default pull-left prev">
									<i class="glyphicon glyphicon-chevron-left"></i>
									<?php _e("Previous", FAG_TEXT_DOMAIN ); ?>
								</button>
								<button type="button" class="btn btn-primary next">
									<?php _e("Next", FAG_TEXT_DOMAIN ); ?>
									<i class="glyphicon glyphicon-chevron-right"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
			jQuery(function() {
				// Set blueimp gallery options
				jQuery.extend(blueimp.Gallery.prototype.options, {
					useBootstrapModal: false,
					hidePageScrollbars: false
				});
			});
			</script>
			
			<div align="center" style="font-size: small; margin-bottom:20px; margin-top:25px; width:100%; float: left;">
				Flickr Album Gallery Powered By: <a href="http://www.weblizar.com/" target="_blank">Weblizar</a>
			</div>
			<?php
	} else {
		echo "<div align='center' class='alert alert-danger'>".__("Sorry! Invalid Flickr Album Shortcode Embedded", FAG_TEXT_DOMAIN )."</div>";
	}
	wp_reset_query();
	return ob_get_clean();
}//end of shortcode function
?>
