<?php

namespace ThalamusSDK\Model\Activity\Event;

use \ThalamusSDK\ThalamusModel;

/**
 * Class EventStatus
 *
 * @package ThalamusSDK
 */
class EventStatus extends ThalamusModel {
	/**
	 * Returns the status for acceptance
	 *
	 * @return boolean
	 */
	public function getAccepted() {
		return $this->getProperty ( 'accepted' );
	}
	
	/**
	 * Returns the status for attendance
	 *
	 * @return boolean
	 */
	public function getAttended() {
		return $this->getProperty ( 'attended' );
	}
	
	/**
	 * Returns the ticket code
	 *
	 * @return string|null
	 */
	public function getTicketCode() {
		return $this->getProperty ( 'ticketCode' );
	}
}