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
Timber::render( array( 'home.twig' ), $context );
