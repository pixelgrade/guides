<?php
/**
 * Custom template tags for this theme and functions that will result in html output.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Guides
 */


if ( ! function_exists('guides_the_archive_title') ) {

	/**
	 * Display the archive title
	 */
	function guides_the_archive_title() {

		$object = get_queried_object();

		echo '<h1 class="page__title">';

		if ( is_home() ) {
			if ( isset( $object->post_title ) ) {
				echo $object->post_title;
			} else {
				esc_html_e( 'News', 'guides' );
			}
		} elseif ( is_search() ) {
			esc_html_e( 'Search Results for: ', 'guides' );
			echo get_search_query();
		} elseif ( is_tag() ) {
			echo single_tag_title( 'Tag: ', false );
		} elseif ( ! empty( $object ) && isset( $object->term_id ) ) {
			esc_html_e( 'Category: ', 'guides' );
			echo $object->name;
		} elseif ( is_day() ) {
			esc_html_e( 'Daily Archives: ', 'guides' );
			echo get_the_date();
		} elseif ( is_month() ) {
			esc_html_e( 'Monthly Archives: ', 'guides' );
			echo get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'guides' ) );
		} elseif ( is_year() ) {
			esc_html_e( 'Yearly Archives: ', 'guides' );
			echo get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'guides' ) );
		} else {
			esc_html_e( 'Archives', 'guides' );
		}

		echo '</h1>';
	}

}