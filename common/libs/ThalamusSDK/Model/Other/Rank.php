<?php

namespace ThalamusSDK\Model\Other;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Rank
 *
 * @package ThalamusSDK
 */
class Rank extends ThalamusModel {
	
	/**
	 * Returns the simpleProfile
	 *
	 * @return string|null
	 */
	public function getSimpleProfile() {
		return $this->getProperty ( 'simpleProfile', SimpleProfile::className () );
	}
	
	/**
	 * Returns the Position
	 *
	 * @return string|null
	 */
	public function getPosition() {
		return $this->getProperty ( 'position' );
	}
	
	/**
	 * Returns the points
	 *
	 * @return String
	 */
	public function getPoints() {
		return $this->getProperty ( 'points' );
	}
}