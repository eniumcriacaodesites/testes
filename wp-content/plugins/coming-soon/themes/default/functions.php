<?php
// Template Tags
function seed_csp4_title() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $seo_title ) ) {
		$output = esc_html( $seo_title );
	}
	return $output;
}

function seed_csp4_metadescription() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $seo_description ) ) {
		$output = '<meta name="description" content="'.esc_attr( $seo_description ).'">';
	}

	return $output;
}

function seed_csp4_privacy() {
	$output = '';

	if ( get_option( 'blog_public' ) == 0 ) {
		$output = "<meta name='robots' content='noindex,nofollow' />";
	}

	return $output;
}

function seed_csp4_favicon() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $favicon ) ) {
		$output .= "<!-- Favicon -->\n";
		$output .= '<link href="'.esc_attr( $favicon ).'" rel="shortcut icon" type="image/x-icon" />';
	}

	return $output;
}

function seed_csp4_customcss() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $custom_css ) ) {
		$output = '<style type="text/css">'.$custom_css.'</style>';
	}

	return $output;
}

function seed_csp4_head() {
	$o = seed_csp4_get_settings();
	extract( $o );

	// CSS
	$output = '';

	$output .= "<!-- Bootstrap and default Style -->\n";
	$output .= '<link rel="stylesheet" href="'.SEED_CSP4_PLUGIN_URL.'themes/default/bootstrap/css/bootstrap.min.css">'."\n";
	$output .= '<link rel="stylesheet" href="'.SEED_CSP4_PLUGIN_URL.'themes/default/style.css">'."\n";
	if ( is_rtl() ) {
		$output .= '<link rel="stylesheet" href="'.SEED_CSP4_PLUGIN_URL.'themes/default/rtl.css">'."\n";
	}
	$output .= '<style type="text/css">'."\n";

	// Calculated Styles

	$output .= '/* calculated styles */'."\n";
	ob_start();
	?>

	/* Background Style */
    html{
		<?php if ( !empty( $bg_image ) ): ;?>
			<?php if ( isset( $bg_cover ) && in_array( '1', $bg_cover ) ) : ?>
				background: <?php echo $bg_color;?> url('<?php echo $bg_image; ?>') no-repeat top center fixed;
				<?php if ( isset( $bg_size ) && $bg_size == 'contain' ) : ?>
				-webkit-background-size: contain;
				-moz-background-size: contain;
				-o-background-size: contain;
				background-size: contain;
				<?php else : ?>
				
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
				<?php endif ?>
			<?php else: ?>
				background: <?php echo $bg_color;?> url('<?php echo $bg_image; ?>') <?php echo $bg_repeat;?> <?php echo $bg_position;?> <?php echo $bg_attahcment;?>;
			<?php endif ?>
        <?php else: 
              if(!empty($bg_color)):
     	?>
        	background: <?php echo $bg_color;?>;
		<?php endif;endif; ?>
    }
    .seed-csp4 body{
			<?php if ( !empty( $bg_effect ) ) : ?>
				background: transparent url('<?php echo plugins_url( 'images/bg-'.$bg_effect.'.png', __FILE__ ) ; ?>') repeat;
			<?php else: ?>
				background: transparent;
			<?php endif; ?>
	}
	<?php if ( !empty( $bg_overlay ) ): ;?>
		#seed-csp4-page{
			background-color: rgba(0,0,0,0.5);
		}
	<?php endif ?>

	<?php if ( !empty( $max_width ) ):?>
	#seed-csp4-content{
    	max-width: <?php echo intval($max_width);?>px;
	}
	<?php endif;?>

	<?php if ( !empty( $enable_well ) ):?>
	#seed-csp4-content{
		min-height: 20px;
		padding: 19px;
		background-color: #f5f5f5;
		border: 1px solid #e3e3e3;
		border-radius: 4px;
	}
	<?php endif;?>

    /* Text Styles */
    <?php if ( !empty( $text_font ) ):?>
	    .seed-csp4 body{
	        font-family: <?php echo SEED_CSP4::get_font_family($text_font); ?>
	    }

	    .seed-csp4 h1, .seed-csp4 h2, .seed-csp4 h3, .seed-csp4 h4, .seed-csp4 h5, .seed-csp4 h6{
	        font-family: <?php echo SEED_CSP4::get_font_family($text_font); ?>
	    }
    <?php endif;?>

    <?php if ( !empty( $text_color ) ) { ?>
		.seed-csp4 body{
			color:<?php echo $text_color;?>;
		}
    <?php } ?>

    <?php if ( !empty( $link_color ) ) { ?>
    <?php if ( empty( $headline_color ) ) { $headline_color = $link_color; }?>
    <?php } ?>


    <?php if ( !empty( $headline_color ) ) { ?>
		.seed-csp4 h1, .seed-csp4 h2, .seed-csp4 h3, .seed-csp4 h4, .seed-csp4 h5, .seed-csp4 h6{
			color:<?php echo $headline_color;?>;
		}
    <?php }?>


    <?php if ( !empty( $link_color ) ) { ?>
		.seed-csp4 a, .seed-csp4 a:visited, .seed-csp4 a:hover, .seed-csp4 a:active{
			color:<?php echo $link_color;?>;
		}


    <?php }

	$output .= ob_get_clean();

	$output .= '</style>'."\n";



	// Javascript
	$output .= "<!-- JS -->\n";
	$include_url = includes_url();
	$last = $include_url[strlen( $include_url )-1];
	if ( $last != '/' ) {
		$include_url = $include_url . '/';
	}
	if ( empty( $enable_wp_head_footer ) ) {
		$output .= '<script src="'.$include_url.'js/jquery/jquery.js"></script>'."\n";
	}
	$output .= '<script src="'.SEED_CSP4_PLUGIN_URL.'themes/default/bootstrap/js/bootstrap.js"></script>'."\n";

	$output .= '<script src="'.SEED_CSP4_PLUGIN_URL.'themes/default/js/script.js"></script>'."\n";


	// Header Scripts
	if ( !empty( $header_scripts ) ) {
		$output .= "<!-- Header Scripts -->\n";
		$output .= $header_scripts;
	}

	// Google Analytics
	if ( !empty( $ga_analytics ) ) {
		$output .= "<!-- Google Analytics -->\n";
		$output .= $ga_analytics;
	}

	// Modernizr
	$output .= "<!-- Modernizr -->\n";
	$output .= '<script src="'.SEED_CSP4_PLUGIN_URL.'themes/default/js/modernizr.min.js"></script>'."\n";

	return $output;
}

function seed_csp4_footer() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';


	if(!empty($bg_cover)){
		$output .= '<!--[if lt IE 9]>
		<script>
		jQuery(document).ready(function($){';

	
		$output .= '$.supersized({';
		$output .= "slides:[ {image : '$bg_image'} ]";
		$output .= '});';
	

		$output .= '});
		</script>
		<![endif]-->';
	}


	if ( !empty( $footer_scripts ) ) {
		$output .= "<!-- Footer Scripts -->\n";
		$output .= $footer_scripts;
	}

	return $output;
}

function seed_csp4_logo() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $logo ) ) {
		$output .= "<img id='seed-csp4-image' src='$logo'>";
	}

	return  $output;
}

function seed_csp4_headline() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $headline ) ) {
		$output .= '<h1 id="seed-csp4-headline">'.$headline.'</h1>';
	}

	return  $output;
}

function seed_csp4_description() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $description ) ) {
		$output .= '<div id="seed-csp4-description">'.shortcode_unautop(wpautop(convert_chars(wptexturize($description)))).'</div>';
	}

	return  $output;
}

function seed_csp4_append_html() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $append_html) ) {
		$output .= '<div id="coming-soon-custom-html">'.$append_html.'</div>';
	}

	return  $output;
}

function seed_csp4_credit() {
	$o = seed_csp4_get_settings();
	extract( $o );

	$output = '';

	if ( !empty( $footer_credit ) ) {
		$output = '<div id="seed-csp4-credit">';
		$output .= '<a target="_blank" href="http://www.seedprod.com/?utm_source=coming-soon-credit-link&utm_medium=banner&utm_campaign=coming-soon-plugin-credit-link"><img src="'.plugins_url('coming-soon',dirname('.')).'/themes/default/images/seedprod-credit.png"></a>';
		$output .= '</div>';
	}

	return  $output;
}