<?php

/**
 * Class Sidebar_Map_Widget
 *
 * Remember: This is just an example
 *
 * Every widget must extend `WP_Widget' class.
 * The same constructor must be used.
 * The output of the widget is done in the `widget` method. Be careful to sanitize any user input, even if is an admin
 * input.
 *
 * Every option must be built in the `form` method. Don't be shy and try to use the `WP_Widget` field methods instead of
 * creating your owns
 *
 */
class Sidebar_Map_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'widget_sidebar_map', // Base ID
			'&#x1F536; ' . esc_html__( 'Listing', 'guides' ) . '  &raquo; ' . esc_html__( 'Location Map', 'guides' ), // Name
			array( 'description' => esc_html__( 'A Map View of the location along with a Directions link to Google Map.', 'guides' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		global $post;

		$address = guides_get_formatted_address();

		if ( empty( $address ) ) {
			return;
		}

		$geolocation_lat  = get_post_meta( get_the_ID(), 'geolocation_lat', true );
		$geolocation_long = get_post_meta( get_the_ID(), 'geolocation_long', true );

		$get_directions_link = '';
		if ( ! empty( $geolocation_lat ) && ! empty( $geolocation_long ) && is_numeric( $geolocation_lat ) && is_numeric( $geolocation_long ) ) {
			$get_directions_link = '//maps.google.com/maps?daddr=' . $geolocation_lat . ',' . $geolocation_long;
		}

		if ( empty( $get_directions_link ) ) {
			return;
		}
		echo $args['before_widget']; ?>

		<div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
			<div id="map" class="listing-map"></div>

			<?php if ( ! empty( $geolocation_lat ) && ! empty( $geolocation_long ) && is_numeric( $geolocation_lat ) && is_numeric( $geolocation_long ) ) : ?>

				<meta itemprop="latitude" content="<?php echo $geolocation_lat; ?>"/>
				<meta itemprop="longitude" content="<?php echo $geolocation_long; ?>"/>

			<?php endif; ?>

		</div>
		<div class="listing-map-content">
			<address class="listing-address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
				<?php
				echo $address;
				if ( true == apply_filters( 'guides_skip_geolocation_formatted_address', false ) ) { ?>
					<meta itemprop="streetAddress"
					      content="<?php echo trim( get_post_meta( $post->ID, 'geolocation_street_number', true ), '' ); ?> <?php echo trim( get_post_meta( $post->ID, 'geolocation_street', true ), '' ); ?>">
					<meta itemprop="addressLocality"
					      content="<?php echo trim( get_post_meta( $post->ID, 'geolocation_city', true ), '' ); ?>">
					<meta itemprop="postalCode"
					      content="<?php echo trim( get_post_meta( $post->ID, 'geolocation_postcode', true ), '' ); ?>">
					<meta itemprop="addressRegion"
					      content="<?php echo trim( get_post_meta( $post->ID, 'geolocation_state', true ), '' ); ?>">
					<meta itemprop="addressCountry"
					      content="<?php echo trim( get_post_meta( $post->ID, 'geolocation_country_short', true ), '' ); ?>">
				<?php } ?>
			</address>
			<?php if ( ! empty( $get_directions_link ) ) { ?>
				<a href="<?php echo $get_directions_link; ?>" class="listing-address-directions"
				   target="_blank"><?php esc_html_e( 'Get directions', 'guides' ); ?></a>
			<?php } ?>
		</div><!-- .listing-map-content -->

		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$original_instance = $instance;

		//Defaults
		$instance = wp_parse_args(
			(array) $instance,
			$this->defaults );

		$placeholders = $this->get_placeholder_strings();

		$title = esc_attr( $instance['title'] );
		//if the user is just creating the widget ($original_instance is empty)
		if ( empty( $original_instance ) && empty( $title ) ) {
			$title = $placeholders['title'];
		}

		$claim_button_text = esc_attr( $instance['claim_button_text'] );
		//if the user is just creating the widget ($original_instance is empty)
		if ( empty( $original_instance ) && empty( $claim_button_text ) ) {
			$claim_button_text = $placeholders['claim_button_text'];
		}

		$claim_description_text = esc_attr( $instance['claim_description_text'] );
		//if the user is just creating the widget ($original_instance is empty)
		if ( empty( $original_instance ) && empty( $claim_description_text ) ) {
			$claim_description_text = $placeholders['claim_description_text'];
		} ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'claim_button_text' ); ?>"><?php _e( 'Claim Button Text:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'claim_button_text' ); ?>"
			       name="<?php echo $this->get_field_name( 'claim_button_text' ); ?>" type="text"
			       value="<?php echo esc_attr( $claim_button_text ); ?>">
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'claim_description_text' ); ?>"><?php _e( 'Description:', 'guides' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'claim_description_text' ); ?>"
			          name="<?php echo $this->get_field_name( 'claim_description_text' ); ?>"><?php
				echo esc_attr( $claim_description_text ); ?></textarea>
		</p>

		<?php
	}

	private function get_placeholder_strings() {
		$placeholders = apply_filters( 'sidebar_claim_widget_backend_placeholders', array() );

		$placeholders = wp_parse_args(
			(array) $placeholders,
			array(
				'title'                  => esc_html__( 'Is this your business?', 'guides' ),
				'claim_button_text'      => esc_html__( 'Claim it now.', 'guides' ),
				'claim_description_text' => esc_html__( 'Make sure your information is up to date.', 'guides' ),
			) );

		return $placeholders;
	}
} // class Sidebar_Map_Widget