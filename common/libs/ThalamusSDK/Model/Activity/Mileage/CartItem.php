<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;

/**
 * Class CartItem
 *
 * @package ThalamusSDK
 */
class CartItem extends ThalamusModel {
	
	/**
	 *
	 * @return Item mileage object
	 */
	public function getItem() {
		return $this->getProperty ( 'item', Item::classname () );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getQuantity() {
		return $this->getProperty ( 'quantity' );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getTotal() {
		return $this->getProperty ( 'total' );
	}
}