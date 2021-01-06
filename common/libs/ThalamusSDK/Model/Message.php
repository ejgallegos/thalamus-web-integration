<?php

namespace ThalamusSDK\Model;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\ThalamusRequest;

/**
 * Class Message
 *
 * @package ThalamusSDK
 */
class Message extends ThalamusModel {
	/**
	 */
	public function getId() {
		return $this->getProperty ( 'id' );
	}
	
	/**
	 */
	public function getRead() {
		return $this->getProperty ( 'read' );
	}
	
	/**
	 */
	public function getSubject() {
		return $this->getProperty ( 'subject' );
	}
	
	/**
	 */
	public function getCommunicationName() {
		return $this->getProperty ( 'communicationName' );
	}
	
	/**
	 */
	public function getBodyHtml() {
		return $this->getProperty ( 'bodyHtml' );
	}
	
	/**
	 */
	public function getBodyPlain() {
		return $this->getProperty ( 'bodyPlain' );
	}
	
	/**
	 */
	public function read() {
		$params = array (
				'read' => true
		);
		
		$response = ThalamusRequest::put ( "/inbox/messages/{$this->getId()}", $params )->execute ();
		
		$this->backingData ['read'] = true;
		
		return $response;
	}
}