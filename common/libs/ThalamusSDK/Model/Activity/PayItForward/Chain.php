<?php

namespace ThalamusSDK\Model\Activity\PayItForward;

use \ThalamusSDK\ThalamusRequest;
use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusHelper;

/**
 * Class Chain
 *
 * @package ThalamusSDK
 */
class Chain extends ThalamusModel {
	
	/**
	 *
	 * @return String
	 */
	public function getActivityCode() {
		return $this->getProperty ( 'activityCode' );
	}
	
	/**
	 *
	 * @return ChainPagination object
	 */
	public function getPagination() {
		return $this->getProperty ( 'pagination', ChainPagination::classname () );
	}
	
	/**
	 *
	 * @return array of Gift objects
	 */
	public function getGifts() {
		return $this->getPropertyAsArray ( 'gifts', Gift::classname (), array (
				'activityCode' => $this->getActivityCode () 
		) );
	}
}