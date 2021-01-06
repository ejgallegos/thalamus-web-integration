<?php

namespace ThalamusSDK\Model\Activity\Event;

use \ThalamusSDK\ThalamusRequest;
use \ThalamusSDK\Model\Other\Country;
use \ThalamusSDK\Model\Other\State;
use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\Thalamus;

/**
 * Class Event
 *
 * @package ThalamusSDK
 */
class Event extends ThalamusModel {
	
	/**
	 * Activity Login
	 *
	 * @return \ThalamusSDK\Model\Activity\Event\Event
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
	
	/**
	 */
	public function getCountry() {
		return $this->getProperty ( 'country', Country::className () );
	}
	
	/**
	 */
	public function getState() {
		return $this->getProperty ( 'state', State::className () );
	}
	
	/**
	 */
	public function getWhenDate() {
		return $this->getProperty ( 'whenDate' );
	}
	
	/**
	 */
	public function getAcceptanceUntil() {
		return $this->getProperty ( 'acceptanceUntil' );
	}
	
	/**
	 */
	public function getWithQuota() {
		return $this->getProperty ( 'withQuota' );
	}
	
	/**
	 */
	public function getCodeRequired() {
		return $this->getProperty ( 'codeRequired' );
	}
	
	/**
	 */
	public function getAttendanceLimit() {
		return $this->getProperty ( 'attendanceLimit' );
	}
	
	/**
	 */
	public function getAttendanceRemainder() {
		return $this->getProperty ( 'attendanceRemainder' );
	}
	
	/**
	 */
	public function getAttendace() {
		return $this->getProperty ( 'attendance' );
	}
	
	/**
	 */
	public function getAcceptanceRemainder() {
		return $this->getProperty ( 'acceptanceRemainder' );
	}
	
	/**
	 */
	public function getAcceptance() {
		return $this->getProperty ( 'acceptance' );
	}
	
	/**
	 */
	public function getStatus() {
		return $this->getProperty ( 'personStatus', EventStatus::className () );
	}
	
	/**
	 *
	 * @param string $ticketCode        	
	 */
	public function accept($ticketCode = false) {
		$params = ($ticketCode) ? array (
				'accepted' => true,
				'ticketCode' => $ticketCode 
		) : array (
				'accepted' => true 
		);
		
		$response = ThalamusRequest::put ( "/events/{$this->getCode()}/acceptance", $params )->execute ();
		
		$this->backingData ['personStatus']->accepted = true;
		
		return $this;
	}
	
	/**
	 * 
	 * @param boolean $ticketCode
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function cancel($ticketCode = false) {
		$params = ($ticketCode) ? array (
				'accepted' => false,
				'ticketCode' => $ticketCode 
		) : array (
				'accepted' => false 
		);
		
		$response = ThalamusRequest::put ( "/events/{$this->getCode()}/acceptance", $params )->execute ();
		
		$this->backingData ['personStatus']->accepted = false;
		
		return $response;
	}
	
	/**
	 * 
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function assist() {
		$params = array (
				'attended' => true 
		);
		
		$response = ThalamusRequest::put ( "/events/{$this->getCode()}/attendance", $params )->execute ();
		
		$this->backingData ['personStatus']->attended = false;
		
		return $response;
	}
}