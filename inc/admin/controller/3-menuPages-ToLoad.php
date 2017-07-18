<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _OFWP_jvet__Menu_Pages {

	const _MENU_ID_ = 'opes_favicon_options';

	private $options;

	function getMenuId() {
		return self::_MENU_ID_;
	}

	private function getOptionName( $beginParam = false , $endParam = false ) {
		$return = 'theme_'.$this->getMenuId();
		
		if ( is_string( $beginParam ) ) {
			$return = $beginParam.$return;
		}
		if ( is_string( $endParam ) ) {
			$return .= $endParam;
		}
		return $return;
	}

	private function __construct( $params ) {
		add_action( 'admin_init', array( $this , 'optionsInit' ) );
		add_action( 'admin_menu', array( $this , 'addThemeAdminMenuItems' ) );

		add_action( 'admin_notices', array( $this , 'adminNotices' ) );
	}

		function adminNotices() {

			$opes_favicon_last_generation_timestamp = get_option( 'opes_favicon_last_generation' , false );
			$opes_favicon_version = get_option( 'opes_favicon_version' , false );

			$opes_favicon_last_generation_is_actual = true;

			if ( is_numeric( $opes_favicon_last_generation_timestamp ) && is_array( $opes_favicon_version ) ) {
				$curr_version = (int)( preg_replace( '/[^0-9]/' , '' , __OFWP_jvet__THIS_PLUGIN__VERSION_ ) );

				if ( $curr_version > $opes_favicon_version[ 'version' ] ) {
					$opes_favicon_last_generation_is_actual = false;
				} else if ( $opes_favicon_last_generation_timestamp < $opes_favicon_version[ 'install_timestamp' ] ) {
					$opes_favicon_last_generation_is_actual = false;
				}
			} else {
				$opes_favicon_last_generation_is_actual = false;
			}

			if ( !$opes_favicon_last_generation_is_actual ) {
?>
		<div class="error">
			<p><?php echo __( 'Your plugin has been updated. Please, re-generate favicons in' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) . ' <strong><code><a href="'.admin_url('themes.php?page=opes_favicon_options').'">'.__( 'Opes Favicon' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</a></code></strong> ' . __( 'in order to have all supported favicons & icons!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></p>
		</div>
<?php
			};
		}

	public static function init( $params ) {
		return new _OFWP_jvet__Menu_Pages( $params );
	}

	public function optionsInit() {
		register_setting( $this->getOptionName() , $this->getOptionName() , array( $this , 'optionsValidate' ) );

		add_settings_section( $this->getOptionName( false , '_settings_header' ) , __( 'Favicon Options', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) , array( $this , 'faviconSettingsHeader' ) , $this->getOptionName() );

		add_settings_field( $this->getOptionName( false , '_image_to_generate' ) ,  __( 'Select image to generate favicons & icons', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) , array( $this , 'showGenerateFaviconsAndIconsFields' ) , $this->getOptionName() , $this->getOptionName( false , '_settings_header' ) );

		add_settings_field( $this->getOptionName( false , '_generated_images' ) ,  __( 'Generated favicons & icons', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) , array( $this , 'showGeneratedFaviconsAndIcons' ) , $this->getOptionName() , $this->getOptionName( false , '_settings_header' ) );
	}

	public function showGenerateFaviconsAndIconsFields() {
?>
		<input type="text" id="to-generate-media-input" class="media-input" value="" name="<?php echo $this->getOptionName( false , '[favicon_url]'); ?>" /><button id="to-generate-media-button" class="media-button button button-secondary"><?php _e( 'Select image' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></button><br>
<?php
	}

	public function showGeneratedFaviconsAndIcons() {
		global $_OFWP_jvet__Init_Data_Common;
		
		$rootUrl = site_url( __OFWP_jvet__PS_ );
		$rootPath = ABSPATH;
		$randomString = _OFWP_jvet__Main::generateRandomString();
?>
		<table>
			<tbody>
				<tr>
					<th colspan="2" style="text-align: center; text-transform: uppercase;">Favicon</th>
				</tr>
				<tr>
						<td>Favicon.ico</td>
<?php
							$imageUrl = $rootUrl . 'favicon.ico?v='.$randomString;
							$imageDir = $rootPath . __OFWP_jvet__PS_ . 'favicon.ico';

							if ( !file_exists( $imageDir ) ) {
?>
								<td style="color: red; font-style: italic;"><?php _e( 'File not generated', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></td>
<?php
							} else {
?>
								<td><img src="<?php echo $imageUrl; ?>"></td>
<?php
							};
?>
				</tr>
<?php		
		foreach ($_OFWP_jvet__Init_Data_Common->sizesPng as $name => $sizes ) {
?>
				<tr>
					<th colspan="2" style="text-align: center; text-transform: uppercase;"><?php if ( $name == 'favicon' ) { echo $name.' icons'; } else { echo $name; } ?></th>
				</tr>	
<?php
			if ( $name == 'favicon' || $name == 'apple-touch-icon' || $name == 'apple-touch-icon-precomposed' || $name == 'android-chrome' || $name == 'mstile' ) {

				foreach ( $sizes as $size => $sizeInfo ) {

						if ( is_numeric( $size ) ) {
							$imageName = $name.'-'.$size.'x'.$size.'.png';
						} else {
							$imageName = $size.'.png';
						}
?>
					<tr>
						<td><?php echo $imageName; ?></td>
<?php
						$imageUrl = $rootUrl . $imageName.'?v='.$randomString;
						$imageDir = $rootPath . __OFWP_jvet__PS_ . $imageName;

						if ( !file_exists( $imageDir ) ) {
?>
							<td style="color: red; font-style: italic;"><?php _e( 'File not generated', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></td>
<?php
						} else {
?>
							<td><img src="<?php echo $imageUrl; ?>"></td>
<?php
						};
?>
					</tr>
<?php
				}
			}
?>
			
<?php
		}
?>
			</tbody>
		</table>
<?php
	}

	public function optionsValidate( $input ) {
		global $_OFWP_jvet__Init_Data_Common;

		$_OFWP_jvet__Init_Data_Common->updatePluginInfoInDB();

		$valid_input = '';

		$submit = ! empty($input['submit']) ? true : false;
		$reset = ! empty($input['reset']) ? true : false;

		if ( $submit ) {
			$imageUrl = trim( $input['favicon_url'] );
			$imageInfo = array();
			@list($image_width, $image_height, $image_type, $image_attr) = /* $imageSize = */ getimagesize( $imageUrl , $imageInfo );

			if ( isset( /*$imageSize[ 'mime' ]*/ $image_type ) ) {
				switch ( $image_type/*$imageSize[ 'mime' ]*/ ) {
					case 3/*'image/png'*/:
						$rootPath = ABSPATH;
						$image = wp_get_image_editor( $imageUrl , array( 'mime_type' => image_type_to_mime_type( $image_type )/*$imageSize[ 'mime' ]*/ ) );
						if ( ! is_wp_error( $image ) ) {
							add_settings_error(
								$this->getOptionName( '_errors' ),
								esc_attr( 'settings_updated' ),
								'<strong style="text-transform: uppercase; font-size: 22px; color: green;">' . __( 'Generating favicons and icons has been made. The report is given below.', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ) . '</strong>',
								'updated'
							);
							
							$destination = $rootPath."favicon.ico";
							if ( !file_exists ( $destination ) ) {
								$handle = fopen( $destination , "w" );
								fwrite( $handle , '' );
								fclose( $handle );
							};

							$sizesIco_Arr = array();
							foreach ( $_OFWP_jvet__Init_Data_Common->sizesIco as $key => $value ) {
								array_push( $sizesIco_Arr, $value );
							};

							$ico_lib = new PHP_ICO( $imageUrl, $sizesIco_Arr );

							$ico_lib->save_ico( $destination );
							chmod( $destination , 0644 );

							add_settings_error(
								$this->getOptionName( '_errors' ),
								esc_attr( 'settings_updated' ),
								'<span style="font-weight: normal; color: green;">'.__( 'File favicon.ico is generated & saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
								'updated'
							);

							$adroid_chrome_manifest_json_icons = '';
							$mstile_browserconfig_xml_icons = '';

							foreach ($_OFWP_jvet__Init_Data_Common->sizesPng as $name => $sizes ) {
								if ( $name == 'favicon' || $name == 'apple-touch-icon' || $name == 'apple-touch-icon-precomposed' || $name == 'android-chrome' || $name == 'mstile' ) {
									foreach ( $sizes as $size => $sizeInfo ) {
										$image = wp_get_image_editor( $imageUrl , array( 'mime_type' => image_type_to_mime_type( $image_type )/*$imageSize[ 'mime' ]*/ ) );
										if ( is_numeric( $size ) ) {
											$fileName = $name.'-'.$size.'x'.$size.'.png';
										} else {
											$fileName = $size.'.png';
										};

										@unlink( $rootPath.$fileName );

										if ( $image->resize( $sizeInfo[ 'width' ] , $sizeInfo[ 'height' ] , true ) === true ) {
											if ( is_numeric( $size ) ) {
												$imageNew = $image->save( $rootPath.$fileName );
												chmod( $rootPath.$fileName , 0644 );

												if ( isset( $imageNew[ 'path' ] ) && !empty( $imageNew[ 'path' ] ) ) {

													if ( $name == 'android-chrome' && isset( $_OFWP_jvet__Init_Data_Common->adroid_chrome_densities[ $size ] ) ) {

														if ( !strlen( $adroid_chrome_manifest_json_icons ) ) {
															$adroid_chrome_manifest_json_icons = 
		'
		{
			"src": "\/android-chrome-'.$size.'x'.$size.'.png",
			"sizes": "'.$size.'x'.$size.'",
			"type": "image\/png",
			"density": "'.$_OFWP_jvet__Init_Data_Common->adroid_chrome_densities[ $size ].'"
		}';
														} else {
															$adroid_chrome_manifest_json_icons .= ',
		{
			"src": "\/android-chrome-'.$size.'x'.$size.'.png",
			"sizes": "'.$size.'x'.$size.'",
			"type": "image\/png",
			"density": "'.$_OFWP_jvet__Init_Data_Common->adroid_chrome_densities[ $size ].'"
		}';
														}
													} else if ( $name == 'mstile' ) {

														if ( !strlen( $mstile_browserconfig_xml_icons ) ) {
															$mstile_browserconfig_xml_icons = '			
			<square'.$size.'x'.$size.'logo src="/mstile-'.$size.'x'.$size.'.png" />';
														} else {
															$mstile_browserconfig_xml_icons .= '
			<square'.$size.'x'.$size.'logo src="/mstile-'.$size.'x'.$size.'.png" />';
														};
													};

													add_settings_error(
														$this->getOptionName( '_errors' ),
														esc_attr( 'settings_updated' ),
														'<span style="font-weight: normal; color: green;">'.__( 'File '.$fileName. ' is generated & saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
														//print_r($imageNew,true),
														'updated'
													);
												} else {
													add_settings_error(
														$this->getOptionName( '_errors' ),
														esc_attr( 'settings_updated' ),
														'<span style="color: red;">'.__( 'File '.$fileName. ' is generated but not saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
														//print_r($imageNew,true),
														'error'
													);
												}
											} else /* $size is not numeric */ {
												$imageNew = $image->save( $rootPath.$fileName );
												chmod( $rootPath.$fileName , 0644 );

												if ( isset( $imageNew[ 'path' ] ) && !empty( $imageNew[ 'path' ] ) ) {
													//chmod( $imageNew[ 'path' ] , 0644 );

													if ( $name == 'mstile' ) {

														if ( !strlen( $mstile_browserconfig_xml_icons ) ) {
															$mstile_browserconfig_xml_icons = 
'			<wide'.$sizeInfo['width'].'x'.$sizeInfo['height'].'logo src="/mstile-'.$sizeInfo['width'].'x'.$sizeInfo['height'].'.png" />';
														} else {
															$mstile_browserconfig_xml_icons .= '
			<wide'.$sizeInfo['width'].'x'.$sizeInfo['height'].'logo src="/mstile-'.$sizeInfo['width'].'x'.$sizeInfo['height'].'.png" />';
														};

													};

													add_settings_error(
														$this->getOptionName( '_errors' ),
														esc_attr( 'settings_updated' ),
														'<span style="font-weight: normal; color: green;">'.__( 'File '.$fileName. ' is generated & saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
														//print_r($imageNew,true),
														'updated'
													);
												} else {
													add_settings_error(
														$this->getOptionName( '_errors' ),
														esc_attr( 'settings_updated' ),
														'<span style="color: red;">'.__( 'File '.$fileName. ' is generated but not saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
														//print_r($imageNew,true),
														'error'
													);
												}
											}
										} else {
											if ( is_numeric( $size ) ) {
												$fileName = $name.'-'.$size.'x'.$size.'.png';
											} else {
												$fileName = $size.'.png';
											}
											add_settings_error(
												$this->getOptionName( '_errors' ),
												esc_attr( 'settings_updated' ),
												'<span style="color: red;">'.__( 'File '.$fileName. ' can not be generated! Check the size of the source image - must not be less than the generated size.' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
												//print_r($imageNew,true),
												'error'
											);
										}
									}
								}
							};

							$fileName = "manifest.json";
							@unlink( $rootPath.$fileName );
							if ( strlen( $adroid_chrome_manifest_json_icons ) ) {
								$adroid_chrome_manifest_json =
'{
	"name": "'.get_bloginfo( 'name' ).'",
	"icons": ['
.$adroid_chrome_manifest_json_icons.'
	]
}';
								sleep(0.5);
								if ( file_put_contents( $rootPath.$fileName , $adroid_chrome_manifest_json ) !== false ) {
									add_settings_error(
										$this->getOptionName( '_errors' ),
										esc_attr( 'settings_updated' ),
										'<span style="font-weight: normal; color: green;">'.__( 'File '.$fileName. ' is generated & saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
										//print_r($imageNew,true),
										'updated'
									);
									chmod( $rootPath.$fileName , 0644 );
								} else {
									add_settings_error(
										$this->getOptionName( '_errors' ),
										esc_attr( 'settings_updated' ),
										'<span style="font-weight: normal; color: green;">'.__( 'File '.$fileName. ' is generated but not saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
										//print_r($imageNew,true),
										'error'
									);
								};
							};

							$fileName = "browserconfig.xml";
							@unlink( $rootPath.$fileName );
							if ( strlen( $mstile_browserconfig_xml_icons ) ) {
								$mstile_browserconfig_xml = 
'<?xml version="1.0" encoding="utf-8"?>
<browserconfig>
	<msapplication>
		<tile>'.
$mstile_browserconfig_xml_icons.'
			<TileColor>#da532c</TileColor>
		</tile>
	</msapplication>
</browserconfig>';
								sleep(0.5);
								if ( file_put_contents( $rootPath.$fileName , $mstile_browserconfig_xml ) !== false ) {
									add_settings_error(
										$this->getOptionName( '_errors' ),
										esc_attr( 'settings_updated' ),
										'<span style="font-weight: normal; color: green;">'.__( 'File '.$fileName. ' is generated & saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
										//print_r($imageNew,true),
										'updated'
									);	
									chmod( $rootPath.$fileName , 0644 );
								} else {
									add_settings_error(
										$this->getOptionName( '_errors' ),
										esc_attr( 'settings_updated' ),
										'<span style="font-weight: normal; color: green;">'.__( 'File '.$fileName. ' is generated but not saved!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
										//print_r($imageNew,true),
										'error'
									);
								};
							};

							//echo "<pre>".htmlentities( $mstile_browserconfig_xml )."</pre>";
							//wp_die();
							update_option( 'opes_favicon_last_generation' , current_time( 'timestamp' ) );

						} else {
							add_settings_error(
								$this->getOptionName( '_errors' ),
								esc_attr( 'settings_updated' ),
								'<span style="color: red;">'.__( 'An unknown error has occurred.' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
								'error'
							);
						}
						break;
					default:
						add_settings_error(
							$this->getOptionName( '_errors' ),
							esc_attr( 'settings_not_updated' ),
							'<span style="color: red;">'.__( 'An error has occurred. The only supported format is PNG. Other formats will be supported soon.', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
							'error'
						);
						break;
				}
			} else {
				add_settings_error(
					$this->getOptionName( '_errors' ),
					esc_attr( 'settings_not_updated' ),
					'<span style="color: red;">'.__( 'An error has occurred. Make sure the path leads to an existing image.', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
					'error'
				);
			}
		} else if ( $reset ) {
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

			add_settings_error(
				$this->getOptionName( '_errors' ),
				esc_attr( 'settings_reset' ),
				'<span style="font-weight: normal; color: green;">'.__( 'Favicons & icons have been deleted successfully!', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span>',
				'updated'
			);
		};

		return false;		
	}

	function faviconSettingsHeader( $section ) {
?>
		<p><?php _e( 'Manage Favicon Options', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></p>
<?php
	}

	public function addThemeAdminMenuItems() {
		add_theme_page( 'Opes Favicon', 'Opes Favicon', 'edit_theme_options', $this->getMenuId() , array( $this , 'adminMenuOptionsContent' ) );
	}

	public function adminMenuOptionsContent() {
?>

		<div class="wrap opes-favicon-icon-admin-block">
			<h2>
<?php 
				_e( 'Opes Favicon', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ); 
?>
			</h2>
<?php
			settings_errors( $this->getOptionName( '_errors' ) );

?>
			<div class="announcement"><p><?php _e( 'Enable/disable function will be supported soon!' , __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></p></div>
<?php

?>

			<form id="form_<?php echo $this->getMenuId(); ?>" action="options.php" method="post" enctype="multipart/form-data">

<?php
				settings_fields( $this->getOptionName() );
?>
				<p class="submit">
<?php
					submit_button( esc_attr__('Generate favicons & icons', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_) , 'primary' , $this->getOptionName( false , '[submit]' ) , false );
					echo ' &nbsp &nbsp ';
					submit_button( esc_attr__('Delete all favicons & icons', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_) , 'secondary' , $this->getOptionName( false , '[reset]' ) , false );
?>
				</p>
<?php
				do_settings_sections( $this->getOptionName() );
?>
				<p class="submit">
<?php
					submit_button( esc_attr__('Generate favicons & icons', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_) , 'primary' , $this->getOptionName( false , '[submit]' ) , false );
					echo ' &nbsp &nbsp ';
					submit_button( esc_attr__('Delete all favicons & icons', __OFWP_jvet__THIS_PLUGIN__TEXT_DOMAIN_) , 'secondary' , $this->getOptionName( false , '[reset]' ) , false );
?>
				</p>

			</form>

		</div>
<?php		
	}
}

_OFWP_jvet__Menu_Pages::init( $params );

