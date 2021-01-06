<?php

namespace ThalamusSDK\Model\Party;

use \ThalamusSDK\ThalamusModel;

/**
 * Class OptIn
 *
 * @package ThalamusSDK
 */
class OptIn extends ThalamusModel {
	/**
	 *
	 * @return number
	 */
	public function getBrandFamilyId() {
		return $this->getProperty ( 'brandFamilyId' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getChannelId() {
		return $this->getProperty ( 'channel' );
	}
	
	/**
	 *
	 * @return bool
	 */
	public function getAccepted() {
		return $this->getProperty ( 'accepted' );
	}
}