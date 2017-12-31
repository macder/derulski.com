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

$template = ( post_password_required( $post->ID ) )
  ? 'single-password.twig'
  : array(
      'single-' . $post->ID . '.twig',
      'single-' . $post->post_type . '.twig',
      'single.twig'
    );

Timber::render( $template, $context );
