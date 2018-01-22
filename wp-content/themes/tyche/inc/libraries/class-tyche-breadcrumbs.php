<?php

/**
 * Class Tyche_Breadcrumbs
 *
 * @author           Cristian Raiber
 * @copyright    (c) Copyright by Macho Themes
 * @link             https://www.machothemes.com
 * @package          Muscle Core
 * @since            Version 1.4
 */
class Tyche_Breadcrumbs {

	/**
	 * @var mixed Current post object
	 */
	private $post;

	/**
	 * @var    string Prefix for the breadcrumb path
	 */
	private $home_prefix;

	/**
	 * @var    string Separator between single breadscrumbs
	 */
	private $separator;

	/**
	 * @var    boolean True if terms should be shown in breadcrumb path
	 */
	private $show_terms;

	/**
	 * @var    string Label for the "Home" link
	 */
	private $home_label;

	/**
	 * @var    string Prefix used for pages like date archive
	 */
	private $tag_archive_prefix;

	/**
	 * @var    string Prefix used for search page
	 */
	private $search_prefix;

	/**
	 * @var    string Prefix used for 404 page
	 */
	private $error_prefix;

	/**
	 * @var string The HTML markup
	 */
	private $html_markup;

	/**
	 * @var
	 */
	private $options;

	/**
	 * Class Constructor
	 */
	public function __construct() {
		// Initialize object variables
		$this->post = ( isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null );

		// Setup default array for changeable variables
		$defaults = array(
			'home_prefix'            => get_theme_mod( 'tyche_blog_breadcrumb_menu_prefix', '' ),
			'separator'              => get_theme_mod( 'tyche_blog_breadcrumb_menu_separator', '/' ),
			'show_post_type_archive' => '1',
			'show_terms'             => get_theme_mod( 'tyche_blog_breadcrumb_menu_post_category', 1 ),
			'home_label'             => esc_html__( 'Home', 'tyche' ),
			'tag_archive_prefix'     => esc_html__( 'Tag:', 'tyche' ),
			'search_prefix'          => esc_html__( 'Search:', 'tyche' ),
			'error_prefix'           => esc_html__( '404 - Page not Found', 'tyche' ),
		);

		// Setup a filter for changeable variables and merge it with the defaults
		$args     = apply_filters( 'tyche_breadcrumbs_defaults', $defaults );
		$defaults = wp_parse_args( $args, $defaults );

		$this->home_prefix            = $defaults['home_prefix'];
		$this->separator              = $defaults['separator'];
		$this->show_post_type_archive = $defaults['show_post_type_archive'];
		$this->show_terms             = $defaults['show_terms'];
		$this->home_label             = $defaults['home_label'];
		$this->tag_archive_prefix     = $defaults['tag_archive_prefix'];
		$this->search_prefix          = $defaults['search_prefix'];
		$this->error_prefix           = $defaults['error_prefix'];

		$this->home_label = __( 'Home ', 'tyche' );
	}

	/**
	 * Publicly accessible function to get the full breadcrumb HTML markup
	 *
	 * @return void
	 */
	public function get_breadcrumbs() {
		$options = get_option( 'wpseo_internallinks' );

		// Support for Yoast Breadcrumbs
		if ( function_exists( 'yoast_breadcrumb' ) && $options && true === $options['breadcrumbs-enable'] ) {
			ob_start();
			yoast_breadcrumb();
			$this->html_markup = ob_get_clean();

			// Muscle Core Breadcrumbs
		} else {
			$this->prepare_breadcrumb_html();
		}

		$this->wrap_breadcrumbs();
		$this->output_breadcrumbs_html();
	}

	/**
	 * Prepare the full output of the breadcrumb path
	 *
	 * @return void
	 */
	private function prepare_breadcrumb_html() {
		// Add the path prefix
		$this->html_markup = $this->get_breadcrumb_prefix();

		// Add the "Home" link
		$this->html_markup .= $this->get_breadcrumb_home();

		// Woocommerce path prefix (e.g "Shop" )
		if ( class_exists( 'WooCommerce' ) && ( ( is_woocommerce() && is_archive() && ! is_shop() ) || is_cart() || is_checkout() || is_account_page() ) ) {
			$this->html_markup .= $this->get_woocommerce_shop_page();
		}

		// bbPress path prefix (e.g "Forums" )
		if ( class_exists( 'bbPress' ) && is_bbpress() && ( bbp_is_topic_archive() || bbp_is_single_user() || bbp_is_search() ) ) {
			$this->html_markup .= $this->get_bbpress_main_archive_page();
		}

		// Single Posts and Pages (of all post types)
		if ( is_singular() ) {
			// If the post type of the current post has an archive link, display the archive breadcrumb
			if ( isset( $this->post->post_type ) && get_post_type_archive_link( false ) && $this->show_post_type_archive ) {
				$this->html_markup .= $this->get_post_type_archive( false );
			}

			// If the post doesn't have parents
			if ( isset( $this->post->post_parent ) && 0 == $this->post->post_parent ) {
				$this->html_markup .= $this->get_post_terms();
				// If there are parents; mostly for pages
			} else {
				$this->html_markup .= $this->get_post_ancestors();
			}

			$this->html_markup .= $this->get_breadcrumb_leaf_markup();
		} else {
			// Custom post types archives
			if ( is_post_type_archive() ) {
				$this->html_markup .= $this->get_post_type_archive( false );

				// Search on custom post type (e.g. Woocommerce)
				if ( is_search() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'search' );
				}
			} elseif ( is_tax() || is_tag() || is_category() ) {
				// If we have a tag archive, add the tag prefix
				if ( is_tag() ) {
					$this->html_markup .= $this->tag_archive_prefix;
				}
				$this->html_markup .= $this->get_taxonomies();
				$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'term' );
				// Date Archives
			} elseif ( is_date() ) {
				global $wp_locale;
				// Set variables
				$year      = esc_html( get_query_var( 'year' ) );
				$permalink = get_option( 'permalink_structure' );
				if ( '' === $permalink ) {
					$query = get_query_var( 'm' );

					switch ( strlen( $query ) ) {
						case 8:
							$year       = substr( $query, 0, 4 );
							$month      = substr( $query, 4, 2 );
							$month_name = $wp_locale->get_month( $month );
							$day        = substr( $query, 6, 2 );
							break;
						case 6:
							$year       = substr( $query, 0, 4 );
							$month      = substr( $query, 4, 2 );
							$month_name = $wp_locale->get_month( $month );
							break;
						case 4:
							$year = substr( $query, 0, 4 );
							break;
					}
				}

				if ( ( is_month() || is_day() ) && ! empty( $permalink ) ) {
					$month      = get_query_var( 'monthnum' );
					$month_name = $wp_locale->get_month( $month );
				}
				// Year Archive, only is a leaf
				if ( is_year() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'year' );
					// Month Archive, needs year link and month leaf
				} elseif ( is_month() ) {
					$this->html_markup .= $this->get_single_breadcrumb_markup( $year, get_year_link( $year ) );
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'month' );
					// Day Archive, needs year and month link and day leaf
				} elseif ( is_day() ) {
					$this->html_markup .= $this->get_single_breadcrumb_markup( $year, get_year_link( $year ) );
					$this->html_markup .= $this->get_single_breadcrumb_markup( $month_name, get_month_link( $year, $month ) );
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'day' );
				}
			} elseif ( is_author() ) {
				$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'author' );
				// Search Page
			} elseif ( is_search() ) {
				$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'search' );
				// 404 Page
			} elseif ( is_404() ) {
				// Special treatment for Events Calendar to avoid 404 messages on list view
				if ( class_exists( 'TribeEvents' ) && tribe_is_event() || is_events_archive() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'events' );
					// Default case
				} else {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( '404' );
				}
			} elseif ( class_exists( 'bbPress' ) ) {
				// Search Page
				if ( bbp_is_search() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'bbpress_search' );
					// User page
				} elseif ( bbp_is_single_user() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'bbpress_user' );
				}
			}// End if().
		}// End if().
	}

	/**
	 * Wrap the breadcrumb path in a div
	 *
	 * @return string The HTML markup of the wrapped breadcrumb path
	 */
	private function wrap_breadcrumbs() {
		$this->html_markup = sprintf( '<div class="tyche-breadcrumbs">%s</div>', $this->html_markup );
	}

	/**
	 * Output the full breadcrumb HTML markup
	 *
	 * @return void
	 */
	private function output_breadcrumbs_html() {
		echo $this->html_markup;
	}

	/**
	 * Get the markup of the breadcrumb path prefix
	 *
	 * @return string The HTML markup of the breadcrumb path prefix
	 */
	private function get_breadcrumb_prefix() {
		$prefix = '';

		// If the home page is a real page
		if ( ! is_front_page() ) {
			// Add chosen path prefix
			if ( $this->home_prefix ) {
				$prefix = sprintf( '<span class="tyche-breadcrumb-prefix">%s:</span>', esc_html( $this->home_prefix ) );
			}
		}

		return $prefix;
	}

	/**
	 * Get the markup of the "Home" Link
	 *
	 * @return string The HTML markup of the "Home" link
	 */
	private function get_breadcrumb_home() {
		$home_link = '';

		// If the home page is a real page
		if ( ! is_front_page() ) {
			$home_link = $this->get_single_breadcrumb_markup( esc_html( $this->home_label ), esc_url( get_home_url() ) );
			// If the home page is the main blog page
		} elseif ( is_home() ) {
			$home_link = $this->get_single_breadcrumb_markup( esc_html( $this->home_label ) );
		}

		return $home_link;

	}

	public function get_latest_post_page() {
		$page_id = get_option( 'page_for_posts', false );
		if ( ! $page_id ) {
			return false;
		}

		return array(
			'link' => get_permalink( $page_id ),
			'name' => get_post( $page_id ),
		);
	}

	/**
	 * Construct the full post term tree path and add its HTML markup
	 *
	 * @return string The HTML markup of the full term breadcrumb path
	 */
	private function get_post_terms() {
		$terms_markup = '';

		// Get the post terms
		if ( 'post' == $this->post->post_type || 'page' == $this->post->post_type ) {
			$taxonomy = 'category';

			/*
			// Muscle Core Portfolio
			} elseif ( $this->post->post_type == 'project' ) {
				$taxonomy = 'project_category';
			*/

			// Woocommerce
		} elseif ( 'product' == $this->post->post_type && class_exists( 'WooCommerce' ) && is_woocommerce() ) {
			$taxonomy = 'product_cat';
			// The Events Calendar
		} elseif ( 'tribe_events' == $this->post->post_type ) {
			$taxonomy = 'tribe_events_cat';
			// For other post types don't return a terms tree to reduce possible errors
		} else {
			return $terms_markup;
		}

		$terms = wp_get_object_terms( $this->post->ID, $taxonomy );

		// If post does not have any terms assigned; possible e.g. portfolio posts
		if ( empty( $terms ) ) {
			return $terms_markup;
		}

		// Check if the terms are all part of one term tree, i.e. only related terms are selected
		$terms_by_id = array();
		foreach ( $terms as $term ) {
			$terms_by_id[ $term->term_id ] = $term;
		}

		// Unset all terms that are parents of some term
		foreach ( $terms as $term ) {
			unset( $terms_by_id[ $term->parent ] );
		}

		// If only one term is left, we have a single term tree
		if ( count( $terms_by_id ) == 1 ) {
			unset( $terms );
			$terms[0] = array_shift( $terms_by_id );
		}

		// The post is only in one term
		if ( count( $terms ) == 1 ) {

			$term_parent = $terms[0]->parent;

			// If the term has a parent we need its ancestors for a full tree
			if ( $term_parent ) {
				// Get space separated string of term tree in slugs
				$term_tree   = get_ancestors( $terms[0]->term_id, $taxonomy );
				$term_tree   = array_reverse( $term_tree );
				$term_tree[] = get_term( $terms[0]->term_id, $taxonomy );

				// Loop through the term tree
				foreach ( $term_tree as $term_id ) {
					// Get the term object by its slug
					$term_object = get_term( $term_id, $taxonomy );

					// Add it to the term breadcrumb markup string
					$terms_markup .= $this->get_single_breadcrumb_markup( $term_object->name, get_term_link( $term_object ) );
				}
			} else {
				$terms_markup = $this->get_single_breadcrumb_markup( $terms[0]->name, get_term_link( $terms[0] ) );
			}
		} else {
			// The lexicographically smallest term will be part of the breadcrump rich snippet path
			$terms_markup = $this->get_single_breadcrumb_markup( $terms[0]->name, get_term_link( $terms[0] ), false );
			// Drop the first index
			array_shift( $terms );

			// Loop through the rest of the terms, and add them to string comma separated
			$max_index = count( $terms );
			$i         = 0;
			foreach ( $terms as $term ) {

				// For the last index also add the separator
				if ( ++ $i == $max_index ) {
					$terms_markup .= ', ' . $this->get_single_breadcrumb_markup( $term->name, get_term_link( $term ), true, false );
				} else {
					$terms_markup .= ', ' . $this->get_single_breadcrumb_markup( $term->name, get_term_link( $term ), false, false );
				}
			}
		}// End if().

		return $terms_markup;
	}

	/**
	 * Construct the full post ancestors tree path and add its HTML markup
	 *
	 * @return string The HTML markup of the ancestors tree
	 */
	private function get_post_ancestors() {
		$ancestors_markup = '';

		// Get the ancestor id, order needs to be reversed
		$post_ancestor_ids = array_reverse( get_post_ancestors( $this->post ) );

		// Loop through the ids to get the full tree
		foreach ( $post_ancestor_ids as $post_ancestor_id ) {
			$post_ancestor    = get_post( $post_ancestor_id );
			$ancestors_markup .= $this->get_single_breadcrumb_markup( $post_ancestor->post_title, esc_url( get_permalink( $post_ancestor->ID ) ) );
		}

		return $ancestors_markup;
	}

	/**
	 * Construct the full term ancestors tree path and add its HTML markup
	 *
	 * @return string The HTML markup of the term ancestors tree
	 */
	private function get_taxonomies() {
		global $wp_query;
		$term         = $wp_query->get_queried_object();
		$terms_markup = '';

		// Make sure we have hierarchical taxonomy and parents
		if ( 0 != $term->parent && is_taxonomy_hierarchical( $term->taxonomy ) ) {
			$term_ancestors = get_ancestors( $term->term_id, $term->taxonomy );
			$term_ancestors = array_reverse( $term_ancestors );
			// Loop through ancestors to get the full tree
			foreach ( $term_ancestors as $term_ancestor ) {
				$term_object  = get_term( $term_ancestor, $term->taxonomy );
				$terms_markup .= $this->get_single_breadcrumb_markup( $term_object->name, get_term_link( $term_object->term_id, $term->taxonomy ) );
			}
		}

		return $terms_markup;
	}

	/**
	 * Adds the markup of a post type archive
	 *
	 * @return string The HTML markup of the post type archive
	 */
	private function get_post_type_archive( $linked = true ) {
		global $wp_query;

		$post_type        = $wp_query->query_vars['post_type'];
		$post_type_object = get_post_type_object( $post_type );
		$link             = '';
		// Dirty fix
		$archive_title = 'Title';
		// Check if we have a post type object
		if ( is_object( $post_type_object ) ) {
			$woocommerce_shop_page = $this->get_woocommerce_shop_page( $linked );
			// Woocommerce: archive name should be same as shop page name
			if ( 'product' == $post_type && $woocommerce_shop_page ) {
				return $woocommerce_shop_page;
			}

			// bbPress: make sure that the Forums slug and link are correct
			if ( class_exists( 'bbPress' ) && 'topic' == $post_type ) {
				$archive_title = bbp_get_forum_archive_title();
				if ( $linked ) {
					$link = esc_url( get_post_type_archive_link( bbp_get_forum_post_type() ) );
				}

				return $this->get_single_breadcrumb_markup( $archive_title, $link );
			}

			// Default case
			// Check if the post type has a non empty label
			if ( isset( $post_type_object->label ) && '' !== $post_type_object->label ) {
				$archive_title = $post_type_object->label;
				// Alternatively check for a non empty menu name
			} elseif ( isset( $post_type_object->labels->menu_name ) && '' !== $post_type_object->labels->menu_name ) {
				$archive_title = $post_type_object->labels->menu_name;
				// Use its name as fallback
			} else {
				$archive_title = $post_type_object->name;
			}
		}// End if().

		// Check if the breadcrumb should be linked
		if ( $linked ) {
			$link = esc_url( get_post_type_archive_link( $post_type ) );
		}

		return $this->get_single_breadcrumb_markup( $archive_title, $link );
	}

	/**
	 * Adds the markup of the woocommerce shop page
	 *
	 * @return string The HTML markup of the woocommerce shop page
	 */
	private function get_woocommerce_shop_page( $linked = true ) {
		global $wp_query;

		$post_type        = 'product';
		$post_type_object = get_post_type_object( $post_type );
		$shop_page_markup = '';
		$link             = '';

		// Make sure we are on a woocommerce page
		if ( is_object( $post_type_object ) && class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			// Get shop page id and then its name
			$shop_page_id   = wc_get_page_id( 'shop' );
			$shop_page_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

			// Use the archive name if no shop page was set.
			if ( ! $shop_page_name ) {
				$shop_page_name = $post_type_object->labels->name;
			}

			// Check if the breadcrumb should be linked
			if ( $linked ) {
				$link = esc_url( get_post_type_archive_link( $post_type ) );
			}

			$shop_page_markup = $this->get_single_breadcrumb_markup( $shop_page_name, $link );
		}

		return $shop_page_markup;
	}

	/**
	 * Adds the markup of the bbpress main forum archive
	 *
	 * @return string The HTML markup of the bbpress main forum archive
	 */
	private function get_bbpress_main_archive_page() {
		global $wp_query;

		return $this->get_single_breadcrumb_markup( bbp_get_forum_archive_title(), esc_url( get_post_type_archive_link( 'forum' ) ) );
	}

	/**
	 * Adds the markup of the breadcrumb leaf
	 *
	 * @param  string $object_id ID of the current query object
	 *
	 * @return string                The HTML markup of the breadcrumb leaf
	 */
	private function get_breadcrumb_leaf_markup( $object_type = '' ) {
		global $wp_query, $wp_locale;

		switch ( $object_type ) {
			case 'term':
				$term  = $wp_query->get_queried_object();
				$title = $term->name;
				break;
			case 'year':
				$permalink = get_option( 'permalink_structure' );
				if ( empty( $permalink ) ) {
					$query = get_query_var( 'm' );
					$title = substr( $query, 0, 4 );
				} else {
					$title = esc_html( get_query_var( 'year' ) );
				}
				break;
			case 'month':
				$permalink = get_option( 'permalink_structure' );
				if ( empty( $permalink ) ) {
					$query = get_query_var( 'm' );
					$month = substr( $query, 4, 2 );
					$title = $wp_locale->get_month( $month );
				} else {
					$title = $wp_locale->get_month( get_query_var( 'monthnum' ) );
				}
				break;
			case 'day':
				$permalink = get_option( 'permalink_structure' );
				if ( empty( $permalink ) ) {
					$query = get_query_var( 'm' );
					$title = substr( $query, 6, 2 );
				} else {
					$title = get_query_var( 'day' );
				}
				break;
			case 'author':
				$user  = $wp_query->get_queried_object();
				$title = $user->display_name;
				break;
			case 'search':
				$title = sprintf( '%s %s', $this->search_prefix, esc_html( get_search_query() ) );
				break;
			case '404':
				$title = $this->error_prefix;
				break;
			case 'bbpress_search':
				$title = sprintf( '%s %s', $this->search_prefix, esc_html( get_query_var( 'bbp_search' ) ) );
				break;
			case 'bbpress_user':
				$current_user = wp_get_current_user();
				$title        = $current_user->user_nicename;
				break;
			case 'events':
				$title = tribe_get_events_title();
				break;
			default:
				$title = get_the_title( $this->post->ID );
				break;
		}// End switch().

		return sprintf( '<span class="breadcrumb-leaf">%s</span>', $title );
	}

	/**
	 * Adds the markup of a single breadcrumb
	 *
	 * @param  string  $title     The title that should be displayed
	 * @param  string  $link      The URL of the breadcrumb
	 * @param  boolean $separator Set to TRUE to show the separator at the end of the breadcrumb
	 * @param boolean  $microdata Set to FALSE to make sure we get a link not being part of the breadcrumb microdata
	 *                            path
	 *
	 * @return string                The HTML markup of a single breadcrumb
	 */
	private function get_single_breadcrumb_markup( $title, $link = '', $separator = true, $microdata = true ) {

		// Init vars
		$microdata_itemscope = '';
		$microdata_url       = '';
		$microdata_title     = '';
		$separator_markup    = '';

		// Setup the elements attributes for breadcrumb microdata rich snippets
		if ( $microdata ) {
			$microdata_itemscope = 'itemscope itemtype="http://data-vocabulary.org/Breadcrumb"';
			$microdata_url       = 'itemprop="url"';
			$microdata_title     = 'itemprop="title"';
		}

		$breadcrumb_content = sprintf( '<span %s>%s</span>', $microdata_title, $title );

		// If a link is set add its markup
		if ( $link ) {
			$breadcrumb_content = sprintf( '<a %s href="%s" >%s</a>', $microdata_url, $link, $breadcrumb_content );
		}

		// If a separator should be added, do it
		if ( $separator ) {
			$separator_markup = sprintf( '<span class="tyche-breadcrumb-sep">%s</span>', $this->separator );
		}

		return sprintf( '<span %s>%s</span>%s', $microdata_itemscope, $breadcrumb_content, $separator_markup );
	}
}

// Omit closing PHP tag to avoid "Headers already sent" issues.
