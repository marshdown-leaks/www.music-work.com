<?php
/*
Plugin Name: Preloader Image Size Extension
Plugin URI: https://wp-plugins.in/the-preloader
Description: Change Preloader image size, width and height. Works with Preloader plugin version 1.0.8 or higher.
Version: 1.0.0
Author: Alobaidi
Author URI: https://wp-time.com
License: GPLv2 or later
*/

/*  Copyright 2018 Alobaidi (email: alobaidi@wp-time.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function wpt_preloader_isext_add_new_options() {
    register_setting( 'WPTime_preloader_register_setting', 'wptpreloader_image_width' );
    register_setting( 'WPTime_preloader_register_setting', 'wptpreloader_image_height' );
}
add_action( 'admin_init', 'wpt_preloader_isext_add_new_options' );


function wpt_preloader_remove_ads(){
	if( isset($_GET['page']) == 'WPTime_preloader_settings'){
		?>
			<style type="text/css">
				body.plugins_page_WPTime_preloader_settings .tool-box{
					display: none !important;
				}
			</style>
		<?php
	}
}
add_action('admin_head', 'wpt_preloader_remove_ads');


function wpt_preloader_isext_width_input(){
	?>
		<input class="small-text" name="wptpreloader_image_width" type="text" id="wptpreloader_image_width" value="<?php echo esc_attr( get_option('wptpreloader_image_width') ); ?>">
        <p class="description">Enter preloader image width size, digit only, for example "256" (pixel), default is 64 (pixel).</p>
	<?php
}
add_filter('wpt_thepreloader_image_size_width_input', 'wpt_preloader_isext_width_input');


function wpt_preloader_isext_height_input(){
	?>
		<input class="small-text" name="wptpreloader_image_height" type="text" id="wptpreloader_image_height" value="<?php echo esc_attr( get_option('wptpreloader_image_height') ); ?>">
        <p class="description">Enter preloader image height size, digit only, for example "256" (pixel), default is 64 (pixel).</p>
	<?php
}
add_filter('wpt_thepreloader_image_size_height_input', 'wpt_preloader_isext_height_input');


function wpt_preloader_isext_remove_128px(){
	echo "Enter preloader image link.";
}
add_filter('wpt_thepreloader_image_size_remove_128px', 'wpt_preloader_isext_remove_128px');


function wpt_preloader_isext_get_width(){
	$get_width = get_option('wptpreloader_image_width');

	if( !$get_width ){
		$get_width = 64;
	}

	return str_replace(array(',', ' ', '.', 'px', '%', 'pc', 'em', '"', "'"), '', $get_width);
}
add_filter('wpt_thepreloader_image_size_get_width', 'wpt_preloader_isext_get_width');


function wpt_preloader_isext_get_height(){
	$get_height = get_option('wptpreloader_image_height');

	if( !$get_height ){
		$get_height = 64;
	}

	return str_replace(array(',', ' ', '.', 'px', '%', 'pc', 'em', '"', "'"), '', $get_height);
}
add_filter('wpt_thepreloader_image_size_get_height', 'wpt_preloader_isext_get_height');