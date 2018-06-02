<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;

$context['sidebar']['recent_posts'] = array_map(
  function( $item ) {
    return array(
      'heading' => $item->title(),
      'body' => $item->date(),
      'link' => $item->link(),
      'image' => array(
        'src' => TimberImageHelper::resize( $item->thumbnail()->src, 120, 80),
        'alt' => $item->title(),
        'title' => $item->title(),
      ),
    );
  },
  Timber::get_posts(
    array(
      'post_type' => 'post',
      'posts_per_page' => '3',
    )
  )
);

$context['social_share'] = get_field('social_share', 'option');

array_walk( $context['social_share'],
  function ( &$value, $key ) use ( $post ) {
    ( $key === 'facebook' ) &&
      $value['link'] .= urlencode( $post->link );

    ( $key === 'twitter' ) &&
      $value['link'] .= urlencode( html_entity_decode( $post->title ) ) ."&url=". urlencode( $post->link );

    $value['icon'] .= ' fa-3x';
  }
);

$template = ( post_password_required( $post->ID ) )
  ? 'single-password.twig'
  : array(
      'single-' . $post->ID . '.twig',
      'single-' . $post->post_type . '.twig',
      'single.twig'
    );

Timber::render( $template, $context );
