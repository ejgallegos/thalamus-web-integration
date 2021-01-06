<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use ThalamusSDK\Thalamus;
use \ThalamusSDK\ThalamusRequest;
use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusHelper;
use ThalamusSDK\Model\Other\Rank;

/**
 * Class Mileage
 *
 * @package ThalamusSDK
 */
class Mileage extends ThalamusModel {
	
	/**
	 * Activity Login
	 *
	 * @return \ThalamusSDK\Model\Activity\Mileage\Mileage
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
	 * @return mixed|NULL|\ThalamusSDK\ThalamusModel
	 */
	public function getCode() {
		return $this->getProperty ( 'code' );
	}
	
	/**
	 * 
	 * @return mixed|NULL|\ThalamusSDK\ThalamusModel
	 */
	public function getType() {
		return $this->getProperty ( 'type' );
	}
	
	/**
	 * 
	 * @return mixed|NULL|\ThalamusSDK\ThalamusModel
	 */
	public function getLinks() {
		return $this->getProperty ( 'links' );
	}
	
	/**
	 * 
	 * @return mixed|NULL|\ThalamusSDK\ThalamusModel
	 */
	public function getMessage() {
		return $this->getProperty ( 'message' );
	}
	
	/**
	 * 
	 * @return mixed|NULL|\ThalamusSDK\ThalamusModel
	 */
	public function getStatus() {
		return $this->getProperty ( 'personStatus', MileageStatus::className () );
	}
	
	/**
	 *
	 * @param String $name
	 * @param Int $page
	 * @param Int $size
	 * @param String $tags
	 * @param String $orderBy        	
	 *
	 * @return array of mileage Item objects
	 */
	public function getCatalogItems(String $name = null, Int $page = null, Int $size = null, String $tags = null, String $orderBy = null, string $allfields = null) {
		$params = array (
				'name' => $name,
				'page' => $page,
				'size' => $size,
				'tags' => $tags,
				'orderby' => $orderBy,
		        'allfields' => $allfields
		);
				
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/catalog/items" . ThalamusHelper::paramsToUrl ( $params ) )->execute ()->getThalamusModelList ( Item::className (), 'items' );
	}
	
	/**
	 * 
	 * @param String $itemCode
	 * @return mixed|\ThalamusSDK\ThalamusModel
	 */
	public function getCatalogItem(String $itemCode) {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/catalog/items/$itemCode" )->execute ()->getThalamusModel ( Item::className () );
	}
	
	/**
	 *
	 * @return Cart object
	 */
	public function getCart() {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/cart" )->execute ()->getThalamusModel ( Cart::classname (), array (
				'mileageCode' => $this->getCode () 
		) );
	}
	
	/**
	 *
	 * @return array of CartItem objects
	 */
	public function getCartItems() {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/cart/items" )->execute ()->getThalamusModelList ( CartItem::classname (), 'items' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getCartTotal() {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/cart/total" )->execute ();
	}
	
	/**
	 *
	 * @return array of Movement object
	 */
	public function getAccountMovements() {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/account/movements" )->execute ()->getThalamusModelList ( Movement::classname (), 'movements' );
	}
	
	/**
	 *
	 * @param array $codes        	
	 */
	public function loadCode(Array $codes) {
		$arr = array ();
		
		foreach ( $codes as $code ) {
			$arr [] = array (
				'code' => $code 
			);
		}
		
		$params = array (
			"codes" => $arr 
		);
		
		return ThalamusRequest::post ( "/mileage/{$this->getCode()}/codes", $params )->execute ();
	}
	
	/**
	 *
	 * @return array of OrderItem objects
	 */
	public function getOrders() {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/orders" )->execute ()->getThalamusModelList ( Order::classname (), 'orders' );
	}
	
	/**
	 *
	 * @param string $orderCode        	
	 * @return Order
	 */
	public function getOrder($orderCode) {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/orders/$orderCode" )->execute ()->getThalamusModel ( Order::classname () );
	}
	
	/**
	 *
	 * @return array of ExchangeCenters
	 */
	public function getExchangeCenters($countryId = null, $stateId = null, $cityId = null) {
		$params = array (
				'country_id' => $countryId,
				'state_id' => $stateId,
				'city_id' => $cityId 
		);

		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/exchangecenters" . ThalamusHelper::paramsToUrl ( $params ) )->execute ()->getThalamusModelList ( ExchangeCenter::classname () , 'exchangeCenters' );
	}
	
	/**
	 *
	 * @return ExchangeCenter object
	 */
	public function getExchangeCenter($exchangeCenterId) {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/exchangecenter/$exchangeCenterId" )->execute ()->getThalamusModel ( ExchangeCenter::classname () );
	}
	
	/**
	 *
	 * @return Array of \ThalamusSDK\Model\Other\Rank
	 */
	public function getRanking() {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/ranking" )->execute ()->getThalamusModelList ( Rank::classname (), 'competitiveRanking' );
	}
	
	/**
	 *
	 * @return Array of \ThalamusSDK\Model\Other\Rank
	 */
	public function getRankings() {
		return ThalamusRequest::get ( "/mileage/{$this->getCode()}/rankings" )->execute ()->getThalamusModelList ( Rank::classname (), 'competitiveRanking' );
	}
	
	/*
	 * @param string $paymentReference
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function cancelPayment($paymentReference) {
	    $params = array (
	        "paymentReference" => $paymentReference
	    );
	    return ThalamusRequest::put ( "/payments/cancel", $params )->execute ();
	}
}