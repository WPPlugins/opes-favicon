<?php

/*
add_action( 'plugins_loaded', '_OFWP_jvet__load_textdomain' );
function _OFWP_jvet__load_textdomain() {
	load_plugin_textdomain( __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ , false , __OFWP_jvet__THIS_PLUGIN__INC_DIR_ . 'languages' );
}

define( '__OFWP_jvet__THIS_PLUGIN__AD_IS_VALID_' , __( 'Ad is active' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__OFWP_jvet__THIS_PLUGIN__AD_IS_NOT_VALID_' , __( 'Ad is NOT active' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__OFWP_jvet__THIS_PLUGIN__AD_VALIDATION_ERROR_' , __( 'An error occurred while validating ad' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__OFWP_jvet__THIS_PLUGIN__AD_VALIDATION_TITLE_' , __( 'Ad activity' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );

define( '__OFWP_jvet__THIS_PLUGIN__ADS_ON_POSITION_TITLE_' , __( 'Getting ads for the selected position' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__OFWP_jvet__THIS_PLUGIN__ADS_ON_POSITION_ERROR_' , __( 'An error occurred while getting ads' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );

define( '__OFWP_jvet__THIS_PLUGIN__UPDATE_POSITION_TITLE_' , __( 'Ads position update' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__OFWP_jvet__THIS_PLUGIN__UPDATE_POSITION_OK_' , __( 'The update succeeded' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__OFWP_jvet__THIS_PLUGIN__UPDATE_POSITION_ERROR_' , __( 'The update was NOT successful' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );

define( '__OFWP_jvet__THIS_PLUGIN__ADD_POSITION_TITLE_' , __( 'Adding ad position' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__OFWP_jvet__THIS_PLUGIN__ADD_POSITION_NAME_ERROR_' , __( 'Position name can not be blank and must have at least 6 characters' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) );
*/

class _OFWP_jvet__Conf {

	public static $defaultScriptsAndStyles = array(
		'common' => array(
			'js' => array(
				
			),
			'css' => array(

			)
		),
		'admin' => array(
			'js' => array(
				array( 
					'handle' => 'opes-favicon-admin',
					'src' => 'admin.js',
					'deps' => array(
						'jquery',
						'thickbox',
						'media-upload'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'opes_favicon_options'
					)
				),
/*
				array( 
					'handle' => 'owpmmng_rxpj_admin-single-project',
					'src' => 'script-admin-single-project.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post-new.php',
						'post.php'
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-single-project-update',
					'src' => 'script-admin-single-project-update.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post-new.php',
						'post.php'
					)
				),
*/
/*
				array( 
					'handle' => 'owpmmng_rxpj_admin-datetime-picker',
					'src' => 'jquery.datetimepicker.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post.php',
						'post-new.php'
					)
				),
				array( 
					'handle' => 'owpmmng_rxpj_admin-jquery-multiselect',
					'src' => 'jquery.multiselect.min.js',
					'deps' => array(
						'jquery',
						'jquery-ui-widget',
						'jquery-effects-fade'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post.php',
						'post-new.php'
					)
				),
				array(
					'handle' => 'owpmmng_rxpj_admin-pnotify-custom',
					'src' => 'pnotify.custom.min.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'post-new.php',
						'post.php',
						'owpmmng_rxpj_options',
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-ad-single',
					'src' => 'script-admin-ad-single.js',
					'deps' => array(
						//'jquery',
						'jquery-ui-sortable',
						'owpmmng_rxpj_admin-pnotify-custom'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post-new.php',
						'post.php'
					),
					'localize' => array(
						'rxpj_ads_on_position_title' => __OFWP_jvet__THIS_PLUGIN__ADS_ON_POSITION_TITLE_,
						'rxpj_ads_on_position_error' => __OFWP_jvet__THIS_PLUGIN__ADS_ON_POSITION_ERROR_
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-ads-list',
					'src' => 'script-admin-ads-list.js',
					'deps' => array(
						'jquery',
						'owpmmng_rxpj_admin-pnotify-custom'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
					),
					'localize' => array(
						'rxpj_ad_is_valid' => __OFWP_jvet__THIS_PLUGIN__AD_IS_VALID_,
						'rxpj_ad_is_not_valid' => __OFWP_jvet__THIS_PLUGIN__AD_IS_NOT_VALID_,
						'rxpj_error_ad_validation_error' => __OFWP_jvet__THIS_PLUGIN__AD_VALIDATION_ERROR_,
						'rxpj_error_ad_validation_title' => __OFWP_jvet__THIS_PLUGIN__AD_VALIDATION_TITLE_
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-ads-list',
					'src' => 'script-admin-ads-list.js',
					'deps' => array(
						'jquery',
						'owpmmng_rxpj_admin-pnotify-custom'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
					),
					'localize' => array(
						'rxpj_ad_is_valid' => __OFWP_jvet__THIS_PLUGIN__AD_IS_VALID_,
						'rxpj_ad_is_not_valid' => __OFWP_jvet__THIS_PLUGIN__AD_IS_NOT_VALID_,
						'rxpj_error_ad_validation_error' => __OFWP_jvet__THIS_PLUGIN__AD_VALIDATION_ERROR_,
						'rxpj_error_ad_validation_title' => __OFWP_jvet__THIS_PLUGIN__AD_VALIDATION_TITLE_
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-ads-options',
					'src' => 'script-admin-ads-options.js',
					'deps' => array(
						'jquery',
						'jquery-ui-accordion',
						'jquery-ui-tabs'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'owpmmng_rxpj_options',
					),
					'localize' => array(
						'rxpj_update_position_title' => __OFWP_jvet__THIS_PLUGIN__UPDATE_POSITION_TITLE_,
						'rxpj_update_position_ok' => __OFWP_jvet__THIS_PLUGIN__UPDATE_POSITION_OK_,
						'rxpj_update_position_error' => __OFWP_jvet__THIS_PLUGIN__UPDATE_POSITION_ERROR_,
						'rxpj_add_position_title' => __OFWP_jvet__THIS_PLUGIN__ADD_POSITION_TITLE_,
						'rxpj_add_position_name_error' => __OFWP_jvet__THIS_PLUGIN__ADD_POSITION_NAME_ERROR_
					)
				),
*/
/*
				array( 
					'handle' => 'owpmmng_rxpj_admin-dashboard',
					'src' => 'script-admin-dashboard.js',
					'deps' => array(
						'jquery',
						'jquery-ui-dialog'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php',
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-bootstrap',
					'src' => 'bootstrap.min.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php',
					)
				)
*/
			),
			'css' => array(
				array( 
					'handle' => 'opes-favicon-admin',
					'src' => 'admin.css',
					'deps' => array(
						'thickbox'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'opes_favicon_options'
					)
				)
/*
				array( 
					'handle' => 'owpmmng_rxpj_admin-shop-single',
					'src' => 'style-admin-shop-single.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post-new.php',
						'post.php'
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-datetime-picker',
					'src' => 'jquery.datetimepicker.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post.php',
						'post-new.php'
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-jquery-multiselect',
					'src' => 'jquery.multiselect.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post.php',
						'post-new.php'
					)
				),

				array(
					'handle' => 'owpmmng_rxpj_admin-pnotify-custom',
					'src' => 'pnotify.custom.min.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'post.php',
						'post-new.php',
						'owpmmng_rxpj_options',
					)
				),

				array(
					'handle' => 'owpmmng_rxpj_admin-jquery-ui',
					'src' => 'jquery-ui.min.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'index.php',
						'post.php',
						'post-new.php',
						'owpmmng_rxpj_options',
					)
				),

				array(
					'handle' => 'owpmmng_rxpj_admin-jquery-ui-structure',
					'src' => 'jquery-ui.structure.min.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'index.php',
						'post.php',
						'post-new.php',
						'owpmmng_rxpj_options',
					)
				),

				array(
					'handle' => 'owpmmng_rxpj_admin-jquery-ui-theme',
					'src' => 'jquery-ui.theme.min.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'index.php',
						'post.php',
						'post-new.php',
						'owpmmng_rxpj_options',
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-ads-list',
					'src' => 'style-admin-ads-list.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-ads-options',
					'src' => 'style-admin-ads-options.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'owpmmng_rxpj_options',
					)
				),
*/
/*
				array( 
					'handle' => 'owpmmng_rxpj_admin-dashboard',
					'src' => 'style-admin-dashboard.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php'
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-bootstrap',
					'src' => 'bootstrap.min.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php',
					)
				),

				array( 
					'handle' => 'owpmmng_rxpj_admin-bootstrap-theme',
					'src' => 'bootstrap-theme.min.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php',
					)
				)
*/
			)
		),
		'front' => array(
			'js' => array(
/*
				array( 
					'handle' => 'owpmmng_rxpj_front_mall_plan',
					'src' => 'script-front-mall-plan.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_,
					'localize' => array(
						'rxpj_ajaxurl' => __OFWP_jvet__THIS_PLUGIN__ADMINAJAX_
					)
				)
*/
			),
			'css' => array(
/*
				array( 
					'handle' => 'owpmmng_rxpj_front-style-css',
					'src' => 'style-front.css',
					'deps' => array(
					),
					'ver' => __OFWP_jvet__THIS_PLUGIN__VERSION_
				)
*/
			)
		)
	);

	public static $added_PHP_Common_Files = array(
	);

	public static $added_PHP_Admin_Files = array(
		__OFWP_jvet__THIS_PLUGIN__PHP_ICO_DIR_
	);

	public static $added_PHP_Front_Files = array(
	);

	public static $added_SCRIPT_Common_Files = array(
	);

	public static $added_STYLE_Common_Files = array(
	);

	public static $added_SCRIPT_Admin_Files = array(
	);

	public static $added_STYLE_Admin_Files = array(
	);

	public static $added_SCRIPT_Front_Files = array(
	);

	public static $added_STYLE_Front_Files = array(
	); 

}
