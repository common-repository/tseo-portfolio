<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * TSEO PRO print style
 *
 * @package TSEOPortfolio
 * @version 1.0.0
 */
if ( ! function_exists( 'tseoportfolio_frontend_styles' ) ) {
    function tseoportfolio_frontend_styles() {
        $gallery_color = get_option('tseoportfolio_gallery_color', '#f8f9fa');
        $gallery_title_color = get_option('tseoportfolio_gallery_title_color', '#4c6363');
        $card_color = get_option('tseoportfolio_card_color', '#ffffff');
        $card_color_border = get_option('tseoportfolio_card_border_color', '#e9ecef');
        $title_color = get_option('tseoportfolio_card_title_color', '#000000');
        $desc_color = get_option('tseoportfolio_card_desc_color', '#666666');
        $footer_bgcolor = get_option('tseoportfolio_card_footer_bgcolor', '#dee2e6');
        
        $custom_css = "
        .tseo-portfolio-gallery { background: " . esc_attr($gallery_color) . "; } 
        .tseo-portfolio-grid-title h2 { color: " . esc_attr($gallery_title_color) . "; } 
        .portfolio-card { background: " . esc_attr($card_color) . "; border: 1px solid " . esc_attr($card_color_border) . "; }
        .portfolio-card-body h3 { color: " . esc_attr($title_color) . "; }
        .portfolio-card-body p { color: " . esc_attr($desc_color) . "; }
        .portfolio-card-footer { background-color: " . esc_attr($footer_bgcolor) . "; }
        .portfolio-card-header { border-bottom: 8px solid " . esc_attr($footer_bgcolor) . "; }";

        $btn_bgcolor = get_option('tseoportfolio_btn_bgcolor', '#f5f5f5');
        $btn_textcolor = get_option('tseoportfolio_btn_textcolor', '#333333');
        $btn_hover_bgcolor = get_option('tseoportfolio_btn_hover_bgcolor', '#e5e5e5');
        $btn_hover_textcolor = get_option('tseoportfolio_btn_hover_textcolor', '#ffffff');
        $btn_visited_color = get_option('tseoportfolio_btn_visited_color', '#ff0000');

        $custom_css .= ".portfolio-card-footer a.btn {background: " . esc_attr($btn_bgcolor) . ";color: " . esc_attr($btn_textcolor) . ";}.portfolio-card-footer a.btn:hover {background: " . esc_attr($btn_hover_bgcolor) . ";color: " . esc_attr($btn_hover_textcolor) . ";}.portfolio-card-footer a.btn:visited {color: " . esc_attr($btn_visited_color) . ";}";
        
        wp_add_inline_style('tseoportfolio', $custom_css);
    }
    add_action('wp_enqueue_scripts', 'tseoportfolio_frontend_styles', 20);
}