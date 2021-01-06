<?php

namespace ThalamusSDK\Model\Party;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Consumer
 *
 * @package ThalamusSDK
 */
class Consumer extends ThalamusModel {
	/**
	 *
	 * @return array
	 */
	public function getLinks() {
		return $this->getProperty ( 'links' );
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function getActiveConsumer() {
	
		return $this->getProperty ( 'activeConsumer' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getConsumptionFrecuency() {
		return $this->getProperty ( 'consumptionFrecuency' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getPreferedBrandId() {
		return $this->getProperty ( 'preferedBrandId' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getPreferedProductId() {
		return $this->getProperty ( 'preferedProductId' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getAlternativeBrandId() {
		return $this->getProperty ( 'alternativeBrandId' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getAlternativeProductId() {
		return $this->getProperty ( 'alternativeProductdId' );
	}
	
	/**
	 *
	 * @return number
	 */
	public function getCompetitiveMarketId() {
		return $this->getProperty ( 'competitiveMarketId' );
	}
}
