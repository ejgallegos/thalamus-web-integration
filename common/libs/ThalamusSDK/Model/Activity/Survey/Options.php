<?php

namespace ThalamusSDK\Model\Activity\Survey;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusHelper;

/**
 * Class Options
 *
 * @package ThalamusSDK
 */
class Options extends ThalamusModel {
	
	/**
	 *
	 * @return array of strings
	 */
	public function getLinks() {
		return $this->getProperty ( 'links' );
	}
	
	/**
	 *
	 * @return array of \ThalamusSDK\Model\Activity\Survey\AnswerOption
	 */
	public function getAnswers() {
		return $this->getPropertyAsArray ( 'answerOptions', AnswerOption::classname () );
	}
}