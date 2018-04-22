<?php
/*
 * Template Name: About
 */

/**
 * The Template for About page
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

$context['body'] = get_field('body');

$context['profiles'] = array_map(
  function($item) {
    return array(
      'link' => $item['link']['url'],
      'icon' => $item['icon'],
      'name' => $item['link']['title'],
    );
  }, get_field('profiles')
);

$context['image'] = $context['post']->thumbnail();

Timber::render( array( 'about.twig' ), $context );
