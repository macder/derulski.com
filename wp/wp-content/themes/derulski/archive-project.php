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

$context = Timber::get_context();

$hero = get_field('hero_project_index', 'option')['content'];

$context['hero'] = array(
  'image' => ( new TimberImage( $hero['hero']['image'] ) )->src(),
  'text' => $hero['hero']['heading'],
  'sub_text' => $hero['hero']['sub_text'],
);

$query = new Timber\PostQuery();

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
      'gallery' => array_map(
        function( $item ) {
          $image = new TimberImage( $item['image'] );
          $thumb = new TimberImage( $item['image'] );
          $thumb->src = ( new Timber\ImageHelper() )->resize( $thumb->src, 182, 104 );

          return array(
            'image' => $image,
            'thumb' => $thumb,
          );
        },
        $item->get_field('gallery')
      ),
    );
  },
  $query->get_posts()
);

$context['pagination'] = get_object_vars( $query->pagination() );

Timber::render('archive-project.twig', $context );
