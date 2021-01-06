<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusHelper;
use DateTime;

/**
 * Class Movement
 *
 * @package ThalamusSDK
 */
class Movement extends ThalamusModel {
	
    /**
	 * 
	 * @return DateTime
	 */
	public function getDate() {
		return ThalamusHelper::timestampToDate ( $this->getProperty ( 'date' ) );
	}
	
	/**
	 *
	 * @return DateTime timestamp
	 */
	public function getTimeStamp() {
		return $this->getProperty ( 'date' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getCode() {
		return $this->getProperty ( 'code' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->getProperty ( 'description' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getMovementType() {
		return $this->getProperty ( 'movementType' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getAmount() {
		return $this->getProperty ( 'amount' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getBalance() {
		return $this->getProperty ( 'balance' );
	}
}