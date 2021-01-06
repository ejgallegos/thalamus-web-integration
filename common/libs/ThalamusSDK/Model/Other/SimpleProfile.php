<?php

namespace ThalamusSDK\Model\Other;

use \ThalamusSDK\ThalamusModel;

/**
 * Class SimpleProfile
 *
 * @package ThalamusSDK
 */
class SimpleProfile extends ThalamusModel {
	
	/**
	 * Returns the Firstname
	 *
	 * @return string|null
	 */
	public function getFirstName() {
		return $this->getProperty ( 'firstname' );
	}
	
	/**
	 * Returns the lastname
	 *
	 * @return string|null
	 */
	public function getLastName() {
		return $this->getProperty ( 'lastname' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getEmail() {
		return $this->getProperty ( 'email' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getShortName() {
		return $this->getProperty ( 'shortName' );
	}
	
	/**
	 * Returns longname
	 *
	 * @return string|null
	 */
	public function getLongName() {
		return $this->getProperty ( 'longName' );
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function getMe() {
		return $this->getProperty ( 'me' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getUrlAvatar() {
		return $this->getProperty ( 'urlAvatar' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function __toString() {
		return $this->getLongName();
	}
}