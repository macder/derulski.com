<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::get_context();

$hero = get_field('hero_blog_index_content', 'option');

$context['hero'] = array(
  'image' => ( new TimberImage( $hero['hero']['image'] ) )->src(),
  'text' => $hero['hero']['heading'],
  'sub_text' => $hero['hero']['sub_text'],
);

$context['index_name'] = get_the_archive_title();

$query = new Timber\PostQuery();

$context['posts'] = array_map(
  function( $item ) {
    return array(
      'title' => $item->title(),
      'date' => $item->date(),
      'author' => $item->author()->display_name,
      'category' => array(
        'name' => $item->category()->title(),
        'link' => $item->category()->link(),
      ),
      'image' => array(
        'src' => $item->thumbnail()->src,
        'width' => 420,
        'height' => 172,
      ),
      'body' => $item->preview()->length(40)->read_more(false),
      'link' => $item->link(),
    );
  },
  $query->get_posts()
);

$context['pagination'] = get_object_vars( $query->pagination() );
$context['sidebar'] = Timber::get_widgets('blog_sidebar');

$context['categories'] = ( new TimberMenu('blog_categories') )->get_items();

Timber::render( 'archive.twig', $context );
