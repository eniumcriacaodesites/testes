<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'tyche-blog-post' ); ?>>
	<header class="entry-header">
		<div class="tyche-blog-image">
			<?php
			if ( has_post_thumbnail() ) {
				echo ! is_single() ? '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' : '';
				the_post_thumbnail( 'tyche-blog-post-image' );
				echo ! is_single() ? '</a>' : '';
			}
			?>
		</div>

		<div class="tyche-blog-meta">
			<?php Tyche_Helper::post_meta(); ?>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content( esc_html__( 'Read More', 'tyche' ) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tyche' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>
		<footer class="entry-footer">
			<?php Tyche_Helper::entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

	<?php
	if ( is_single() ) :
		get_template_part( 'template-parts/author-info' );
	endif;
	?>
</article><!-- #post-## -->
