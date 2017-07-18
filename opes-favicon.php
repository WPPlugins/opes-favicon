<?php
/**
 * @package Opes Favicon
 */
/*
Plugin Name: Opes Favicon
Plugin URI: https://wordpress.org/plugins/opes-favicon/
Description: This plugin allows you to add and manage a favicon on your WordPress website.
Version: 3.1.6
Author: Paweł Twardziak
Author URI: http://it-opes.com/
License: GPLv2 or later
Text Domain: __OFWP_jvet__
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define( '__OFWP_jvet__THIS_PLUGIN__VERSION_' , '3.1.6' );

global $wp_version;

define( '__OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_' , '__OFWP_jvet__' );

$exit_msg = __( 'Opes Favicon requires WordPress 3.5 or newer' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'. <a href="http://codex.wordpress.org/Upgrading_WordPress">' . __( 'Please update!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) . '</a>';
if ( version_compare( $wp_version, "2.5", "<" ) ) {
	exit($exit_msg);
};

define( '__OFWP_jvet__THIS_PLUGIN__MAIN_FILE_' , __FILE__ );

define( '__OFWP_jvet__DS_' , DIRECTORY_SEPARATOR );
define( '__OFWP_jvet__PS_' , '/' );

define( '__OFWP_jvet__THIS_PLUGIN__ADMINAJAX_' , admin_url( 'admin-ajax.php' ) );
define( '__OFWP_jvet__THIS_PLUGIN__DB_VERSION_' , '1.0.0' );


define( '__OFWP_jvet__THIS_PLUGIN__DIR_' , plugin_dir_path( __FILE__ ) );
define( '__OFWP_jvet__THIS_PLUGIN__INC_DIR_' , __OFWP_jvet__THIS_PLUGIN__DIR_ . 'inc' . __OFWP_jvet__DS_ );
define( '__OFWP_jvet__THIS_PLUGIN__COMMON_DIR_' , __OFWP_jvet__THIS_PLUGIN__INC_DIR_ . 'common' . __OFWP_jvet__DS_ );
define( '__OFWP_jvet__THIS_PLUGIN__ADMIN_DIR_' , __OFWP_jvet__THIS_PLUGIN__INC_DIR_ . 'admin' . __OFWP_jvet__DS_ );
define( '__OFWP_jvet__THIS_PLUGIN__FRONT_DIR_' , __OFWP_jvet__THIS_PLUGIN__INC_DIR_ . 'front' . __OFWP_jvet__DS_ );


define( '__OFWP_jvet__THIS_PLUGIN__URL_' , plugin_dir_url( __FILE__ ) );
define( '__OFWP_jvet__THIS_PLUGIN__INC_URL_' , __OFWP_jvet__THIS_PLUGIN__URL_ . 'inc' . __OFWP_jvet__PS_ );
define( '__OFWP_jvet__THIS_PLUGIN__COMMON_URL_' , __OFWP_jvet__THIS_PLUGIN__INC_URL_ . 'common' . __OFWP_jvet__PS_ );
define( '__OFWP_jvet__THIS_PLUGIN__ADMIN_URL_' , __OFWP_jvet__THIS_PLUGIN__INC_URL_ . 'admin' . __OFWP_jvet__PS_ );
define( '__OFWP_jvet__THIS_PLUGIN__FRONT_URL_' , __OFWP_jvet__THIS_PLUGIN__INC_URL_ . 'front' . __OFWP_jvet__PS_ );


define( '__OFWP_jvet__THIS_PLUGIN__PHP_ICO_DIR_' , __OFWP_jvet__THIS_PLUGIN__INC_DIR_.'php-ico'.__OFWP_jvet__DS_.'class-php-ico.php' );


require_once __OFWP_jvet__THIS_PLUGIN__DIR_ . "conf.php";
require_once __OFWP_jvet__THIS_PLUGIN__INC_DIR_ . "main.class.php";


_OFWP_jvet__Main::init( array() );


