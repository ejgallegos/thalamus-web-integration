<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;

/**
 * Class OrderItem
 *
 * @package ThalamusSDK
 */
class OrderItem extends ThalamusModel {
	
	/**
	 *
	 * @return Item mileage object
	 */
	public function getItem() {
		return $this->getProperty ( 'item', Item::classname () );
	}
	
	/**
	 *
	 * @return Voucher mileage object
	 */
	public function getVoucher() {
		return $this->getProperty ( 'voucher', Voucher::classname () );
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
	
	/**
	 *
	 * @return Number
	 */
	public function getUnitaryPrice() {
		return $this->getProperty ( 'unitaryPrice' );
	}
	
	
}