<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Order
 *
 * @package ThalamusSDK
 */
class Order extends ThalamusModel {
	
	/**
	 *
	 * @return number
	 */
	public function getOrderNumber() {
		return $this->getProperty ( 'orderNumber' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getOrderState() {
		return $this->getProperty ( 'orderState' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getAddressCode() {
		return $this->getProperty ( 'addressCode' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getExchangeCenterId() {
		return $this->getProperty ( 'exchangeCenterId' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getMessage() {
		return $this->getProperty ( 'message' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getDescription() {
		return $this->getProperty ( 'description' );
	}
	
	/**
	 *
	 * @return array OrderItem Objects
	 */
	public function getItems() {
		return $this->getPropertyAsArray ( 'items', OrderItem::classname () );
	}
	
	/*
	 * @return timestamp
	 */
	public function getCreationDate() {
	    return $this->getProperty ( 'creationDate' );
	}
}