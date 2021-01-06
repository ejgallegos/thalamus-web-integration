<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Voucher
 *
 * @package ThalamusSDK
 */
class Voucher extends ThalamusModel {
	
	/**
	 *
	 * @return String
	 */
	public function getCode() {
		return $this->getProperty ( 'code' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getState() {
		return $this->getProperty ( 'state' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getParameter1() {
		return $this->getProperty ( 'parameter1' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getParameter2() {
		return $this->getProperty ( 'parameter2' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getParameter3() {
		return $this->getProperty ( 'parameter3' );
	}
	
}