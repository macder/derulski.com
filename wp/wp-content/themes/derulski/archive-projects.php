<?php
/**
 * The Template for events archive (index/listing)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();

Timber::render('archive-projects.twig', $context );

