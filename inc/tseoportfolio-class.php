<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * TSEO PRO class TSEO_Portfolio
 *
 * @package TSEOPortfolio
 * @version 1.0.0
 */

class TSEOPortfolio_Main {

    /**
     * TSEO PRO Constructor
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function __construct() {      
        add_action('init', array($this, 'register_tseoportfolio_post_type'));
        add_action('add_meta_boxes', array($this, 'tseoportfolio_add_description_metabox'));
        add_action('save_post_tseoportfolio', array($this, 'tseoportfolio_save_description_metabox_data'));
        add_action('add_meta_boxes', array($this, 'tseoportfolio_add_web_links_metabox'));
        add_action('save_post_tseoportfolio', array($this, 'tseoportfolio_save_web_links_metabox_data'));
        add_shortcode('tseoportfolio_grid', array($this, 'tseoportfolio_display_portfolio_grid'));
        add_action('wp_enqueue_scripts', array($this, 'tseoportfolio_enqueue_styles_and_scripts'));
        add_action('add_meta_boxes', array($this, 'tseoportfolio_add_shortcode_instructions_metabox'));
        add_action('add_meta_boxes', array($this, 'tseoportfolio_register_order_metabox'));
        add_action('save_post', array($this, 'tseoportfolio_save_order_metabox'));
        add_action('add_meta_boxes', array($this, 'tseoportfolio_add_metabox_checkbox'));
        add_action('save_post', array($this, 'tseoportfolio_save_metabox_data'));
        add_action('init', array($this, 'tseoportfolio_rewrite_rules'));
    }
    public function register_tseoportfolio_post_type() {
        $args = array(
            'label' => __('TSEO Portfolio', 'tseoportfolio'),
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'supports' => array('title', 'thumbnail'),
            'menu_icon' => 'dashicons-portfolio',
            'rewrite' => array('slug' => 'portfolio'),
        );
        register_post_type('tseoportfolio', $args);
    }

    /**
     * Metabox description
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function tseoportfolio_add_description_metabox() {
        add_meta_box(
            'tseoportfolio_description', 
            __('Description', 'tseoportfolio'), 
            array($this, 'tseoportfolio_render_description_metabox'), 
            'tseoportfolio', 
            'normal', 
            'high'
        );
    }
    public function tseoportfolio_render_description_metabox($post) {
        $description = get_post_meta($post->ID, '_tseoportfolio_description', true);
        wp_nonce_field('tseoportfolio_save_description', 'tseoportfolio_description_nonce');
        echo '<textarea id="tseoportfolio_description" name="tseoportfolio_description" style="width:100%;height:100px;">' . esc_textarea($description) . '</textarea>';
    }
    public function tseoportfolio_save_description_metabox_data($post_id) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        if (!isset($_POST['tseoportfolio_description_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tseoportfolio_description_nonce'])), 'tseoportfolio_save_description')) {

            return;
        }
        if (isset($_POST['tseoportfolio_description'])) {
            update_post_meta($post_id, '_tseoportfolio_description', sanitize_textarea_field($_POST['tseoportfolio_description']));
        }
    }

    /**
     * Metabox Web Links (nonce)
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function tseoportfolio_add_web_links_metabox() {
        add_meta_box(
            'tseoportfolio_web_links',
            __('Web links for analytics', 'tseoportfolio'),
            array($this, 'tseoportfolio_render_web_links_metabox'),
            'tseoportfolio',
            'normal',
            'high'
        );
    }
    public function tseoportfolio_render_web_links_metabox($post) {
        wp_nonce_field('tseoportfolio_save_web_links', 'tseoportfolio_web_links_nonce');

        $web_link = get_post_meta($post->ID, '_tseoportfolio_web_link', true);
        $pagespeed_mobile_link = get_post_meta($post->ID, '_tseoportfolio_pagespeed_mobile_link', true);
        $pagespeed_desktop_link = get_post_meta($post->ID, '_tseoportfolio_pagespeed_desktop_link', true);

        // Nuevos para agregar
        $web_link_pingdom = get_post_meta($post->ID, '_tseoportfolio_web_link_pingdom', true);
        $web_link_gtmetrix = get_post_meta($post->ID, '_tseoportfolio_web_link_gtmetrix', true);
        $web_link_richresults = get_post_meta($post->ID, '_tseoportfolio_web_link_richresults', true);

        echo '<label for="tseoportfolio_web_link"><strong>' . esc_html_e('Web Link', 'tseoportfolio') . '</strong></label>';
        echo '<input type="url" id="tseoportfolio_web_link" name="tseoportfolio_web_link" value="' . esc_url($web_link) . '" style="width:100%;padding: 8px;">';
        echo '<div style="margin-bottom:20px;">' . esc_html_e('Insert the website URL.','tseoportfolio') . '</div>';
    
        echo '<label for="tseoportfolio_pagespeed_mobile_link"><strong>' . esc_html_e('PageSpeed Mobile Link', 'tseoportfolio') . '</strong></label>';
        echo '<input type="url" id="tseoportfolio_pagespeed_mobile_link" name="tseoportfolio_pagespeed_mobile_link" value="' . esc_url($pagespeed_mobile_link) . '" style="width:100%;padding: 8px;">';
        echo '<div style="margin-bottom:20px;">' . esc_html_e('Get the URL from here after analyzing (mobile): ', 'tseoportfolio') . '<a href="' . esc_url('https://pagespeed.web.dev/') . '" target="_blank" rel="noopener noreferrer">https://pagespeed.web.dev/</a>' . '</div>';
    
        echo '<label for="tseoportfolio_pagespeed_desktop_link"><strong>' . esc_html_e('PageSpeed Desktop Link', 'tseoportfolio') . '</strong></label>';
        echo '<input type="url" id="tseoportfolio_pagespeed_desktop_link" name="tseoportfolio_pagespeed_desktop_link" value="' . esc_url($pagespeed_desktop_link) . '" style="width:100%;padding: 8px;">';
        echo '<div style="margin-bottom:20px;">' . esc_html_e('Get the URL from here after analyzing (desktop): ','tseoportfolio') . '<a href="' . esc_url('https://pagespeed.web.dev/') . '" target="_blank" rel="noopener noreferrer">https://pagespeed.web.dev/</a>' . '</div>';

        echo '<label for="tseoportfolio_web_link_pingdom"><strong>' . esc_html_e('Pingdom', 'tseoportfolio') . '</strong></label>';
        echo '<input type="url" id="tseoportfolio_web_link_pingdom" name="tseoportfolio_web_link_pingdom" value="' . esc_url($web_link_pingdom) . '" style="width:100%;padding: 8px;">';
        echo '<div style="margin-bottom:20px;">' . esc_html_e('Get the URL from here after analyzing: ','tseoportfolio') . '<a href="' . esc_url('https://tools.pingdom.com/') . '" target="_blank" rel="noopener noreferrer">https://tools.pingdom.com/</a>' . '</div>';
    
        echo '<label for="tseoportfolio_web_link_gtmetrix"><strong>' . esc_html_e('GTmetrix', 'tseoportfolio') . '</strong></label>';
        echo '<input type="url" id="tseoportfolio_web_link_gtmetrix" name="tseoportfolio_web_link_gtmetrix" value="' . esc_url($web_link_gtmetrix) . '" style="width:100%;padding: 8px;">';
        echo '<div style="margin-bottom:20px;">' . esc_html_e('Get the URL from here after analyzing: ','tseoportfolio') . '<a href="' . esc_url('https://gtmetrix.com/') . '" target="_blank" rel="noopener noreferrer">https://gtmetrix.com/</a>' . '</div>';
    
        echo '<label for="tseoportfolio_web_link_richresults"><strong>' . esc_html_e('Google Rich Results', 'tseoportfolio') . '</strong></label>';
        echo '<input type="url" id="tseoportfolio_web_link_richresults" name="tseoportfolio_web_link_richresults" value="' . esc_url($web_link_richresults) . '" style="width:100%;padding: 8px;">';
        echo '<div style="margin-bottom:20px;">' . esc_html_e('Get the URL from here after analyzing: ','tseoportfolio') . '<a href="' . esc_url('https://search.google.com/test/rich-results') . '" target="_blank" rel="noopener noreferrer">https://search.google.com/test/rich-results/</a>' . '</div>';
    }
    public function tseoportfolio_save_web_links_metabox_data($post_id) {
        if (!isset($_POST['tseoportfolio_web_links_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tseoportfolio_web_links_nonce'])), 'tseoportfolio_save_web_links')) {
            return;
        }

        if ('tseoportfolio' !== get_post_type($post_id)) {
            return;
        }        

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['tseoportfolio_web_link'])) {
            update_post_meta($post_id, '_tseoportfolio_web_link', esc_url_raw($_POST['tseoportfolio_web_link']));
        }
    
        if (isset($_POST['tseoportfolio_pagespeed_mobile_link'])) {
            update_post_meta($post_id, '_tseoportfolio_pagespeed_mobile_link', esc_url_raw($_POST['tseoportfolio_pagespeed_mobile_link']));
        }
    
        if (isset($_POST['tseoportfolio_pagespeed_desktop_link'])) {
            update_post_meta($post_id, '_tseoportfolio_pagespeed_desktop_link', esc_url_raw($_POST['tseoportfolio_pagespeed_desktop_link']));
        }

        if (isset($_POST['tseoportfolio_web_link_pingdom'])) {
            update_post_meta($post_id, '_tseoportfolio_web_link_pingdom', esc_url_raw($_POST['tseoportfolio_web_link_pingdom']));
        }
    
        if (isset($_POST['tseoportfolio_web_link_gtmetrix'])) {
            update_post_meta($post_id, '_tseoportfolio_web_link_gtmetrix', esc_url_raw($_POST['tseoportfolio_web_link_gtmetrix']));
        }
    
        if (isset($_POST['tseoportfolio_web_link_richresults'])) {
            update_post_meta($post_id, '_tseoportfolio_web_link_richresults', esc_url_raw($_POST['tseoportfolio_web_link_richresults']));
        }
    }
    
    /**
     * Shortcode
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function tseoportfolio_display_portfolio_grid($atts) {
        $atts = shortcode_atts(array(
            'count' => -1
        ), $atts, 'tseoportfolio_grid');
    
        $query_args = array(
            'post_type' => 'tseoportfolio',
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            'posts_per_page' => $atts['count'],
            'meta_key' => '_tseoportfolio_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => '_tseoportfolio_display_in_grid',
                    'compare' => 'NOT EXISTS'
                )
            )
        );
    
        $portfolio_query = new WP_Query($query_args);

        $this->portfolio_query = $portfolio_query;
    
        ob_start();
    
        if ($portfolio_query->have_posts()) {

            $tseo_title_gallery = get_option('tseoportfolio_gallery_title');

            echo '<div class="tseo-portfolio-gallery">';

                echo '<div class="tseo-portfolio-grid-title">';
                echo '<h2>' . esc_html($tseo_title_gallery) . '</h2>';
                echo '</div>';            
            
            echo '<div class="tseo-portfolio-grid">';
            while ($portfolio_query->have_posts()) {
                $portfolio_query->the_post();
    
                $web_link = get_post_meta(get_the_ID(), '_tseoportfolio_web_link', true);
                $pagespeed_mobile_link = get_post_meta(get_the_ID(), '_tseoportfolio_pagespeed_mobile_link', true);
                $pagespeed_desktop_link = get_post_meta(get_the_ID(), '_tseoportfolio_pagespeed_desktop_link', true);
                $description = get_post_meta(get_the_ID(), '_tseoportfolio_description', true);
                $web_link_pingdom = get_post_meta(get_the_ID(), '_tseoportfolio_web_link_pingdom', true);
                $web_link_gtmetrix = get_post_meta(get_the_ID(), '_tseoportfolio_web_link_gtmetrix', true);
                $web_link_richresults = get_post_meta(get_the_ID(), '_tseoportfolio_web_link_richresults', true);
    
                echo '<div class="portfolio-card">';
                    echo '<div class="portfolio-card-header">';
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('full');
                        }
                    echo '</div>';
                    echo '<div class="portfolio-card-body">';
                        echo '<h3>' . esc_html(get_the_title()) . '</h3>';
                        echo '<p>' . esc_html($description) . '</p>';
                    echo '</div>';
                    echo '<div class="portfolio-card-footer">';
                        echo '<a href="' . esc_url($web_link) . '" class="btn" target="_blank" rel="noopener noreferrer" title="'.esc_html__('See website','tseoportfolio').'"><span class="tseoportfolio-dribbble"></span> '.esc_html__('Web','tseoportfolio').'</a>';
                        echo '<a href="' . esc_url($pagespeed_mobile_link) . '" class="btn" target="_blank" rel="noopener noreferrer" title="'.esc_html__('Analyze in mobile PageSpeed','tseoportfolio').'"><span class="tseoportfolio-mobile"></span> '.esc_html__('Mobile','tseoportfolio').'</a>';
                        echo '<a href="' . esc_url($pagespeed_desktop_link) . '" class="btn" target="_blank" rel="noopener noreferrer" title="'.esc_html__('Analyze on computer PageSpeed','tseoportfolio').'"><span class="tseoportfolio-display"></span> '.esc_html__('PC','tseoportfolio').'</a>';
                        echo '<a href="' . esc_url($web_link_pingdom) . '" class="btn" target="_blank" rel="noopener noreferrer" title="'.esc_html__('Analyze in Pingdom','tseoportfolio').'"><span class="tseoportfolio-meter"></span> '.esc_html__('Ping','tseoportfolio').'</a>';
                        echo '<a href="' . esc_url($web_link_gtmetrix) . '" class="btn" target="_blank" rel="noopener noreferrer" title="'.esc_html__('Analyze in GTmetrix','tseoportfolio').'"><span class="tseoportfolio-clock"></span> '.esc_html__('GT','tseoportfolio').'</a>';
                        echo '<a href="' . esc_url($web_link_richresults) . '" class="btn" target="_blank" rel="noopener noreferrer" title="'.esc_html__('Google Test Rich Results','tseoportfolio').'"><span class="tseoportfolio-embed2"></span> '.esc_html__('TestRR','tseoportfolio').'</a>';
                    echo '</div>';
                echo '</div>';
            }
            echo '</div>'; // Grid
            echo '</div>'; // Gallery
        } else {
            echo '<p>' . esc_html_e('No websites found.', 'tseoportfolio') . '</p>';
        }

        wp_reset_postdata();
        
        $this->tseoportfolio_pagination();
        return ob_get_clean();   
    }

    /**
     * Pagination
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     * 
     */
    public function tseoportfolio_pagination() {
        $portfolio_query = $this->portfolio_query;
        $big = 999999999;
        echo '<div class="tseoportfolio-pagination">';
        $links = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $portfolio_query->max_num_pages,
            'prev_text' => '<span class="tseoportfolio-backward2">',
            'next_text' => '<span class="tseoportfolio-forward3">',
            'type' => 'array'
        ) );
        if ( is_array( $links ) && count( $links ) > 0 ) {
            foreach ( $links as $link ) {
                echo esc_html( $link );
            }
        }
        echo '</div>';
    }

    /**
     * Rewrite rules
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function tseoportfolio_rewrite_rules() {
        add_rewrite_rule(
            'portfolio/page/([0-9]+)/?$',
            'index.php?pagename=portfolio&paged=$matches[1]',
            'top'
        );
    }    
    
    /**
     * Glue assets
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function tseoportfolio_enqueue_styles_and_scripts() {
        if (is_admin()) {
            return;
        }
        
        wp_enqueue_style('tseoportfolio', plugin_dir_url(dirname(__FILE__)) . 'public/css/tseoportfolio.min.css', array(), TSEOPORTFOLIO_VERSION, 'all');
    }

    /**
     * Metabox info
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function tseoportfolio_add_shortcode_instructions_metabox() {
        add_meta_box(
            'tseoportfolio_shortcode_instructions', 
            __('Shortcode', 'tseoportfolio'), 
            array($this, 'tseoportfolio_render_shortcode_instructions_metabox'), 
            'tseoportfolio', 
            'side', 
            'default'
        );
    }
    public function tseoportfolio_render_shortcode_instructions_metabox() {
        echo '<p>';
        esc_html_e('To display the website gallery on any page or post, simply insert the following shortcode:', 'tseoportfolio');
        echo '</p>';
        echo '<code>[tseoportfolio_grid]</code>';

        echo '<p>';
        esc_html_e('If you want, you can insert the number of posts to display like this:', 'tseoportfolio');
        echo '</p>';
        echo '<code>[tseoportfolio_grid count="10"]</code>';
    }

    /**
     * Order post
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function tseoportfolio_register_order_metabox() {
        add_meta_box(
            'tseoportfolio_order_metabox', 
            __('Order of appearance', 'tseoportfolio'), 
            array($this, 'tseoportfolio_render_order_metabox'), 
            'tseoportfolio', 
            'side', 
            'default'
        );
    }
    public function tseoportfolio_render_order_metabox($post) {
        wp_nonce_field('tseoportfolio_order_nonce', 'tseoportfolio_order_nonce_field');

        $order = get_post_meta($post->ID, '_tseoportfolio_order', true);

        if ('' === $order) {
            $order = 0;
        }
    
        echo '<input type="number" name="tseoportfolio_order" value="' . esc_attr($order) . '" style="width: 100%;" />';
    }
    public function tseoportfolio_save_order_metabox($post_id) {
        if (!isset($_POST['tseoportfolio_order_nonce_field']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tseoportfolio_order_nonce_field'])), 'tseoportfolio_order_nonce')) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if ('tseoportfolio' !== $_POST['post_type'] || !current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        $order = isset($_POST['tseoportfolio_order']) ? intval($_POST['tseoportfolio_order']) : 0;
        update_post_meta($post_id, '_tseoportfolio_order', $order);
    }
    
    /**
     * Checkbox public/no public
     *
     * @package TSEOPortfolio
     * @version 1.0.0
     */
    public function tseoportfolio_add_metabox_checkbox() {
        add_meta_box(
            'tseoportfolio_display_option', 
            __('Display in Gallery', 'tseoportfolio'), 
            array($this, 'tseoportfolio_display_option_callback'), 
            'tseoportfolio', 
            'side', 
            'default'
        );
    }
    public function tseoportfolio_display_option_callback($post) {
        wp_nonce_field('tseoportfolio_display_option', 'tseoportfolio_display_option_nonce');

        $value = get_post_meta($post->ID, '_tseoportfolio_display_in_grid', true);

        echo '<label for="tseoportfolio_display_in_grid">';
        echo '<input type="checkbox" id="tseoportfolio_display_in_grid" name="tseoportfolio_display_in_grid" value="1"' . checked(1, $value, false) . ' />';
        esc_html_e('Do not display in gallery', 'tseoportfolio');
        echo '</label>';
    }
    public function tseoportfolio_save_metabox_data($post_id) {
        if (!isset($_POST['tseoportfolio_display_option_nonce'])) {
            return;
        }

        if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tseoportfolio_display_option_nonce'])), 'tseoportfolio_display_option')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['tseoportfolio_display_in_grid'])) {
            update_post_meta($post_id, '_tseoportfolio_display_in_grid', 1);
        } else {
            delete_post_meta($post_id, '_tseoportfolio_display_in_grid');
        }
    }
    
}

$tseoportfolio_main = new TSEOPortfolio_Main();