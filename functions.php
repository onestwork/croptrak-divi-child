<?php

// redirect solution
add_action( 'template_redirect', 'croptrak_redirect_solutions' );
function croptrak_redirect_solutions() {
  if ( is_singular( 'solution' ) ) :
    wp_redirect( get_permalink(15), 301 );
    exit;
  endif;
}

// WP-LOGIN
function croptrak_custom_login() {
  echo '<link media="all" type="text/css" href="'.get_stylesheet_directory_uri().'/assets/css/login-style.css" rel="stylesheet">';
  $logo = '';
  if ( function_exists( 'et_get_option' )) {
    $logo = et_get_option( 'divi_logo' );
  }
  if ($logo) {
  ?>
    <style type="text/css" media="screen">
      body.login {
        border-top: 4px solid #78B96D;
        background-color: #F2F1EF;
      }
      body.login h1 a {
        background-image: url(<?php echo $logo; ?>);
        background-size: contain;
        background-position: center center;
      }
    </style>
  <?php
  }
}

function croptrak_custom_wp_login_url() {
  return home_url();
}
function croptrak_custom_wp_login_title() {
  return get_option('blogname');
}
add_action( 'login_head', 'croptrak_custom_login' );
add_filter('login_headerurl', 'croptrak_custom_wp_login_url');
add_filter('login_headertext', 'croptrak_custom_wp_login_title');

// DISABLE DEFAULT WIDGETS
function disable_default_dashboard_widgets() {
  remove_meta_box('dashboard_browser_nag', 'dashboard', 'core');
  remove_meta_box('dashboard_right_now', 'dashboard', 'core');
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
  remove_meta_box('dashboard_plugins', 'dashboard', 'core');
  remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
  remove_meta_box('dashboard_primary', 'dashboard', 'core');
  remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

// allow upload extra filetypes
function allow_svg($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'allow_svg');

function fix_mime_type_svg($data = null, $file = null, $filename = null, $mimes = null) {
  $ext = isset($data['ext']) ? $data['ext'] : '';
  if (strlen($ext) < 1) {
    $exploded=explode('.', $filename);
    $ext=strtolower(end($exploded));
  }
  if ($ext==='svg') {
    $data['type']='image/svg+xml' ;
    $data['ext']='svg' ;
  } elseif ($ext==='svgz') {
    $data['type']='image/svg+xml' ;
    $data['ext']='svgz' ;
  }
  return $data;
}
add_filter('wp_check_filetype_and_ext', 'fix_mime_type_svg', 75, 4);

// enqueue styles and scripts
function croptrak_theme_enqueue_styles() {
	wp_enqueue_style( 'croptrak-style', get_stylesheet_directory_uri() . '/assets/css/main.css' );
}
add_action( 'wp_enqueue_scripts', 'croptrak_theme_enqueue_styles' );
add_action( 'admin_enqueue_scripts', 'croptrak_theme_enqueue_styles' );

function croptrak_theme_enqueue_scripts() {
  wp_enqueue_script( 'jquery' );
	wp_enqueue_script('croptrack-script', get_stylesheet_directory_uri() . '/assets/js/main-min.js', ['jquery'], false, true);
}
add_action('wp_enqueue_scripts', 'croptrak_theme_enqueue_scripts');

// unset cpt projects
function croptrak_project_posttype_args( $args ) {
	return array_merge( $args, [
    'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
  ]);
}
add_filter( 'et_project_posttype_args', 'croptrak_project_posttype_args', 10, 1 );

// create custom menu page
function croptrak_menu_admin() {
  remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'croptrak_menu_admin' );

// extend native modules
function divi_custom_blog_module() { 
  require_once ('includes/Blog.php');
  $dcfm = new Custom_ET_Builder_Module_Blog(); 

  remove_shortcode( 'et_pb_blog' ); 
  add_shortcode( 'et_pb_blog', [$dcfm, '_render'] ); 
}
add_action( 'et_builder_ready', 'divi_custom_blog_module' );

function divi_custom_posts_navigation_module() { 
  require_once ('includes/PostsNavigation.php');
  $dcfm = new Custom_ET_Builder_Module_Posts_Navigation(); 
  
  remove_shortcode( 'et_pb_post_nav' ); 
  add_shortcode( 'et_pb_post_nav', [$dcfm, '_render'] ); 
}
add_action( 'et_builder_ready', 'divi_custom_posts_navigation_module' );

function divi_custom_gallery_module() { 
  require_once ('includes/Gallery.php');
  $dcfm = new Custom_ET_Builder_Module_Gallery(); 

  remove_shortcode( 'et_pb_gallery' ); 
  add_shortcode( 'et_pb_gallery', [$dcfm, '_render'] ); 
}
add_action( 'et_builder_ready', 'divi_custom_gallery_module' );

function divi_custom_number_counter_module() { 
  require_once ('includes/NumberCounter.php');
  $dcfm = new Custom_ET_Builder_Module_Number_Counter(); 

  remove_shortcode( 'et_pb_gallery' ); 
  add_shortcode( 'et_pb_gallery', [$dcfm, '_render'] ); 
}
add_action( 'et_builder_ready', 'divi_custom_number_counter_module' );

function divi_custom_modules_class( $classlist ) { 
  $classlist['et_pb_blog']            = [ 'classname' => 'Custom_ET_Builder_Module_Blog' ]; 
  $classlist['et_pb_post_nav']        = [ 'classname' => 'Custom_ET_Builder_Module_Posts_Navigation' ]; 
  $classlist['et_pb_gallery']         = [ 'classname' => 'Custom_ET_Builder_Module_Gallery' ]; 
  $classlist['et_pb_number_counter']  = [ 'classname' => 'Custom_ET_Builder_Module_Number_Counter' ]; 

  return $classlist; 
}  
add_filter( 'et_module_classes', 'divi_custom_modules_class' );

add_filter( 'et_pb_blog_image_width', 'custom_image_width' );
function custom_image_width($width) {
  return '425';
}

add_filter( 'et_pb_blog_image_height', 'custom_image_height' );
function custom_image_height($height) {
  return '288';
}

// Filters
// Filters can be found in template files, in single.php, index.php, main-modules.php

// Single post + single page + archive pages (category, tags, search results etc):
// et_pb_index_blog_image_width
// et_pb_index_blog_image_height
// Single project:
// et_pb_portfolio_single_image_width
// et_pb_portfolio_single_image_height
// Blog module
// et_pb_blog_image_width
// et_pb_blog_image_height
// Portfolio modules
// et_pb_portfolio_image_width
// et_pb_portfolio_image_height
// Gallery module
// et_pb_gallery_image_width
// et_pb_gallery_image_height