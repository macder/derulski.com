<?php
defined( 'ABSPATH' ) or die();

Timber::$locations = array(
 '../ui/build/patterns/_patterns',
);

add_filter('timber/loader/loader', function($loader){
  $loader->addPath(realpath('../ui/build/patterns/_layouts'),
    'layouts'
  );
  return $loader;
});

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
    register_nav_menu('project_type', 'Project Navigation');
    register_nav_menu('blog_categories', 'Blog Navigation');
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

      acf_add_options_sub_page( array(
        'page_title'  => '404',
        'menu_title'  => '404',
        'parent_slug' => 'global-settings',
        'menu_slug'   => '404-settings',
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
    register_taxonomy(
      'project_type',
      'project',
      array(
        'label' => 'Project Types',
        'meta_box_cb' => false,
        'show_in_quick_edit' => false,
        'rewrite' => array(
          'slug' => 'projects',
          'with_front' => false,
        ),
      )
    );

    register_taxonomy_for_object_type( 'project_type', 'project' );
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
      'before_title'  => '<h3 class="c-vertical-text-menu__heading u-text-center">',
      'after_title'   => '</h3>',
    ) );
  }
}

new DerulskiSite();

add_filter( 'jpeg_quality', function( $quality, $context ) {
  return 75;
}, 10, 2 );

// limit 2 projects per page on archive and taxonomy pages
add_action( 'pre_get_posts', function ( $query ) {
  ( !is_admin() && ( $query->query_vars['post_type'] === 'project' || $query->is_tax('project_type') ) ) &&
    set_query_var('posts_per_page', 2);
});

// disables html in post comments
add_filter('comment_text', 'wp_filter_nohtml_kses');
add_filter('comment_text_rss', 'wp_filter_nohtml_kses');
add_filter('comment_excerpt', 'wp_filter_nohtml_kses');

// contact form validation pass
add_action( 'contact_form', function( $form ) {
  $name = $form->input()->escape('fname');
  $email = $form->input()->escape('email');
  $msg = $form->input()->escape('message');

  $to = get_bloginfo('admin_email');
  $subject = 'Message from derulski.com contact form';
  $message =
    "From: ". $name ." (". $email .") \n".
    "Message: \n". $msg;

  $headers[] = 'From:'. $email;

  wp_mail( $to, $subject, $message, $headers );
});
