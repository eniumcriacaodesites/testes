<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage estore
 * @since estore 1.0
 */

add_action( 'widgets_init', 'estore_widgets_init' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function estore_widgets_init() {
	// Registering Right Sidebar
   register_sidebar( array(
      'name'          => esc_html__( 'Right Sidebar', 'estore' ),
      'id'            => 'estore_sidebar_right',
      'description'   => '',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4 class="widget-title"><span>',
      'after_title'   => '</span></h4>'
   ) );
	// Registering Left Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'estore' ),
		'id'            => 'estore_sidebar_left',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>'
	) );
   // Register Header Right Sidebar
   register_sidebar( array(
      'name'          => esc_html__( 'Header Right Sidebar', 'estore' ),
      'id'            => 'estore_sidebar_header',
      'description'   => '',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4 class="widget-title"><span>',
      'after_title'   => '</span></h4>'
   ) );

	// Register Slider Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page: Slider Area', 'estore' ),
		'id'            => 'estore_sidebar_slider',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>'
	) );

	// Register Area beside slider Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page: Area beside Slider', 'estore' ),
		'id'            => 'estore_sidebar_slider_beside',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>'
	) );

   // Register Front Page Sidebar
   register_sidebar( array(
      'name'          => esc_html__( 'Front Page Sidebar', 'estore' ),
      'id'            => 'estore_sidebar_front',
      'description'   => '',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4 class="widget-title">',
      'after_title'   => '</h4>'
   ) );

	// Footer Widgets
	$footer_sidebar_count = get_theme_mod('estore_footer_widgets', '4');

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 1', 'estore' ),
		'id'            => 'estore_footer_sidebar1',
		'description'   => esc_html__( 'Show widgets at Footer section', 'estore' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );

	if ( $footer_sidebar_count >= 2 ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Sidebar 2', 'estore' ),
			'id'            => 'estore_footer_sidebar2',
			'description'   => esc_html__( 'Show widgets at Footer section', 'estore' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );
	}

	if ( $footer_sidebar_count >= 3 ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Sidebar 3', 'estore' ),
			'id'            => 'estore_footer_sidebar3',
			'description'   => esc_html__( 'Show widgets at Footer section', 'estore' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );
	}

	if ($footer_sidebar_count >= 4 ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Sidebar 4', 'estore' ),
			'id'            => 'estore_footer_sidebar4',
			'description'   => esc_html__( 'Show widgets at Footer section', 'estore' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );
	}

	// Widgets Registration
	register_widget( "estore_728x90_ad" );
	register_widget( "estore_about" );
	register_widget( "estore_featured_posts_widget" );
	register_widget( "estore_logo_widget" );
	register_widget( "estore_featured_posts_slider_widget" );
	register_widget( "estore_featured_posts_carousel_widget" );
	register_widget( "estore_posts_grid" );
	register_widget( "estore_vertical_promo_widget" );
	register_widget( "estore_full_width_promo_widget" );
}

// 728 X 90 Advertisement Widget
class estore_728x90_ad extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_image_with_link',
			'description' => esc_html__( 'Add your Advertisement here', 'estore')
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false,$name= esc_html__( 'TG: Advertisement', 'estore' ),$widget_ops);
	}

	function form( $instance ) {
		$instance                = wp_parse_args( (array) $instance, array( 'title' => '', '728x90_image_url' => '', '728x90_image_link' => '') );
		$title                   = esc_attr( $instance[ 'title' ] );

		$image_link              = '728x90_image_link';
		$image_url               = '728x90_image_url';

		$instance[ $image_link ] = esc_url( $instance[ $image_link ] );
		$instance[ $image_url ]  = esc_url( $instance[ $image_url ] );

	?>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<label><?php esc_html_e( 'Add your Advertisement Images Here. Any size supported.', 'estore' ); ?></label>
	<p>
		<label for="<?php echo $this->get_field_id( $image_link ); ?>"> <?php esc_html_e( 'Advertisement Image Link ', 'estore' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( $image_link ); ?>" name="<?php echo $this->get_field_name( $image_link ); ?>" value="<?php echo $instance[$image_link]; ?>"/>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( $image_url ); ?>"> <?php esc_html_e( 'Advertisement Image ', 'estore' ); ?></label>
		<div class="media-uploader" id="<?php echo $this->get_field_id( $image_url ); ?>">
			<div class="custom_media_preview">
				<?php if ( $instance[ $image_url ] != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ $image_url ] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( $image_url ); ?>" name="<?php echo $this->get_field_name( $image_url ); ?>" value="<?php echo esc_url( $instance[$image_url] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( $image_url ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'estore' ); ?></button>
		</div>
	</p>

	<?php }
	function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance[ 'title' ]     = sanitize_text_field( $new_instance[ 'title' ] );

		$image_link              = '728x90_image_link';
		$image_url               = '728x90_image_url';

		$instance[ $image_link ] = esc_url_raw( $new_instance[ $image_link ] );
		$instance[ $image_url ]  = esc_url_raw( $new_instance[ $image_url ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$title      = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '' );

		$image_link = '728x90_image_link';
		$image_url  = '728x90_image_url';

		$image_link   = isset( $instance[ $image_link ] ) ? $instance[ $image_link ] : '';
		$image_url    = isset( $instance[ $image_url ] ) ? $instance[ $image_url ] : '';


		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Advertisement Image' . $this->id, $image_url );
			icl_register_string( 'eStore', 'TG: Advertisement Image Link' . $this->id, $image_link );
		}
		if ( function_exists( 'icl_t' ) ) {
			$image_url  = icl_t( 'eStore', 'TG: Advertisement Image'. $this->id, $image_url );
			$image_link = icl_t( 'eStore', 'TG: Advertisement Image Link'. $this->id, $image_link );
		}

		echo $before_widget; ?>

		<div class="image_with_link">
			<?php if ( !empty( $title ) ) { ?>
			<div class="image_with_link-title">
				<?php echo $before_title. esc_html( $title ) . $after_title; ?>
			</div>
			<?php }
			$output = '';
			if ( !empty( $image_url ) ) {
				$output .= '<div class="image_with_link-content">';
				if ( !empty( $image_link ) ) {
				$output .= '<a href="'.esc_url($image_link).'" class="single_image_with_link" target="_blank" rel="nofollow">
								<img src="'.esc_url($image_url).'" />
							</a>';
				} else {
					$output .= '<img src="'.esc_url($image_url).'" />';
				}
				$output .= '</div>';
				echo $output;
			} ?>
		</div>
		<?php
		echo $after_widget;
	}
}

// Estore About Widget
class estore_about extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-about clearfix',
			'description' => esc_html__( 'Show your about page. Suitable for Click to Action.', 'estore' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'TG: About Widget', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'page_id' ]          = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$page_id          = absint( $instance[ 'page_id' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p><?php esc_html_e('Select a page to display Title, Excerpt and Featured image.', 'estore') ?></p>
		<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php esc_html_e( 'Page', 'estore' ); ?>:</label>

		<?php wp_dropdown_pages( array(
			'show_option_none'  => ' ',
			'name'              => $this->get_field_name( 'page_id' ),
			'selected'          => $instance[ 'page_id' ]
			) );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ]          = sanitize_text_field( $new_instance[ 'title' ] );
		$instance[ 'page_id' ]        = absint( $new_instance[ 'page_id' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$page_id          = isset( $instance[ 'page_id' ] ) ? $instance[ 'page_id' ] : '';

		echo $before_widget; ?>
		<div class="section-wrapper">
		<?php if( $page_id ) : ?>
			<?php if( get_the_post_thumbnail($page_id) != '' ) : ?>
				<figure class="about-img">
					<?php echo get_the_post_thumbnail ( $page_id, 'full', '' ); ?>
				</figure>
			<?php endif; ?>
			<div class="tg-container">
				<div class="about-content-wrapper">
					<div class="about-block">
					<?php
					$the_query = new WP_Query( 'page_id='.$page_id );
						while( $the_query->have_posts() ):$the_query->the_post();
							$title_attribute = the_title_attribute( 'echo=0' );

							$output   = '<h3 class="about-title"><a href="' . esc_url( get_permalink() ) . '">' . $title . '</a></h3>';

							$output  .= '<h4 class="about-sub-title">'. get_the_title() .'</h4>';

							$output .= '<div class="about-content">' . get_the_excerpt() . '</div>';

							$output .= '</div>';
							echo $output;
							?>
					</div>
					<?php endwhile;

					// Reset Post Data
					wp_reset_postdata(); ?>
			</div><!-- .about-content-wrapper -->
				<?php endif; ?>
		</div><!-- .tg-container -->
	<?php echo $after_widget;
	}
}

// Full Width Promo Widget
class estore_woocommerce_full_width_promo_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
					'classname'   => 'widget_full_width_promo widget-collection-thumb clearfix',
					'description' => esc_html__( 'Display WooCommerce Product Categories with featured image in horizontal layout.', 'estore' ) );
		$control_ops = array(
				'width'  => 200,
				'height' => 250
			);
		parent::__construct( false, $name = esc_html__( 'TG: Horizontal Promo WC Category', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		for ( $i=0; $i<3; $i++ ) {
			$var = 'cat_id'.$i;
			$defaults[$var] = '';
		}

		$instance = wp_parse_args( (array) $instance, $defaults );
		for ( $i=0; $i<3; $i++ ) {
			$var = 'cat_id'.$i;
			$var = absint( $instance[ $var ] );
		}

		for( $i=0; $i<3; $i++) { ?>
			<p>
				<label for="<?php echo $this->get_field_id( 'cat_id'.$i ); ?>"><?php esc_html_e( 'Category', 'estore' ); ?>:</label>
				<?php wp_dropdown_categories(
					array(
						'show_option_none' => ' ',
						'name'             => $this->get_field_name( 'cat_id'.$i ),
						'selected'         => $instance['cat_id'.$i],
						'taxonomy'         => 'product_cat'
					)
				);
				?>
			</p>
		<?php
		next( $defaults );// forwards the key of $defaults array
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for( $i=0; $i<3; $i++ ) {
			$var = 'cat_id'.$i;
			$instance[ $var] = absint( $new_instance[ $var ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$cat_array = array();
		for( $i=0; $i<3; $i++ ) {
			$var = 'cat_id'.$i;
			$cat_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';

 			if( !empty( $cat_id ) ) {
				array_push( $cat_array, $cat_id );// Push the category id in the array
 			}
		}

		$get_featured_cats = array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'date',
			'hide_empty'   => '0',
			'include'      => $cat_array
		);
		echo $before_widget; ?>
		<div class="tg-container">
			<div class="tg-column-wrapper clearfix">
			<?php
			if( !empty($cat_array) ) {
				$all_categories = get_categories( $get_featured_cats );
				$j = 1;
 				foreach ($all_categories as $cat) {
					$cat_id   = $cat->term_id;
					$cat_link = get_term_link( $cat_id );
				?>
				<div class="tg-column-3 collection-thumb-block">
					<a href="<?php echo esc_url( $cat_link ); ?>">
						<figure class="collection-thumb-img">
						<?php
						$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
						//$image = wp_get_attachment_url( $thumbnail_id );
						$image = wp_get_attachment_image_src( $thumbnail_id, 'estore-featured-image');
						if ( $image[0] ) {
							echo '<img src="' . esc_url( $image[0] ) . '" alt="" />';
						}
						// @todo: Default Place holder image needed
						?>
						</figure>
						<span class="collection-thumb-hover">
							<span class="collection-thumb-title-wrapper">
								<span class="collection-thumb-title"><?php echo esc_html( $cat->name ); ?></span>
								<span class="collection-thumb-sub-title"><?php echo esc_html( $cat->description ); ?></span>
							</span>
						</span> <!-- collection-thumb-hover end -->
					</a>
				</div>
				<?php $j++; ?>
			<?php } // Foreach
			// Reset Post Data
			wp_reset_postdata();
			} // check $cat_array is empty
			?>
			</div>
		</div>
		<?php
		echo $after_widget;
	}
}

// Horizontal Promo - From Pages
class estore_full_width_promo_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
					'classname'   => 'widget_full_width_promo widget-collection-thumb clearfix',
					'description' => esc_html__( 'Display some pages with featured image in horizontal layout.', 'estore' ) );
		$control_ops = array(
				'width'  => 200,
				'height' => 250
			);
		parent::__construct( false, $name = esc_html__( 'TG: Horizontal Promo', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		for ( $i=0; $i<3; $i++ ) {
			$var = 'page_id'.$i;
			$defaults[$var] = '';
		}

		$instance = wp_parse_args( (array) $instance, $defaults );
		for ( $i=0; $i<3; $i++ ) {
			$var = 'page_id'.$i;
			$var = absint( $instance[ $var ] );
		}

		for( $i=0; $i<3; $i++) { ?>
			<p>
				<label for="<?php echo $this->get_field_id( 'page_id'.$i ); ?>"><?php esc_html_e( 'Pages', 'estore' ); ?>:</label>
				<?php wp_dropdown_pages( array(
					'show_option_none'  => ' ',
					'name'              => $this->get_field_name( key($defaults) ),
					'selected'          => $instance[ key($defaults) ]
				) );
				?>
			</p>
		<?php
		next( $defaults );// forwards the key of $defaults array
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for( $i=0; $i<3; $i++ ) {
			$var = 'page_id'.$i;
			$instance[ $var] = absint( $new_instance[ $var ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$page_array = array();
		for( $i=0; $i<3; $i++ ) {
			$var = 'page_id'.$i;
			$page_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';

 			if( !empty( $page_id ) ) {
				array_push( $page_array, $page_id );// Push the category id in the array
 			}
		}

		$get_featured_pages = new WP_Query( array(
			'posts_per_page'        => 3,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
		) );
		echo $before_widget; ?>
		<div class="tg-container">
			<div class="tg-column-wrapper clearfix">
			<?php
			if( !empty($page_array) ) {
				while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();

				if( !has_post_thumbnail() )
					return;
				?>
				<div class="tg-column-3 collection-thumb-block">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
						<figure class="collection-thumb-img">
						<?php echo get_the_post_thumbnail( $post->ID, 'estore-featured-image' ); ?>
						</figure>
						<span class="collection-thumb-hover">
							<span class="collection-thumb-title-wrapper">
								<span class="collection-thumb-title"><?php echo esc_html( get_the_title() ); ?></span>
							</span>
						</span> <!-- collection-thumb-hover end -->
					</a>
				</div>
			<?php
			endwhile;
			wp_reset_postdata();
			}
			?>
			</div>
		</div>
		<?php
		echo $after_widget;
	}
}

// Vertical Promo Widget
class estore_woocommerce_vertical_promo_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
					'classname'   => 'widget_vertical_promo collection-wrapper clearfix',
					'description' => esc_html__( 'Display WooCommerce Product Categories in vertical layout with featured image.', 'estore' ) );
		$control_ops = array(
				'width'  => 200,
				'height' => 250
			);
		parent::__construct( false, $name = esc_html__( 'TG: Vertical Promo WC Category', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		for ( $i=0; $i<2; $i++ ) {
			$var = 'cat_id'.$i;
			$defaults[$var] = '';
		}

		$instance = wp_parse_args( (array) $instance, $defaults );
		for ( $i=0; $i<2; $i++ ) {
			$var = 'cat_id'.$i;
			$var = absint( $instance[ $var ] );
		}

		for( $i=0; $i<2; $i++) { ?>
			<p>
				<label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php esc_html_e( 'Category', 'estore' ); ?>:</label>
				<?php wp_dropdown_categories(
					array(
						'show_option_none' => ' ',
						'name'             => $this->get_field_name( key($defaults) ),
						'selected'         => $instance[key($defaults)],
						'taxonomy'         => 'product_cat'
					)
				);
				?>
			</p>
		<?php
		next( $defaults );// forwards the key of $defaults array
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for( $i=0; $i<2; $i++ ) {
			$var = 'cat_id'.$i;
			$instance[ $var] = absint( $new_instance[ $var ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$cat_array = array();
		for( $i=0; $i<2; $i++ ) {
			$var = 'cat_id'.$i;
			$cat_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';

 			if( !empty( $cat_id ) ) {
				array_push( $cat_array, $cat_id );// Push the category id in the array
 			}
		}
		$get_featured_cats = array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'date',
			'hide_empty'   => '0',
			'include'      => $cat_array
		);
		echo $before_widget; ?>
			<?php
			if( !empty($cat_array) ) {
				$all_categories = get_categories( $get_featured_cats );
				$j = 1;
 				foreach ($all_categories as $cat) {
					$cat_id   = $cat->term_id;
					$cat_link = get_term_link( $cat_id );
				?>
				<div class="collection-block">
					<figure class="slider-collection-img">
					<?php
					$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
					//$image = wp_get_attachment_url( $thumbnail_id );
					$image = wp_get_attachment_image_src( $thumbnail_id, 'estore-featured-image');
					if ( $image[0] ) {
						echo '<img src="' . esc_url( $image[0] ) . '" alt="" />';
					}
					// @todo: Default Place holder image needed
					?>
					</figure>
					<h3 class="slider-title"><a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat->name ); ?></a></h3>
				</div>
				<?php $j++; ?>
			<?php } //foreach
			// Reset Post Data
			wp_reset_postdata();
			} // cat array check
			?>
		<?php
		echo $after_widget;
	}
}

// Vertical Promo Widget
class estore_vertical_promo_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
					'classname'   => 'widget_vertical_promo collection-wrapper clearfix',
					'description' => esc_html__( 'Display some pages in vertical layout with featured image.', 'estore' ) );
		$control_ops = array(
				'width'  => 200,
				'height' => 250
			);
		parent::__construct( false, $name = esc_html__( 'TG: Vertical Promo', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		for ( $i=0; $i<2; $i++ ) {
			$var = 'page_id'.$i;
			$defaults[$var] = '';
		}

		$instance = wp_parse_args( (array) $instance, $defaults );
		for ( $i=0; $i<2; $i++ ) {
			$var = 'page_id'.$i;
			$var = absint( $instance[ $var ] );
		}

		for( $i=0; $i<2; $i++) { ?>
			<p>
				<label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php esc_html_e( 'Pages', 'estore' ); ?>:</label>
				<?php wp_dropdown_pages( array(
					'show_option_none'  => ' ',
					'name'              => $this->get_field_name( key($defaults) ),
					'selected'          => $instance[ key($defaults) ]
				) );
			?>
			</p>
		<?php
		next( $defaults );// forwards the key of $defaults array
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for( $i=0; $i<2; $i++ ) {
			$var = 'page_id'.$i;
			$instance[ $var] = absint( $new_instance[ $var ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$page_array = array();
		for( $i=0; $i<2; $i++ ) {
			$var = 'page_id'.$i;
			$page_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';

 			if( !empty( $page_id ) ) {
				array_push( $page_array, $page_id );// Push the category id in the array
 			}
		}
		$get_featured_pages = new WP_Query( array(
			'posts_per_page'        => 2,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
		) );
		echo $before_widget; ?>
			<?php
			if( !empty($page_array) ) {
				while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();

				if( !has_post_thumbnail() )
					return;
				?>
				<div class="collection-block">
					<figure class="slider-collection-img">
						<?php echo get_the_post_thumbnail( $post->ID, 'estore-featured-image' ); ?>
					</figure>
					<h3 class="slider-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h3>
				</div>
				<?php endwhile;
				wp_reset_postdata();
			}
			?>
		<?php
		echo $after_widget;
	}
}

// Estore WooCommerce Product Carousel Widget
class estore_woocommerce_product_carousel extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-featured-collection featured-collection-color clearfix',
			'description' => esc_html__( 'Show WooCommerce Featured Products Carousel.', 'estore' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'TG: Products Carousel', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'subtitle' ]         = '';
		$defaults[ 'source' ]           = '';
		$defaults[ 'category' ]         = '';
		$defaults[ 'product_number' ]   = 10;
		$defaults[ 'hide_thumbnail_mask' ]   = 0;

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$subtitle         = esc_textarea( $instance[ 'subtitle' ] );
		$source           = $instance[ 'source' ];
		$category         = absint( $instance[ 'category' ] );
		$product_number   = absint( $instance[ 'product_number' ] );
		$hide_thumbnail_mask = $instance[ 'hide_thumbnail_mask' ] ? 'checked="checked"' : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','estore' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $subtitle; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'source' ); ?>"><?php esc_html_e( 'Product Source:', 'estore' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'source' ); ?>" name="<?php echo $this->get_field_name( 'source' ); ?>">
				<option value="latest" <?php selected( $instance['source'], 'latest'); ?>><?php esc_html_e( 'Latest Products', 'estore' ); ?></option>
				<option value="featured" <?php selected( $instance['source'], 'featured'); ?>><?php esc_html_e( 'Featured Products', 'estore' ); ?></option>
				<option value="sale" <?php selected( $instance['source'], 'sale'); ?>><?php esc_html_e( 'On Sale Products', 'estore' ); ?></option>
				<option value="category" <?php selected( $instance['source'], 'category'); ?>><?php esc_html_e( 'Certain Category', 'estore' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'estore' ); ?></label>
			<?php
			wp_dropdown_categories(
				array(
					'show_option_none' => '',
					'name'             => $this->get_field_name( 'category' ),
					'selected'         => $instance['category'],
					'taxonomy'         => 'product_cat'
				)
			);
			?>
		</p>


		<p>
			<label for="<?php echo $this->get_field_id( 'product_number' ); ?>"><?php esc_html_e( 'Number of Products:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'product_number' ); ?>" name="<?php echo $this->get_field_name( 'product_number' ); ?>" type="number" value="<?php echo $product_number; ?>" />
		</p>
		<p>
	    	<input class="checkbox" <?php echo $hide_thumbnail_mask; ?> id="<?php echo $this->get_field_id( 'hide_thumbnail_mask' ); ?>" name="<?php echo $this->get_field_name( 'hide_thumbnail_mask' ); ?>" type="checkbox" />
	    	<label for="<?php echo $this->get_field_id('hide_thumbnail_mask'); ?>"><?php esc_html_e( 'Check to hide image hover effect.', 'estore' ); ?></label>
	   	</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ]          = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'subtitle' ] =  $new_instance[ 'subtitle' ];
		else
			$instance[ 'subtitle' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'subtitle' ] ) ) );
		$instance[ 'source' ]         = $new_instance[ 'source' ];
		$instance[ 'category' ]       = absint( $new_instance[ 'category' ] );
		$instance[ 'product_number' ] = absint( $new_instance[ 'product_number' ] );
		$instance[ 'hide_thumbnail_mask' ]   = isset( $new_instance[ 'hide_thumbnail_mask' ] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$subtitle         = isset( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
		$source           = isset( $instance[ 'source' ] ) ? $instance[ 'source' ] : '';
		$category         = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$product_number   = isset( $instance[ 'product_number' ] ) ? $instance[ 'product_number' ] : '';
		$hide_thumbnail_mask = isset( $instance[ 'hide_thumbnail_mask' ] ) ? $instance[ 'hide_thumbnail_mask' ] : 0;

		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Product Carousel Subtitle' . $this->id, $subtitle );
		}
		if ( function_exists( 'icl_t' ) ) {
			$subtitle  = icl_t( 'eStore', 'TG: Product Carousel Subtitle'. $this->id, $subtitle );
		}

		if ( $source == 'featured' ) {
			$args = array(
				'post_type'        => 'product',
				'posts_per_page'   => $product_number,
				'tax_query' => array(
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					),
				)
			);
		} elseif ( $source == 'sale' ) {
			$args = array(
				'post_type'      => 'product',
				'meta_query'     => array(
				'relation' => 'OR',
					array( // Simple products type
						'key'           => '_sale_price',
						'value'         => 0,
						'compare'       => '>',
						'type'          => 'numeric'
					),
					array( // Variable products type
					'key'           => '_min_variation_sale_price',
					'value'         => 0,
					'compare'       => '>',
					'type'          => 'numeric'
					)
				),
				'posts_per_page'   => $product_number
			);
		} elseif ( $source == 'category' ){
			$args = array(
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy'  => 'product_cat',
						'field'     => 'id',
						'terms'     => $category
					)
				),
				'posts_per_page' => $product_number
			);
		} else {
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => $product_number
			);
		}
		echo $before_widget; ?>
		<div class="tg-container">
			<div class="section-title-wrapper clearfix">
				<div class="section-title-block">
					<?php if ( !empty( $title ) ) { ?>
					<h3 class="page-title"><?php echo esc_html( $title ); ?></h3>
					<?php }
					if ( !empty( $subtitle ) ) { ?>
					<h4 class="page-sub-title"><?php echo esc_textarea( $subtitle );?></h4>
					<?php } ?>
				</div>
			</div>
			<div class="featured-wrapper clearfix">
				<ul class="featured-slider">
				<?php
				$featured_query = new WP_Query( $args );
				while ($featured_query->have_posts()) :
					$featured_query->the_post();
					$product = wc_get_product( $featured_query->post->ID ); ?>
					<li>
					<?php
						$image_id = get_post_thumbnail_id();
						$image_url = wp_get_attachment_image_src($image_id,'estore-square', false); ?>
						<figure class="featured-img">
							<?php if($image_url[0]) { ?>
								<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" alt="<?php the_title(); ?>"><img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>"></a>
							<?php } else { ?>
								<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" alt="<?php the_title(); ?>"><img src="<?php echo estore_woocommerce_placeholder_img_src(); ?>" alt="<?php the_title_attribute(); ?>"></a>
							<?php } ?>
							<?php if ( $product->is_on_sale() ) : ?>
								<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sales-tag">' . esc_html__( 'Sale!', 'estore' ) . '</div>', $post, $product ); ?>
							<?php endif; ?>

							<?php if ( $hide_thumbnail_mask != 1 ) : ?>
								<div class="featured-hover-wrapper">
									<div class="featured-hover-block">
										<?php if($image_url[0]) { ?>
										<a href="<?php echo esc_url( $image_url[0] ); ?>" class="zoom" data-rel="prettyPhoto"><i class="fa fa-search-plus"> </i></a>
										<?php } else {?>
										<a href="<?php echo estore_woocommerce_placeholder_img_src(); ?>"  class="zoom" data-rel="prettyPhoto"><i class="fa fa-search-plus"> </i></a>
										<?php }
										woocommerce_template_loop_add_to_cart( $product ); ?>
									</div>
								</div><!-- featured hover end -->
							<?php endif; ?>
						</figure>
						<div class="featured-content-wrapper">
							<h3 class="featured-title"> <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="woocommerce-product-rating woocommerce"> <?php
								 if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) { ?>
										<?php echo $rating_html; ?>
									<?php } else {
										echo '<div class="star-rating"></div>' ;
									}?>
							</div>
							<?php if ( $price_html = $product->get_price_html() ) : ?>
								<span class="price"><span class="price-text"><?php esc_html_e('Price:', 'estore'); ?></span><?php echo $price_html; ?></span>
							<?php endif; ?>

							<?php
							if( function_exists( 'YITH_WCWL' ) ){
								$url = add_query_arg( 'add_to_wishlist', $product->get_id() );
							?>
							<a href="<?php echo esc_url($url); ?>" class="single_add_to_wishlist" ><?php esc_html_e('Add to Wishlist','estore'); ?><i class="fa fa-heart"></i></a>
							<?php } ?>
						</div><!-- featured content wrapper -->
					</li>
				<?php
				endwhile;
				?>
				</ul>
			</div>
		</div>

		<?php wp_reset_postdata(); ?>
		<?php
		echo $after_widget;
	}
}

// Estore WooCommerce Product Grid Widget
class estore_woocommerce_product_grid extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-collection clearfix',
			'description' => esc_html__( 'Show WooCommerce Featured Products Grid.', 'estore' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'TG: Product Grid', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'subtitle' ]         = '';
		$defaults[ 'category']          = '';
		$defaults[ 'product_number' ]   = 10;
		$defaults[ 'cat_image_url' ]    = '';
		$defaults[ 'cat_image_link' ]   = '';
		$defaults[ 'align' ]            = 'collection-left-align';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$subtitle         = esc_textarea( $instance[ 'subtitle' ] );
		$cat_image_url    = esc_url( $instance[ 'cat_image_url' ] );
		$cat_image_link   = esc_url( $instance[ 'cat_image_link' ] );
		$align            = $instance[ 'align' ];
		$category         = absint( $instance[ 'category' ] );
		$product_number   = absint( $instance[ 'product_number' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','estore' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $subtitle; ?></textarea>

		<label><?php esc_html_e( 'Add your Category Image here.', 'estore' ); ?></label>

		<p>
			<label for="<?php echo $this->get_field_id( 'cat_image_link' ); ?>"> <?php esc_html_e( 'Image Link', 'estore' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'cat_image_link' ); ?>" name="<?php echo $this->get_field_name( 'cat_image_link' ); ?>" value="<?php echo $instance[ 'cat_image_link' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_image_url' ); ?>"> <?php esc_html_e( 'Category Image', 'estore' ); ?></label>
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ 'cat_image_url' ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'cat_image_url' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>" name="<?php echo $this->get_field_name( 'cat_image_url' ); ?>" value="<?php echo esc_url( $instance['cat_image_url'] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'estore' ); ?></button>
			</div>
		</p>

		<label><?php esc_html_e( 'Choose where to align your image.', 'estore' ); ?></label>

		<p>
			<input type="radio" <?php checked( $align, 'collection-right-align' ) ?> id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" value="collection-right-align" /><?php esc_html_e( 'Right Align', 'estore' );?><br />
			<input type="radio" <?php checked( $align,'collection-left-align' ) ?> id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" value="collection-left-align" /><?php esc_html_e( 'Left Align', 'estore' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'estore' ); ?></label>
			<?php
			wp_dropdown_categories(
				array(
					'show_option_none' => '',
					'name'             => $this->get_field_name( 'category' ),
					'selected'         => $instance['category'],
					'taxonomy'         => 'product_cat'
				)
			);
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'product_number' ); ?>"><?php esc_html_e( 'Number of Products:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'product_number' ); ?>" name="<?php echo $this->get_field_name( 'product_number' ); ?>" type="number" value="<?php echo $product_number; ?>" />
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ]          = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'subtitle' ] =  $new_instance[ 'subtitle' ];
		else
			$instance[ 'subtitle' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'subtitle' ] ) ) );
		$instance[ 'category' ]       = absint( $new_instance[ 'category' ] );

		$instance[ 'product_number' ] = absint( $new_instance[ 'product_number' ] );

		$instance[ 'cat_image_link' ] = esc_url_raw( $new_instance[ 'cat_image_link' ] );
		$instance[ 'cat_image_url' ]  = esc_url_raw( $new_instance[ 'cat_image_url' ] );
		$instance[ 'align' ]          = $new_instance[ 'align' ];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$subtitle         = isset( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';

		$cat_image_link   = isset( $instance[ 'cat_image_link' ] ) ? $instance[ 'cat_image_link' ] : '';
		$cat_image_url    = isset( $instance[ 'cat_image_url' ] ) ? $instance[ 'cat_image_url' ] : '';
		$align            = isset( $instance[ 'align' ] ) ? $instance[ 'align' ] : 'collection-left-align' ;

		$category         = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$product_number   = isset( $instance[ 'product_number' ] ) ? $instance[ 'product_number' ] : '';

		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Product Grid Subtitle' . $this->id, $subtitle );
			icl_register_string( 'eStore', 'TG: Product Grid Image' . $this->id, $cat_image_url );
			icl_register_string( 'eStore', 'TG: Product Grid Image Link' . $this->id, $cat_image_link );
		}
		if ( function_exists( 'icl_t' ) ) {
			$subtitle       = icl_t( 'eStore', 'TG: Product Grid Subtitle'. $this->id, $subtitle );
			$cat_image_url  = icl_t( 'eStore', 'TG: Product Grid Image'. $this->id, $cat_image_url );
			$cat_image_link = icl_t( 'eStore', 'TG: Product Grid Image Link'. $this->id, $cat_image_link );
		}

		$args = array(
			'post_type' => 'product',
			'orderby'   => 'date',
			'tax_query' => array(
				array(
					'taxonomy'  => 'product_cat',
					'field'     => 'id',
					'terms'     => $category
				)
			),
			'posts_per_page' => $product_number
		);
		echo $before_widget; ?>
		<div class="tg-container estore-cat-color_<?php echo $category; ?> <?php echo $align; ?>">
			<div class="section-title-wrapper clearfix">
				<div class="section-title-block">
					<?php if ( !empty( $title ) ) { ?>
					<h3 class="page-title"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $title ); ?></a></h3>
					<?php }
					if ( !empty( $subtitle ) ) { ?>
					<h4 class="page-sub-title"><?php echo esc_textarea( $subtitle );?></h4>
					<?php } ?>
				</div>
				<div class="sorting-form-wrapper">
					<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php esc_html_e( 'View all', 'estore' ); ?></a>
				</div>
			</div>
			<div class="collection-block-wrapper tg-column-wrapper clearfix">
				<div class="tg-column-4 collection-block">
						<?php
						$output = '';
						if ( !empty( $cat_image_url ) ) {
							if ( !empty( $cat_image_link ) ) {
							$output .= '<a href="'.esc_url($cat_image_link).'" target="_blank" rel="nofollow">
											<img src="'.esc_url($cat_image_url).'" alt="'.esc_html($title).'" />
										</a>';
							} else {
								$output .= '<img src="'.esc_url($cat_image_url).'" alt="'.esc_html($title).'" />';
							}
							echo $output;
						} ?>
				</div>
				<?php
				$count = 1;
				$featured_query = new WP_Query( $args );
				while ($featured_query->have_posts()) :
					$featured_query->the_post();
					$product = wc_get_product( $featured_query->post->ID );
				if($count == 1){ ?>
				<div class="tg-column-4 collection-block">
					<div class="hot-product-block">
						<h3 class="hot-product-title"><?php esc_html_e( 'Hot products', 'estore' ); ?></h3>
						<div class="hot-product-content-wrapper clearfix">
							<?php
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'estore-medium-image', false); ?>
							<figure class="hot-img">
								<a href="<?php the_permalink(); ?>">
									<?php if($image_url) { ?>
									<img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>">
									<?php } else { ?>
										<img src="<?php echo get_template_directory_uri() . '/images/placeholder-shop-380x250.jpg'; ?>" alt="<?php the_title_attribute(); ?>" width="250" height="180" >
									<?php } ?>
								</a>
								<div class="cart-price-wrapper clearfix">
									<?php woocommerce_template_loop_add_to_cart( $product ); ?>
									<?php if ( $price_html = $product->get_price_html() ) : ?>
									<span class="hot-price price"><?php echo $price_html; ?></span>
								<?php endif; ?>
								</div>
								<?php if ( $product->is_on_sale() ) : ?>
									<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sales-tag">' . esc_html__( 'Sale!', 'estore' ) . '</div>', $post, $product ); ?>
								<?php endif; ?>
							</figure>
							<div class="hot-content-wrapper">
								<h3 class="hot-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="hot-content"><?php the_excerpt(); ?></div>
								<!-- Rating products -->
								<div class="woocommerce-product-rating woocommerce">
									<?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) { ?>
										<?php echo $rating_html; ?>
									<?php } else {
										echo '<div class="star-rating"></div>' ;
									}?>
								</div>
								<?php
								if( function_exists( 'YITH_WCWL' ) ){
									$url = add_query_arg( 'add_to_wishlist', $product->get_id() );
								?>
									<a href="<?php echo esc_url($url); ?>" class="single_add_to_wishlist" ><?php esc_html_e('Add to Wishlist','estore'); ?><i class="fa fa-heart"></i></a>
								<?php } ?>
							</div> <!-- hot-content-wrapper end -->
						</div> <!-- hot-product-content-wrapper end -->
					</div> <!-- hot product block end -->
				</div>
				<?php }

				if($count == 2 || $count == 7){ ?>
					<div class="tg-column-4 collection-block">
						<div class="product-list-wrap">
				<?php }
					if($count > 1 && $count < 7 || $count > 6) { ?>
						<div class="product-list-block clearfix">
						<?php
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'estore-product-grid', false); ?>
							<figure class="product-list-img">
								<a href="<?php the_permalink(); ?>">
									<?php if($image_url[0]) { ?>
									<img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>">
									<?php } else { ?>
										<img src="<?php echo estore_woocommerce_placeholder_img_src(); ?>" alt="<?php the_title_attribute(); ?>" width="75" height="75">
									<?php } ?>
								</a>
							</figure>
							<div class="product-list-content">
								<h3 class="product-list-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
								<?php if ( $price_html = $product->get_price_html() ) : ?>
									<span class="price"><span class="price-text"><?php esc_html_e('Price: ', 'estore'); ?></span><?php echo $price_html; ?></span>
								<?php endif; ?>
								<div class="cart-wishlist-btn">
								<?php
								if( function_exists( 'YITH_WCWL' ) ){
									$url = add_query_arg( 'add_to_wishlist', $product->get_id() );
								?>
									<a href="<?php echo esc_url($url); ?>" class="single_add_to_wishlist" ><?php esc_html_e('Add to Wishlist','estore'); ?><i class="fa fa-heart"></i></a>
								<?php }
									woocommerce_template_loop_add_to_cart( $product );
								?>

								</div> <!-- cart-wishlist-btn end -->
							</div>
						</div>
				<?php } // Closing div for columns
				if($count == 6){ ?>
					</div>
				</div>
				<?php }
				$count++;
				endwhile;
				wp_reset_postdata();
				?>
			</div><!-- collection-block-wrapper tg-column-wrapper clearfix -->
			</div>
		<?php
		echo $after_widget;
	}
}

// Estore Featured Post Widget
class estore_featured_posts_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_featured_posts_block blog-section',
			'description' => esc_html__( 'Display latest posts or posts of specific category', 'estore')
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false,$name= esc_html__( 'TG: Featured Posts', 'estore' ),$widget_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]      = '';
		$defaults[ 'number' ]     = 3;
		$defaults[ 'type' ]       = 'latest';
		$defaults[ 'category' ]   = '';

		$instance = wp_parse_args( (array) $instance, $defaults );


		$title       = esc_attr( $instance[ 'title' ] );
		$number      = absint( $instance[ 'number' ] );
		$type        = $instance[ 'type' ];
		$category    = $instance[ 'category' ];
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to display:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input type="radio" <?php checked( $type, 'latest' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show latest Posts', 'estore' );?><br />
			<input type="radio" <?php checked( $type,'category' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show posts from a category', 'estore' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'estore' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
		</p>

		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ]       = sanitize_text_field( $new_instance[ 'title' ] );
		$instance[ 'number' ]      = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]        = $new_instance[ 'type' ];
		$instance[ 'category' ]    = $new_instance[ 'category' ];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title       = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$number      = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
		$type        = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category    = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'ignore_sticky_posts'   => true
		) );
		}
		else {
		$get_featured_posts = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             => 'post',
			'category__in'          => $category
		) );
	}

	echo $before_widget; ?>

		<div class="tg-container">
			<div class="secton-title-wrapper">
				<?php if ( !empty( $title ) ) { echo $before_title . esc_html( $title ) . $after_title; } ?>
			</div>

			<div class="blog-wrapper tg-column-wrapper clearfix">
				<?php
				while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post(); ?>
				<div <?php post_class(); ?>>
				<div class="tg-column-3 blog-block">
					<figure class="entry-thumbnail">
						<?php

						$time_string = '<time class="posted-on" datetime="%1$s"><a href="%3$s" title="%4$s">%2$s</a></time>';

						$time_string = printf( $time_string,
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date( 'M j' ) ),
							esc_html( esc_url( get_the_permalink() ) ),
							esc_html( the_title_attribute('echo=0') )
							);

						?>

						<?php
						if( has_post_thumbnail() ) {
							the_post_thumbnail('estore-featured-image');
						} else { ?>
							<img src='<?php echo get_template_directory_uri(); ?>/images/placeholder-blog-380x250.jpg' alt='<?php esc_attr__('Blog Image', 'estore');?>' width="380" height="250" />
						<?php } ?>
					</figure>


					<h4 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a></h4>

					<div class="entry-content-text-wrapper clearfix">

						<div class="entry-content-wrapper">
							<div class="entry-meta">
								<span class="byline author vcard"><i class="fa fa-user"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr(get_the_author()); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>

								<span class="comments-link"><i class="fa fa-comments-o"></i><?php comments_popup_link( esc_html__( '0 Comment', 'estore' ), esc_html__( '1 Comment', 'estore' ), esc_html__( ' % Comments', 'estore' ) ); ?></span>

								<span class="cat-links"><i class="fa fa-folder-open"></i><?php the_category(', '); ?></span>

								<?php $tags_list = get_the_tag_list( '<span class="tag-links">', ', ', '</span>' );
									if ( $tags_list ) echo $tags_list;
								?>
							</div>
							<div class="entry-content">
								<?php the_excerpt(); ?>
							</div>
							<div class="entry-btn">
								<a class="btn" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php echo esc_html_e( 'Read more' , 'estore' ) ?></a>
							</div>
						</div>
					</div>
				</div>
				</div><!-- .post_class -->
				<?php
				endwhile;
				?>
			</div><!-- .blog-wrapper -->
		</div><!-- .tg-container -->
	<?php
		// Reset Post Data
		wp_reset_postdata();
		echo $after_widget;
	}
}

// Clients/Brands Logo Widget
class estore_logo_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_logo clearfix',
			'description' => esc_html__( 'Add your clients/brand logo images here', 'estore')
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false,$name= esc_html__( 'TG: Logo', 'estore' ),$widget_ops);
	}

	function form( $instance ) {
		$instance 	= wp_parse_args( (array) $instance,
						array(
							'title'        => '',
							'logo_image1'  => '',
							'logo_link1'   => '',
							'logo_image2'  => '',
							'logo_link2'   => '',
							'logo_image3'  => '',
							'logo_link3'   => '',
							'logo_image4'  => '',
							'logo_link4'   => '',
							'logo_image5'  => '',
							'logo_link5'   => '',
						)
					);
		$title 		= esc_attr( $instance[ 'title' ] );

		for ( $i = 1; $i < 6; $i++ ) {
			$image_link = 'logo_link'.$i;
			$image_url  = 'logo_image'.$i;

			$instance[ $image_link ] = esc_url( $instance[ $image_link ] );
			$instance[ $image_url ]  = esc_url( $instance[ $image_url ] );
		}

	?>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<label><?php esc_html_e( 'Add your clients/brands logo Here', 'estore' ); ?></label>
	<?php
		for ( $i = 1; $i < 6 ; $i++ ) {
			$image_link = 'logo_link'.$i;
			$image_url = 'logo_image'.$i;
	?>
	<p>
		<label for="<?php echo $this->get_field_id( $image_link ); ?>"> <?php esc_html_e( 'Logo Link ', 'estore' ); echo $i; ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( $image_link ); ?>" name="<?php echo $this->get_field_name( $image_link ); ?>" value="<?php echo $instance[$image_link]; ?>"/>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( $image_url ); ?>"> <?php esc_html_e( 'Logo Image ', 'estore' ); echo $i; ?></label>
		<div class="media-uploader" id="<?php echo $this->get_field_id( $image_url ); ?>">
			<div class="custom_media_preview">
				<?php if ( $instance[ $image_url ] != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ $image_url ] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( $image_url ); ?>" name="<?php echo $this->get_field_name( $image_url ); ?>" value="<?php echo esc_url( $instance[$image_url] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( $image_url ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'estore' ); ?></button>
		</div>
	</p>

	<?php } // Loop ending
	}
	function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance[ 'title' ]     = sanitize_text_field( $new_instance[ 'title' ] );

		for ( $i = 1; $i < 7; $i++ ) {
			$image_link = 'logo_link'.$i;
			$image_url  = 'logo_image'.$i;

			$instance[ $image_link ] = esc_url_raw( $new_instance[ $image_link ] );
			$instance[ $image_url ]  = esc_url_raw( $new_instance[ $image_url ] );
      }

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$title       = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');

		$image_array = array();
		$link_array  = array();

		$j = 0;
		for ( $i = 1; $i < 6; $i++ ) {
			$image_link = 'logo_link'.$i;
			$image_url  = 'logo_image'.$i;

			$image_link = isset( $instance[ $image_link ] ) ? $instance[ $image_link ] : '';
			$image_url = isset( $instance[ $image_url ] ) ? $instance[ $image_url ] : '';

			array_push( $link_array, $image_link );
			array_push( $image_array, $image_url );

			// For Multilingual compatibility
			if ( function_exists( 'icl_register_string' ) ) {
				icl_register_string( 'eStore', 'TG: Logo Image' . $this->id.$j, $image_array[$j] );
				icl_register_string( 'eStore', 'TG: Logo Link' . $this->id.$j, $link_array[$j] );
			}

			$j++;
		}

		echo $before_widget; ?>

		<div class="tg-container">
			<div class="tg-column-wrapper">
			<?php if ( !empty( $title ) ) { ?>
				<?php echo $before_title. esc_html( $title ) . $after_title; ?>
			<?php }

			$output = '';
			if ( !empty( $image_array ) ) {
				$output .= '<div class="tg-column-wrapper">';
				for ( $i = 1; $i < 6; $i++ ) {
					$j = $i - 1;
					if( !empty( $image_array[$j] ) ) {
						$output .= '<div class="tg-column-5">';
						// For Multilingual compatibility
						if ( function_exists( 'icl_t' ) ) {
							$image_array[$j] = icl_t( 'eStore', 'TG: Logo Image' . $this->id . $j , $image_array[$j] );
						}
						if( !empty( $link_array[$j] ) ) {
							if ( function_exists( 'icl_t' ) ) {
								$link_array[$j] = icl_t( 'eStore', 'TG: Logo Link' . $this->id . $j , $link_array[$j] );
							}

							$output .= '<a href="'.esc_url($link_array[$j]).'" class="logo-link" target="_blank"><img src="'.esc_url($image_array[$j]).'"></a>';
						} else {
							$output .= '<img src="'.esc_url($image_array[$j]).'">';
						}
						$output .= '</div>';
					}
				}
				$output .= '</div>';
				echo $output;
			}
			?>
			</div>
		</div>
		<?php
		echo $after_widget;
	}
}

// Featured Category Slider Widget
class estore_featured_posts_slider_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'slider_wrapper category-slider clearfix',
			'description' => esc_html__( 'Display latest posts or posts of specific category, which will be used as the slider.', 'estore' ) );

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false,$name= esc_html__( 'TG: Category Slider', 'estore' ), $widget_ops);
	}

	function form( $instance ) {
		$tg_defaults['number']   = 4;
		$tg_defaults['type']     = 'latest';
		$tg_defaults['category'] = '';

		$instance = wp_parse_args( (array) $instance, $tg_defaults );

		$number   = $instance['number'];
		$type     = $instance['type'];
		$category = $instance['category'];
	?>

	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of posts to display:', 'estore' ); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
	</p>

	<p>
		<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show latest Posts', 'estore' );?><br />
		<input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show posts from a category', 'estore' );?><br />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'estore' ); ?>:</label>
		<?php
		wp_dropdown_categories(
			array(
				'show_option_none' =>' ',
				'name'             => $this->get_field_name( 'category' ),
				'selected'         => $category
			)
		);
		?>
	</p>

	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'number' ]   = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]     = $new_instance[ 'type' ];
		$instance[ 'category' ] = $new_instance[ 'category' ];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$number   = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'ignore_sticky_posts'   => true
			) );
		}
		else {
		$get_featured_posts = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             => 'post',
			'category__in'          => $category
			) );
		}
		echo $before_widget;
		?>
		<ul class="home-slider">
		<?php
		while( $get_featured_posts->have_posts() ):
			$get_featured_posts->the_post();
			if( has_post_thumbnail() ) { ?>
			<li>
			<?php
				$title_attribute = get_the_title( $post->ID );
				the_post_thumbnail( $post->ID, 'estore-slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) );
			?>
				<div class="slider-caption-wrapper">
					<h3 class="slider-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
					<div class="slider-content"><?php the_excerpt(); ?></div>
					<a href="<?php the_permalink(); ?>" class="slider-btn"><?php esc_html_e( 'Read More', 'estore' ); ?></a>
				</div>
			</li>
		<?php
		}
		endwhile;
		// Reset Post Data
		wp_reset_postdata();
		?>
		</ul>
		<?php echo $after_widget;
	}
}

// WooCommerce Product Slider Widget
class estore_woocommerce_product_slider extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'slider_wrapper product-slider clearfix',
			'description' => esc_html__( 'Display WooCommerce Product from category.', 'estore' ) );

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false,$name = esc_html__( 'TG: Product Slider', 'estore' ), $widget_ops);
	}

	function form( $instance ) {
		$tg_defaults['number']   = 4;
		$tg_defaults['type']     = 'latest';
		$tg_defaults['category'] = '';

		$instance = wp_parse_args( (array) $instance, $tg_defaults );

		$number   = $instance['number'];
		$type     = $instance['type'];
		$category = $instance['category'];
	?>

	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of products to display:', 'estore' ); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
	</p>

	<p>
		<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show Latest Products', 'estore' );?><br />
		<input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show Products from a category', 'estore' );?><br />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'estore' ); ?>:</label>
		<?php
		wp_dropdown_categories(
			array(
				'show_option_none' => '',
				'name'             => $this->get_field_name( 'category' ),
				'selected'         => $instance['category'],
				'taxonomy'         => 'product_cat'
			)
		);
		?>
	</p>

	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'number' ]   = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]     = $new_instance[ 'type' ];
		$instance[ 'category' ] = $new_instance[ 'category' ];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$number   = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'product',
				'ignore_sticky_posts'   => true
			) );
		}
		else {
		$get_featured_posts = new WP_Query( array(
			'post_type' => 'product',
			'orderby'   => 'date',
			'tax_query' => array(
				array(
					'taxonomy'  => 'product_cat',
					'field'     => 'id',
					'terms'     => $category
				)
			),
			'posts_per_page' => $number
			) );
		}
		echo $before_widget;
		?>

		<ul class="home-slider">
		<?php
		while( $get_featured_posts->have_posts() ):
			$get_featured_posts->the_post();
			if( has_post_thumbnail() ) {
		?>
			<li>
			<?php
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'estore-slider', false); ?>
				<img src="<?php echo esc_url( $image_url[0] ); ?>">
				<div class="slider-caption-wrapper">
					<h3 class="slider-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
					<div class="slider-content"><?php the_excerpt(); ?></div>
					<a href="<?php the_permalink(); ?>" class="slider-btn"><?php esc_html_e( 'Add to Cart', 'estore' ); ?><i class="fa fa-shopping-cart"></i></a>
				</div>
			</li>
		<?php
		}
		endwhile;
		// Reset Post Data
		wp_reset_postdata();
		?>
		</ul>
		<?php echo $after_widget;
	}
}

// Featured Category Carousel Widget
class estore_featured_posts_carousel_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'slider_wrapper widget-featured-collection clearfix',
			'description' => esc_html__( 'Display latest posts or posts of specific category, which will be used as the carousel.', 'estore' ) );

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false,$name= esc_html__( 'TG: Category Carousel', 'estore' ), $widget_ops);
	}

	function form( $instance ) {
		$tg_defaults[ 'title' ]     = '';
		$tg_defaults[ 'subtitle' ]  = '';
		$tg_defaults['number']      = 5;
		$tg_defaults['type']        = 'latest';
		$tg_defaults['category']    = '';

		$instance = wp_parse_args( (array) $instance, $tg_defaults );

		$title     = esc_attr( $instance[ 'title' ] );
		$subtitle  = esc_textarea( $instance[ 'subtitle' ] );
		$number    = $instance['number'];
		$type      = $instance['type'];
		$category  = $instance['category'];
	?>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<?php esc_html_e( 'Description:','estore' ); ?>
	<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $subtitle; ?></textarea>

	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of posts to display:', 'estore' ); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
	</p>

	<p>
		<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show latest Posts', 'estore' );?><br />
		<input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show posts from a category', 'estore' );?><br />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'estore' ); ?>:</label>
		<?php
		wp_dropdown_categories(
			array(
				'show_option_none' =>' ',
				'name'             => $this->get_field_name( 'category' ),
				'selected'         => $category
			)
		);
		?>
	</p>

	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ]        = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'subtitle' ] =  $new_instance[ 'subtitle' ];
		else
			$instance[ 'subtitle' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'subtitle' ] ) ) );

		$instance[ 'number' ]   = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]     = $new_instance[ 'type' ];
		$instance[ 'category' ] = $new_instance[ 'category' ];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title    = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$subtitle = isset( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
		$number   = empty( $instance[ 'number' ] ) ? 5 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'ignore_sticky_posts'   => true
			) );
		}
		else {
		$get_featured_posts = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             => 'post',
			'category__in'          => $category
			) );
		}

		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Category Carousel Subtitle' . $this->id, $subtitle );
		}
		if ( function_exists( 'icl_t' ) ) {
			$subtitle  = icl_t( 'eStore', 'TG: Category Carousel Subtitle'. $this->id, $subtitle );
		}
		echo $before_widget;
		?>
		<div class="tg-container">
			<div class="section-title-wrapper clearfix">
				<div class="section-title-block">
					<?php if ( !empty( $title ) ) { ?>
					<h3 class="page-title"><?php echo esc_html( $title ); ?></h3>
					<?php }
					if ( !empty( $subtitle ) ) { ?>
					<h4 class="page-sub-title"><?php echo esc_textarea( $subtitle );?></h4>
					<?php } ?>
				</div>
			</div>
			<div class="featured-wrapper clearfix">
				<ul class="featured-slider">
				<?php

				while ($get_featured_posts->have_posts()) :
					$get_featured_posts->the_post(); ?>
					<li>
					<?php
						$image_id = get_post_thumbnail_id();
						$image_url = wp_get_attachment_image_src($image_id,'estore-square', false); ?>
						<figure class="featured-img">
						<?php if($image_url[0]) { ?>
							<img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>">
							<?php } else { ?>
								<img src="<?php echo get_template_directory_uri() . '/images/placeholder-blog.jpg'; ?>" alt="<?php the_title_attribute(); ?>">
							<?php } ?>
							<div class="featured-hover-wrapper">
								<div class="featured-hover-block">
									<?php if($image_url[0]) { ?>
									<a href="<?php echo esc_url( $image_url[0] ); ?>" class="zoom" data-rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>
									<?php } else { ?>
									<a href="<?php echo get_template_directory_uri() . '/images/placeholder-blog.jpg'; ?>" class="zoom" data-rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>
									<?php } ?>
									<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" class="link"> <i class="fa fa-link"> </i> </a>
								</div>
							</div><!-- featured hover end -->
						</figure>
						<div class="featured-content-wrapper">
							<h3 class="featured-title"> <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<a href="<?php the_permalink(); ?>" class="single_add_to_wishlist" ><?php esc_html_e('Read More','estore'); ?><i class="fa fa-heart"></i></a>
						</div><!-- featured content wrapper -->
					</li>
				<?php
				endwhile;
				?>
				</ul>
			</div>
		</div>
		<?php
		wp_reset_postdata();
		echo $after_widget;
	}
}

// Featured Posts Grid Widget
class estore_posts_grid extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-collection clearfix',
			'description' => esc_html__( 'Show Featured Category Posts in Grid Layout.', 'estore' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'TG: Category Grid', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'subtitle' ]         = '';
		$defaults[ 'category']          = '';
		$defaults[ 'post_number' ]      = 10;
		$defaults[ 'cat_image_url' ]    = '';
		$defaults[ 'cat_image_link' ]   = '';
		$defaults[ 'align' ]            = 'collection-left-align';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$subtitle         = esc_textarea( $instance[ 'subtitle' ] );
		$cat_image_url    = esc_url( $instance[ 'cat_image_url' ] );
		$cat_image_link   = esc_url( $instance[ 'cat_image_link' ] );
		$align            = $instance[ 'align' ];
		$category         = absint( $instance[ 'category' ] );
		$post_number      = absint( $instance[ 'post_number' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','estore' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $subtitle; ?></textarea>

		<label><?php esc_html_e( 'Add your Category Image here.', 'estore' ); ?></label>

		<p>
			<label for="<?php echo $this->get_field_id( 'cat_image_link' ); ?>"> <?php esc_html_e( 'Image Link', 'estore' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'cat_image_link' ); ?>" name="<?php echo $this->get_field_name( 'cat_image_link' ); ?>" value="<?php echo $instance[ 'cat_image_link' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_image_url' ); ?>"> <?php esc_html_e( 'Category Image', 'estore' ); ?></label>
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ 'cat_image_url' ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'cat_image_url' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>" name="<?php echo $this->get_field_name( 'cat_image_url' ); ?>" value="<?php echo esc_url( $instance['cat_image_url'] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'estore' ); ?></button>
			</div>
		</p>

		<label><?php esc_html_e( 'Choose where to align your image.', 'estore' ); ?></label>

		<p>
			<input type="radio" <?php checked( $align, 'collection-right-align' ) ?> id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" value="collection-right-align" /><?php esc_html_e( 'Right Align', 'estore' );?><br />
			<input type="radio" <?php checked( $align,'collection-left-align' ) ?> id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" value="collection-left-align" /><?php esc_html_e( 'Left Align', 'estore' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'estore' ); ?></label>
			<?php
			wp_dropdown_categories(
				array(
					'show_option_none' => '',
					'name'             => $this->get_field_name( 'category' ),
					'selected'         => $instance['category']
				)
			);
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_number' ); ?>"><?php esc_html_e( 'Number of Posts:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'post_number' ); ?>" name="<?php echo $this->get_field_name( 'post_number' ); ?>" type="number" value="<?php echo $post_number; ?>" />
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ]          = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'subtitle' ] =  $new_instance[ 'subtitle' ];
		else
			$instance[ 'subtitle' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'subtitle' ] ) ) );
		$instance[ 'category' ]       = absint( $new_instance[ 'category' ] );

		$instance[ 'post_number' ]  = absint( $new_instance[ 'post_number' ] );

		$instance[ 'cat_image_link' ] = esc_url_raw( $new_instance[ 'cat_image_link' ] );
		$instance[ 'cat_image_url' ]  = esc_url_raw( $new_instance[ 'cat_image_url' ] );
		$instance[ 'align' ]          = $new_instance[ 'align' ];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$subtitle         = isset( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';

		$cat_image_link   = isset( $instance[ 'cat_image_link' ] ) ? $instance[ 'cat_image_link' ] : '';
		$cat_image_url    = isset( $instance[ 'cat_image_url' ] ) ? $instance[ 'cat_image_url' ] : '';
		$align            = isset( $instance[ 'align' ] ) ? $instance[ 'align' ] : 'collection-left-align' ;

		$category         = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$product_number   = isset( $instance[ 'post_number' ] ) ? $instance[ 'post_number' ] : '';

		$args = array(
			'posts_per_page'        => $post_number,
			'post_type'             => 'post',
			'category__in'          => $category
		);

		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Category Grid Subtitle' . $this->id, $subtitle );
			icl_register_string( 'eStore', 'TG: Category Grid Image' . $this->id, $cat_image_url );
			icl_register_string( 'eStore', 'TG: Category Grid Image Link' . $this->id, $cat_image_link );
		}
		if ( function_exists( 'icl_t' ) ) {
			$subtitle       = icl_t( 'eStore', 'TG: Category Grid Subtitle'. $this->id, $subtitle );
			$cat_image_url  = icl_t( 'eStore', 'TG: Category Grid Image'. $this->id, $cat_image_url );
			$cat_image_link = icl_t( 'eStore', 'TG: Category Grid Image Link'. $this->id, $cat_image_link );
		}

		echo $before_widget; ?>
		<div class="tg-container estore-cat-color_<?php echo $category; ?> <?php echo $align; ?>">
			<div class="section-title-wrapper clearfix">
				<div class="section-title-block">
					<?php if ( !empty( $title ) ) { ?>
					<h3 class="page-title"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $title ); ?></a></h3>
					<?php }
					if ( !empty( $subtitle ) ) { ?>
					<h4 class="page-sub-title"><?php echo esc_textarea( $subtitle );?></h4>
					<?php } ?>
				</div>
				<div class="sorting-form-wrapper">
					<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php esc_html_e( 'View all', 'estore' ); ?></a>
				</div>
			</div>
			<div class="collection-block-wrapper tg-column-wrapper clearfix">
				<div class="tg-column-4 collection-block">
						<?php
						$output = '';
						if ( !empty( $cat_image_url ) ) {
							if ( !empty( $cat_image_link ) ) {
							$output .= '<a href="'.esc_url($cat_image_link).'" target="_blank" rel="nofollow">
											<img src="'.esc_url($cat_image_url).'" alt="'.esc_html($title).'" />
										</a>';
							} else {
								$output .= '<img src="'.esc_url($cat_image_url).'" alt="'.esc_html($title).'" />';
							}
							echo $output;
						} ?>
				</div>
				<?php
				$count = 1;
				$featured_query = new WP_Query( $args );
				while ($featured_query->have_posts()) :
					$featured_query->the_post();
				if($count == 1){ ?>
				<div class="tg-column-4 collection-block">
					<div class="hot-product-block">
						<div class="hot-product-content-wrapper clearfix">
							<?php
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'estore-medium-image', false); ?>
							<figure class="hot-img">
								<a href="<?php the_permalink(); ?>">
								<?php if($image_url[0]){ ?>
									<img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>">
								<?php } else { ?>
									<img src="<?php echo get_template_directory_uri() . '/images/placeholder-blog-380x250.jpg'; ?>" alt="<?php the_title_attribute(); ?>">
								<?php } ?>
								</a>
							</figure>
							<div class="hot-content-wrapper">
								<h3 class="hot-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<!-- Rating products -->
								<div class="hot-content"><?php the_excerpt(); ?></div>
							</div> <!-- hot-content-wrapper end -->
						</div> <!-- hot-product-content-wrapper end -->
					</div> <!-- hot product block end -->
				</div>
				<?php }

				if($count == 2 || $count == 7){ ?>
					<div class="tg-column-4 collection-block">
						<div class="product-list-wrap">
				<?php }
					if($count > 1 && $count < 7 || $count > 6) { ?>
						<div class="product-list-block clearfix">
						<?php
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'estore-product-grid', false); ?>
							<figure class="product-list-img">
								<a href="<?php the_permalink(); ?>">
									<?php if($image_url[0]){ ?>
									<img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>">
									<?php } else { ?>
									<img src="<?php echo get_template_directory_uri() . '/images/placeholder-blog.jpg'; ?>" alt="<?php the_title_attribute(); ?>" width="75" height="75">
								<?php } ?>
								</a>
							</figure>
							<div class="product-list-content">
								<h3 class="product-list-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
								<div class="entry-meta">
								<span class="byline author vcard"><i class="fa fa-user"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr(get_the_author()); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
								<?php

								if ( ! post_password_required() && comments_open() ) { ?>
								<span class="comments-link"><i class="fa fa-comments-o"></i><?php comments_popup_link( esc_html__( '0 Comment', 'estore' ), esc_html__( '1 Comment', 'estore' ), esc_html__( ' % Comments', 'estore' ) ); ?></span>
								<?php } ?>
								</div>
							</div> <!-- cart-wishlist-btn end -->
						</div>
				<?php } // Closing div for columns
				if($count == 6){ ?>
					</div>
				</div>
				<?php }
				$count++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			</div><!-- collection-block-wrapper tg-column-wrapper clearfix -->
		<?php
		echo $after_widget;
	}
}
