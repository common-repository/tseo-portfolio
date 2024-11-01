<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * TSEO PRO Uninstall
 *
 * Uninstalling TseoPortfolio deletes options.
 *
 * @package TSEOPortfolio
 * @version 1.0.0
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

$options_to_delete = array(
    'tseoportfolio_gallery_title',
    'tseoportfolio_gallery_color',
    'tseoportfolio_gallery_title_color',
    'tseoportfolio_card_color',
    'tseoportfolio_card_border_color',
    'tseoportfolio_card_title_color',
    'tseoportfolio_card_desc_color',
    'tseoportfolio_card_footer_bgcolor',
    'tseoportfolio_btn_bgcolor',
    'tseoportfolio_btn_textcolor',
    'tseoportfolio_btn_hover_bgcolor',
    'tseoportfolio_btn_hover_textcolor',
    'tseoportfolio_btn_visited_color'
);

$delete_data_option = get_option('tseoportfolio_delete_data');

if ($delete_data_option == 1) {
    $options_to_delete[] = 'tseoportfolio_delete_data';

    global $wpdb;
    $meta_keys_to_delete = array(
        '_tseoportfolio_description',
        '_tseoportfolio_web_link',
        '_tseoportfolio_pagespeed_mobile_link',
        '_tseoportfolio_pagespeed_desktop_link',
        '_tseoportfolio_order',
        '_tseoportfolio_display_in_grid',
        '_tseoportfolio_web_link_pingdom',
        '_tseoportfolio_web_link_gtmetrix',
        '_tseoportfolio_web_link_richresults'
    );

    foreach ($meta_keys_to_delete as $meta_key) {
        $wpdb->delete($wpdb->postmeta, array('meta_key' => $meta_key));
    }

    $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'tseoportfolio'");
}

foreach ($options_to_delete as $option) {
    delete_option($option);
    delete_site_option($option);
}