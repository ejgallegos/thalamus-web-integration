<?php

namespace ThalamusSDK\Model\Other;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Country
 *
 * @package ThalamusSDK
 */
class Country extends ThalamusModel {
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
	 */
	public function getAgeOfMajority() {
		return $this->getProperty ( 'ageOfMajority' );
	}
	
	/**
	 */
	public function getUsingThalamus() {
		return $this->getProperty ( 'usingThalamus' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function __toString() {
		return $this->getName ();
	}
}
