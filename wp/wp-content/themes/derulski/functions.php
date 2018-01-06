<?php
defined( 'ABSPATH' ) or die();

Timber::$locations = array(
 '../ui/build/patterns/_patterns',
);

Timber::$dirname = array('templates', 'twigs');

class DerulskiSite extends TimberSite {

  public function __construct() {
    add_theme_support( 'post-formats' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

    // add stuff to Timber context
    add_filter( 'timber_context', array( $this, 'add_to_context' ) );

    // register custom Twig functions/extensions
    add_filter( 'get_twig', array( $this, 'add_to_twig' ) );

    // register all the custom post types
    add_action( 'init', array( $this, 'register_post_types' ) );

    // register all the custom taxonomies
    add_action( 'init', array( $this, 'register_taxonomies' ) );

    // register all the menus
    add_action( 'init', array( $this, 'register_menus' ) );

    // register all the dashboards custom option pages
    add_action( 'init', array( $this, 'register_options_pages' ) );

    add_action( 'widgets_init', array( $this, 'register_widgets' ) );

    // use newer jQuery from CDN
    add_action( 'wp_enqueue_scripts', array( $this, 'include_jquery') );
    parent::__construct();
  }

  /**
   * Adds sitewide values to Timber context
   *
   * @param $context array
   *
   * @return array
   */
  public function add_to_context( $context ) {
    $context['primary_menu'] = ( new TimberMenu('primary') )->get_items();
    $context['secondary_menu'] = ( new TimberMenu('secondary') )->get_items();
    $context['social_menu'] = ( new TimberMenu('social') )->get_items();
    $context['copyr'] = get_field('copyr', 'option');
    $context['site'] = $this;
    return $context;
  }

  /**
   * Add functions/extensions to Twig
   *
   * @param $twig Twig_Environment
   *
   * @return Twig_Environment
   */
  public function add_to_twig( $twig ) {
    /* this is where you can add your own functions to twig */
    $twig->addExtension( new Twig_Extension_StringLoader() );
    // $twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
    return $twig;
  }

  /**
   * Use newer jQuery from CDN
   *
   */
  public function include_jquery() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('jquery');
  }

  /**
   * Register custom menus
   *
   */
  public function register_menus() {
    register_nav_menu('primary', 'Primary Navigation');
    register_nav_menu('secondary', 'Footer Navigation');
    register_nav_menu('social', 'Footer Social');
  }

  /**
   * Register custom option pages in dashboard
   *
   */
  public function register_options_pages() {
    if( function_exists('acf_add_options_page') ) {
      acf_add_options_page( array(
        'page_title'  => 'Global Settings',
        'menu_title'  => 'Global Settings',
        'menu_slug'   => 'global-settings',
        'capability'  => 'edit_posts',
      ));

      acf_add_options_sub_page( array(
        'page_title'  => 'Footer',
        'menu_title'  => 'Footer',
        'parent_slug' => 'global-settings',
        'menu_slug'   => 'footer-settings',
      ));

      acf_add_options_page( array(
        'page_title'  => 'Post Settings',
        'menu_title'  => 'Post Settings',
        'menu_slug'   => 'post-settings',
        'parent_slug' => 'edit.php',
        'capability'  => 'edit_posts',
      ));

      acf_add_options_page( array(
        'page_title'  => 'Project Settings',
        'menu_title'  => 'Project Settings',
        'menu_slug'   => 'project-settings',
        'parent_slug' => 'edit.php?post_type=project',
        'capability'  => 'edit_posts',
      ));
    }
  }

  /**
   * Register all the custom post types
   *
   */
  public function register_post_types() {
    register_post_type( 'project',
      array(
        'labels' => array(
          'name' => 'Projects',
          'singular_name' => 'Project'
        ),
        'supports' => array(
          'page-attributes',
          'title',
        ),
        'capability_type' => 'post',
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'public' => true,
        'has_archive' => 'projects',
        'rewrite' => array(
          'slug' => 'project',
          'with_front' => false,
        ),
      )
    );
  }

  /**
   * Register all the custom taxonomies
   *
   */
  public function register_taxonomies() {
    //this is where you can register custom taxonomies
  }

  /**
   * Register sidebar widget areas
   *
   */
  public function register_widgets () {
    register_sidebar( array(
      'name'          => 'Blog sidebar',
      'id'            => 'blog_sidebar',
      'before_widget' => '<div class="c-sidebar__item o-box">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3 class="c-horizontal-text-menu__heading u-text-center">',
      'after_title'   => '</h3>',
    ) );
  }
}

new DerulskiSite();

add_filter( 'jpeg_quality', function( $quality, $context ) {
  return 75;
}, 10, 2 );


add_action( 'pre_get_posts', function ( $query ) {
  if ( is_admin() || !isset( $query->query_vars['post_type'] ) )
    return;

  ( $query->query_vars['post_type'] === 'project' ) &&
    set_query_var('posts_per_page', 2);
});
