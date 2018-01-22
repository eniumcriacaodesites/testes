<?php
/**
 * Config
 *
 * @package WordPress
 * @subpackage seed_csp4
 * @since 0.1.0
 */

/**
 * Config Settings
 */
function seed_csp4_get_options(){

    /**
     * Create new menus
     */

    $seed_csp4_options[ ] = array(
        "type" => "menu",
        "menu_type" => "add_options_page",
        "page_name" => __( "Coming Soon", 'coming-soon' ),
        "menu_slug" => "seed_csp4",
        "layout" => "2-col"
    );

    /**
     * Settings Tab
     */
    $seed_csp4_options[ ] = array(
        "type" => "tab",
        "id" => "seed_csp4_setting",
        "label" => __( "Content", 'coming-soon' ),
    );

    $seed_csp4_options[ ] = array(
        "type" => "setting",
        "id" => "seed_csp4_settings_content",
    );

    $seed_csp4_options[ ] = array(
        "type" => "section",
        "id" => "seed_csp4_section_general",
        "label" => __( "General", 'coming-soon' ),
    );

    $seed_csp4_options[ ] = array(
        "type" => "radio",
        "id" => "status",
        "label" => __( "Status", 'coming-soon' ),
        "option_values" => array(
            '0' => __( 'Disabled', 'coming-soon' ),
            '1' => __( 'Enable Coming Soon Mode', 'coming-soon' ),
            '2' => __( 'Enable Maintenance Mode', 'coming-soon' )
        ),
        "desc" => __( "When you are logged in you'll see your normal website. Logged out visitors will see the Coming Soon or Maintenance page. Coming Soon Mode will be available to search engines if your site is not private. Maintenance Mode will notify search engines that the site is unavailable. <a href='https://www.seedprod.com/coming-soon-vs-maintenance-mode/' target='_blank'>Learn the difference between Coming Soon and Maintenance Mode</a>", 'coming-soon' ),
        "default_value" => "0"
    );


    $csp4_maintenance_file = WP_CONTENT_DIR."/maintenance.php";
    if (file_exists($csp4_maintenance_file)) {
    $seed_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "enable_maintenance_php",
        "label" => __( "Use maintenance.php", 'coming-soon' ),
        "desc" => __('maintenance.php detected, would you like to use this for your maintenance page?', 'coming-soon'),
        "option_values" => array(
             'name' => __( 'Yes', 'coming-soon' ),
             //'required' => __( 'Make Name Required', 'coming-soon' ),
        )
    );
    }

    // Page Setttings
    $seed_csp4_options[ ] = array(
        "type" => "section",
        "id" => "seed_csp4_section_page_settings",
        "label" => __( "Page Settings", 'coming-soon' )
    );

    $seed_csp4_options[ ] = array(
        "type" => "upload",
        "id" => "logo",
        "label" => __( "Logo", 'coming-soon' ),
        "desc" => __('Upload a logo or teaser image (or) enter the url to your image.', 'coming-soon'),
    );

    $seed_csp4_options[ ] = array(
        "type" => "textbox",
        "id" => "headline",
        "class" => "large-text",
        "label" => __( "Headline", 'coming-soon' ),
        "desc" => __( "Enter a headline for your page.", 'coming-soon' ),
    );

    $seed_csp4_options[ ] = array(
        "type" => "wpeditor",
        "id" => "description",
        "label" => __( "Message", 'coming-soon' ),
        "desc" => __( "Tell the visitor what to expect from your site. Check out the Pro Version if you need ShortCode support.", 'coming-soon' ),
        "class" => "large-text"
    );

     $seed_csp4_options[ ] = array( "type" => "radio",
        "id" => "footer_credit",
        "label" => __("Powered By SeedProd", 'ultimate-coming-soon-page'),
        "option_values" => array('0'=>__('Nope - Got No Love', 'coming-soon'),'1'=>__('Yep - I Love You Man', 'coming-soon')),
        "desc" => __("Can we show a <strong>cool stylish</strong> footer credit at the bottom the page.", 'coming-soon'),
        "default_value" => "0",
    );


    // Header
    $seed_csp4_options[ ] = array(
        "type" => "section",
        "id" => "seed_csp4_section_header",
        "label" => __( "Header", 'coming-soon' )
    );

    $seed_csp4_options[ ] = array(
        "type" => "upload",
        "id" => "favicon",
        "label" => __( "Favicon", 'coming-soon' ),
        "desc" => __('Favicons are displayed in a browser tab. Need Help <a href="http://tools.dynamicdrive.com/favicon/" target="_blank">creating a favicon</a>?', 'coming-soon'),
    );

    $seed_csp4_options[ ] = array(
        "type" => "textbox",
        "id" => "seo_title",
        "label" => __( "SEO Title", 'coming-soon' ),
    );

    $seed_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "seo_description",
        "label" => __( "SEO Meta Description", 'coming-soon' ),
        "class" => "large-text"
    );


    $seed_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "ga_analytics",
        "class" => "large-text",
        "label" => __( "Analytics Code", 'coming-soon' ),
        "desc" => __('Paste in your Universal or Classic <a href="http://www.google.com/analytics/" target="_blank">Google Analytics</a> code.', 'coming-soon'),
    );


    /**
     * Design Tab
     */
    $seed_csp4_options[ ] = array(
        "type" => "tab",
        "id" => "seed_csp4_design",
        "label" => __( "Design", 'coming-soon' )
    );

    $seed_csp4_options[ ] = array(
        "type" => "setting",
        "id" => "seed_csp4_settings_design"
    );


    // Background
    $seed_csp4_options[ ] = array(
        "type" => "section",
        "id" => "seed_csp4_section_background",
        "label" => __( "Background", 'coming-soon' )
    );


    $seed_csp4_options[ ] = array(
        "type" => "color",
        "id" => "bg_color",
        "label" => __( "Background Color", 'coming-soon' ),
        "default_value" => "#fafafa",
        "validate" => 'color',
        "desc" => __( "Choose between having a solid color background or uploading an image. By default images will cover the entire background.", 'coming-soon' )
    );


    $seed_csp4_options[ ] = array(
        "type" => "upload",
        "id" => "bg_image",
        "desc" => '
        Looking for free background images? Confirm that\'s your email and click the button below.<br>
        <div id="seed-bg-images-form"><input type="email" id="seed-bg-images-email"  value="'.get_option('admin_email').'" /><button id="seed-bg-images-btn" class="button-primary">Send Me FREE Background Images</button></div>
        <script>
        jQuery( "#seed-bg-images-btn" ).click(function(e) {
            e.preventDefault();
            jQuery("#drip-email").val(jQuery("#seed-bg-images-email").val());
            jQuery("#drip-submit").click();
        });
        </script>
        ',
        "label" => __( "Background Image", 'coming-soon' ),
    );

    $seed_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "bg_cover",
        "label" => __( "Responsive Background", 'coming-soon' ),
        "desc" => __("Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area.", 'coming-soon'),
        "option_values" => array(
             '1' => __( 'Yes', 'coming-soon' ),
        ),
        "default" => "1",
    );

    $seed_csp4_options[ ] = array(
        "type" => "select",
        "id" => "bg_size",
        "desc" => __('Cover (most users will use this setting), this setting will crop parts of the background that do not fit, Contain, this will force the background image to stay contained within the browser and parts that don\'t fit will show the background color.', 'coming-soon' ),
        "label" => __( "Responsive Size", 'coming-soon' ),
        "option_values" => array(
            'cover' => __( 'Cover', 'coming-soon' ),
            'contain' => __( 'Contain', 'coming-soon' ),
        )
    );

    $seed_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "bg_overlay",
        "label" => __( "Dim Background", 'coming-soon' ),
        "desc" => __("This will add an overlay over your image dimming it.", 'coming-soon'),
        "option_values" => array(
             '1' => __( 'Yes', 'coming-soon' ),
        ),
        "default" => "1",
    );

    $seed_csp4_options[ ] = array(
        "type" => "select",
        "id" => "bg_repeat",
        "desc" => __('This setting is not applied if Responsive Background is checked', 'coming-soon' ),
        "label" => __( "Background Repeat", 'coming-soon' ),
        "option_values" => array(
            'no-repeat' => __( 'No-Repeat', 'coming-soon' ),
            'repeat' => __( 'Tile', 'coming-soon' ),
            'repeat-x' => __( 'Tile Horizontally', 'coming-soon' ),
            'repeat-y' => __( 'Tile Vertically', 'coming-soon' ),
        )
    );


    $seed_csp4_options[ ] = array(
        "type" => "select",
        "id" => "bg_position",
        "desc" => __('This setting is not applied if Responsive Background is checked', 'coming-soon' ),
        "label" => __( "Background Position", 'coming-soon' ),
        "option_values" => array(
            'left top' => __( 'Left Top', 'coming-soon' ),
            'left center' => __( 'Left Center', 'coming-soon' ),
            'left bottom' => __( 'Left Bottom', 'coming-soon' ),
            'right top' => __( 'Right Top', 'coming-soon' ),
            'right center' => __( 'Right Center', 'coming-soon' ),
            'right bottom' => __( 'Right Bottom', 'coming-soon' ),
            'center top' => __( 'Center Top', 'coming-soon' ),
            'center center' => __( 'Center Center', 'coming-soon' ),
            'center bottom' => __( 'Center Bottom', 'coming-soon' ),
        )
    );

    $seed_csp4_options[ ] = array(
        "type" => "select",
        "id" => "bg_attahcment",
        "desc" => __('This setting is not applied if Responsive Background is checked', 'coming-soon' ),
        "label" => __( "Background Attachment", 'coming-soon' ),
        "option_values" => array(
            'fixed' => __( 'Fixed', 'coming-soon' ),
            'scroll' => __( 'Scroll', 'coming-soon' ),
        )
    );

    // Background
    $seed_csp4_options[ ] = array(
        "type" => "section",
        "id" => "seed_csp4_section_well",
        "label" => __( "Content", 'coming-soon' )
    );

    $seed_csp4_options[ ] = array(
        "type" => "textbox",
        "id" => "max_width",
        "class" => "text-small",
        "label" => __( "Max Width", 'coming-soon' ),
        "desc" => __("By default the max width of the content is set to 600px. Enter a number value if you need it bigger. Example: 900", 'coming-soon'),    );

    $seed_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "enable_well",
        "label" => __( "Enable Well", 'coming-soon' ),
        "desc" => __("This will wrap your content in a box.", 'coming-soon'),
        "option_values" => array(
             '1' => __( 'Yes', 'coming-soon' ),
        ),
    );



    // Text
    $seed_csp4_options[ ] = array(
        "type" => "section",
        "id" => "seed_csp4_section_text",
        "label" => __( "Text", 'coming-soon' )
    );

    $seed_csp4_options[ ] = array(
        "type" => "color",
        "id" => "text_color",
        "label" => __( "Text Color", 'coming-soon' ),
        "default_value" => "#666666",
        "validate" => 'required,color',
    );

    $seed_csp4_options[ ] = array(
        "type" => "color",
        "id" => "link_color",
        "label" => __( "Link Color", 'coming-soon' ),
        "default_value" => "#27AE60",
        "validate" => 'required,color',
    );

    $seed_csp4_options[ ] = array(
        "type" => "color",
        "id" => "headline_color",
        "label" => __( "Headline Color", 'coming-soon' ),
        "validate" => 'color',
        "default_value" => "#444444",
        "desc" => __('If no Headline Color is chosen then the Link Color will be used. ','coming-soon'),
    );



    $seed_csp4_options[ ] = array(
        "type" => "select",
        "id" => "text_font",
        "label" => __( "Text Font", 'coming-soon' ),
        "option_values" => apply_filters('seed_csp4_fonts',array(
            '_arial'     => 'Arial',
            '_arial_black' =>'Arial Black',
            '_georgia'   => 'Georgia',
            '_helvetica_neue' => 'Helvetica Neue',
            '_impact' => 'Impact',
            '_lucida' => 'Lucida Grande',
            '_palatino'  => 'Palatino',
            '_tahoma'    => 'Tahoma',
            '_times'     => 'Times New Roman',
            '_trebuchet' => 'Trebuchet',
            '_verdana'   => 'Verdana',
            )),
    );


    // Template
    $seed_csp4_options[ ] = array(
        "type" => "section",
        "id" => "seed_csp4_section_template",
        "label" => __( "Template", 'coming-soon' )
    );


    $seed_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "custom_css",
        "class" => "large-text",
        "label" => __( "Custom CSS", 'coming-soon' ),
        "desc" => __('Need to tweaks the styles? Add your custom CSS here.','coming-soon'),
    );

    /**
     * Advanced Tab
     */
    $seed_csp4_options[ ] = array(
        "type" => "tab",
        "id" => "seed_csp4_advanced",
        "label" => __( "Advanced", 'coming-soon' )
    );

    $seed_csp4_options[ ] = array(
        "type" => "setting",
        "id" => "seed_csp4_settings_advanced"
    );


    // Scripts
    $seed_csp4_options[ ] = array(
        "type" => "section",
        "id" => "seed_csp4_section_scripts",
        "label" => __( "Scripts", 'coming-soon' )
    );

    $seed_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "disable_default_excluded_urls",
        "label" => __( "Disable Default Excluded URLs", 'coming-soon' ),
        "desc" => __("By default we exclude urls with the terms: login, admin, dashboard and account to prevent lockouts. Check to disable.", 'coming-soon'),
        "option_values" => array(
             '1' => __( 'Disable', 'coming-soon' ),
        ),
        "default" => "1",
    );

    $seed_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "header_scripts",
        "label" => __( "Header Scripts", 'coming-soon' ),
        "desc" => __('Enter any custom scripts. You can enter Javascript or CSS. This will be rendered before the closing head tag.', 'coming-soon'),
        "class" => "large-text"
    );

    $seed_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "footer_scripts",
        "label" => __( "Footer Scripts", 'coming-soon' ),
        "desc" => __('Enter any custom scripts. This will be rendered before the closing body tag.', 'coming-soon'),
        "class" => "large-text"
    );

    $seed_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "html",
        "label" => __( "Custom HTML", 'coming-soon' ),
        "desc" => __("This will replace the plugin's entire template with your custom html. Make sure to include the html, head and body tags when replacing the html.", 'coming-soon'),
        "class" => "large-text"
    );

    $seed_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "append_html",
        "label" => __( "Append HTML", 'coming-soon' ),
        "desc" => __("This will append html to the bottom of the template using the current styles.", 'coming-soon'),
        "class" => "large-text"
    );


    return $seed_csp4_options;

}
