<?php

namespace Railyard;

function autoload( $cls ) {
	$cls = ltrim( $cls, '\\' );
	if ( strpos( $cls, 'Railyard\\' ) !== 0 ) {
		return;
	}
	$cls = strtolower( str_replace( [ 'Railyard\\', '_' ], [ '', '-' ], $cls ) );
	$dirs = explode( '\\', $cls );
	$cls = array_pop( $dirs );
	require_once( PATH . rtrim( '/inc/' . implode( '/', $dirs ), '/' ) . '/' . $cls . '.php' );
}
spl_autoload_register( '\Railyard\autoload' );