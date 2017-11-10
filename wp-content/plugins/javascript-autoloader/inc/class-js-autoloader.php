<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( !class_exists( 'Javascript_Autoloader' ) ) { 

  class Javascript_Autoloader {
    public $_file;
    public $plugin_name;
    public $plugin_slug;
    public $version;
    private $wp_url;
    private $my_url;

    public function __construct( $file ) {
      $this->_file = $file;
      $this->plugin_name = 'JavaScript AutoLoader';
      $this->plugin_slug = 'javascript-autoloader';
      $this->version = '1.4';
      $this->init();
    }
    
    function init() {
      $this->wp_url = 'https://wordpress.org/plugins/' . $this->plugin_slug;
      $this->my_url = 'http://petersplugins.com/free-wordpress-plugins/' . $this->plugin_slug;
      add_action( 'init', array( $this, 'add_text_domain' ) );
      add_action( 'wp_enqueue_scripts', array( $this, 'jsautoloader' ), 999 );
      add_filter( 'plugin_action_links_' . plugin_basename( $this->_file ), array( $this, 'add_links' ) ); 
      add_action( 'admin_menu', array( $this, 'adminmenu' ) );
    }
    
    function add_text_domain () {
      load_plugin_textdomain( 'javascript-autoloader' );
    }
    
    // add like meta box 
    function show_meta_boxes() {
      ?>
      <div id="postbox-container-1" class="postbox-container">
        <div class="meta-box-sortables">
          <div class="postbox">
           <h3><span><?php _e( 'Like this Plugin?', 'javascript-autoloader' ); ?></span></h3>
            <div class="inside">
              <ul>
                <li><div class="dashicons dashicons-wordpress"></div>&nbsp;&nbsp;<a href="<?php echo $this->wp_url; ?>"><?php _e( 'Please rate the plugin', 'javascript-autoloader' ); ?></a></li>
                <li><div class="dashicons dashicons-admin-home"></div>&nbsp;&nbsp;<a href="<?php echo $this->my_url; ?>"><?php _e( 'Plugin homepage', 'javascript-autoloader'); ?></a></li>
                <li><div class="dashicons dashicons-admin-home"></div>&nbsp;&nbsp;<a href="http://petersplugins.com/"><?php _e( 'Author homepage', 'javascript-autoloader' );?></a></li>
                <li><div class="dashicons dashicons-googleplus"></div>&nbsp;&nbsp;<a href="http://g.petersplugins.com/"><?php _e( 'Authors Google+ Page', 'javascript-autoloader' ); ?></a></li>
                <li><div class="dashicons dashicons-facebook-alt"></div>&nbsp;&nbsp;<a href="http://f.petersplugins.com/"><?php _e( 'Authors facebook Page', 'javascript-autoloader' ); ?></a></li>
              </ul>
            </div>
          </div>
          <div class="postbox">
            <h3><span><?php _e( 'Need help?', 'javascript-autoloader' ); ?></span></h3>
            <div class="inside">
              <ul>
                <li><div class="dashicons dashicons-wordpress"></div>&nbsp;&nbsp;<a href="https://wordpress.org/support/plugin/<?php echo $this->plugin_slug; ?>"><?php _e( 'Take a look at the Support section', 'javascript-autoloader'); ?></a></li>
                <li><div class="dashicons dashicons-admin-comments"></div>&nbsp;&nbsp;<a href="http://petersplugins.com/contact/"><?php _e( 'Feel free to contact the Author', 'javascript-autoloader' ); ?></a></li>
              </ul>
            </div>
          </div>
          <div class="postbox">
            <h3><span><?php _e( 'Translate this Plugin', 'javascript-autoloader' ); ?></span></h3>
            <div class="inside">
              <p><?php _e( 'It would be great if you\'d support the JavaScript AutoLoader Plugin by adding a new translation or keeping an existing one up to date!', 'javascript-autoloader' ); ?></p>
              <p><a href="https://translate.wordpress.org/projects/wp-plugins/<?php echo $this->plugin_slug; ?>"><?php _e( 'Translate online', 'javascript-autoloader' ); ?></a></p>
            </div>
          </div>
        </div>
      </div>
      <?php
    }
    
    // returns an array of files to add
    function getFiles( $dir, $suffix='', $urlprefix='', $prefix='', $depth=0, $footer=0, $source ) {
      $dir = rtrim( $dir, '\\/' );
      $files = array();
      $result = array();
      if( $urlprefix != '' && substr( $urlprefix, -1 ) != '/' ) {
        $urlprefix .= '/';
      }
      $suffix = strtolower( $suffix );
      if ( file_exists( $dir ) ) {
        foreach ( scandir( $dir ) as $f ) {
          if ( $f !== '.' && $f !== '..' ) {
            if ( is_dir( "$dir/$f" ) && substr( $f, 0, 1 ) != '_' ) {
              if( $f == 'footer' || $footer == 1 ) {
                $ft = 1;
              } else {
                $ft = 0;
              }
              $result = array_merge( $result, $this->getFiles( "$dir/$f", "$suffix", "$urlprefix", "$prefix$f/", $depth+1, $ft, $source ) );
            } else {
              if ( $suffix=='' || ( $suffix != '' && strtolower( substr( $f, -strlen( $suffix ) ) ) == $suffix ) ) {
                $file['name'] = $urlprefix.$prefix.$f;
                $file['depth'] = $depth;
                $file['footer'] = $footer;
                $file['source'] = $source;
                $result[] = $file;
              }
            }
          }
        }
      }
      return $result;
    }

    // get an sorted array of all *.js files in all possible loactions 
    function getAllFiles() {
      $dir = 'jsautoload';
      $filesarray = array();
      if ( is_child_theme() ) { $filesarray = $this->getFiles( get_stylesheet_directory() . '/' . $dir, '.js', get_stylesheet_directory_uri() . '/' . $dir, '', 0, 0, 1 ); }
      $filesarray = array_merge( $filesarray, $this->getFiles( get_template_directory() . '/' . $dir, '.js', get_template_directory_uri(). '/' . $dir, '', 0, 0, 2 ) );
      $filesarray = array_merge( $filesarray, $this->getFiles( WP_CONTENT_DIR . '/' . $dir, '.js', content_url() . '/' . $dir, '', 0, 0, 3 ) );
      $files = array();
      $depth = array();
      $source = array();
      $footer = array();
      foreach ( $filesarray as $file ) {
        $files[] = $file['name'];
        $depth[] = $file['depth'];
        $source[] = $file['source'];
        $footer[] = $file['footer'];
      }
      array_multisort( $footer, SORT_NUMERIC, $source, SORT_NUMERIC, $depth, SORT_NUMERIC, $files, SORT_ASC, $filesarray );
      return $filesarray;
    }

    // adds an js file to header
    function add( $jsfile, $footer ) {
      wp_enqueue_script( 'swcc-js-autoloader-' . basename($jsfile), $jsfile, array(), false, ( $footer==1 ) );
    }

    // show admin page
    function showadmin() {
      if ( !current_user_can( 'activate_plugins' ) )  {
        wp_die( ___( 'You do not have sufficient permissions to access this page.' ) );
      }
      $dir = 'jsautoload'; 
      ?>
      <div class="wrap">
        <?php screen_icon(); ?>
        <h2 style="min-height: 32px; line-height: 32px; padding-left: 40px; background-image: url(<?php echo plugins_url( 'pluginicon.png', $this->_file ); ?>); background-repeat: no-repeat; background-position: left center"><a href="<?php echo $this->my_url; ?>"><?php echo $this->plugin_name; ?></a></h2>
        <hr />
        <p>Plugin Version: <?php echo $this->version; ?> <a class="dashicons dashicons-editor-help" href="https://wordpress.org/plugins/<?php echo $this->plugin_slug; ?>/changelog/"></a></p>
        <div id="poststuff">
          <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content">
              <div class="meta-box-sortables ui-sortable">
                <div class="postbox">
                  <h3><span><?php _e( 'Possible paths to store your JavaScript files', 'javascript-autoloader'); ?></span></h3>
                  <div class="inside">
                    <h4><?php _e( 'Child Theme Directory', 'javascript-autoloader'); ?></h4>
                    <p><?php 
                      if ( is_child_theme() ) {
                        echo __( 'Current Path', 'javascript-autoloader' ) . ': <code>' . get_stylesheet_directory() . '/' . $dir . '</code>';
                      } else {
                        _e( 'You are not using a Child Theme', 'javascript-autoloader' );
                      }
                    ?></p>
                    <h4><?php _e( 'Theme Directory', 'javascript-autoloader'); ?></h4>
                    <p><?php echo __( 'Current Path', 'javascript-autoloader' ) . ': <code>' . get_template_directory() . '/' . $dir; ?></code></p>
                    <h4><?php _e( 'General Directory', 'javascript-autoloader'); ?></h4>
                    <p><?php echo __( 'Current Path', 'javascript-autoloader' ) . ': <code>' . WP_CONTENT_DIR . '/' . $dir; ?></code></p>
                  </div>
                  <hr />
                  <h3><span><?php _e( 'Currently loaded JavaScript files (in that order)', 'javascript-autoloader'); ?></span></h3>
                  <div class="inside">
                    <?php $this->showcurrent(); ?>
                  </div>
                </div> 
              </div>
            </div>
            <?php $this->show_meta_boxes(); ?>
          </div>
          <br class="clear" />
        </div>    
      </div>
      <?php
    }

    // list cuurently loaded js files on admin page
    function showcurrent() {
      $filesarray = $this->getAllFiles();  
      if ( empty( $filesarray ) ) {
        echo '<p>' . __( 'no files loaded currently', 'javascript-autoloader' ) . '</p>';
      } else {
      $loc = -1;
        foreach ( $filesarray as $file ) {
          if ( $file['footer'] != $loc) {
            if ( $file['footer'] == 0) {
              echo '<p><strong>' . __('in Header', 'javascript-autoloader' ) . '</strong></p>';
              echo '<ul>';
            } else {
              if ( $loc != -1 ) {
                echo '</ul>';
              }
              echo '<ul>';
              echo '<p><strong>' . __( 'in Footer (be sure to call wp_footer() in your footer template!)', 'javascript-autoloader' ) . '</strong></p>';
            }
            $loc = $file['footer'];
          }
          echo '<li><code>' . $file['name'] . '</code></li>';
        }
        echo '</ul>';
      }
    }

    // init frontend
    function jsautoloader() {
      $filesarray = $this->getAllFiles();  
      foreach ( $filesarray as $file ) {
        $this->add( $file['name'], $file['footer'] );
      }
    }

    // init backend
    function adminmenu() {
      add_management_page( 'WP JS AutoLoader', 'JS AutoLoader', 'activate_plugins', 'wpjsautoloader', array( $this, 'showadmin' ) );
    }
    
    function add_links( $links ) {
      return array_merge( $links, array( '<a class="dashicons dashicons-editor-help" href="' . admin_url( 'tools.php?page=wpjsautoloader' ) . '"></a>', '<a href="https://wordpress.org/support/plugin/' . $this->plugin_slug . '/reviews/">' . __( 'Please rate Plugin', 'javascript-autoloader' ) .'</a>' ) );
    }
    
  }

}

?>