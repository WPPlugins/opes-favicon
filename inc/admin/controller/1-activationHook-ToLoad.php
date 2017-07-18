<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _OFWP_jvet__Activation_Hook {

	private function __construct( $params ) {
		register_activation_hook( __OFWP_jvet__THIS_PLUGIN__MAIN_FILE_, array( $this , 'activationActions' ) );
		register_deactivation_hook( __OFWP_jvet__THIS_PLUGIN__MAIN_FILE_, array( $this , 'deactivationActions' ) );
	}

	public static function init( $params ) {
		return new _OFWP_jvet__Activation_Hook( $params );
	}

	public function deactivationActions() {
		global $_OFWP_jvet__Init_Data_Common;
		
		delete_option( 'opes_favicon_version' );
		delete_option( 'opes_favicon_last_generation' );

		$rootPath = ABSPATH;
		$fileName = "favicon.ico";
		@unlink( $rootPath.$fileName );

		$fileName = "manifest.json";
		@unlink( $rootPath.$fileName );

		$fileName = "browserconfig.xml";
		@unlink( $rootPath.$fileName );


		foreach ($_OFWP_jvet__Init_Data_Common->sizesPng as $name => $sizes ) {
			if ( $name == 'favicon' || $name == 'apple-touch-icon' || $name == 'apple-touch-icon-precomposed' || $name == 'android-chrome' || $name == 'mstile' ) {
				foreach ( $sizes as $size => $sizeInfo ) {
					if ( is_numeric( $size ) ) {
						$fileName = $name.'-'.$size.'x'.$size.'.png';
					} else {
						$fileName = $size.'.png';
					};
					@unlink( $rootPath.$fileName );
				}
			}
		};
	}

	public function activationActions() {
		global $_OFWP_jvet__Init_Data_Common;

		$_OFWP_jvet__Init_Data_Common->updatePluginInfoInDB();
	}
}

_OFWP_jvet__Activation_Hook::init( array() ); 
