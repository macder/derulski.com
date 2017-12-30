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
    }
  }

  /**
   * Register all the custom post types
   *
   */
  public function register_post_types() {
    //this is where you can register custom post types
  }

  /**
   * Register all the custom taxonomies
   *
   */
  public function register_taxonomies() {
    //this is where you can register custom taxonomies
  }
}

new DerulskiSite();
