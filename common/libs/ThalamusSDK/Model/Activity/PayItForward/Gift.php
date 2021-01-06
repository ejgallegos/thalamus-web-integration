<?php

namespace ThalamusSDK\Model\Activity\PayItForward;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusRequest;

/**
 * Class Gift
 *
 * @package ThalamusSDK
 */
class Gift extends ThalamusModel {
	
	/**
	 *
	 * @return String
	 */
	public function getActivityCode() {
		return $this->getProperty ( 'activityCode' );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getId() {
		return $this->getProperty ( 'id' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getItemCode() {
		return $this->getProperty ( 'itemCode' );
	}
	
	/**
	 *
	 * @return array
	 */
	public function getLinks() {
		return $this->getProperty ( 'links' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getState() {
		return $this->getProperty ( 'state' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getWishedDate() {
		return $this->getProperty ( 'wishedDate' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getAvailableDate() {
		return $this->getProperty ( 'availableDate' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getAssignedDate() {
		return $this->getProperty ( 'assignedDate' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getClaimCode() {
		return $this->getProperty ( 'claimCode' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getClaimedDate() {
		return $this->getProperty ( 'claimedDate' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getGiver() {
		return $this->getProperty ( 'giver', Giver::classname () );
	}
	
	/**
	 *
	 * @return Boolean
	 */
	public function getReceiver() {
		return $this->getProperty ( 'receiver', Receiver::classname () );
	}
	
	/**
	 * 
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function claim() {
		$params = array (
				"claimed" => true
		);
							   
		return ThalamusRequest::put ( "/payitforward/{$this->getActivityCode()}/claims/{$this->getItemCode()}", $params )->execute ();
	}
}