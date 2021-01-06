<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusRequest;

/**
 * Class Cart
 *
 * @package ThalamusSDK
 */
class Cart extends ThalamusModel {
	
	/**
	 *
	 * @return String
	 */
	public function getCode() {
		return $this->getProperty ( 'mileageCode' );
	}
	
	/**
	 * Returns the name for the user as a string if present.
	 *
	 * @return CartItem Array
	 */
	public function getItems() {
		return $this->getPropertyAsArray ( 'items', CartItem::classname () );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getAccountBalance() {
		return $this->getProperty ( 'accountBalance' );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getAccountLeft() {
		return $this->getProperty ( 'accountLeft' );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getTotal() {
		return $this->getProperty ( 'total' );
	}
	
	/**
	 *
	 * @param string $itemCode        	
	 * @param number $quantity        	
	 */
	public function add($itemCode, $quantity = 1) {
		$params = array (
				"itemCode" => $itemCode,
				"quantity" => $quantity 
		);
		
		$response = ThalamusRequest::post ( "/mileage/{$this->getCode()}/cart/items", $params )->execute ();
		
		/**
		 * agregar item al objeto cart
		 * Pedir que la respuesta devuelva el item.
		 */
		
		$this->_updateCart ( $response );
		
		return $response;
	}
	
	/**
	 *
	 * @param string $itemCode        	
	 * @param number $quantity        	
	 */
	public function updateQuantity($itemCode, $quantity = 1) {
		$params = array (
				"quantity" => $quantity 
		);
		
		$response = ThalamusRequest::put ( "/mileage/{$this->getCode()}/cart/items/$itemCode", $params )->execute ();
		
		/**
		 * Update Item Object Quantity
		 */
		foreach ( $this->backingData ['items'] as $key => $item ) {
			
			if ($item->item->code == $itemCode) {
				$item->quantity = $quantity;
				$item->total = $quantity * $item->item->price;
				$this->backingData ['items'] [$key] = $item;
				continue;
			}
		}
		
		/**
		 * Update Cart Object
		 */
		$this->_updateCart ( $response );
		
		return $response;
	}
	
	/**
	 *
	 * @param string $itemCode        	
	 */
	public function remove($itemCode) {
		$response = ThalamusRequest::delete ( "/mileage/{$this->getCode()}/cart/items/$itemCode" )->execute ();
		
		/**
		 * Delete item from Cart Object
		 */
		$newItems = array ();
		
		foreach ( $this->backingData ['items'] as $item ) {
			if ($item->item->code != $itemCode) {
				$newItems [] = $item;
			}
		}
		
		$this->backingData ['items'] = $newItems;
		
		/**
		 * Update Cart Object
		 */
		$this->_updateCart ( $response );
		
		return $response;
	}
	
	/**
	 */
	public function removeAll() {
		$response = ThalamusRequest::delete ( "/mileage/{$this->getCode()}/cart/items" )->execute ();
		
		$this->_updateCart ( $response );
		
		$this->backingData ['items'] = array ();
		
		return $response;
	}
	
	/**
	 *
	 * @param array $fields        	
	 * @param string $addressCode 
	 * @param string $status code       	
	 * @return Array of \ThalamusSDK\Model\Activity\Mileage\Order
	 */
	public function makeCheckoutAddress($fields = array(), $addressCode, $status = "CHECKOUT") {
		$params = array (
				"addressCode" => $addressCode,
		        "status" => $status
		);
		$params = array_merge($params, $fields);
		$service = ($status=="CHECKOUT_PAYMENT_PROCESSING") ? 'payment' : 'delivery';
		return ThalamusRequest::put ( "/mileage/{$this->getCode()}/cart/$service", $params )->execute ();
	}
	
	/**
	 *
	 * @param array $fields        	
	 * @param string $exchangeCenterId   
	 * * @param string $status code         	
	 * @return Array of \ThalamusSDK\Model\Activity\Mileage\Order
	 */
	public function makeCheckoutExchangeCenter($fields = array(), $exchangeCenterId, $status = "CHECKOUT") {
		$params = array (
				"exchangeCenterId" => $exchangeCenterId,
		        "status" => $status
		);
		$params = array_merge($params, $fields);
		$service = ($status=="CHECKOUT_PAYMENT_PROCESSING") ? 'payment' : 'delivery';
		return ThalamusRequest::put ( "/mileage/{$this->getCode()}/cart/$service", $params )->execute ();
	}
	
	/**
	 * Update Cart Object
	 * 
	 * @param \ThalamusSDK\ThalamusResponse $response        	
	 */
	private function _updateCart(\ThalamusSDK\ThalamusResponse $response) {
		$status = "";
		
		$activities = $response->getThalamusModel ()->getProperty ( 'context' )->getPropertyAsArray ( 'activities' );
		
		foreach ( $activities as $activity ) {
			if ($activity->getProperty ( 'code' ) == $this->getCode ()) {
				$status = $activity->getProperty ( 'personStatus' );
				continue;
			}
		}
		
		$this->backingData ['accountBalance'] = $status->getProperty ( 'accountBalance' );
		$this->backingData ['accountLeft'] = $status->getProperty ( 'accountLeft' );
		$this->backingData ['total'] = $status->getProperty ( 'cartTotal' );
		$this->backingData ['quantityItemsInCart'] = $status->getProperty ( 'quantityItemsInCart' );
	}
}