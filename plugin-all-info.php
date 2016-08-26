<?php
/*--------------------------------------------------------------------------------------
 # Plugin Name: Plugin All Info
 # Plugin URI: http://www.wpshopee.com/plugin-all-info/
 # Description: Plugin all info to fetch all plugin information from wordpress.org
 # Author: wpshopee
 # Version: 1.0.2
 # Author URI: http://wpshopee.com/
*-------------------------------------------------------------------------------------*/
/**
 * Plugin All Info
 * Copyright (C) 2016, WPshopee - wpshopee@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 **/

if ( !function_exists( 'add_action' ) ) {
	echo 'Uh huh! Plugin can not do much when called directly.';
	exit;
}

function wps_plugin_all_info_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'plugin' => NULL,
		'para' => NULL
	), $atts );
	
	if( ! $a['plugin'] || ! $a['para'] ) {
		return;
	}
	
	if( ! function_exists( 'plugins_api' ) ) {
		include_once ABSPATH . '/wp-admin/includes/plugin-install.php';
	}
	$plugin_info = plugins_api( 'plugin_information', array(
		'slug' => $a['plugin'],
		'fields' => array( 
			'version' => true,
			'author' => true,
			'author_profile' => true,
			'active_installs' => true, 
			'downloaded' => true,  
			'rating' => true,
			'num_ratings' => true,
			'star_ratings' => true,
			'added' => true,
			'sections' => array('changelog' => true),
			'download_link' => true,
			'donate_link' => true
		)
	) );
	if(!is_wp_error($plugin_info)) {
	switch ($a['para']) {
	case 'version':
			$pai_ver = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_ver=='') {
				return '<span>'.$plugin_info->version.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->version, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_ver.'</span>';
			}
			break;
	case 'author':
			$pai_author = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_author=='') {
				return '<span>'.$plugin_info->author.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->author, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_author.'</span>';
			}
			break;
	case 'author-profile':
			$pai_author_prof = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_author_prof=='') {
				return '<span>'.$plugin_info->author_profile.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->author_profile, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_author_prof.'</span>';
			}
			break;
	case 'active-installs':
			$pai_act_installs = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_act_installs=='') {
				return '<span>'.$plugin_info->active_installs.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->active_installs, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_act_installs.'</span>';
			}	
			break;
    case 'downloaded':
    		$pai_downloaded = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_downloaded=='') {
				return '<span>'.$plugin_info->downloaded.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->downloaded, 24 * HOUR_IN_SECONDS );	
			}
			else {
				return '<span>'.$pai_downloaded.'</span>';
			}
			break;
	case 'rating':
			$pai_rating = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_rating=='') {
				return '<span>'.$plugin_info->rating.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->rating, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_rating.'</span>';
			}
			break;
  	case 'number-ratings':
  			$pai_nrating = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_nrating=='') {
				return '<span>'.$plugin_info->num_ratings.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->num_ratings, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_nrating.'</span>';
			}
			break;

	case 'star-ratings':
				$rating_avg = ($plugin_info->rating/100)*5;
				$sfilled = floor($rating_avg);
				$shalf = $rating_avg - $sfilled;
				$sempty = 5 - $sfilled; 
				$spn_stars = '';
				while ( $sfilled > 0 ) {
					$spn_stars.='<span class="dashicons dashicons-star-filled"></span>';
					$sfilled--;
				}
				if( $shalf != 0) {
					$spn_stars.= '<span class="dashicons dashicons-star-half"></span>';	
					$sempty = $sempty - 1;
				}
				while ( $sempty > 0 ) {
					$spn_stars.= '<span class="dashicons dashicons-star-empty"></span>';
					$sempty--;
				}
				return '<div class="wporg-ratings" title="'.$rating_avg.' out of 5 stars" style="color:#ffb900;display: table-row;">'.$spn_stars.'</div>';
			break;
	case 'added':
			$pai_added = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_added=='') {
				return '<span>'.$plugin_info->added.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->added, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_added.'</span>';
			}
			break;
	case 'changelog':
			$pai_changlog = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_changlog=='') {
				return '<span>'.$plugin_info->sections['changelog'].'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->sections['changelog'], 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_changlog.'</span>';
			}
			break;
	case 'download-link':
			$pai_downldlink = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_downldlink=='') {
				return '<span>'.$plugin_info->download_link.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->download_link, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_downldlink.'</span>';
			}
			break;
	case 'donate_link':
			$pai_donate_link = get_transient('wps-plugin-all-info-' . $a['plugin'] . $a['para']);
			if($pai_donate_link=='') {
				return '<span>'.$plugin_info->donate_link.'</span>';
				set_transient( 'wps-plugin-all-info-' . $a['plugin'] . $a['para'], $plugin_info->donate_link, 24 * HOUR_IN_SECONDS );
			}
			else {
				return '<span>'.$pai_donate_link.'</span>';
			}
			break;
    default:
        return 'Seems like you entered wrong para value in plugin all info shortcode.';
	}
 }
 else {
 	echo "<p> Sorry, unable to connect WordPress API.</p>";
 }
}
add_shortcode( 'plugin-all-info','wps_plugin_all_info_shortcode');
# Register submenu
add_action( 'admin_menu', 'wps_pai_register_submenu' );
function wps_pai_register_submenu() {
	add_options_page('Plugin All Info', 'Plugin All Info', 'manage_options', 'plugin-all-info', 'wps_plugin_all_info_admin_page');
}
function wps_plugin_all_info_admin_page() {
	require_once ( plugin_dir_path( __FILE__ ) . 'settings/admin-page.php');
}
function wps_plugin_all_info_remove_footer_admin_text () { 
	$wps_screen = get_current_screen(); 
	if ( $wps_screen->base == 'settings_page_plugin-all-info' ) {
		echo '<span id="footer-thankyou">Developed by <a href="http://www.wpshopee.com" target="_blank">WPshopee</a>. | Please rate <a href="https://wordpress.org/support/view/plugin-reviews/plugin-all-info?rate=5#postform" target="_blank">Plugin All Info</a> | Need help? <a href="http://www.wpshopee.com/contact-us/" target="_blank">Contact us</a></span>';
	}
	else { echo '<span id="footer-thankyou">Thank you for creating with <a href="https://wordpress.org/">WordPress</a>.</span>'; }
	return;
}
add_filter('admin_footer_text', 'wps_plugin_all_info_remove_footer_admin_text');
?>