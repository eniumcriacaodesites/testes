<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 0.1
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'estore_before_post_content' ); ?>

	<div class="entry-thumbnail">
		<?php if ( get_theme_mod('estore_postmeta', '') == '' && get_theme_mod( 'estore_postmeta_date', '') == '' )  { ?>
		<span class="posted-on"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<?php }
		if ( has_post_thumbnail() ) { ?>
			<?php the_post_thumbnail( 'estore-slider' ); ?>
		<?php } ?>
	</div>
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	<div class="entry-content-text-wrapper clearfix">
		<div class="entry-content-wrapper">
			<?php estore_entry_meta(); ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php
				$estore_tag_list = get_the_tag_list( '', ',&nbsp;', '' );
				if( !empty( $estore_tag_list ) ) {
				?>
				<div class="tags">
					<?php esc_html_e( 'Tagged on: ', 'estore' ); echo $estore_tag_list; ?>
				</div>
                  <?php
				}
				?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'estore' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->
		</div>
	</div>

	<?php do_action( 'estore_after_post_content' ); ?>
</article><!-- #post-## -->
