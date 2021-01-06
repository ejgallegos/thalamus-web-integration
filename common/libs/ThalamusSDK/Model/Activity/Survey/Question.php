<?php

namespace ThalamusSDK\Model\Activity\Survey;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusHelper;
use \ThalamusSDK\ThalamusRequest;

/**
 * Class Question
 *
 * @package ThalamusSDK
 */
class Question extends ThalamusModel {
	
	/**
	 */
	public function getCode() {
		return $this->getProperty ( 'questionCode' );
	}
	
	/**
	 */
	public function getSurveyCode() {
		return $this->getProperty ( 'surveyCode' );
	}
	
	/**
	 */
	public function getText() {
		return $this->getProperty ( 'questionText' );
	}
	
	/**
	 */
	public function getType() {
		return $this->getProperty ( 'questionType' );
	}
	
	/**
	 */
	public function getOptions() {
		return $this->getProperty ( 'options', Options::className () );
	}
	
	/**
	 * Returns answers options
	 * @return NULL
	 */
	public function getAnswerOptions() {
		return !empty($this->getOptions()) ? $this->getOptions()->getAnswers() : null;
	}
	
	/**
	 * 
	 * @return NULL
	 */
	public function getOptionsLinks() {
		return !empty($this->getOptions()) ? $this->getOptions()->getLinks() : null;
	}
	
	/**
	 *
	 * @param
	 *        	answerData:value format $answerDataValue (see Thalamus API Documentation - Survey Activity- Answer Current Question)
	 */
	public function answer($answerDataValue) {
		$params = array (
				'activitySurveycode' => $this->getSurveyCode (),
				'questionCode' => $this->getCode (),
				'answerData' => array (
						'type' => $this->getType (),
						'value' => $answerDataValue 
				) 
		);
		
		return ThalamusRequest::put ( "/surveys/{$this->getSurveyCode()}/questions/current/answer", $params )->execute ();
	}
}