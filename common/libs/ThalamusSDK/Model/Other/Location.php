<?php

namespace ThalamusSDK\Model\Other;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Location
 *
 * @package ThalamusSDK
 */
class Location extends ThalamusModel {
	/**
	 * Returns the street1 component of the location
	 *
	 * @return string|null
	 */
	public function getStreet() {
		return ($this->getProperty ( 'street1' )) ? $this->getProperty ( 'street1' ) : '';
	}
	
	/**
	 * Returns the street2 component of the location
	 *
	 * @return string|null
	 */
	public function getStreet2() {
		return $this->getProperty ( 'street2' );
	}
	
	/**
	 * Returns the city component of the location
	 *
	 * @return string|null
	 */
	public function getCity() {
		return $this->getProperty ( 'city' );
	}
	
	/**
	 * Returns the state id component of the location
	 *
	 * @return string|null
	 */
	public function getStateId() {
		return $this->getProperty ( 'stateId' );
	}
	
	/**
	 * Returns the country id component of the location
	 *
	 * @return int|null
	 */
	public function getCountryId() {
		return $this->getProperty ( 'countryId' );
	}
	
	/**
	 * Returns the country component of the location
	 *
	 * @return string|null
	 */
	public function getCountry() {
		return $this->getProperty ( 'countryName' );
	}
	
	/**
	 * Returns the postal code component of the location
	 *
	 * @return string|null
	 */
	public function getPostalCode() {
		return $this->getProperty ( 'postalCode' );
	}
	
	/**
	 */
	public function getType() {
		return $this->getProperty ( 'type' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function __toString() {
		return ($this->getCity ()) ? $this->getStreet () . ', ' . $this->getCity () : $this->getStreet ();
	}
}