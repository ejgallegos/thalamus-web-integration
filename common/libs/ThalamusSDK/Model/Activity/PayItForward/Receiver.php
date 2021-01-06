<?php

namespace ThalamusSDK\Model\Activity\PayItForward;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Receiver
 *
 * @package ThalamusSDK
 */
class Receiver extends ThalamusModel {
	
	/**
	 * Returns the name for the user as a string if present.
	 *
	 * @return String
	 */
	public function getFirstName() {
		return $this->getProperty ( 'firstname' );
	}
	
	/**
	 *
	 * @return String
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
	 * @return Boolean
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
}