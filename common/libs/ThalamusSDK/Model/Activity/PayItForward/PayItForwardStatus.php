<?php

namespace ThalamusSDK\Model\Activity\PayItForward;

use \ThalamusSDK\ThalamusModel;

/**
 * Class PayItForwardStatus
 *
 * @package ThalamusSDK
 */
class PayItForwardStatus extends ThalamusModel {
	/**
	 *
	 * @return Number
	 */
	public function getTotalGifts() {
		return $this->getProperty ( 'totalGifts' );
	}
}