<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * TSEO PRO Options
 *
 * @package TSEOPortfolio
 * @version 1.0.0
 */

function tseoportfolio_add_submenu_page() {
    add_submenu_page(
        'edit.php?post_type=tseoportfolio',
        __('TSEO Portfolio Settings', 'tseoportfolio'),
        __('Settings', 'tseoportfolio'),
        'manage_options',
        'tseoportfolio-settings',
        'tseoportfolio_settings_page'
    );
}
add_action('admin_menu', 'tseoportfolio_add_submenu_page');

/**
 * TSEO PRO settings
 *
 * @package TSEOPortfolio
 * @version 1.0.0
 */
function tseoportfolio_settings_page() {
    ?>
    <div class="tseoportfolio-admin-panel">
        <div id="tseoport-loading-overlay">
            <div class="centered-content">
                <div class="tseoport-loading-spinner"></div>
                <span><?php echo esc_html_e('Saving TSEO Portfolio settings', 'tseoportfolio'); ?></span>
            </div>
        </div>
        <div class="main-content">
            <h1><?php esc_html_e('TSEO Portfolio Settings', 'tseoportfolio'); ?></h1>
            <form method="post" action="options.php">
            <?php settings_fields('tseoportfolio_settings_group'); ?>
            <table class="form-table">
                <?php settings_errors(); ?>
                <script>
                    setTimeout(function() {
                        jQuery('.notice').fadeOut('slow');
                    }, 3000);
                </script>
                <tr valign="top">
                    <th scope="row" colspan="2">
                        <h3><?php esc_html_e('Customize Gallery', 'tseoportfolio'); ?></h3>
                    </th>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Title', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_gallery_title" value="<?php echo esc_attr(get_option('tseoportfolio_gallery_title')); ?>" placeholder="<?php echo esc_html_e('Portfolio of Websites Optimized for SEO and SEM','tseoportfolio'); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Gallery Title Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_gallery_title_color" value="<?php echo esc_attr(get_option('tseoportfolio_gallery_title_color', '#4c6363')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Gallery Background Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_gallery_color" value="<?php echo esc_attr(get_option('tseoportfolio_gallery_color', '#f8f9fa')); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row" colspan="2">
                        <h3><?php esc_html_e('Customize Cards', 'tseoportfolio'); ?></h3>
                    </th>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Card Background Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_card_color" value="<?php echo esc_attr(get_option('tseoportfolio_card_color', '#ffffff')); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Card Border Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_card_border_color" value="<?php echo esc_attr(get_option('tseoportfolio_card_border_color', '#e9ecef')); ?>" />
                    </td>
                </tr>


                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Card Title Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_card_title_color" value="<?php echo esc_attr(get_option('tseoportfolio_card_title_color', '#003e71')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Card Description Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_card_desc_color" value="<?php echo esc_attr(get_option('tseoportfolio_card_desc_color', '#666666')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Card Footer Background Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_card_footer_bgcolor" value="<?php echo esc_attr(get_option('tseoportfolio_card_footer_bgcolor', '#dee2e6')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" colspan="2">
                        <h3><?php esc_html_e('Customize Buttons', 'tseoportfolio'); ?></h3>
                    </th>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Background Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_btn_bgcolor" value="<?php echo esc_attr(get_option('tseoportfolio_btn_bgcolor', '#f5f5f5')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Text Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_btn_textcolor" value="<?php echo esc_attr(get_option('tseoportfolio_btn_textcolor', '#333333')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Hover Background Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_btn_hover_bgcolor" value="<?php echo esc_attr(get_option('tseoportfolio_btn_hover_bgcolor', '#e5e5e5')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Hover Text Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_btn_hover_textcolor" value="<?php echo esc_attr(get_option('tseoportfolio_btn_hover_textcolor', '#ffffff')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Visited Text Color', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="text" name="tseoportfolio_btn_visited_color" value="<?php echo esc_attr(get_option('tseoportfolio_btn_visited_color', '#ff0000')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" colspan="2">
                        <h3><?php esc_html_e('Delete data', 'tseoportfolio'); ?></h3>
                    </th>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Delete data when uninstalling', 'tseoportfolio'); ?></th>
                    <td>
                        <input type="checkbox" name="tseoportfolio_delete_data" value="1" <?php checked(1, get_option('tseoportfolio_delete_data'), true); ?> />
                        <label for="tseoportfolio_delete_data"><?php esc_html_e('Delete all data when uninstalling the plugin', 'tseoportfolio'); ?></label>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
            </form>
        </div>    
        <div class="sidebar">
            <h2><?php echo esc_html_e('How to display the gallery','tseoportfolio'); ?></h2>

            <p><?php esc_html_e('To display the website gallery on any page or post, simply insert the following shortcode:', 'tseoportfolio'); ?></p>
            <code>[tseo_portfolio_grid]</code>

            <p><?php esc_html_e('If you want, you can insert the number of posts to display like this:', 'tseoportfolio'); ?></p>
            <code>[tseo_portfolio_grid count="10"]</code>

            <h2><?php echo esc_html_e('Information','tseoportfolio'); ?></h2>

            <p><?php echo esc_html_e("TSEO Portfolio is recommended for digital marketing agencies that want to showcase a portfolio of websites in WordPress with high performance for SEO and SEM campaigns.",'tseoportfolio'); ?></p>

            <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'admin/img/tseopro.jpg'); ?>" alt="TSEO PRO theme">

            <h3><?php echo esc_html_e('Boost your business with our TSEO PRO theme','tseoportfolio'); ?></h3>
            
            <p><?php echo esc_html_e("A Hassle-Free, Comprehensive Solution: If you're aiming to establish a powerful and seamless online presence, you've come to the right place. With our TSEO PRO theme and its 'Web Renting' subscription model, we offer an ideal solution for businesses and entrepreneurs. Get a high-performance website, SEO-optimized, without making significant upfront investments.",'tseoportfolio'); ?></p>

            <a href="<?php echo esc_url('https://tseo.pro/'); ?>" target="_black" rel="noopener noreferrer" class="button"><?php echo esc_html_e('Visit TSEO PRO', 'tseoportfolio'); ?></a>
        </div>
    </div>
    <?php
}

function tseoportfolio_register_settings() {
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_gallery_title');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_gallery_title_color');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_gallery_color');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_card_color');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_card_border_color');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_card_title_color');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_card_desc_color');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_card_footer_bgcolor');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_btn_bgcolor');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_btn_textcolor');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_btn_hover_bgcolor');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_btn_hover_textcolor');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_btn_visited_color');
    register_setting('tseoportfolio_settings_group', 'tseoportfolio_delete_data');
}
add_action('admin_init', 'tseoportfolio_register_settings');

/**
 * TSEO PRO default color picker
 *
 * @package TSEOPortfolio
 * @version 1.0.0
 */
function tseoportfolio_enqueue_color_picker($hook_suffix) {
    if ('tseoportfolio_page_tseoportfolio-settings' != $hook_suffix) {
        return;
    }

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    wp_enqueue_script('tseoportfolio-color-picker', plugin_dir_url(dirname(__FILE__)) . 'admin/js/tseoport-color-picker.js', array('jquery', 'wp-color-picker'), TSEOPORTFOLIO_VERSION, true);

    wp_enqueue_script('tseoportfolio-loading', plugin_dir_url(dirname(__FILE__)) . 'admin/js/tseoport-loading.js', array(), TSEOPORTFOLIO_VERSION, true);
}
add_action('admin_enqueue_scripts', 'tseoportfolio_enqueue_color_picker');

/**
 * TSEO PRO admin style
 *
 * @package TSEOPortfolio
 * @version 1.0.0
 */
function tseoportfolio_admin_styles($hook) {
    if ('tseoportfolio_page_tseoportfolio-settings' != $hook) {
        return;
    }
    wp_enqueue_style('tseoportfolio-admin', plugin_dir_url(dirname(__FILE__)) . 'admin/css/tseoport.min.css', array(), TSEOPORTFOLIO_VERSION, 'all');
}
add_action('admin_enqueue_scripts', 'tseoportfolio_admin_styles');