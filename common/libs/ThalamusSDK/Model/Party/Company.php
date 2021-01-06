<?php

namespace ThalamusSDK\Model\Party;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusHelper;
use \ThalamusSDK\ThalamusRequest;
use ThalamusSDK\Model\Activity;
use ThalamusSDK\Model\Message;

/**
 * Class Company
 *
 * @package ThalamusSDK
 */
class Company extends ThalamusModel {
	
	/**
	 * return Party Id
	 */
	public function getId() {
		return $this->getProperty('id');
	}
	
	/**
	 * 
	 * @return array|\ThalamusSDK\ThalamusModel[]|mixed[]
	 */
	public function getConsumers() {
		return $this->getPropertyAsArray ( 'consumers', Consumer::classname () );
	}
	
	/**
	 * 
	 * @return array|\ThalamusSDK\ThalamusModel[]|mixed[]
	 */
	public function getOptIns() {
		return $this->getPropertyAsArray ( 'optIns', OptIn::classname () );
	}
	
	/**
	 * 
	 * @param Int $channel
	 * @return NULL|array|\ThalamusSDK\ThalamusModel[]|mixed[]
	 */
	public function getOptIn(Int $channel) {
		$optIn = null;
		
		foreach ( $this->getOptIns () as $item ) {
			if ($item->getChannelId () == $channel)
				$optIn = $item;
		}
		
		return $optIn;
	}
	
	/**
	 * get All activities
	 * 
	 * @return array of objects
	 */
	public function getActivities() {
		return $this->getActivity()->getAll();
	}
	
	/**
	 * 
	 * @throws \ThalamusSDK\ThalamusOtherException
	 * @return \ThalamusSDK\Model\Activity
	 */
	public function getActivity() {
		$activity = $this->getProperty ( 'activities', Activity::classname () );
		
		if ($activity instanceof Activity) {
			return $activity;
		}
		
		throw new \ThalamusSDK\ThalamusOtherException ( 'ACTIVITIES_NOT_FOUND', 'ACTIVITIES_NOT_FOUND', 404 );
	}
	
	/**
	 * getEvent
	 *
	 * @param string $eventCode        	
	 * @return \ThalamusSDK\Model\Activity\Event\Event
	 */
	public function getEvent(String $eventCode) {
		return $this->getActivity ()->getEvent ( $eventCode );
	}
	
	/**
	 * getSurvey
	 *
	 * @param string $surveyCode        	
	 * @return \ThalamusSDK\Model\Activity\Survey\Survey
	 */
	public function getSurvey(String $surveyCode) {
	    return $this->getActivity ()->getSurvey ( $surveyCode );
	}
	
	/**
	 * getMileage
	 *
	 * @param string $mileageCode        	
	 * @return \ThalamusSDK\Model\Activity\Mileage\Mileage
	 */
	public function getMileage(String $mileageCode) {
		return $this->getActivity ()->getMileage ( $mileageCode );
	}
	
	/**
	 * getPayItForward
	 *
	 * @param string $payItForwardCode
	 * @return \ThalamusSDK\Model\Activity\PayItForward\PayItForward
	 */
	public function getPayItForward(String $payItForwardCode) {
		return $this->getActivity()->getPayItForward($payItForwardCode);
	}
	
	/**
	 */
	public function getProfile() {
		return $this->getProperty ( 'profile', Profile::classname () );
	}
	
	/**
	 *
	 * @param string|null $oldPassword        	
	 * @param string $newPassword        	
	 * @param string $confirmNewPassword        	
	 */
	public function changePassword($oldPassword, String $newPassword, String $confirmNewPassword) {
		
		$session = \ThalamusSDK\ThalamusSession::getSession();
		
		$params = array();
		
		if ($oldPassword === null) {
		    $oldPasswordRequired = 'false'; 
		} else {
		    $params["oldpassword"] = $oldPassword;
		    $oldPasswordRequired = 'true';
		}
		
		$params["newPassword"] = $newPassword;
		$params["confirmNewPassword"] = $confirmNewPassword;
		
		$r = ThalamusRequest::put ( "/company/passwordchange?oldPasswordRequired=$oldPasswordRequired", $params )->auth($session->getRealUser(), $session->getAccessToken())->execute ();
		
		$session->setAccessToken($newPassword);
		
		return $r;
	}
	
	/**
	 * 
	 * @return SocialConnection Array
	 */
	public function getSocialConnections() {
		return ThalamusRequest::get ( '/connect', array () )->execute ()->getPropertyAsArray ( 'socialConnections', SocialConnection::classname () );
	}
	
	/**
	 * update updates profile/consumers/optIns data
	 * @param array $profile
	 * @param array $optIns
	 * @param array $consumers
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function update(Array $profile = null, Array $optIns = null, Array $consumers = null) {
		$params = array ();
		
		if ($profile != null) {
			$params ['profile'] = $profile;
		}
		
		if ($consumers != null) {
			$params ['consumers'] = $consumers;
		} else {
			$params ['consumers'] = array ();
		}
		
		if ($optIns != null) {
			$params ['optIns'] = $optIns;
		}
		
		return ThalamusRequest::put ( '/company', $params )->execute ();
		
	}
	
	/**
	 *
	 * @param boolean $read
	 * @param int $page
	 * @param int $size
	 *
	 * @return array of Message objects
	 */
	public function getInBox(Bool $read = null, Int $page = null, Int $size = null) {
		$params = array (
				'read' => $read,
				'page' => $page,
				'size' => $size 
		);
		
		return ThalamusRequest::get ( '/inbox/messages' . ThalamusHelper::paramsToUrl ( $params ) )->execute ()->getThalamusModelList ( Message::className (), 'messages' );
	}
	
	/**
	 *
	 * @return String Person Full Name
	 */
	public function __toString() {
		return $this->getProfile ()->getProperty('name');
	}
}
