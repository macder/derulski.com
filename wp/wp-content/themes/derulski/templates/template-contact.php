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
  'name' => 'contact_form',
  'method' => 'post',
  'submit' => 'Send',
  'fields' => array(
    [
      'type' => 'text',
      'id' => 'fname',
      'name' => 'fname',
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
  'validator' => array(
    'fname' => [
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
  )
);

wfv_create( 'contact_form', $context['form']['validator'] );

Timber::render( array( 'contact.twig' ), $context );
