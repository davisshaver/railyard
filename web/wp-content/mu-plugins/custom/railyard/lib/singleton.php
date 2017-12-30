<?php
namespace Switchboard;

trait Singleton {

	protected static $item;
	
	public static function item() {
		if ( ! isset( static::$item ) ) {
			static::$item = new static();
			static::$item->init();
		}
		return static::$item;
	}

	public function init() {
		// Put custom init here.
	}
}