<?php
/**
 * Template Name: Front Page
 *
 * Page templates are a specific type of template file that can be applied to a specific page or groups of pages.
 * https://developer.wordpress.org/themes/template-files-section/page-template-files/page-templates/
 *
 * @package Guides
 * @since Guides 1.0
 */

get_header();

global $post; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			/**
			 * This is a front_page template, you should be creative here!
			 */
			?>
		</main>
		<!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();