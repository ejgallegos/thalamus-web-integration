<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;

/**
 * Class MileageStatus
 *
 * @package ThalamusSDK
 */
class MileageStatus extends ThalamusModel {
	/**
	 *
	 * @return number
	 */
	public function getAccountBalance() {
		return $this->getProperty ( 'accountBalance' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getAccountLeft() {
		return $this->getProperty ( 'accountLeft' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getCarTotal() {
		return $this->getProperty ( 'cartTotal' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getQuantityItemsInCart() {
		return $this->getProperty ( 'quantityItemsInCart' );
	}
}