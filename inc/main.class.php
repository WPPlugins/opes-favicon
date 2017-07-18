<?php

require_once __OFWP_jvet__THIS_PLUGIN__DIR_ . "inc/common/common.class.php";

class _OFWP_jvet__Main {

	private $adminClassFile = 'admin.class.php';
	private $frontClassFile = 'front.class.php';

	//private $instance = false;
	private $commonInstance = false;
	private $adminInstance = false;
	private $frontInstance = false;

	private $defIfScreenPropCondOperator = 'OR';
	
	private $defIfCondType = 'CONTAIN';
	private $defIfCondOperator = 'OR';

	public function generateContainStringIfCond( $contain ) {
		if ( is_array( $contain ) ) {
			$func = $contain[ 'function' ];
			$where = $contain[ 'where' ];
			$what =  $contain[ 'what' ];
			return "$func( $where , $what )";
		} else {
			return '1 == 1';
		}
	}

	private function __construct( $params ) {
		if ( !is_a( $this->commonInstance , '_OFWP_jvet__Common' ) ) {
			$this->commonInstance = _OFWP_jvet__Common::init( array() );
		};

		if ( is_admin() ) {
			require_once __OFWP_jvet__THIS_PLUGIN__ADMIN_DIR_ . $this->adminClassFile;
			
			add_action( 'admin_enqueue_scripts', array( $this , 'addDafeultCommonScriptsAndStyles' ) );
			add_action( 'admin_enqueue_scripts', array( $this , 'addDafeultAdminScriptsAndStyles' ) );

			if ( !is_a( $this->adminInstance , '_OFWP_jvet__Admin' ) ) {
				$this->adminInstance = _OFWP_jvet__Admin::init( array() );
			};
		} else {
			require_once __OFWP_jvet__THIS_PLUGIN__FRONT_DIR_ . $this->frontClassFile;

			add_action( 'wp_enqueue_scripts', array( $this , 'addDafeultCommonScriptsAndStyles' ) );
			add_action( 'wp_enqueue_scripts', array( $this , 'addDafeultFrontScriptsAndStyles' ) );

			if ( !is_a( $this->frontInstance , '_OFWP_jvet__Front' ) ) {
				$this->frontInstance = _OFWP_jvet__Front::init( array() );
			};
		}
	}

	public static function init( $params ) {
		return new _OFWP_jvet__Main( $params );
	}

	private static function registerScript( $paramsIn ) {
		$default = array( 
			'handle' => '' ,
			'src' => '' , 
			'deps' => array() , 
			'ver' => false , 
			'in_footer' => false 
		);

		extract( shortcode_atts( $default , $paramsIn ) );

		wp_register_script( $handle, $src, $deps, $ver, $in_footer );

		return wp_script_is( $handle , 'registered' );
	}

	private static function registerStyle( $paramsIn ) {
		$default = array( 
			'handle' => '' ,
			'src' => '' , 
			'deps' => array() , 
			'ver' => false , 
			'media' => 'all' 
		);

		extract( shortcode_atts( $default , $paramsIn ) );

		wp_register_style( $handle, $src, $deps, $ver, $media );

		return wp_style_is( $handle , 'registered' );
	}

	private static function enqueueScript( $handle ) {
		wp_enqueue_script( $handle );

		return wp_script_is( $handle , 'enqueued' );
	}

	private static function enqueueStyle( $handle ) {
		wp_enqueue_style( $handle );

		return wp_style_is( $handle , 'enqueued' );
	}

	public static function addScript( $paramsIn ) {
		if ( is_array( $paramsIn ) && isset( $paramsIn[ 'handle' ] ) && isset( $paramsIn[ 'src' ] ) && !empty( $paramsIn[ 'handle' ] ) && !empty( $paramsIn[ 'src' ] ) ) {
			if ( _OFWP_jvet__Main::registerScript( $paramsIn ) && _OFWP_jvet__Main::enqueueScript( $paramsIn[ 'handle' ] ) ) {

				if ( isset( $paramsIn[ 'localize' ] ) && is_array( $paramsIn[ 'localize' ] ) ) {
					foreach ( $paramsIn[ 'localize' ] as $name => $value ) {
						wp_localize_script( $paramsIn[ 'handle' ] , $name , $value );
					}
				}

				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function addStyle( $paramsIn ) {
		if ( is_array( $paramsIn ) && isset( $paramsIn[ 'handle' ] ) && isset( $paramsIn[ 'src' ] ) && !empty( $paramsIn[ 'handle' ] ) && !empty( $paramsIn[ 'src' ] ) ) {
			return ( _OFWP_jvet__Main::registerStyle( $paramsIn ) && _OFWP_jvet__Main::enqueueStyle( $paramsIn[ 'handle' ] ) );
		} else {
			return false;
		}
	}

	public function addDafeultCommonScriptsAndStyles( $hook ) {
		//global _OFWP_jvet__Conf::$defaultScriptsAndStyles;
		$space = 'common';

		if ( is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles ) && isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ] ) ) {
			if ( is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ] ) ) {
				if ( isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] ) && is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] ) ) {
					$type = 'js' . __OFWP_jvet__PS_;
					
					foreach ( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] as $script ) {
						$script[ 'src' ] = __OFWP_jvet__THIS_PLUGIN__COMMON_URL_ . 'assets' . __OFWP_jvet__PS_ . $type . $script[ 'src' ];
						if ( isset( $script[ 'hook_deps' ] ) ) {
							if ( is_string( $script[ 'hook_deps' ] ) ) {
								if ( strpos( $hook , trim( $script[ 'hook_deps' ] ) ) ) {
									$this->addScript( $script );
								}
							} else if ( is_array( $script[ 'hook_deps' ] ) ) {
								foreach ( $script[ 'hook_deps' ] as $value ) {
									if ( strpos( $hook , trim( $value ) ) !== false ) {
										$this->addScript( $script );
										break;
									}
								}
							}
						} else {
							$this->addScript( $script );
						}
					}
				}
				if ( isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] ) && is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] ) ) {
					$type = 'css' . __OFWP_jvet__PS_;

					foreach ( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] as $style ) {
						$style[ 'src' ] = __OFWP_jvet__THIS_PLUGIN__COMMON_URL_ . 'assets' . __OFWP_jvet__PS_ . $type . $style[ 'src' ];
						if ( isset( $style[ 'hook_deps' ] ) ) {
							if ( is_string( $style[ 'hook_deps' ] ) ) {
								if ( strpos( $hook , trim( $style[ 'hook_deps' ] ) ) ) {
									$this->addStyle( $style );
								}
							} else if ( is_array( $style[ 'hook_deps' ] ) ) {
								foreach ( $style[ 'hook_deps' ] as $value ) {
									if ( strpos( $hook , trim( $value ) ) !== false ) {
										$this->addStyle( $style );
										break;
									}
								}
							}
						} else {
							$this->addStyle( $style );
						}
					}
				}
			}
		}
	}

	public function addDafeultAdminScriptsAndStyles( $hook ) {
		//global _OFWP_jvet__Conf::$defaultScriptsAndStyles;
		$space = 'admin';

		if ( is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles ) && isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ] ) ) {
			if ( is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ] ) ) {
				if ( isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] ) && is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] ) ) {
					$type = 'js' . __OFWP_jvet__PS_;

					foreach ( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] as $script ) {
						$script[ 'src' ] = __OFWP_jvet__THIS_PLUGIN__ADMIN_URL_ . 'assets' . __OFWP_jvet__PS_ . $type . $script[ 'src' ];
						if ( isset( $script[ 'hook_deps' ] ) ) {
							if ( is_string( $script[ 'hook_deps' ] ) ) {
								if ( strpos( $hook , trim( $script[ 'hook_deps' ] ) ) ) {
									$this->addScript( $script );
								}
							} else if ( is_array( $script[ 'hook_deps' ] ) ) {
								foreach ( $script[ 'hook_deps' ] as $value ) {
									if ( strpos( $hook , trim( $value ) ) !== false ) {
										$this->addScript( $script );
										break;
									}
								}
							}
						} else {
							$this->addScript( $script );
						}
					}
				}
				if ( isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] ) && is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] ) ) {
					$type = 'css' . __OFWP_jvet__PS_;
					foreach ( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] as $style ) {
						$style[ 'src' ] = __OFWP_jvet__THIS_PLUGIN__ADMIN_URL_ . 'assets' . __OFWP_jvet__PS_ . $type . $style[ 'src' ];
						if ( isset( $style[ 'hook_deps' ] ) ) {
							if ( is_string( $style[ 'hook_deps' ] ) ) {
								if ( strpos( $hook , trim( $style[ 'hook_deps' ] ) ) ) {
									$this->addStyle( $style );
								}
							} else if ( is_array( $style[ 'hook_deps' ] ) ) {
								foreach ( $style[ 'hook_deps' ] as $value ) {
									if ( strpos( $hook , trim( $value ) ) !== false ) {
										$this->addStyle( $style );
										break;
									}
								}
							}
						} else {
							$this->addStyle( $style );
						}
					}
				}
			}
		}
	}

	public function addDafeultFrontScriptsAndStyles( $hook ) {
		//global _OFWP_jvet__Conf::$defaultScriptsAndStyles;
		$space = 'front';

		if ( is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles ) && isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ] ) ) {
			if ( is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ] ) ) {
				if ( isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] ) && is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] ) ) {
					$type = 'js' . __OFWP_jvet__PS_;

					foreach ( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'js' ] as $script ) {
						$script[ 'src' ] = __OFWP_jvet__THIS_PLUGIN__FRONT_URL_ . 'assets' . __OFWP_jvet__PS_ . $type . $script[ 'src' ];
						if ( isset( $script[ 'hook_deps' ] ) ) {
							if ( is_string( $script[ 'hook_deps' ] ) ) {
								if ( strpos( $hook , trim( $script[ 'hook_deps' ] ) ) ) {
									$this->addScript( $script );
								}
							} else if ( is_array( $script[ 'hook_deps' ] ) ) {
								foreach ( $script[ 'hook_deps' ] as $value ) {
									if ( strpos( $hook , trim( $value ) ) !== false ) {
										$this->addScript( $script );
										break;
									}
								}
							}
						} else {
							$this->addScript( $script );
						}
					}
				}
				if ( isset( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] ) && is_array( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] ) ) {
					$type = 'css' . __OFWP_jvet__PS_;

					foreach ( _OFWP_jvet__Conf::$defaultScriptsAndStyles[ $space ][ 'css' ] as $style ) {
						$style[ 'src' ] = __OFWP_jvet__THIS_PLUGIN__FRONT_URL_ . 'assets' . __OFWP_jvet__PS_ . $type . $style[ 'src' ];
						if ( isset( $style[ 'hook_deps' ] ) ) {
							if ( is_string( $style[ 'hook_deps' ] ) ) {
								if ( strpos( $hook , trim( $style[ 'hook_deps' ] ) ) ) {
									$this->addStyle( $style );
								}
							} else if ( is_array( $style[ 'hook_deps' ] ) ) {
								foreach ( $style[ 'hook_deps' ] as $value ) {
									if ( strpos( $hook , trim( $value ) ) !== false ) {
										$this->addStyle( $style );
										break;
									}
								}
							}
						} else {
							$this->addStyle( $style );
						}
					}
				}
			}
		}
	}

	public static function generateRandomString( $length = 5 ) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

} 
