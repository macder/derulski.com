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
    $image = $item->thumbnail();
    $image->src = TimberImageHelper::resize($image->src, 120, 80);
    return array(
      'heading' => $item->title(),
      'body' => $item->date(),
      'link' => $item->link(),
      'image' => $image,
      'style_mod' => 'small',
    );
  },
  Timber::get_posts(
    array(
      'post_type' => 'post',
      'posts_per_page' => '3',
    )
  )
);

$context['categories'] = array_map(
  function( $item ) {
    return array(
      'link' => $item->link(),
      'label' => $item->name,
    );
  }, $context['post']->categories()
);

// WIP - temp until moved into wp dashboard
$context['social_share'] = array(
  [
    "link" => "https://www.facebook.com/sharer/sharer.php?u=". urlencode( $post->link ),
    "icon" => "fa-facebook-square fa-3x",
    "name" => "Share on Facebook",
    "is_external" => 1,
  ],
  [
    "link" =>
      "https://twitter.com/intent/tweet/?text=". urlencode( html_entity_decode( $post->title ) ) ."&url=". urlencode( $post->link ),
    "icon" => "fa-twitter-square fa-3x",
    "name" => "Share on Twitter",
    "is_external" => 1,
  ]
);

$template = ( post_password_required( $post->ID ) )
  ? 'single-password.twig'
  : array(
      'single-' . $post->ID . '.twig',
      'single-' . $post->post_type . '.twig',
      'single.twig'
    );

Timber::render( $template, $context );
