<?php

namespace ThalamusSDK\Model;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\Model\Activity\Event\Event;
use \ThalamusSDK\Model\Activity\Generic\Generic;
use \ThalamusSDK\Model\Activity\Mileage\Mileage;
use \ThalamusSDK\Model\Activity\Survey\Survey;
use \ThalamusSDK\Model\Activity\PayItForward\PayItForward;
use \ThalamusSDK\ThalamusOtherException;

/**
 *
 * @author ezequiel
 *        
 */
class Activity extends ThalamusModel {
	
	/**
	 *
	 * @param String $typeOf        	
	 * @return multitype:NULL unknown
	 */
	public function getAll($typeOf = false) {
		$target = array ();
		
		if (is_array ( $this->backingData )) {
			$target = $this->backingData;
		}
		
		$out = array ();
		
		foreach ( $target as $key => $value ) {
			
			if (is_scalar ( $value )) {
				$out [$key] = $value;
			} else {
				$type = 'ThalamusSDK\Model\Activity';
				switch ($value->type) {
					case 'PUBLIC_EVENT' :
						$type .= '\Event\Event';
						break;
					case 'SURVEY' :
						$type .= '\Survey\Survey';
						break;
					case 'MILEAGE' :
						$type .= '\Mileage\Mileage';
						break;
					case 'PAYITFORWARD' :
						$type .= '\PayItForward\PayItForward';
						break;
					default :
						$type .= '\Generic\Generic';
				}
				if ($typeOf) {
					if ($type == $typeOf) {
						$tObj = new ThalamusModel ( $value );
						$out [$key] = $tObj->cast ( $type );
					}
				} else {
					$tObj = new ThalamusModel ( $value );
					$out [$key] = $tObj->cast ( $type );
				}
			}
		}
		
		return $out;
	}
	
	/**
	 *
	 * @return array of \ThalamusSDK\Model\Activity\Event\Event Objects
	 */
	public function getEvents() {
		return $this->getAll ( Event::className () );
	}
	
	/**
	 *
	 * @param String $eventCode        	
	 * @throws ThalamusOtherException
	 * @return \ThalamusSDK\Model\Activity\Event\Event object
	 */
	public function getEvent($eventCode) {
		foreach ( $this->getEvents () as $event ) {
			if ($event->getCode () == $eventCode)
				return $event;
		}
		
		throw new ThalamusOtherException ( 'EVENT_NOT_FOUND', 'EVENT_NOT_FOUND', 404 );
	}
	
	/**
	 *
	 * @return array of \ThalamusSDK\Model\Activity\Mileage\Mileage objects
	 */
	public function getMileages() {
		return $this->getAll ( Mileage::className () );
	}
	
	/**
	 *
	 * @param String $mileageCode
	 * @throws ThalamusOtherException
	 * @return \ThalamusSDK\Model\Activity\Mileage\Mileage object
	 */
	public function getMileage($mileageCode) {
		foreach ( $this->getMileages () as $mileage ) {
			if ($mileage->getCode () == $mileageCode)
				return $mileage;
		}
		
		throw new ThalamusOtherException ( 'MILEAGE_NOT_FOUND', 'MILEAGE_NOT_FOUND', 404 );
	}
	
	/**
	 *
	 * @return array of Survey objects
	 */
	public function getSurveys() {
		return $this->getAll ( Survey::className () );
	}
	
	/**
	 *
	 * @param String $surveyCode        	
	 * @throws ThalamusOtherException
	 * @return \ThalamusSDK\Model\Activity\Survey\Survey objects
	 */
	public function getSurvey($surveyCode) {
		foreach ( $this->getSurveys () as $survey ) {
			if ($survey->getCode () == $surveyCode)
				return $survey;
		}

		throw new ThalamusOtherException ( 'SURVEY_NOT_FOUND', 'SURVEY_NOT_FOUND', 404 );
	}

	/**
	 *
	 * @return array of \ThalamusSDK\Model\Activity\Generic\Generic objects
	 */
	public function getGenerics() {
		return $this->getAll ( Generic::className () );
	}

	/**
	 *
	 * @param String $genericCode
	 * @throws ThalamusOtherException
	 * @return \ThalamusSDK\Model\Activity\Generic\Generic object
	 */
	public function getGeneric($genericCode) {
		foreach ( $this->getGenerics () as $generic ) {
			if ($generic->getCode () == $genericCode)
				return $generic;
		}
		
		throw new ThalamusOtherException ( 'GENERIC_NOT_FOUND', 'GENERIC_NOT_FOUND', 404 );
	}
	
	/**
	 *
	 * @return array of \ThalamusSDK\Model\Activity\PayItForward\PayItForward objects
	 */
	public function getPayItForwards() {
		return $this->getAll ( PayItForward::className () );
	}
	
	/**
	 *
	 * @param String $payItForwardCode        	
	 * @throws ThalamusOtherException
	 * @return \ThalamusSDK\Model\Activity\PayItForward\PayItForward object
	 */
	public function getPayItForward($payItForwardCode) {
		foreach ( $this->getPayItForwards () as $payItForward ) {
			if ($payItForward->getCode () == $payItForwardCode)
				return $payItForward;
		}
		
		throw new ThalamusOtherException ( 'PAYITFORWARD_NOT_FOUND', 'PAYITFORWARD_NOT_FOUND', 404 );
	}
	// gamification
}