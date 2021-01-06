<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Item
 *
 * @package ThalamusSDK
 */
class Item extends ThalamusModel {
	public function getId() {
		return $this->getProperty ( 'id' );
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
	public function getItemType() {
		return $this->getProperty ( 'itemType' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getTags() {
		return $this->getProperty ( 'tags' );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getPrice() {
		return $this->getProperty ( 'price' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getShortDescription() {
		return $this->getProperty ( 'shortDescription' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getLongDescription() {
		return $this->getProperty ( 'longDescription' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getSmallImageURL() {
		return $this->getProperty ( 'smallImageURL' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getMediumImageURL() {
		return $this->getProperty ( 'mediumImageURL' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getLargeImageURL() {
		return $this->getProperty ( 'largeImageURL' );
	}
	
	/**
	 *
	 * @return Boolean
	 */
	public function getAvailable() {
		return $this->getProperty ( 'available' );
	}
	
	/**
	 *
	 * @return Boolean
	 */
	public function getChance() {
		return $this->getProperty ( 'chance' );
	}
	
	/**
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this->getCode() . ' - ' . $this->getName(); 
	}
}