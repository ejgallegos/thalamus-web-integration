<?php

namespace ThalamusSDK\Model\Activity\PayItForward;

use \ThalamusSDK\ThalamusModel;

/**
 * Class ChainPagination
 *
 * @package ThalamusSDK
 */
class ChainPagination extends ThalamusModel {
	
	/**
	 *
	 * @return Number
	 */
	public function getCurrentPage() {
		return $this->getProperty ( 'currentPage' );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getCurrentSize() {
		return $this->getProperty ( 'currentSize' );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getTotalCount() {
		return $this->getProperty ( 'totalCount' );
	}
	
	/**
	 *
	 * @return Number
	 */
	public function getTotalPages() {
		return $this->getProperty ( 'totalPages' );
	}
}