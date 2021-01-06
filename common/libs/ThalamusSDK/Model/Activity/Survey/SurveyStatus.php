<?php

namespace ThalamusSDK\Model\Activity\Survey;

use \ThalamusSDK\ThalamusModel;

/**
 * Class SurveyStatus
 *
 * @package ThalamusSDK
 */
class SurveyStatus extends ThalamusModel {
	/**
	 *
	 * @return boolean
	 */
	public function getCompleted() {
		return $this->getProperty ( 'completed' );
	}
}