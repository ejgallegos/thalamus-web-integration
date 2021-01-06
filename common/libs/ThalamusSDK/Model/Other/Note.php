<?php

namespace ThalamusSDK\Model\Other;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Note
 *
 * @package ThalamusSDK
 */
class Note extends ThalamusModel {
	
	/**
	 *
	 * @return ID
	 */
	public function getId() {
		return $this->getProperty ( 'id' );
	}
	
	/**
	 *
	 * @return Case Number 
	 */
	public function getCaseInstanceId() {
		return $this->getProperty ( 'caseInstanceId' );
	}
	
	/**
	 *
	 * @return String Description
	 */
	public function getDescription() {
		return $this->getProperty ( 'description' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function __toString() {
		return $this->getDescription ();
	}
}
