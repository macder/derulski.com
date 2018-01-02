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

Timber::render('archive-project.twig', $context );

