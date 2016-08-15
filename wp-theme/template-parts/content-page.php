<?php
/**
 * The template used for displaying page content
 *
 * @package Guides
 * @since   Guides 1.0
 */ ?>

<article id="post-<?php the_ID(); ?>"  <?php post_class( 'entry--page  pr  clearfix' ); ?>>

	<div class="entry-content  js-post-gallery">

		<?php

		the_content();

		global $numpages;
		if ( $numpages > 1 ) { ?>

			<div class="entry__meta-box  meta-box--pagination">
				<span class="meta-box__title"><?php esc_html_e( 'Pages', 'guides' ); ?></span>

				<?php
				$args = array(
					'before'           => '<ol class="nav  pagination--single">',
					'after'            => '</ol>',
					'next_or_number'   => 'next_and_number',
					'previouspagelink' => esc_html__( '&laquo;', 'guides' ),
					'nextpagelink'     => esc_html__( '&raquo;', 'guides' )
				);
				wp_link_pages( $args ); ?>

			</div><!-- .entry__meta-box.meta-box-pagination -->

		<?php } ?>

	</div><!-- .entry-content -->

	<?php

	if ( get_post_meta( get_the_ID(), '_guides_page_enabled_social_share', true ) ) { ?>

		<div class="entry-footer">

			<div class="metabox">
				<button class="share-button  js-popup-share">
					<i class="icon icon-share-alt"></i> <?php esc_html_e( 'Share', 'guides' ); ?>
				</button>
			</div><!-- .metabox -->

		</div><!--entry-footer-->
	<?php } ?>

</article><!-- .entry-page -->
