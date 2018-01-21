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

Timber::render( array( 'contact.twig' ), $context );
