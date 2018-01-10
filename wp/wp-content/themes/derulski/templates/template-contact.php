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

$context['form'] = array(
  'fields' => array(
    [
      'type' => 'text',
      'id' => 'name',
      'name' => 'name',
      'label' => 'Name:',
    ],
    [
      'type' => 'text',
      'id' => 'email',
      'name' => 'email',
      'label' => 'Email:',
    ],
    [
      'type' => 'textarea',
      'id' => 'message',
      'name' => 'message',
      'label' => 'Message:',
    ]
  ),
);

$validator = array(
  'name' => [
    'label' => 'Name',
    'rules' => 'required',
  ],
  'email' => [
    'label' => 'Email',
    'rules' => 'required|email',
  ],
  'message' => [
    'label' => 'Message',
    'rules' => 'required',
  ]
);

wfv_create( 'my_form', $validator );

// print_r($validator);

Timber::render( array( 'contact.twig' ), $context );
