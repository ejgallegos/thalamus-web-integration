<?php

namespace ThalamusSDK;

/**
 * ThalamusSession
 *
 * @author Ezequiel
 */
class ThalamusSession {
	/**
	 * El index donde se guarda la sesion en $_SESSION
	 * @const string
	 */
	const SESSION_NAME = "thalamus_session";
	
	/**
	 * Basic Auth User
	 *
	 * @var string
	 */
	private $user = '';
	
	/**
	 * Basic Auth Password
	 *
	 * @var string
	 */
	private $accessToken = '';
	
	/**
	 *
	 * @var string
	 */
	private $tags = null;
	
	/**
	 *
	 * @var string
	 */
	private $source = null;
	
	/**
	 * \ThalamusSDK\Model\Party\Person | \ThalamusSDK\Model\Party\Company | \ThalamusSDK\Model\Party\PhysicalLocation
	 */
	private $party = false;
	
	/**
	 */
	private function __construct() {
		$_SESSION [self::SESSION_NAME] = array (
				'obj' => $this 
		);
	}
	
	/**
	 *
	 * @return \ThalamusSDK\ThalamusSession
	 */
	private static function _reConstruct() {
		if (isset ( $_SESSION [self::SESSION_NAME] ['serialized_obj'] ) and (unserialize ( $_SESSION [self::SESSION_NAME] ['serialized_obj'] ) != null)) {
			
			return unserialize ( $_SESSION [self::SESSION_NAME] ['serialized_obj'] );
		}
		
		return new ThalamusSession ();
	}
	
	/**
	 */
	private static function _sessionStart() {
		if (! isset ( $_SESSION )) {
			session_start ();
		}
	}
	
	/**
	 */
	public function __destruct() {
		self::_sessionStart ();
		if ($this->getUser () != "")
			$_SESSION [self::SESSION_NAME] ['serialized_obj'] = serialize ( $this );
	}
	
	/**
	 */
	public function destroy() {
		self::_sessionStart ();
		$this->reset ();
		
		$this->setTags ( "" );
		$this->setSource ( "" );
		
		session_destroy ();
	}
	
	/**
	 */
	public function reset() {
		$this->setUser ( "" );
		$this->setAccessToken ( "" );
		$this->party = false;
	}
	
	/**
	 */
	public static function getSession() {
		self::_sessionStart ();
		return ! empty ( $_SESSION [self::SESSION_NAME] ['obj'] ) ? $_SESSION [self::SESSION_NAME] ['obj'] : self::_reConstruct ();
	}
	
	/**
	 *
	 * @param string $user        	
	 * @return \ThalamusSDK\ThalamusSession
	 */
	public function setUser($user) {
		$this->user = $user;
		return $this;
	}
	
	/**
	 *
	 * @param string $accessToken        	
	 * @return \ThalamusSDK\ThalamusSession
	 */
	public function setAccessToken($accessToken) {
		$this->accessToken = $accessToken;
		return $this;
	}
	
	/**
	 *
	 * @param $party
	 */
	public function setParty($party) {
		return $this->party = $party;
	}
	
	/**
	 * 
	 * @param String $tags
	 * @return \ThalamusSDK\ThalamusSession
	 */
	public function setTags(String $tags) {
		$this->tags = $tags;
		return $this;
	}
	
	/**
	 * 
	 * @param String $source
	 * @return \ThalamusSDK\ThalamusSession
	 */
	public function setSource(String $source) {
		$this->source = $source;
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getTags() {
		return $this->tags;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getSource() {
		return $this->source;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getAccessToken() {
		return $this->accessToken;
	}
	
	/**
	 * 
	 * @return \ThalamusSDK\Model\Party\Person | \ThalamusSDK\Model\Party\Company | \ThalamusSDK\Model\Party\PhysicalLocation
	 */
	public function getParty() {
		return $this->party;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getRealUser() {
		return $this->user;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public static function sessionExists() {
		return isset ( $_SESSION [self::SESSION_NAME] );
	}
}