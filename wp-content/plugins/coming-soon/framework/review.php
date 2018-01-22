<?php 

// Review Request
add_action( 'admin_footer_text', 'seed_csp4_admin_footer' );

function seed_csp4_admin_footer( $text ) {
  global $current_screen;
  $review = get_option( 'seed_csp4_review' );
  if ( isset( $review['dismissed'] ) &&  $review['dismissed']){
  	return $text;
  }

  if ( !empty( $current_screen->id ) && strpos( $current_screen->id, 'settings_page_seed_csp4' ) !== false ) {

    $url  = 'https://wordpress.org/support/plugin/coming-soon/reviews/?filter=5#new-post';
    $text = sprintf( __( 'Please rate <strong>Coming Soon Page & Maintenance Mode by SeedProd</strong> <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%s" target="_blank">WordPress.org</a> to help us spread the word. Thank you from the SeedProd team!', 'coming-soon' ), $url, $url );
  }
  return $text;
}

add_action( 'admin_notices', 'seed_csp4_review' );
function seed_csp4_review() {

	// Verify that we can do a check for reviews.

	$review = get_option( 'seed_csp4_review' );
	$time	= time();
	$load	= false;
	$settings = seed_csp4_get_settings();
	

	if ( ! $review ) {
		$review = array(
			'time' 		=> $time,
			'dismissed' => false
		);
		$load = true;
	} else {
		// Check if it has been dismissed or not.
		if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + DAY_IN_SECONDS) <= $time) && $settings['status'] > 0) ) {
			$load = true;
		}
	}


	// If we cannot load, return early.
	if ( ! $load ) {
		return;
	}

	// Update the review option now.
	update_option( 'seed_csp4_review', $review );

	$current_user = wp_get_current_user();
	$fname = '';
	if(!empty($current_user->user_firstname)){
		$fname = $current_user->user_firstname;
	}

	$page_type = 'Coming Soon Page';
	if(!empty($settings['status']) && $settings['status'] == 2){
		$page_type = 'Maintenance Mode Page';
	}


	// We have a candidate! Output a review message.
	?>
	<div class="notice notice-info is-dismissible seed-csp4-review-notice">
		<p><?php printf(__( 'Hey %s, I noticed you created a %s with our plugin - that’s awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress to help us spread the word?', 'coming-soon' ),$fname, $page_type); ?></p>
		<p><strong><?php _e( '~ John Turner<br>SeedProd', 'coming-soon' ); ?></strong></p>
		<p>
			<a href="https://wordpress.org/support/plugin/coming-soon/reviews/?filter=5#new-post" class="seed-csp4-dismiss-review-notice seed-csp4-review-out" target="_blank" rel="noopener"><?php _e( 'Ok, you deserve it', 'coming-soon' ); ?></a><br>
			<a href="#" class="seed-csp4-dismiss-review-notice" target="_blank" rel="noopener"><?php _e( 'Nope, maybe later', 'coming-soon' ); ?></a><br>
			<a href="#" class="seed-csp4-dismiss-review-notice" target="_blank" rel="noopener"><?php _e( 'I already did', 'coming-soon' ); ?></a><br>
		</p>
	</div>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$(document).on('click', '.seed-csp4-dismiss-review-notice, .seed-csp4-review-notice .notice-dismiss', function( event ) {
				if ( ! $(this).hasClass('seed-csp4-review-out') ) {
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'seed_csp4_dismiss_review'
				});

				$('.seed-csp4-review-notice').remove();
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_seed_csp4_dismiss_review', 'seed_csp4_dismiss_review' );
function seed_csp4_dismiss_review() {

	$review = get_option( 'seed_csp4_review' );
	if ( ! $review ) {
		$review = array();
	}

	$review['time'] 	 = time();
	$review['dismissed'] = true;

	update_option( 'seed_csp4_review', $review );
	die;
}