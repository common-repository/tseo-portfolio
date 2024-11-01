<?php
/**
 * TSEO Portfolio
 *
 * @package           TSEOPortfolio
 * @author            TSEO PRO team
 * @copyright         2023 TSEO PRO
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       TSEO Portfolio
 * Plugin URI:        https://tseo.pro/portfolio/
 * Description:       TSEO Portfolio allows you to display a gallery of websites that you have developed with WordpPress. Each entry displays an image, title, description and six buttons that link to the website, PageSpeed Mobile, PageSpeed Desktop, Pingdom, GTmetrix and Google Rich Results that allows each visitor to analyze the quality of each website.
 * Version:           1.0.1
 * Requires at least: 5.5
 * Requires PHP:      7.4
 * Author:            TSEO PRO team
 * Author URI:        https://tseo.pro/
 * Text Domain:       tseoportfolio
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*
TSEO Portfolio is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

TSEO Portfolio is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with TSEO Portfolio. If not, see https://tseo.pro/.
*/

defined('ABSPATH') or die('No script kiddies please!');

if ( ! defined( 'TSEOPORTFOLIO_VERSION' ) ) {
	define( 'TSEOPORTFOLIO_VERSION', '1.0.0' );
}

function tseoportfolio_load_textdomain() {
    load_plugin_textdomain('tseoportfolio', false, basename(dirname(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'tseoportfolio_load_textdomain');

if ( is_admin() ) {
    require_once plugin_dir_path(__FILE__) . 'admin/tseoportfolio-settings.php';
}
require_once plugin_dir_path(__FILE__) . 'inc/tseoportfolio-class.php';
require_once plugin_dir_path(__FILE__) . 'public/tseoportfolio-style.php';

$tseoportfolio_main = new TSEOPortfolio_Main();

function tseoportfolio_add_settings_link($links) {
    $settings_link = '<a href="edit.php?post_type=tseoportfolio&page=tseoportfolio-settings">' . esc_html__('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'tseoportfolio_add_settings_link');