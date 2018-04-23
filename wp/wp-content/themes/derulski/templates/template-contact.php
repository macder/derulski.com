<?php
/*
 * Template Name: Contact
 */

/**
 * The Template for Contact Page
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

// form is a acf repeater field
$context['form'] = get_field('form');

// create form config array for wfv-validation
foreach ( $context['form']['fields'] as $field ) {
  $context['validator'][ $field['name'] ] = array(
    'label' => $field['label'],
    'rules' => $field['rules'],
    'messages' => ( $field['messages'] )
      ? array_column( $field['messages'], 'message', 'rule' )
      : null,
  );
}

// creates and assigns validation instance to $context['validator']
wfv_create( 'contact_form', $context['validator'] );

$context['alert'] = array(
  'body' => ($context['validator']->is_valid() )
    ? get_field('messages_success')
    : get_field('messages_error'),
  'success' => $context['validator']->is_valid(),
  'error' => $context['validator']->has_errors(),
);

Timber::render( array( 'contact.twig' ), $context );
