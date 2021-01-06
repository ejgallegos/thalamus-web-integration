<?php

namespace ThalamusSDK\Model\Activity\Survey;

use ThalamusSDK\Thalamus;
use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusRequest;

/**
 * Class Survey
 *
 * @package ThalamusSDK
 */
class Survey extends ThalamusModel {
	
	/**
	 * Activity Login
	 *
	 * @return \ThalamusSDK\Model\Activity\Survey\Survey
	 */
	public function login() {
		$thalamus = Thalamus::getInstance ();
		$thalamus->activityLogin ( $this->getCode () );
		return $this;
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
	public function getType() {
		return $this->getProperty ( 'type' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getLinks() {
		return $this->getProperty ( 'links' );
	}
	
	/**
	 *
	 * @return String
	 */
	public function getMessage() {
		return $this->getProperty ( 'message' );
	}
	
	/**
	 *
	 * @return \ThalamusSDK\Model\Activity\Survey\SurveyStatus
	 */
	public function getStatus() {
		return $this->getProperty ( 'personStatus', SurveyStatus::className () );
	}
	
	/**
	 *
	 * @return \ThalamusSDK\Model\Activity\Survey\Question
	 */
	public function getCurrentQuestion() {
		return ThalamusRequest::get ( "/surveys/{$this->getCode()}/questions/current", array () )->execute ()->getThalamusModel ( \ThalamusSDK\Model\Activity\Survey\Question::className () );
	}
}