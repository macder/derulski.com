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
  'text' => get_field('hero_heading'),
  'sub_text' => get_field('hero_sub_text'),
);

$context['recent_posts']['items'] = array_map(
  function( $item ) {
    return array(
      'heading' => $item->title(),
      'date' => $item->date(),
      'author' => $item->author()->display_name,
      'category' => $item->terms('category'),
      'image' => $item->thumbnail(),
      'body' => $item->preview()->length(20)->read_more(false),
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

$context['recent_posts']['title'] = get_field('recent_posts_heading');

Timber::render( array( 'home.twig' ), $context );
