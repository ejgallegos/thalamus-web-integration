<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;

/**
 * Class ExchangeCenter
 *
 * @package ThalamusSDK
 */
class ExchangeCenter extends ThalamusModel {
	
	/**
	 *
	 * @return number
	 */
	public function getId() {
		return $this->getProperty ( 'id' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getName() {
		return $this->getProperty ( 'name' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getImageURL() {
		return $this->getProperty ( 'imageURL' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->getProperty ( 'description' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getStreet() {
		return $this->getProperty ( 'street1' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getStreet2() {
		return $this->getProperty ( 'street2' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getCityId() {
		return $this->getProperty ( 'cityId' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getStateOrProvinceId() {
		return $this->getProperty ( 'stateOrProvinceId' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getCountryId() {
		return $this->getProperty ( 'countryId' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function getPostalCode() {
		return $this->getProperty ( 'postalCode' );
	}
}