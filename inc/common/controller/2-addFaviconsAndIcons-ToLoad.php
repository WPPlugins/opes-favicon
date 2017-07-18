<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _OFWP_jvet__Favicons_And_Icons {

	private function __construct( $params ) {
		if ( is_admin() )
			add_action( 'admin_head', array( $this , 'addFaviconsAndIconsToHead' ) );
		else {
			add_action( 'wp_head', array( $this , 'addFaviconsAndIconsToHead' ) );
		}
	}

	public static function init( $params ) {
		return new _OFWP_jvet__Favicons_And_Icons( $params );
	}

	public function addFaviconsAndIconsToHead() {
		global $_OFWP_jvet__Init_Data_Common;
		
		$rootUrl =  __OFWP_jvet__PS_;
		$rootPath = ABSPATH;
		$randomString = _OFWP_jvet__Main::generateRandomString( 3 );
		$manifest_json_linked = false;
		$browserconfig_xml_linked = false;

		foreach ($_OFWP_jvet__Init_Data_Common->sizesPng_Front as $name => $sizes ) {
			if ( $name == 'favicon' || $name == 'apple-touch-icon' || $name == 'apple-touch-icon-precomposed' || $name == 'android-chrome' || $name == 'mstile' ) {

				foreach ( $sizes as $size => $sizeInfo ) {
					if ( is_numeric( $size ) ) {
						$imageName = $name.'-'.$size.'x'.$size.'.png';
					} else {
						$imageName = $size.'.png';
					};

					//echo "<pre>".$imageName."</pre>";

					$imageUrl = $rootUrl . $imageName.'?v='.$randomString;
					$imageDir = $rootPath . __OFWP_jvet__PS_ . $imageName;

					if ( file_exists( $imageDir ) ) {
						if ( $name == 'android-chrome' /*&& $size == '192'*/ ) {
							if ( !$manifest_json_linked ) {
								$manifest_json_linked = true;
?>
								<link rel="manifest" href="/manifest.json">
<?php
							}
?>
							<link rel="icon" type="image/png" href="<?php echo $imageUrl; ?>" sizes="<?php echo $sizeInfo['width'].'x'.$sizeInfo['height'] ?>">
<?php
						} else if ( $name == 'mstile' /*&& $size == '144'*/ ) {
							if ( !$browserconfig_xml_linked ) {
								$browserconfig_xml_linked = true;
?>
								<!--<link rel="browserconfig" href="/browserconfig.xml">-->
								<meta name="msapplication-config" content="browserconfig.xml" />
								<meta name="msapplication-TileColor" content="#da532c">
<?php
							}
?>
							<meta name="msapplication-TileImage" content="/mstile-<?php echo $sizeInfo['width'].'x'.$sizeInfo['height']; ?>.png">
<?php
						} else if ( $name == 'apple-touch-icon' ) {
?>
							<link rel="apple-touch-icon" sizes="<?php echo $sizeInfo['width'].'x'.$sizeInfo['height'] ?>" href="<?php echo $imageUrl; ?>">
<?php
						} else if ( $name == 'apple-touch-icon-precomposed' ) {
?>
							<link rel="apple-touch-icon-precomposed" sizes="<?php echo $sizeInfo['width'].'x'.$sizeInfo['height'] ?>" href="<?php echo $imageUrl; ?>">
<?php
						} else if ( $name == 'favicon' ) {
							//if ( strpos( $imageUrl , '.png' ) ) {
?>
							<link rel="icon" type="image/png" sizes="<?php echo $sizeInfo['width'].'x'.$sizeInfo['height'] ?>" href="<?php echo /*site_url().*/$imageUrl; ?>">
<?php
							//}
						}
					};
				}
			}
		};
		$imageUrl = site_url( __OFWP_jvet__PS_ ) . 'favicon.ico?v='.$randomString;
		$imageDir = $rootPath . __OFWP_jvet__PS_ . 'favicon.ico';

		if ( 1==1 && file_exists( $imageDir ) ) {

?>	
			<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo $imageUrl; ?>">
<?php

		}
	}
}

_OFWP_jvet__Favicons_And_Icons::init( $params ); 
