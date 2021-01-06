<?php

namespace ThalamusSDK\Model\Activity\Generic;

use ThalamusSDK\Thalamus;
use \ThalamusSDK\ThalamusModel;

/**
 * Class Generic
 *
 * @package ThalamusSDK
 */
class Generic extends ThalamusModel {
	
	/**
	 * Activity Login
     * 
     * @return \ThalamusSDK\Model\Activity\Generic\Generic
     */
	public function login() {
		$thalamus = Thalamus::getInstance ();
		$thalamus->activityLogin ( $this->getCode () );
		return $this;
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
	public function getCode() {
		return $this->getProperty ( 'code' );
	}
	
	/**
	 */
	public function getType() {
		return $this->getProperty ( 'type' );
	}
	
	/**
	 */
	public function getLinks() {
		return $this->getProperty ( 'links' );
	}
	
	/**
	 */
	public function getMessage() {
		return $this->getProperty ( 'message' );
	}
}