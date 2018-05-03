<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();

$hero = get_field('hero_404', 'option');

$context['hero'] = array(
  'image' => ( new TimberImage( $hero['hero']['image'] ) )->src(),
  'text' => $hero['hero']['heading'],
  'sub_text' => $hero['hero']['sub_text'],
);

$context['body'] = get_field('404_body', 'option');

Timber::render( '404.twig', $context );
