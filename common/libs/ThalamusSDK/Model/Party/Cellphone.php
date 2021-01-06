<?php

namespace ThalamusSDK\Model\Party;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Cellphone
 *
 * @package ThalamusSDK
 */
class Cellphone extends ThalamusModel {
	
	/**
	 *
	 * @return String
	 */
	public function getAreaCode() {
		return $this->getProperty ( 'areaCode' );
	}
	
	/**
	 * Returns the Phone number.
	 *
	 * @return string
	 */
	public function getNumber() {
		return $this->getProperty ( 'number' );
	}
	
	/**
	 * Returns the Cellphone type.
	 *
	 * @return string
	 */
	public function getType() {
		return $this->getProperty ( 'type' );
	}
	
	/**
	 * Returns the intCode.
	 *
	 * @return String
	 */
	public function getIntCode() {
		return $this->getProperty ( 'intCode' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getIntCode () . '-' . $this->getAreaCode () . '-' . $this->getNumber ();
	}
}