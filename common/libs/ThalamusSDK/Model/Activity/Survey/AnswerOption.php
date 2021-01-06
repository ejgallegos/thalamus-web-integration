<?php

namespace ThalamusSDK\Model\Activity\Survey;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusHelper;

/**
 * Class AnswerOption
 *
 * @package ThalamusSDK
 */
class AnswerOption extends ThalamusModel {
	
	/**
	 *
	 * @return String
	 */
	public function getValue() {
		return $this->getProperty ( 'value' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getText() {
		return $this->getProperty ( 'text' );
	}
}