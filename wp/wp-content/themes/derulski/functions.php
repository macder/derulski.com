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
    add_filter( 'timber_context', array( $this, 'add_to_context' ) );
    add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'init', array( $this, 'register_taxonomies' ) );
    add_action( 'init', array( $this, 'register_menus' ) );
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
   * Register custom menus
   *
   */
  public function register_menus() {
    register_nav_menu('primary', 'Primary Navigation');
    register_nav_menu('secondary', 'Footer Navigation');
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
