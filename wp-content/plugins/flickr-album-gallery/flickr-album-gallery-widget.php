<?php
/**
 * Adds widget.
 */
class Flickr_album_gallery extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
				'fa_gallery', // Base ID
				 ' Flickr Album gallery', // Name
			   array( 'description' => 'Display Flickr Album Gallery', 'text_domain'  ) // Args
			   );
	}
			     /*
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		  @param array $instance Saved values from database.
		 */

		  public function widget( $args, $instance ) {
		  	$Title    	=   apply_filters( 'flickr_widget_title', $instance['Title'] );
		  	echo $args['before_widget'];

		  	$FID	=   apply_filters( 'flickr_widget_shortcode', $instance['Shortcode'] );

		  	if(is_numeric($FID))
		  	{
		  		if ( ! empty( $instance['Title'] ) )
		  		{
		  			echo $args['before_title'] . apply_filters( 'widget_title', $instance['Title'] ). $args['after_title'];
		  		}
		  		echo do_shortcode( '[FAG id='.$FID.']' );
		  	} else {
		  		echo "<p>Sorry! No Flickr Album Gallery Shortcode Found.</p>";
		  	}
		  	echo $args['after_widget'];
		  	wp_reset_query();
		  }

	 /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
	 public function form( $instance )
	 {

	 	if ( isset( $instance[ 'Title' ] ) )
	 	{
	 		$Title = $instance[ 'Title' ];
	 	} else
	 	{
	 		$Title = "Flickr Album Gallery";
	 	}

	 	if ( isset( $instance[ 'Shortcode' ] ) )
	 	{
	 		$Shortcode = $instance[ 'Shortcode' ];
	 	} else
	 	{
	 		$Shortcode = "Select Any Flickr Album Gallery";
	 	}
	 	?>
	 	<p>
	 		<label for="<?php echo $this->get_field_id( 'Title' ); ?>"><?php _e( 'Widget Title' ); ?></label>
	 		<input class="widefat" id="<?php echo $this->get_field_id( 'Title' ); ?>" name="<?php echo $this->get_field_name( 'Title' ); ?>" type="text" value="<?php echo esc_attr( $Title ); ?>">
	 	</p>

	 	<p>
	 		<label for="<?php echo $this->get_field_id( 'Shortcode' ); ?>"><?php _e( 'Select Any' ); ?> (Required)</label>
	 		<?php
			/**
			 * Get All Flickr Shortcode Custom Post Type
			 */
			$FLICKR_CPT_Name = "fa_gallery";
			$FLICKR_All_Posts = wp_count_posts( $FLICKR_CPT_Name )->publish;
			global $All_Flickr;
			$All_Flickr = array('post_type' => $FLICKR_CPT_Name, 'orderby' => 'ASC', 'posts_per_page' => $FLICKR_All_Posts);
			$All_Flickr = new WP_Query( $All_Flickr );
			?>
			<select id="<?php echo $this->get_field_id( 'Shortcode' ); ?>" name="<?php echo $this->get_field_name( 'Shortcode' ); ?>" style="width: 100%;">
				<option value="Select Any Settings" <?php if($Shortcode == "Select Any Settings") echo 'selected="selected"'; ?>>Select Any Settings</option>
				<?php
				if( $All_Flickr->have_posts() ) {	 ?>
				<?php while ( $All_Flickr->have_posts() ) : $All_Flickr->the_post();
				$PostId = get_the_ID();
				$PostTitle = get_the_title($PostId);
				?>
				<option value="<?php echo $PostId; ?>" <?php if($Shortcode == $PostId) echo 'selected="selected"'; ?>><?php if($PostTitle) echo $PostTitle; else _e("No Title", FAGP_TEXT_DOMAIN); ?></option>
			<?php endwhile; ?>
			<?php
		}
		else
		{
			echo "<option>Sorry! No Flickr Album Gallery Shortcode Found.</option>";
		}
		?>
	</select>
</p>

<?php
}
public  function update( $new_instance, $old_instance )
{
	$instance = array();
	$instance['Title'] = ( ! empty( $new_instance['Title'] ) ) ? strip_tags( $new_instance['Title'] ) : '';
	$instance['Shortcode'] = ( ! empty( $new_instance['Shortcode'] ) ) ? strip_tags( $new_instance['Shortcode'] ) : 'Select Any Flickr Album Gallery';

	return $instance;
}
	} // end of class Flickr Album Gallery Shortcode Widget Class

// Register Flickr Album Gallery Shortcode Widget
	add_action( 'widgets_init', 'register_Flickr_album_gallery' );
	function register_Flickr_album_gallery()
	{
		register_widget( 'Flickr_album_gallery' );
	}?>