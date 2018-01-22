<?php
/**
 * seed_csp4 Admin
 *
 * @package WordPress
 * @subpackage seed_csp4
 * @since 0.1.0
 */


class SEED_CSP4_ADMIN
{
    public $plugin_version = SEED_CSP4_VERSION;
    public $plugin_name = SEED_CSP4_PLUGIN_NAME;

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

   /**
     * Slug of the plugin screen.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_screen_hook_suffix = null;

    /**
     * Load Hooks
     */
    function __construct( )
    {
        if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ){
            add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts'  ) );
            add_action( 'admin_menu', array( &$this, 'create_menus'  ) );
            add_action( 'admin_init', array( &$this, 'reset_defaults' ) );
            add_action( 'admin_init', array( &$this, 'create_settings' ) );
            add_filter( 'plugin_action_links', array( &$this, 'plugin_action_links' ), 10, 2 );
            add_filter( 'tmp_grunion_allow_editor_view', '__return_false' );
        }
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Reset the settings page. Reset works per settings id.
     *
     */
    function reset_defaults( )
    {
        if ( isset( $_POST[ 'seed_csp4_reset' ] ) ) {
            $option_page = $_POST[ 'option_page' ];
            check_admin_referer( $option_page . '-options' );
            require_once(SEED_CSP4_PLUGIN_PATH.'inc/default-settings.php');

            $_POST[ $_POST[ 'option_page' ] ] = $seed_csp4_settings_deafults[$_POST[ 'option_page' ]];
            add_settings_error( 'general', 'seed_csp4-settings-reset', __( "Settings reset." ), 'updated' );
        }
    }

    /**
     * Properly enqueue styles and scripts for our theme options page.
     *
     * This function is attached to the admin_enqueue_scripts action hook.
     *
     * @since  0.1.0
     * @param string $hook_suffix The name of the current page we are on.
     */
    function admin_enqueue_scripts( $hook_suffix )
    {
        if ( $hook_suffix != $this->plugin_screen_hook_suffix )
            return;

        wp_enqueue_script( 'media-upload' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'wp-lists' );
        wp_enqueue_script( 'seed_csp4-framework-js', SEED_CSP4_PLUGIN_URL . 'framework/settings-scripts.js', array( 'jquery' ), $this->plugin_version );
        wp_enqueue_script( 'theme-preview' );
        wp_enqueue_style( 'thickbox' );
        wp_enqueue_style( 'media-upload' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'seed_csp4-framework-css', SEED_CSP4_PLUGIN_URL . 'framework/settings-style.css', false, $this->plugin_version );
        wp_enqueue_style( 'font-awesome', SEED_CSP4_PLUGIN_URL . 'framework/css/font-awesome.css', false, $this->plugin_version, false, $this->plugin_version );
    }

    /**
     * Creates WordPress Menu pages from an array in the config file.
     *
     * This function is attached to the admin_menu action hook.
     *
     * @since 0.1.0
     */
    function create_menus( )
    {
      $this->plugin_screen_hook_suffix = add_options_page(
            __( "Coming Soon Page & Maintenance Mode", 'coming-soon' ),
            __( "Coming Soon Page & Maintenance Mode", 'coming-soon' ),
            'manage_options',
            'seed_csp4',
            array( &$this , 'option_page' )
            );
    }

    /**
     * Display settings link on plugin page
     */
    function plugin_action_links( $links, $file )
    {
        $plugin_file = SEED_CSP4_SLUG;

        if ( $file == $plugin_file ) {
            $settings_link = '<a href="options-general.php?page=seed_csp4">Settings</a>';
            array_unshift( $links, $settings_link );
        }
        return $links;
    }


    /**
     * Allow Tabs on the Settings Page
     *
     */
    function plugin_options_tabs( )
    {
        $menu_slug   = null;
        $page        = $_REQUEST[ 'page' ];
        $uses_tabs   = false;
        $current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : false;

        //Check if this config uses tabs
        foreach ( seed_csp4_get_options() as $v ) {
            if ( $v[ 'type' ] == 'tab' ) {
                $uses_tabs = true;
                break;
            }
        }

        // If uses tabs then generate the tabs
        if ( $uses_tabs ) {
            echo '<h2 class="nav-tab-wrapper" style="padding-left:20px">';
            $c = 1;
            foreach ( seed_csp4_get_options() as $v ) {
                    if ( isset( $v[ 'menu_slug' ] ) ) {
                        $menu_slug = $v[ 'menu_slug' ];
                    }
                    if ( $menu_slug == $page && $v[ 'type' ] == 'tab' ) {
                        $active = '';
                        if ( $current_tab ) {
                            $active = $current_tab == $v[ 'id' ] ? 'nav-tab-active' : '';
                        } elseif ( $c == 1 ) {
                            $active = 'nav-tab-active';
                        }
                        echo '<a class="nav-tab ' . $active . '" href="?page=' . $menu_slug . '&tab=' . $v[ 'id' ] . '">';  
                        if($v[ 'id' ] == 'seed_csp4_setting'){
                            echo '<i class="fa fa-edit"></i> ';
                        }
                        if($v[ 'id' ] == 'seed_csp4_design'){
                            echo '<i class="fa fa-image"></i> ';
                        }
                         if($v[ 'id' ] == 'seed_csp4_advanced'){
                            echo '<i class="fa fa-code"></i> ';
                        }
                        echo $v[ 'label' ] . '</a>';
                        $c++;
                    }
            }
            echo '<a class="nav-tab seed_csp4-preview thickbox-preview" target="_blank" href="'.home_url().'?cs_preview=true&TB_iframe=true&width=640&height=632" title="'.__('&larr; Close Window','coming-soon').'"><i class="fa fa-external-link"></i> '.__('Live Preview','coming-soon').'</a>';
            if(defined('SEED_CSP_API_KEY') === false){
                echo '<a class="nav-tab seed_csp4-support" style="background-color: #444;color: #fff" href="https://www.seedprod.com/ultimate-coming-soon-page-vs-coming-soon-pro/?utm_source=coming-soon-plugin&utm_medium=banner&utm_campaign=coming-soon-link-in-plugin" target="_blank"><i class="fa fa-bolt"></i> '.__('Upgrade to Pro for More Features','coming-soon').'</a>';
                //echo '<a class="nav-tab seed_csp4-support" style="background-color: #444;color: #fff" href="http://testdrive.seedprod.com?utm_source=coming-soon-plugin&utm_medium=banner&utm_campaign=coming-soon-link-in-plugin" target="_blank"><i class="fa fa-bolt"></i> '.__('Try the Pro Version for Free','coming-soon').'</a>';
            }
            echo '</h2>';

        }
    }

    /**
     * Get the layout for the page. classic|2-col
     *
     */
    function get_page_layout( )
    {
        $layout = 'classic';
        foreach ( seed_csp4_get_options() as $v ) {
            switch ( $v[ 'type' ] ) {
                case 'menu';
                    $page = $_REQUEST[ 'page' ];
                    if ( $page == $v[ 'menu_slug' ] ) {
                        if ( isset( $v[ 'layout' ] ) ) {
                            $layout = $v[ 'layout' ];
                        }
                    }
                    break;
            }
        }
        return $layout;
    }

    /**
     * Render the option pages.
     *
     * @since 0.1.0
     */
    function option_page( )
    {
        $menu_slug = null;
        $page   = $_REQUEST[ 'page' ];
        $layout = $this->get_page_layout();
        ?>
        <div class="wrap columns-2 seed-csp4">
        
            <h2><?php echo $this->plugin_name; ?> <span class="seed_csp4-version"> <?php echo SEED_CSP4_VERSION; ?></span></h2>
            <?php //settings_errors() ?>
            <?php $this->plugin_options_tabs(); ?>
            <?php if ( $layout == '2-col' ): ?>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content" >
            <?php endif; ?>
                    <?php if(!empty($_GET['tab']))
                            do_action( 'seed_csp4_render_page', array('tab'=>$_GET['tab']));
                    ?>
                    <form action="options.php" method="post">

                    <!-- <input name="submit" type="submit" value="<?php _e( 'Save All Changes', 'coming-soon' ); ?>" class="button-primary"/> -->
                    <?php if(!empty($_GET['tab']) && $_GET['tab'] != 'seed_csp4_tab_3') { ?>
                    <!-- <input id="reset" name="reset" type="submit" value="<?php _e( 'Reset Settings', 'coming-soon' ); ?>" class="button-secondary"/>     -->
                    <?php } ?>

                            <?php
                            $show_submit = false;
                            foreach ( seed_csp4_get_options() as $v ) {
                                if ( isset( $v[ 'menu_slug' ] ) ) {
                                    $menu_slug = $v[ 'menu_slug' ];
                                }
                                    if ( $menu_slug == $page ) {
                                        switch ( $v[ 'type' ] ) {
                                            case 'menu';
                                                break;
                                            case 'tab';
                                                $tab = $v;
                                                if ( empty( $default_tab ) )
                                                    $default_tab = $v[ 'id' ];
                                                break;
                                            case 'setting':
                                                $current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $default_tab;
                                                if ( $current_tab == $tab[ 'id' ] ) {
                                                    settings_fields( $v[ 'id' ] );
                                                    $show_submit = true;
                                                }

                                                break;
                                            case 'section':
                                                $current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $default_tab;
                                                if ( $current_tab == $tab[ 'id' ] or $current_tab === false ) {
                                                    if ( $layout == '2-col' ) {
                                                        echo '<div id="'.$v[ 'id' ].'" class="postbox seedprod-postbox">';
                                                        $this->do_settings_sections( $v[ 'id' ],$show_submit );
                                                        echo '</div>';
                                                    } else {
                                                        do_settings_sections( $v[ 'id' ] );
                                                    }

                                                }
                                                break;

                                        }

                                }
                            }
                        ?>
                    <?php if($show_submit): ?>
                    <p>
                    <!-- <input name="submit" type="submit" value="<?php _e( 'Save All Changes', 'coming-soon' ); ?>" class="button-primary"/> -->
                    <!-- <input id="reset" name="reset" type="submit" value="<?php _e( 'Reset Settings', 'coming-soon' ); ?>" class="button-secondary"/> -->
                    </p>
                    <?php endif; ?>
                    </form>

                    <?php if ( $layout == '2-col' ): ?>
                    </div> <!-- #post-body-content -->

                    <div id="postbox-container-1" class="postbox-container">
                        <div id="side-sortables" class="meta-box-sortables ui-sortable">

                         <!--     <div class="postbox ">
                                <div class="handlediv" title="Click to toggle"><br /></div>
                                <h3 class="hndle"><span><i class="fa fa-rocket"></i>&nbsp;&nbsp;<?php _e('Getting Started Video - 60 sec', 'coming-soon') ?></span></h3>
                                <div class="inside">
                                    <div class="">
                                        <iframe width="250" height="188" src="https://www.youtube.com/embed/hcY0M0IYcAE" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div> -->

                            
                            <a style="border:1px solid #ddd;display:inline-block;" href="https://www.seedprod.com/landing/coming-soon-page-getting-started-video/?utm_source=coming-soon-plugin&utm_medium=banner&utm_campaign=coming-soon-banner-in-plugin" target="_blank"><img src="<?php echo SEED_CSP4_PLUGIN_URL; ?>framework/getting-started-banner.png" /></a>
                            <br><br>

                           
                            <a  style="border:1px solid #ddd;display:inline-block;" href="https://www.seedprod.com/ultimate-coming-soon-page-vs-coming-soon-pro/?utm_source=coming-soon-plugin&utm_medium=banner&utm_campaign=coming-soon-banner-in-plugin" target="_blank"><img src="<?php echo SEED_CSP4_PLUGIN_URL; ?>framework/coming-soon-pro-sidebar.png" /></a>
                            <br><br>


                 <!--            <div class="postbox " style="background-color:#FAE6A4;color:#333 !important; border-color:#333 !important">
                                <div class="handlediv" title="Click to toggle"><br /></div>
                                <h3 class="hndle" style="color:#fff !important;border-color:#333 !important; background-color:#333"><span><i class="fa fa-star"></i>&nbsp;&nbsp;<?php _e('Yo-Yo-Yo, Why Go Pro?', 'coming-soon') ?></span></h3>
                                <div class="inside">
                                    <div class="support-widget">
                                    
                                        <ul>

                                            <li><i class="fa fa-check"></i> <strong>Realtime Page Customizer</strong></li>
                                            <li><i class="fa fa-check"></i> <strong>More Design Controls and Widgets</strong></li>
                                            <li><i class="fa fa-check"></i> <strong>Pre Made Themes</strong></li>
                                            <li><i class="fa fa-check"></i> <strong>1000's of Free Stock Images</strong></li>
                                            <li><i class="fa fa-check"></i> <strong>Collect Emails (MailChimp, Database and other integrations)
                                            </strong></li>
                                            <li><i class="fa fa-check"></i> <strong>Go Viral with Social Media Integrations
                                            </strong></li>
                                            <li><i class="fa fa-check"></i> <strong>Shortcode Support, Google Font Support, Background Slideshow and Videos
                                            </strong></li>
                                            
                                             <li><i class="fa fa-check"></i> <strong>Give clients Instant Access with a Bypass Link
                                            </strong></li>
                                            <li><hr style=" border-top: 1px solid #333; border-bottom: none"></li>
                                            <li><strong>Plus lots more!</strong></li>
                                        </ul>
                                        <p>
                                        <a class="button-primary" style="background-color:#05AE0E; border-color:#05AE0E; box-shadow:none; text-shadow: none; width:100%; text-align:center;" href="https://www.seedprod.com/ultimate-coming-soon-page-vs-coming-soon-pro/?utm_source=coming-soon-plugin&utm_medium=banner&utm_campaign=coming-soon-banner-in-plugin" target="_blank">See What's In The Pro Version</a>
                                        </p>

                                    </div>
                                </div>
                            </div> -->

                            <div class="postbox ">
                                <div class="handlediv" title="Click to toggle"><br /></div>
                            
                                <div class="inside">
                                    <div class="support-widget">
                                     
                                 <p style="text-align: center;margin-bottom:0"><a href="https://wordpress.org/support/plugin/coming-soon" target="_blank"><?php _e('Got a Support Question', 'coming-soon') ?></a> <i class="fa fa-question-circle" aria-hidden="true"></i>
                                          <!--   <li>&raquo; <a href="http://support.seedprod.com/article/83-how-to-clear-wp-super-caches-cache" target="_blank"><?php _e('Common Caching Issues Resolutions', 'coming-soon') ?></a></li> -->
                                        </p>
                                            <!--   <p style="text-align: center; margin-top:0">

                                            <a style="display:inline-block" href="https://wordpress.org/support/plugin/coming-soon/reviews/?filter=5#new-post">Please Rate this Plugin to show your Support!</a> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></p> -->
                                            

                                   

                                    </div>
                                </div>
                            </div>

                            <form id="seed-bg-form" style="display:none" action="https://www.getdrip.com/forms/39621858/submissions" method="post" data-drip-embedded-form="39621858" target="_blank">
                                <div>
                                    <label for="drip-email">Email Address</label><br />
                                    <input type="email" id="drip-email" name="fields[email]" value="" />
                                </div>
                              <div>
                                <input id="drip-submit" type="submit" name="submit" value="Sign Up" data-drip-attribute="sign-up-button" />
                              </div>
                            </form>

                           
                               <!-- <div class="postbox like-postbox">
                                    <div class="handlediv" title="Click to toggle"><br /></div>
                                    <h3 class="hndle"><span><i class="fa fa-heart"></i>&nbsp;&nbsp;<?php _e('Show Some Love', 'coming-soon') ?></span></h3>
                                    <div class="inside">
                                        <div class="like-widget">
                                            <p><?php _e('Like this plugin? Show your support by:', 'coming-soon')?></p>
                                            <ul>
                                                <li>&raquo; <a target="_blank" href="http://www.seedprod.com/features/?utm_source=coming-soon-plugin&utm_medium=banner&utm_campaign=coming-soon-link-in-plugin"><?php _e('Buy It', 'coming-soon') ?></a></li>

                                                <li>&raquo; <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/coming-soon?rate=5#postform"><?php _e('Rate It on WordPress.org', 'coming-soon') ?></a></li>
                                                <li>&raquo; <a target="_blank" href="<?php echo "http://twitter.com/share?url=https%3A%2F%2Fwordpress.org%2Fplugins%2Fultimate-coming-soon-page%2F&text=Check out this awesome %23WordPress Plugin I'm using, Coming Soon Page and Maintenance Mode by SeedProd"; ?>"><?php _e('Tweet It', 'coming-soon') ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> -->
                            


                       <!--          <div class="postbox rss-postbox">
    											<div class="handlediv" title="Click to toggle"><br /></div>
    											<h3 class="hndle"><span><i class="fa fa-wordpress"></i>&nbsp;&nbsp;<?php _e('SeedProd Blog', 'ultimate-coming-soon-page') ?></span></h3>
    											<div class="inside">

    												<div class="rss-widget">
    													<?php
    													wp_widget_rss_output(array(
    													'url' => 'http://feeds.feedburner.com/seedprod/',
    													'title' => 'SeedProd Blog',
    													'items' => 3,
    													'show_summary' => 0,
    													'show_author' => 0,
    													'show_date' => 1,
    												));
    												?>
    												<ul>

    											</ul>
    										</div>
    									</div>
    								</div> -->

                        </div>
                    </div>
                </div> <!-- #post-body -->


            </div> <!-- #poststuff -->
            <?php endif; ?>
        </div> <!-- .wrap -->

        <!-- JS login to confirm setting resets. -->
        <script>
            jQuery(document).ready(function($) {
                $('#reset').click(function(e){
                    if(!confirm('<?php _e( 'This tabs settings be deleted and reset to the defaults. Are you sure you want to reset?', 'coming-soon' ); ?>')){
                        e.preventDefault();
                    }
                });
            });
        </script>
        <?php
    }

    /**
     * Create the settings options, sections and fields via the WordPress Settings API
     *
     * This function is attached to the admin_init action hook.
     *
     * @since 0.1.0
     */
    function create_settings( )
    {
        foreach ( seed_csp4_get_options() as $k => $v ) {

            switch ( $v[ 'type' ] ) {
                case 'menu':
                    $menu_slug = $v[ 'menu_slug' ];

                    break;
                case 'setting':
                    if ( empty( $v[ 'validate_function' ] ) ) {
                        $v[ 'validate_function' ] = array(
                             &$this,
                            'validate_machine'
                        );
                    }
                    register_setting( $v[ 'id' ], $v[ 'id' ], $v[ 'validate_function' ] );
                    $setting_id = $v[ 'id' ];
                    break;
                case 'section':
                    if ( empty( $v[ 'desc_callback' ] ) ) {
                        $v[ 'desc_callback' ] = array(
                             &$this,
                            'return_empty_string'
                        );
                    } else {
                        $v[ 'desc_callback' ] = $v[ 'desc_callback' ];
                    }
                    add_settings_section( $v[ 'id' ], $v[ 'label' ], $v[ 'desc_callback' ], $v[ 'id' ] );
                    $section_id = $v[ 'id' ];
                    break;
                case 'tab':
                    break;
                default:
                    if ( empty( $v[ 'callback' ] ) ) {
                        $v[ 'callback' ] = array(
                             &$this,
                            'field_machine'
                        );
                    }

                    add_settings_field( $v[ 'id' ], $v[ 'label' ], $v[ 'callback' ], $section_id, $section_id, array(
                         'id' => $v[ 'id' ],
                        'desc' => ( isset( $v[ 'desc' ] ) ? $v[ 'desc' ] : '' ),
                        'setting_id' => $setting_id,
                        'class' => ( isset( $v[ 'class' ] ) ? $v[ 'class' ] : '' ),
                        'type' => $v[ 'type' ],
                        'default_value' => ( isset( $v[ 'default_value' ] ) ? $v[ 'default_value' ] : '' ),
                        'option_values' => ( isset( $v[ 'option_values' ] ) ? $v[ 'option_values' ] : '' )
                    ) );

            }
        }
    }

    /**
     * Create a field based on the field type passed in.
     *
     * @since 0.1.0
     */
    function field_machine( $args )
    {
        extract( $args ); //$id, $desc, $setting_id, $class, $type, $default_value, $option_values

        // Load defaults
        $defaults = array( );
        foreach ( seed_csp4_get_options() as $k ) {
            switch ( $k[ 'type' ] ) {
                case 'setting':
                case 'section':
                case 'tab':
                    break;
                default:
                    if ( isset( $k[ 'default_value' ] ) ) {
                        $defaults[ $k[ 'id' ] ] = $k[ 'default_value' ];
                    }
            }
        }
        $options = get_option( $setting_id );

        $options = wp_parse_args( $options, $defaults );

        $path = SEED_CSP4_PLUGIN_PATH . 'framework/field-types/' . $type . '.php';
        if ( file_exists( $path ) ) {
            // Show Field
            include( $path );
            // Show description
            if ( !empty( $desc ) ) {
                echo "<small class='description'>{$desc}</small>";
            }
        }

    }

    /**
     * Validates user input before we save it via the Options API. If error add_setting_error
     *
     * @since 0.1.0
     * @param array $input Contains all the values submitted to the POST.
     * @return array $input Contains sanitized values.
     * @todo Figure out best way to validate values.
     */
    function validate_machine( $input )
    {
        $option_page = $_POST['option_page'];
        foreach ( seed_csp4_get_options() as $k ) {
            switch ( $k[ 'type' ] ) {
                case 'menu':
                case 'setting':
                    if(isset($k['id']))
                        $setting_id = $k['id'];
                case 'section':
                case 'tab';
                    break;
                default:
                    if ( !empty( $k[ 'validate' ] ) && $setting_id == $option_page ) {
                        $validation_rules = explode( ',', $k[ 'validate' ] );

                        foreach ( $validation_rules as $v ) {
                            $path = SEED_CSP4_PLUGIN_PATH . 'framework/validations/' . $v . '.php';
                            if ( file_exists( $path ) ) {
                                // Defaults Values
                                $is_valid  = true;
                                $error_msg = '';

                                // Test Validation
                                include( $path );

                                // Is it valid?
                                if ( $is_valid === false ) {
                                    add_settings_error( $k[ 'id' ], 'seedprod_error', $error_msg, 'error' );
                                    // Unset invalids
                                    unset( $input[ $k[ 'id' ] ] );
                                }

                            }
                        } //end foreach

                    }
            }
        }

        return $input;
    }

    /**
     * Dummy function to be called by all sections from the Settings API. Define a custom function in the config.
     *
     * @since 0.1.0
     * @return string Empty
     */
    function return_empty_string( )
    {
        echo '';
    }


    /**
     * SeedProd version of WP's do_settings_sections
     *
     * @since 0.1.0
     */
    function do_settings_sections( $page, $show_submit )
    {
        global $wp_settings_sections, $wp_settings_fields;

        if ( !isset( $wp_settings_sections ) || !isset( $wp_settings_sections[ $page ] ) )
            return;

        foreach ( (array) $wp_settings_sections[ $page ] as $section ) {
            echo "<h3 class='hndle'>{$section['title']}</h3>\n";
            echo '<div class="inside">';
            call_user_func( $section[ 'callback' ], $section );
            if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[ $page ] ) || !isset( $wp_settings_fields[ $page ][ $section[ 'id' ] ] ) )
                continue;
            echo '<table class="form-table">';
            $this->do_settings_fields( $page, $section[ 'id' ] );
            echo '</table>';
            if($show_submit): ?>
                <p>
                <input name="submit" type="submit" value="<?php _e( 'Save All Changes', 'coming-soon' ); ?>" class="button-primary"/>
                </p>
            <?php endif;
            echo '</div>';
        }
    }

    function do_settings_fields($page, $section) {
          global $wp_settings_fields;

          if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section]) )
              return;

          foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
              echo '<tr valign="top">';
              if ( !empty($field['args']['label_for']) )
                  echo '<th scope="row"><label for="' . $field['args']['label_for'] . '">' . $field['title'] . '</label></th>';
              else
                  echo '<th scope="row"><strong>' . $field['title'] . '</strong><!--<br>'.$field['args']['desc'].'--></th>';
              echo '<td>';
              call_user_func($field['callback'], $field['args']);
              echo '</td>';
              echo '</tr>';
          }
      }

}

add_action( 'admin_head', 'seed_csp4_set_user_settings' );
function seed_csp4_set_user_settings() {
  if(isset($_GET['page']) && $_GET['page'] == 'seed_csp4'){
              $user_id = get_current_user_id();
              $options = get_user_option( 'user-settings', $user_id );
              parse_str($options,$user_settings);
              $user_settings['imgsize'] = 'full';
              update_user_option( $user_id, 'user-settings', http_build_query($user_settings), false );
              update_user_option( $user_id, 'user-settings-time', time(), false );
  }
}
