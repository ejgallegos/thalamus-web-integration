<?php

namespace ThalamusSDK\Model\Activity\Mileage;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusRequest;

/**
 * Class Payment
 *
 * @package ThalamusSDK
 */
class Payment extends ThalamusModel {
	
	/**
	 *
	 * @return Number
	 */
	public function getPaymentReferenceCode() {
	    return $this->getProperty ( 'paymentReference' );
	}
	
	
	
}