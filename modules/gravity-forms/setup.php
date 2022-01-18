<?php
/**
 * Setup: Gravity Forms plugin compatibility
 *
 * @package axio
 */

/**
 * Set gravity form default settings for new forms.
 *
 * @param object $form   Target form.
 * @param bool   $is_new Whether the form is a new form or not.
 */
add_action('gform_after_save_form', function ($form, $is_new) {

  if ($is_new) {

    // set default gdpr and spam settings
    $form['enableHoneypot']            = true;
    $form['personalData']['preventIP'] = true;
    $form['personalData']['retention'] = [
      'policy'              => 'delete',
      'retain_entries_days' => '180',
    ];

    // set default from address if it is defined
    if (defined('AXIO_FROM_ADDRESS') && is_email(AXIO_FROM_ADDRESS)) {
      foreach ($form['notifications'] as &$notification) {
        $notification['from'] = AXIO_FROM_ADDRESS;
      }
    }

    GFAPI::update_form($form);

  }

}, 10, 2);

/**
 * Force {admin_email} to default address if it is defined
 *
 * @param array         $notification the notificaiton settings
 * @param Form Object   $form the gravity forms form object
 * @param Entry Object  $entry the gravity forms entry object
 *
 * @return array
 */
add_filter('gform_notification', function ($notification, $form, $entry) {

  if (is_array($notification) && isset($notification['from']) && defined('AXIO_FROM_ADDRESS') && is_email(AXIO_FROM_ADDRESS)) {
    $notification['from'] = AXIO_FROM_ADDRESS;
  }
  return $notification;

}, 10, 3);

/**
 * Force anchors
 */
add_filter('gform_confirmation_anchor', '__return_true');

/**
 * Allow block
 */
add_filter('allowed_block_types_all', function($blocks, $block_editor_context) {

  $blocks[] = 'gravityforms/form';
  return $blocks;

}, 11, 2);
