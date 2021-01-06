<?php

namespace ThalamusSDK\Model\Party;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\Model\Other\Location;

/**
 * Class Profile
 *
 * @package ThalamusSDK
 */
class Profile extends ThalamusModel {
	/**
	 * Returns the name for the user as a string if present.
	 *
	 * @return string|null
	 */
	public function getName() {
		return $this->getProperty ( 'firstname' ) . " " . $this->getProperty ( 'lastname' );
	}
	
	/**
	 */
	public function getEmail() {
		return $this->getProperty ( 'email' );
	}
	
	/**
	 * Returns the first name for the user as a string if present.
	 *
	 * @return string|null
	 */
	public function getFirstName() {
		return $this->getProperty ( 'firstname' );
	}
	
	/**
	 * Returns the last name for the user as a string if present.
	 *
	 * @return string|null
	 */
	public function getLastName() {
		return $this->getProperty ( 'lastname' );
	}
	
	/**
	 * Returns the gender for the user as a string if present.
	 *
	 * @return string | null
	 */
	public function getGender() {
		return $this->getProperty ( 'gender' );
	}
	
	/**
	 * Returns the users birthday, if available.
	 *
	 * @return \DateTime|null
	 */
	public function getBirthday() {
		return $this->getProperty ( 'birthday' );
	}
	
	/**
	 * Returns the current location of the user as a Location
	 * if available.
	 *
	 * @return Location | null
	 */
	public function getLocation() {
		return $this->getProperty ( 'address', Location::className () );
	}
	
	/**
	 *
	 * @return \ThalamusSDK\Model\Party\Document
	 */
	public function getDocument() {
		return $this->getProperty ( 'document', Document::className () );
	}
	
	/**
	 *
	 * @return \ThalamusSDK\Model\Party\Phone
	 */
	public function getPhone() {
		return $this->getProperty ( 'phone', Phone::classname () );
	}
	
	/**
	 *
	 * @return \ThalamusSDK\Model\Party\Cellphone
	 */
	public function getCellphone() {
		return $this->getProperty ( 'cellphone', Cellphone::classname () );
	}
	
	/**
	 * get Party Type 10 Person | 11 Company | 14 Physical Location
	 */
	public function getPartyType() {
		return $this->getProperty( 'partyType' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getName ();
	}
}