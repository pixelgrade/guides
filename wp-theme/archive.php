<?php
/**
 * The template for displaying archive pages for every post type that lacks a archive-<post_type>.php template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Guides
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php guides_the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			</header><!-- .page-header -->

			<div class="postcards">
				<div class="grid" id="posts-container">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="grid__item  postcard">
							<?php
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() ); ?>
						</div>
					<?php endwhile; ?>
				</div>
				<?php the_posts_navigation(); ?>
			</div>

		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer(); ?>
