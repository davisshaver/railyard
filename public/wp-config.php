<?php
/*
 * Don't show deprecations.
 */
error_reporting( E_ALL ^ E_DEPRECATED );

/**
 * Set root path.
 */
$rootPath = realpath( __DIR__ . '/..' );

/**
 * Include the Composer autoload
 */
require_once( $rootPath . '/vendor/autoload.php' );

/**
 * Disallow on server file edits.
 */
define( 'DISALLOW_FILE_EDIT', true );
define( 'DISALLOW_FILE_MODS', true );

/**
 * Force SSL.
 */
define( 'FORCE_SSL_ADMIN', true );

/**
 * Limit post revisions.
 */
define( 'WP_POST_REVISIONS', 3 );

/**
 * Define site and home URLs.
 */
$site_url = getenv( 'WP_HOME' ) !== false ? getenv( 'WP_HOME' ) : 'https://' . $_SERVER['HTTP_HOST'] . '/';
define( 'WP_HOME', $site_url );
define( 'WP_SITEURL', $site_url . 'wp/' );

/**
 * Set Database Details
 */
define( 'DB_NAME', getenv( 'DB_NAME' ) );
define( 'DB_USER', getenv( 'DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) !== false ? getenv( 'DB_PASSWORD' ) : '' );
define( 'DB_HOST', getenv( 'DB_HOST' ) );

/**
 * Set debug modes
 */
define( 'WP_DEBUG', getenv( 'WP_DEBUG' ) === 'true' ? true : false );
define( 'IS_LOCAL', getenv( 'IS_LOCAL' ) !== false ? true : false );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', '^J/U[^{cOJxhcmmCq2MX%nUs}i_^7nm[w+VsetLZ[JXW9Un/IiyWVEXk;s}X=?u$' );
define( 'SECURE_AUTH_KEY', 'dT,wlW20L5V3ChmTEHFGVtUE-r&A)y+G%Pnql&eKdVAWvdIr9FO4lh_Gc9ZVn!1|' );
define( 'LOGGED_IN_KEY', '{0E{}k_e7!XRt*}h}nuMP[sKn$gb(O@|[>?bUs}B{>:|+|lL%czE/!Tlc Uk53#:' );
define( 'NONCE_KEY', '|M9$H1t9D@AR6>JM[]?9RoA^dmOCHt6ldAE%x|0 Iqpi+m32>1>?0*_?*#|6f7|W' );
define( 'AUTH_SALT', 'CA-BmAsS|o_P|!I8Wfu%a=qXC;!3p[8]W_:N2{oI]HhpLP(%2]zWLH+aHTHDw9>%' );
define( 'SECURE_AUTH_SALT', 'pi-EA,AOXk*U[VZ|t]R;@K<WMcbD)>k* ;8+hKX:A|$.Z@HL@0`SE?W0:-?-IRd!' );
define( 'LOGGED_IN_SALT', 'e+6%u)u@RZn-$}_Q[N;Na<|A-[Am_$#nhD~}ci:%R&B*oiq<sPF$v)d1r<-V-5W|' );
define( 'NONCE_SALT', 'r%oyx_`[A-~<LB)]I.,^//}/&]a)H|fzk3IUWrZn[L4qf#Pp#lsB-B}+/ai&u,/|' );

/*
* Define wp-content directory outside of WordPress core directory
*/
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/wp-content' );
define( 'WP_CONTENT_URL', WP_HOME . '/wp-content' );

/*
 Optionally use S3 Uploads.
*/
if ( getenv( 'AWS_S3_BUCKET' ) !== false ) {
	define( 'S3_UPLOADS_BUCKET', getenv( 'AWS_S3_BUCKET' ) );
}
if ( getenv( 'AWS_KEY_ID' ) !== false ) {
	define( 'S3_UPLOADS_KEY', getenv( 'AWS_KEY_ID' ) );
}
if ( getenv( 'AWS_KEY_SECRET' ) !== false ) {
	define( 'S3_UPLOADS_SECRET', getenv( 'AWS_KEY_SECRET' ) );
}
if ( getenv( 'S3_UPLOADS_REGION' ) !== false ) {
	define( 'S3_UPLOADS_REGION', getenv( 'S3_UPLOADS_REGION' ) );
}

/* Inserted for Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* Inserted for Local by Flywheel. Fixes $is_nginx global for rewrites. */
if (strpos($_SERVER['SERVER_SOFTWARE'], 'Flywheel/') !== false) {
	$_SERVER['SERVER_SOFTWARE'] = 'nginx/1.10.1';
}

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = getenv( 'DB_PREFIX' ) !== false ? getenv( 'DB_PREFIX' ) : 'wp_';

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );