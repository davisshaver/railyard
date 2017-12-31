<?php

/**
 * WordPress automatically loads single-file MU plugins
 * but will ignore MU plugins in subdirectories. Those can
 * be loaded here.
 *
 * MU plugins are required / available across the entire network.
 */

$railyard_mu_plugins = array(
	'gutenberg/gutenberg.php',
	'custom/railyard/railyard.php',
);

foreach ( $railyard_mu_plugins as $railyard_mu_plugin ) {
	if ( file_exists( dirname( __FILE__ ) . '/' . $railyard_mu_plugin ) ) {
		require_once dirname( __FILE__ ) . '/' . $railyard_mu_plugin;
	}
}