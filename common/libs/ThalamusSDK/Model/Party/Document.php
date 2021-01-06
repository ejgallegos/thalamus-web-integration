<?php

namespace ThalamusSDK\Model\Party;

use \ThalamusSDK\ThalamusModel;

/**
 * Class Document
 *
 * @package ThalamusSDK
 */
class Document extends ThalamusModel {
	
	/**
	 * Returns the Document number.
	 *
	 * @return string
	 */
	public function getNumber() {
		return $this->getProperty ( 'number' );
	}
	
	/**
	 * Returns the Document type.
	 *
	 * @return int
	 */
	public function getType() {
		return $this->getProperty ( 'type' );
	}
	
	/**
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getNumber ();
	}
}