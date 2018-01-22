<?php
/**
 * Template part for displaying top header part
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */
?>

<!-- Top Header Bar -->
<header class="top-header-bar-container">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="top-header-bar">
					<!-- Email -->
					<li class="top-email">
						<i class="fa fa-envelope-o"></i> <?php echo esc_html( get_theme_mod( 'tyche_top_bar_email', get_option( 'admin_email' ) ) ); ?>
					</li>
					<!-- / Email -->
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<!-- Cart -->
						<li class="top-cart">
							<a href="<?php echo esc_url( Tyche_Helper::get_woocommerge_page( 'cart' ) ); ?>"><i class="fa fa-shopping-cart"></i> <?php echo esc_html__( 'My Cart', 'tyche' ); ?>
								- <?php echo esc_html( get_woocommerce_currency_symbol( get_woocommerce_currency() ) . ' ' . Tyche_WooCommerce_Hooks::get_cart_total() ); ?>
							</a>
						</li> <!-- / Cart -->
					<?php endif; ?>

					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<!-- Account -->
						<li class="top-account">
							<a href="<?php echo esc_url( Tyche_Helper::get_woocommerge_page( 'account' ) ); ?>"><i class="fa fa-user"></i> <?php echo esc_html__( 'Account', 'tyche' ); ?>
							</a>
						</li><!-- / Account -->
					<?php endif; ?>

					<?php if ( function_exists( 'pll_the_languages' ) ) : ?>
						<!-- Multi language picker -->
						<li class="top-multilang">
							<?php
							$current_lang = pll_current_language( 'name' );
							$current_flag = pll_current_language( 'flag' );
							?>
							<a href="#" class="multilang-toggle" id="multilang-toggle"> <?php echo esc_html( $current_flag ) . esc_html( $current_lang ); ?> </a>
							<ul class="tyche-multilang-menu" data-menu data-menu-toggle="#multilang-toggle">
								<?php
								$args = array(
									'show_flags' => 1,
									'show_names' => 1,
								);

								pll_the_languages( $args );
								?>
							</ul>
						</li><!-- / Multi language picker -->
					<?php endif; ?>
					<?php
					$enable_search_bar = get_theme_mod( 'tyche_enable_top_bar_search', 'enabled' );
					?>
					<?php if ( 'enabled' === $enable_search_bar ) : ?>
						<!-- Top Search -->
						<li class="top-search">
							<!-- Search Form -->
							<form role="search" method="get" class="pull-right" id="searchform_topbar" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<label>
									<span class="screen-reader-text"><?php esc_html__( 'Search for:', 'tyche' ); ?></span>
									<input class="search-field-top-bar" id="search-field-top-bar" placeholder="<?php echo esc_attr__( 'Search ...', 'tyche' ); ?>" value="" name="s" type="search">
								</label>
								<button id="search-top-bar-submit" type="submit" class="search-top-bar-submit">
									<span class="fa fa-search"></span>
								</button>
							</form>
						</li><!-- / Top Search -->
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</header><!-- /Top Header Bar -->
