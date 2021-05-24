<?php
/**
 * The template for displaying attachments
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package axio
 */

// redirect attachment to its file
wp_redirect(wp_get_attachment_url(), 302);
