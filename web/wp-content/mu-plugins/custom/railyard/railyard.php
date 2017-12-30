<?php

namespace Railyard;

define( __NAMESPACE__ . '\PATH', __DIR__ );
define( __NAMESPACE__ . '\URL', trailingslashit( plugins_url( '', __FILE__ ) ) );

require_once( PATH . '/lib/autoload.php' );
require_once( PATH . '/lib/singleton.php' );

add_action( 'after_setup_theme', [ '\Railyard\Theme', 'instance' ] );