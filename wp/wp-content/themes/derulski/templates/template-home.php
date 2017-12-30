<?php
/*
 * Template Name: Home Page
 */

/**
 * The Template for Home page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$context['post'] = new TimberPost();

$context['hero'] = array(
  'image' => ( new TimberImage( get_field('hero_image') ) )->src(),
  'text' => get_field('hero_heading')
);

$context['recent_posts'] = array_map(
  function( $item ) {
    return array(
      'title' => $item->title(),
      'date' => $item->date(),
      'author' => $item->author()->display_name,
      'image' => $item->thumbnail(),
      'body' => $item->get_content(50),
      'url' => $item->link(),
    );
  },
  Timber::get_posts(
    array(
      'post_type' => 'post',
      'posts_per_page' => '2',
    )
  )
);

// print_r($context['recent_posts']);

Timber::render( array( 'home.twig' ), $context );
