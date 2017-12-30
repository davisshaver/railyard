<?php

namespace Railyard;

require_once( __DIR__ . '/lib/singleton.php' );
require_once( __DIR__ . '/inc/theme.php' );

add_action( 'after_setup_theme', [ '\Railyard\Theme', 'instance' ] );