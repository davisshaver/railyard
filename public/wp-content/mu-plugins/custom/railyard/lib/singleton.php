<?php
namespace Railyard;

trait Singleton {

	protected static $instance;
	
	public static function instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static();
			static::$instance->setup();
		}
		return static::$instance;
	}

	public function setup() {
		// Put custom init here.
	}
}