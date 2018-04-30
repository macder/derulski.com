<?php
/**
 * The Template for proejct archive
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

if ( !isset( $context ) ) {
  $context = Timber::get_context();
  add_filter( 'the_seo_framework_enable_auto_description', '__return_false' );
  add_filter( 'the_seo_framework_generated_description', function() {
    return get_field('meta_desc_project_index', 'option');
  } );
}

$hero = get_field('hero_project_index', 'option')['content'];

$context['hero'] = array(
  'image' => ( new TimberImage( $hero['hero']['image'] ) )->src(),
  'text' => $hero['hero']['heading'],
  'sub_text' => $hero['hero']['sub_text'],
);

$context['tax_menu'] = ( new TimberMenu('project_type') )->get_items();

$query = new Timber\PostQuery();

// TODO - simplify this
$context['projects'] = array_map(
  function( $item ) {
    return array(
      'summary' => array(
        'title' => $item->title(),
        'sub_heading' => $item->get_field('summary_sub_heading'),
        'body' => $item->get_field('summary_body'),
        'list' => array(
          'items' => array_column( $item->get_field('summary_list'), 'name' ),
        ),
      ),
      'gallery' => ( $item->get_field('media_type') == 'gallery' ) ?
        array_map(
          function( $item ) {
            $image = new TimberImage( $item['image'] );
            $thumb = new TimberImage( $item['image'] );
            $thumb->src = ( new Timber\ImageHelper() )->resize( $thumb->src, 218, 124 );

            return array(
              'image' => $image,
              'thumb' => $thumb,
            );
          },
          $item->get_field('gallery')
        ) : null,
      'image' => ( $item->get_field('media_type') === 'image' )
        ? new TimberImage( $item->get_field('featured_image') )
        : null,
      'slug' => $item->slug,
    );
  },
  $query->get_posts()
);

$context['pagination'] = get_object_vars( $query->pagination() );

Timber::render('archive-project.twig', $context );
