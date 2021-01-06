<?php

namespace ThalamusSDK\Model\Party;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Phone
 *
 * @package ThalamusSDK
 */
class Phone extends ThalamusModel {
	
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
	 * Returns the Phone type.
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