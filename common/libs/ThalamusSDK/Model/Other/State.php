<?php

namespace ThalamusSDK\Model\Other;

use \ThalamusSDK\ThalamusModel;

/**
 * Class State
 *
 * @package ThalamusSDK
 */
class State extends ThalamusModel {
	
	/**
	 * Returns the ID for the user as a string if present.
	 *
	 * @return string|null
	 */
	public function getId() {
		return $this->getProperty ( 'id' );
	}
	
	/**
	 * Returns the name for the user as a string if present.
	 *
	 * @return string|null
	 */
	public function getName() {
		return $this->getProperty ( 'name' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getCountryId() {
		return $this->getProperty ( 'countryId' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function __toString() {
		return $this->getName ();
	}
}