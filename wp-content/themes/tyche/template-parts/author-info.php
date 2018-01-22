<?php
/**
 * Template part for displaying author info.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

global $post;
$curauth        = get_userdata( $post->post_author );
$author_enabled = get_theme_mod( 'tyche_enable_author_box', 'enabled' );
if ( is_single() && ! empty( $curauth->description ) && 'enabled' === $author_enabled ) {
	?>
	<!-- Author description -->
	<div class="author-description">
		<!-- Avatar -->
		<div class="col-md-2 tyche-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
		</div>
		<!-- .Avatar -->
		<!-- Short Description -->
		<div class="col-md-10" itemscope="" itemtype="http://schema.org/Person">
			<h4 class="post-author"><?php echo wp_kses_post( get_the_author_posts_link() ); ?></h4>
			<a class="post-author-website" href="<?php echo esc_url( get_the_author_meta( 'url' ) ); ?>"><?php echo get_the_author_meta( 'url' ); ?></a>
			<p><?php the_author_meta( 'description' ); ?></p>
		</div>
		<!-- .Short Description -->
	</div>    <!-- .Author description -->
<?php } ?>
