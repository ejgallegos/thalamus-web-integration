<?php

namespace ThalamusSDK\Model\Activity\PayItForward;

use ThalamusSDK\Thalamus;
use ThalamusSDK\ThalamusHelper;
use \ThalamusSDK\ThalamusRequest;
use \ThalamusSDK\ThalamusModel;
use ThalamusSDK\ThalamusResponse;

/**
 * Class PayItForward
 *
 * @package ThalamusSDK
 */
class PayItForward extends ThalamusModel {
	
	/**
	 * Activity Login
	 *
	 * @return PayItForward
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
	 *
	 * @return String
	 */
	public function getCode() {
		return $this->getProperty ( 'code' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getType() {
		return $this->getProperty ( 'type' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getLinks() {
		return $this->getProperty ( 'links' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getMessage() {
		return $this->getProperty ( 'message' );
	}
	
	/**
	 *
	 * @return PayItForwardStatus object
	 */
	public function getStatus() {
		return $this->getProperty ( 'personStatus', PayItForwardStatus::className () );
	}
	
	/**
	 *
	 * @param Number $size        	
	 * @param Number $page        	
	 * @return Chain object
	 */
	public function getChain(Int $size = null, Int $page = null) {
		$params = array (
			'size' => $size,
			'page' => $page 
		);
		
		return ThalamusRequest::get ( "/payitforward/{$this->getCode()}/gifts/chain/public" . ThalamusHelper::paramsToUrl ( $params ) )->execute ()->getThalamusModel ( Chain::classname (), array (
				'activityCode' => $this->getCode ()
		) );
	}
	
	/**
	 *
	 * @param String $itemCode        	
	 * @return ThalamusResponse
	 */
	public function giveOneGift($itemCode) {
		$params = array (
				'itemCode' => $itemCode
		);
		
		return ThalamusRequest::post ( "/payitfoward/{$this->getCode()}/gifts", $params )->execute ()->getThalamusModel ( Gift::className(), array( 'activityCode' => $this->getCode() ) );
	}
	
	/**
	 * Solo para pernod-ricard
	 *
	 * @param String $itemCode
	 * @return ThalamusResponse
	 */
	public function giveOneGiftPaymentApproved($itemCode) {
		$params = array (
				'itemCode' => $itemCode 
		);
		
		return ThalamusRequest::post ( "/pernod/chivas/payitforward/{$this->getCode()}/gifts", $params )->execute ();
	}
	
	/**
	 * 
	 * @param string $itemCode
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function claimGift($itemCode) {
		$params = array (
				"claimed" => true
		);
		
		return ThalamusRequest::put ( "/payitfoward/{$this->getCode()}/claimss/$itemCode", $params )->execute ();
	}
}