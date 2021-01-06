<?php

namespace ThalamusSDK;

use ThalamusSDK\Model\Caso;
use ThalamusSDK\Model\Activity\Mileage\Mileage;

/**
 * Provides methods to connect with the Thalamus API
 *
 * @author Ezequiel
 * @version 4.1.4
 */

class Thalamus {
	
    /**
	 * @const string version de la SDK.
	 */
	const VERSION_SDK = '4.1.4';

	/**
	 * @const string version de la API
	 */
	const VERSION_API = 'v4';
	
	/**
	 * @const string test|prod
	 */
	const THALAMUS_ENVIRONMENT = 'test';
	
	/**
	 * @const client
	 */
	const THALAMUS_CLIENT = 'mccain';
	
	/**
	 * @const string
	 */
	const THALAMUS_TOUCHPOINT = 'arg_mccain_ecommerce';
	
	/**
	 * @const string
	 */
	const THALAMUS_TOKEN = '5bog7zvcjgrvsol93x2k4b30671wdruv9jigggdqdz1403w6u8lwds4oo0tn5mp1';
	
	/**
	 * @const default password para registros sin password.
	 */
	const DEFAULT_PASSWORD = '';
	
	/**
	 *
	 * @var ThalamusSession The session used for requests
	 */
	private $session;
	
	/**
	 * getMe returns Thalamus instance
	 *
	 * @return \ThalamusSDK\Thalamus
	 */
	public static function getInstance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new static ();
		}
		
		return $instance;
	}
	
	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		$this->session = ThalamusSession::getSession ();
	}
	
	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {
	}
	
	/**
	 * Private unserialize method to prevent unserializing of the *Singleton*
	 * instance.
	 *
	 * @return void
	 */
	private function __wakeup() {
	}

	/**
	 * setTags
	 *
	 * @param string $tags
	 * @return Thalamus object
	 */
	public function setTags(String $tags) {
		$this->session->setTags ( $tags );
		return $this;
	}

	/**
	 * setSource
	 *
	 * @param string $source
	 * @return Thalamus object
	 */
	public function setSource(String $source) {
		$this->session->setSource ( $source );
		return $this;
	}
	
	/**
	 * isAlive checks if thalamus server is alive
	 *
	 * @return boolean
	 */
	public static function isAlive() {
		self::getInstance ();
		return ThalamusRequest::get ( '/isAlive' )->execute ()->getResponse ()->isAlive == true;
	}
	
	/**
	 *  login user
	 * @param String $principal
	 * @param String $password
	 * @param Int $documentType
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function login(String $principal, String $password = "", Int $documentType = null) {
		$this->session->reset ();
	
		$params = array (
			'principal' => ($documentType) ? $documentType . '$' . $principal : $principal,
			'password' => ! empty ( $password ) ? $password : self::DEFAULT_PASSWORD
		);
	
		$response = ThalamusRequest::post ( '/signin', $params )->noAuth ()->execute();
		
		$this->session->setUser ( $params ['principal'] );
		$this->session->setAccessToken ( $params ['password'] );
	
		return $response;
	}
	
	/**
	 * 
	 * @param Bool $cache
	 * @return \ThalamusSDK\Model\Party\Person|\ThalamusSDK\Model\Party\Company|\ThalamusSDK\Model\Party\PhysicalLocation
	 */
	public function getParty(Bool $cache = true) {
	    
		if ($this->session->getParty() && $cache) {
			return $this->session->getParty();	
		} 

	    $params = array (
	        'date_format' => 'readable'
	    );
	    
// 	    $response = ThalamusRequest::get ( '/me', $params )->execute();
	    
//         switch (true) {
            
//             case isset($response->getResponse()->company):
//                 $party = $response->getThalamusModel ( \ThalamusSDK\Model\Party\Company::className () );
//                 break;
            
//             case isset($response->getResponse()->physicallocation):
//                 $party = $response->getThalamusModel ( \ThalamusSDK\Model\Party\PhysicalLocation::className () );
//                 break;
            
//             case isset($response->getResponse()->person):
                $response = ThalamusRequest::get ( '/person', $params )->execute();
                $party = $response->getThalamusModel ( \ThalamusSDK\Model\Party\Person::className () );
//                 break;
            
//             default:
//                 $party = null;
                
//         }
	    $this->session->setParty($party);
	    return $party;
		
	}
	
	/**
	 * logout
	 *
	 * @return ThalamusResponse
	 */
	public function logout() {
		$response = ThalamusRequest::get ( '/logout' )->execute ();
		
		$this->session->destroy ();
		
		return $response;
	}
	
	/**
	 * register person
	 * 
	 * @param array $profile
	 * @param array $optIns
	 * @param String $principal
	 * @param String $password
	 * @param array $consumers
	 * @param String automatic (default value) | manual | temporary | pre-validated | pre-registration
	 * @throws ThalamusRequestException
	 * @return \ThalamusSDK\ThalamusResponse
	 * 
	 */
	public function register(Array $profile, Array $optIns, String $principal, String $password = self::DEFAULT_PASSWORD, Array $consumers = array(), String $validation = 'automatic') {
		$params = array (
				'consumers' => $consumers,
				'optIns' => $optIns,
				'profile' => $profile,
				'credential' => array (
						'principal' => $principal,
						'password' => $password 
				) 
		);
		   
		if (!empty($params['profile']['birthday']) 
		    && is_string($params['profile']['birthday']) 
		    && (\ThalamusSDK\ThalamusHelper::validateDate($params['profile']['birthday']) == false)) {
		        throw new \ThalamusSDK\ThalamusRequestException(
		            'BIRTHDAY_INVALID_FORMAT',
		            array(
		                array (
		                    'code' => 1241,
		                    'code_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
		                    'message_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
		                    'error_name' => 'BIRTHDAY_INVALID_FORMAT',
		                    'error_description' => 'Birthday invalid format.'
		                )
		            ),  404);
	    }
		
	    $response = ThalamusRequest::post ( "/person?validation=$validation", $params )->noAuth ()->execute ();
		
		$principal = str_replace(':', '$', $principal);
		
		$this->session->setUser ( $principal );
		$this->session->setAccessToken ( $password );
		
		return $response;
	}
	
	/**
	 * register company
	 * 
	 * @param array $profile
	 * @param array $optIns
	 * @param String $principal
	 * @param String $password
	 * @param array $consumers
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function registerCompany(Array $profile, Array $optIns, String $principal, String $password = self::DEFAULT_PASSWORD, Array $consumers = array()) {
		$params = array (
				'consumers' => $consumers,
				'optIns' => $optIns,
				'profile' => $profile,
				'credential' => array (
						'principal' => $principal,
						'password' => $password
				)
		);
	
		$response = ThalamusRequest::post ( '/company', $params )->noAuth ()->execute ();
	
		$principal = str_replace(':', '$', $principal);
		
		$this->session->setUser ( $principal );
		$this->session->setAccessToken ( $password );
	
		return $response;
	}
	
	/**
	 * register physical location
	 *
	 * @param array $profile
	 * @param array $optIns
	 * @param String $principal
	 * @param String $password
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function registerPhysicalLocation(Array $profile, Array $optIns, String $principal, String $password = self::DEFAULT_PASSWORD) {
		$params = array (
				'optIns' => $optIns,
				'profile' => $profile,
				'credential' => array (
						'principal' => $principal,
						'password' => $password
				)
		);
	
		$response = ThalamusRequest::post ( '/physicallocation', $params )->noAuth ()->execute ();
        
		$principal = str_replace(':', '$', $principal);
		
		$this->session->setUser ( $principal );
		$this->session->setAccessToken ( $password );
	
		return $response;
	}
	
	/**
	 * requestResetPassword
	 * @param String $principal
	 * @param Int $documentType
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function requestResetPassword(String $principal, Int $documentType = null) {
		if ($documentType !== null) {
			$principal = $documentType . ':' . $principal;
		}
		
		$params = array (
				"principal" => $principal 
		);
		
		return ThalamusRequest::post ( '/person/password/requestreset', $params )->noAuth ()->execute ();
	}
	
	/**
	 * resetPassword
	 * 
	 * @param String $tokenLink
	 * @param String $newPassword
	 * @param String $principalLink
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function resetPassword(String $tokenLink, String $newPassword, String $principalLink) {
		$params = array (
				'token' => $tokenLink,
				'password' => $newPassword,
				'principal' => $principalLink 
		);
		
		return ThalamusRequest::put ( '/person/password', $params )->noAuth ()->execute ();
	}
	
	/**
	 * fireInteraction
	 * 
	 * @param String $interactionTypeCode
	 * @param String $additionalInfo
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function fireInteraction(String $interactionTypeCode, String $additionalInfo = "") {
		$params = array (
				'interactionTypeCode' => $interactionTypeCode,
				'additionalInfo' => $additionalInfo 
		);
		
		return ThalamusRequest::post ( '/interaction/fire', $params )->execute ();
	}
	
	/**
	 *
	 * @param boolean $read        	
	 * @param int $page        	
	 * @param int $size        	
	 *
	 * @return array of Message objects
	 */
	public function getInBox(Bool $read = null, Int $page = null, Int $size = null) {
		return $this->getParty ()->getInBox ( $read, $page, $size );
	}
	
	/**
	 * 
	 * @param Int $caseId
	 * @return mixed|NULL|\ThalamusSDK\ThalamusModel|mixed|\ThalamusSDK\ThalamusModel[]
	 */
	public function getCases(Int $caseId = null) {
		if ($caseId !== null)
			return ThalamusRequest::get ( '/cases/' . $caseId )->execute ()->getThalamusModel ( Caso::className () );
		else
			return ThalamusRequest::get ( '/cases/' )->execute ()->getThalamusModelList ( Caso::className (), 'cases' );
	}
	
	/**
	 *
	 */
	public function getCaseStatus() {
		
		return ThalamusRequest::get ( '/cases/status' )->execute ()->getResponse();
		
	}
	
	/**
	 *
	 */
	public function getTypeCategory() {
	
		return ThalamusRequest::get ( '/cases/typecategory?visibility=app' )->execute ()->getResponse();
	
	}
	
	/**
	 * 
	 * @param String $categoryCode
	 * @param String $typeCode
	 * @param String $description
	 * @param String $status
	 * @param String $resolution
	 * @param array $caseData
	 * @return \ThalamusSDK\Model\Caso
	 */
	public function createCase(String $categoryCode, String $typeCode, String $description = "", String $status = null, String $resolution = null, Array $caseData = array()) {
		$params = array (
				'categoryCode' => $categoryCode,
				'typeCode' => $typeCode ,
				'status' => $status,
				'resolution' => $resolution,
		);	
		
		if (!empty($caseData)) {
		    $params ['caseData'] = $caseData;
		}
		
		if (! empty ( $description )) {
			$params ['comments'] = array (
					array (
							'description' => $description 
					) 
			);
		}
		
		return ThalamusRequest::post ( '/cases', $params )->execute ()->getThalamusModel ()->getProperty ( 'case', Caso::className () );
	}
	
	/**
	 * 
	 * @param Int $caseId
	 * @param String $categoryCode
	 * @param String $typeCode
	 * @param String $description
	 * @param String $status
	 * @param String $resolution
	 * @param array $caseData
	 * @return \ThalamusSDK\Model\Caso
	 */
	public function updateCase(Int $caseId,String $categoryCode, String $typeCode, String $description = "", String $status = null, String $resolution = null, Array $caseData = array()) {
		$params = array (
				'categoryCode' => $categoryCode,
				'typeCode' => $typeCode ,
				'status' => $status,
				'resolution' => $resolution,
		);
        
		if (!empty($caseData)) {
		    $params ['caseData'] = $caseData;
		}
		
		if (! empty ( $description )) {
			$params ['comments'] = array (
					array (
							'description' => $description
					)
			);
		}
		
		return ThalamusRequest::put ( '/cases/'.$caseId, $params )->execute ()->getThalamusModel ()->getProperty ( 'case', Caso::className () );
	}
	
	/**
	 *
	 * @param string $statusName
	 */
	public function updateStatusCase(Int $caseId,String $statusName = null) {
		$params = array (
				'statusName' => $statusName
		);
	
		return ThalamusRequest::put ( '/cases/'.$caseId.'/transitions', $params )->execute ()->getThalamusModel ()->getProperty ( 'case', Caso::className () );
	}
	
	/**
	 *
	 * @param string $email
	 */
	public function assignCase(Int $caseId,String $email = null) {
		$params = array (
				'email' => $email
		);
	
		return ThalamusRequest::put ( '/cases/'.$caseId.'/assignment', $params )->execute ()->getThalamusModel ()->getProperty ( 'case', Caso::className () );
	}
	
	
	/**
	 *
	 * @param string $callbackUrl        	
	 */
	public function getFacebookLink(String $callbackUrl) {
		return ThalamusRequest::post ( '/signin/facebook?callback_url=' . $callbackUrl )->noAuth ()->execute ()->getResponse ()->link->href;
	}
		
	/**
	 * 
	 * @param String $code
	 * @param String $callbackUrl
	 * @throws ThalamusOtherException
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function loginFacebook(String $code, String $callbackUrl) {
		$response = ThalamusRequest::get ( "/signin/facebook?code=$code&callback_url=$callbackUrl" )->noAuth ()->execute ();
		
		// exito
		if ($response->getResponse ()->reason == "SuccessfullySignIn") {
			
			$this->session->setUser (  str_replace ( ':', '$', $response->getResponse ()->data->principal ) );
			$this->session->setAccessToken ( str_replace ( ':', '$', $response->getResponse ()->data->tmp_password ) );
			
			return $response;
			
			// si no esta registrado
		} else if ($response->getResponse ()->reason == "NotRegistered") {
			// Retorna exception con mensaje "NotRegistered"
			throw new ThalamusOtherException ( 'NotRegistered', $response->getResponse (), 200 );
		}
		
		return $response;
	}
	
	/**
	 * 
	 * @param String $callbackUrl
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function getLinkAddFacebook(String $callbackUrl = null) {
		if ($callbackUrl != null) {
			return ThalamusRequest::post ( "/connect/facebook?callback_url=$callbackUrl")->execute ();
		}
		return ThalamusRequest::post ( "/connect/facebook")->execute ();
	}
	
	/**
	 * 
	 * @param String $code
	 * @param String $callbackUrl
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function addFacebook(String $code, String $callbackUrl) {
		return ThalamusRequest::get ( "/connect/facebook?code=$code&callback_url=$callbackUrl")->execute();
	}
	
	/**
	 * 
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function deleteFacebookAccount() {
		return ThalamusRequest::delete ( '/connect/facebook' )->execute ();
	}
	
	/**
	 *
	 * @param string $callbackUrl
	 */
	public function getGoogleLink(String $callbackUrl) {
	    return ThalamusRequest::post ( '/signin/google?callback_url=' . $callbackUrl )->noAuth ()->execute ()->getResponse ()->link->href;
	}
	
	/**
	 *
	 * @param String $code
	 * @param String $callbackUrl
	 * @throws ThalamusOtherException
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function loginGoogle(String $code, String $callbackUrl) {
	    $response = ThalamusRequest::get ( "/signin/google?code=$code&callback_url=$callbackUrl" )->noAuth ()->execute ();
	    
	    // exito
	    if ($response->getResponse ()->reason == "SuccessfullySignIn") {
	        
	        $this->session->setUser (  str_replace ( ':', '$', $response->getResponse ()->data->principal ) );
	        $this->session->setAccessToken ( str_replace ( ':', '$', $response->getResponse ()->data->tmp_password ) );
	        
	        return $response;
	        
	        // si no esta registrado
	    } else if ($response->getResponse ()->reason == "NotRegistered") {
	        // Retorna exception con mensaje "NotRegistered"
	        throw new ThalamusOtherException ( 'NotRegistered', $response->getResponse (), 200 );
	    }
	    
	    return $response;
	}
	
	/**
	 *
	 * @param String $callbackUrl
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function getLinkAddGoogle(String $callbackUrl = null) {
	    if ($callbackUrl != null) {
	        return ThalamusRequest::post ( "/connect/google?callback_url=$callbackUrl")->execute ();
	    }
	    return ThalamusRequest::post ( "/connect/google")->execute ();
	}
	
	/**
	 *
	 * @param String $code
	 * @param String $callbackUrl
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function addGoogle(String $code, String $callbackUrl) {
	    return ThalamusRequest::get ( "/connect/google?code=$code&callback_url=$callbackUrl")->execute();
	}
	
	/**
	 *
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function deleteGoogleAccount() {
	    return ThalamusRequest::delete ( '/connect/google' )->execute ();
	}
	/**
	 *
	 * @param string $callbackUrl
	 */
	public function getTwitterLink(String $callbackUrl) {
		return ThalamusRequest::post ( '/signin/twitter' )->noAuth ()->execute ()->getResponse ()->link->href;
	}
	
	/**
	 * 
	 * @param String $code
	 * @param String $callbackUrl
	 * @throws ThalamusOtherException
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function loginTwitter(String $code, String $callbackUrl) {
		$response = ThalamusRequest::get ( "/signin/twitter?code=$code&callback_url=$callbackUrl" )->noAuth ()->execute ();
		
		if ($response->getResponse ()->reason == "SuccessfullySignIn") {	
		    
		    $this->session->setUser ( str_replace( ':', '$', $response->getResponse ()->data->principal ) );
			$this->session->setAccessToken ( str_replace ( ':', '$', $response->getResponse ()->data->tmp_password ) );

		} else if ($response->getResponse ()->reason == "NotRegistered") {// si no esta registrado
		    
			throw new ThalamusOtherException ( 'NotRegistered', $response->getResponse (), 200 );
		}
	
		return $response;
	}
	
	/**
	 * 
	 * @param String $callbackUrl
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function getLinkAddTwitter(String $callbackUrl = null) {
		if ($callbackUrl != null) {
			return ThalamusRequest::post ( "/connect/twitter?callback_url=$callbackUrl")->execute ();
		}
		return ThalamusRequest::post ( "/connect/twitter")->execute ();
	}
	
	/**
	 * 
	 * @param String $code
	 * @param String $callbackUrl
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function addTwitter(String $code, String $callbackUrl) {
		return ThalamusRequest::get ( "/connect/twitter?code=$code&callback_url=$callbackUrl")->execute();
	}
	
	/**
	 * 
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function deleteTwitterAccount() {
		return ThalamusRequest::delete ( '/connect/twitter' )->execute ();
	}
	
	/**
	 * 
	 * @param array $profile
	 * @param array $facebookSocialConnection
	 * @param array $optIns
	 * @param array $consumers
	 * @param String automatic (default value) | manual | temporary | pre-validated | pre-registration
	 * @throws ThalamusClientException
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function registerFacebook(Array $profile, Array $facebookSocialConnection, Array $optIns, Array $consumers = array(), String $validation = 'automatic') {
		$params = array (
			'consumers' => $consumers,
			'profile' => $profile,
			'optIns' => $optIns,
			'socialConnections' => array (
                $facebookSocialConnection 
			) 
		);
		
		if (!empty($params['profile']['birthday'] && (\ThalamusSDK\ThalamusHelper::validateDate($params['profile']['birthday']) == false))) {
		    throw new \ThalamusSDK\ThalamusRequestException(
		        'BIRTHDAY_INVALID_FORMAT',
		        array(
		            array (
		                'code' => 1241,
		                'code_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
		                'message_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
		                'error_name' => 'BIRTHDAY_INVALID_FORMAT',
		                'error_description' => 'Birthday invalid format.'
		            )
		        ),  404);
		}
		
		$response = ThalamusRequest::post ( "/person?validation=$validation", $params )->noAuth ()->execute ();
		
		$this->session->setUser ( str_replace( ':', '$', $response->getResponse ()->temporal_credential->principal ) );
		$this->session->setAccessToken ( str_replace ( ':', '$', $response->getResponse ()->temporal_credential->tmp_password ) );
		
		return $response;
	}

	/**
	 * 
	 * @param array $profile
	 * @param array $facebookSocialConnection
	 * @param array $optIns
	 * @param array $consumers
	 * @throws ThalamusClientException
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function updateFacebook(Array $profile, Array $facebookSocialConnection, Array $optIns, Array $consumers = array()) {
        $params = array (
			'consumers' => $consumers,
			'profile' => $profile,
			'optIns' => $optIns,
			'socialConnections' => array (
					$facebookSocialConnection
			)
		);
	    
        if (!empty($params['profile']['birthday'] && (\ThalamusSDK\ThalamusHelper::validateDate($params['profile']['birthday']) == false))) {
            throw new \ThalamusSDK\ThalamusRequestException(
                'BIRTHDAY_INVALID_FORMAT',
                array(
                    array (
                        'code' => 1241,
                        'code_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
                        'message_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
                        'error_name' => 'BIRTHDAY_INVALID_FORMAT',
                        'error_description' => 'Birthday invalid format.'
                    )
                ),  404);
        }
        
		$response = ThalamusRequest::post ( '/person', $params )->execute ();
	
		$this->session->setUser ( str_replace( ':', '$', $response->getResponse ()->temporal_credential->principal ) );
		$this->session->setAccessToken ( str_replace ( ':', '$', $response->getResponse ()->temporal_credential->tmp_password ) );
	
		return $response;
	}
	
	/**
	 *
	 * @param array $profile
	 * @param array $googleSocialConnection
	 * @param array $optIns
	 * @param array $consumers
	 * @throws ThalamusClientException
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function registerGoogle(Array $profile, Array $googleSocialConnection, Array $optIns, Array $consumers = array()) {
	    $params = array (
	        'consumers' => $consumers,
	        'profile' => $profile,
	        'optIns' => $optIns,
	        'socialConnections' => array (
	            $googleSocialConnection
	        )
	    );
	    
	    if (!empty($params['profile']['birthday'] && (\ThalamusSDK\ThalamusHelper::validateDate($params['profile']['birthday']) == false))) {
	        throw new \ThalamusSDK\ThalamusRequestException(
	            'BIRTHDAY_INVALID_FORMAT',
	            array(
	                array (
	                    'code' => 1241,
	                    'code_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
	                    'message_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
	                    'error_name' => 'BIRTHDAY_INVALID_FORMAT',
	                    'error_description' => 'Birthday invalid format.'
	                )
	            ),  404);
	    }
	    
	    $response = ThalamusRequest::post ( '/person', $params )->noAuth ()->execute ();
	    
	    $this->session->setUser ( str_replace( ':', '$', $response->getResponse ()->temporal_credential->principal ) );
	    $this->session->setAccessToken ( str_replace ( ':', '$', $response->getResponse ()->temporal_credential->tmp_password ) );
	    
	    return $response;
	}
	
	/**
	 *
	 * @param array $profile
	 * @param array $googleSocialConnection
	 * @param array $optIns
	 * @param array $consumers
	 * @throws ThalamusClientException
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function updateGoogle(Array $profile, Array $googleSocialConnection, Array $optIns, Array $consumers = array()) {
	    $params = array (
	        'consumers' => $consumers,
	        'profile' => $profile,
	        'optIns' => $optIns,
	        'socialConnections' => array (
	            $googleSocialConnection
	        )
	    );
	    
	    if (!empty($params['profile']['birthday'] && (\ThalamusSDK\ThalamusHelper::validateDate($params['profile']['birthday']) == false))) {
	        throw new \ThalamusSDK\ThalamusRequestException(
	            'BIRTHDAY_INVALID_FORMAT',
	            array(
	                array (
	                    'code' => 1241,
	                    'code_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
	                    'message_thalamus' => 'BIRTHDAY_INVALID_FORMAT',
	                    'error_name' => 'BIRTHDAY_INVALID_FORMAT',
	                    'error_description' => 'Birthday invalid format.'
	                )
	            ),  404);
	    }
	    
	    $response = ThalamusRequest::post ( '/person', $params )->execute ();
	    
	    $this->session->setUser ( str_replace( ':', '$', $response->getResponse ()->temporal_credential->principal ) );
	    $this->session->setAccessToken ( str_replace ( ':', '$', $response->getResponse ()->temporal_credential->tmp_password ) );
	    
	    return $response;
	}
	
	/**
	 * getEvent
	 *
	 * @param string $eventCode        	
	 * @return \ThalamusSDK\Model\Activity\Event\Event
	 */
	public function getEvent(String $eventCode) {
		return $this->getParty ()->getActivity ()->getEvent ( $eventCode );
	}
	
	/**
	 * getSurvey
	 *
	 * @param string $surveyCode        	
	 * @return \ThalamusSDK\Model\Activity\Survey\Survey
	 */
	public function getSurvey(String $surveyCode) {
		return $this->getParty ()->getActivity ()->getSurvey ( $surveyCode );
	}

	/**
	 * 
	 * @param String $mileageCode
	 * @return Mileage
	 */
	public function getMileage(String $mileageCode) {
		return $this->getParty()->getActivity ()->getMileage ( $mileageCode );
	}

	/**
	 * 
	 * @param String $payItForwardCode
	 * @param Int $size
	 * @param Int $page
	 * @return mixed|\ThalamusSDK\ThalamusModel
	 */
	public function getChain(String $payItForwardCode, Int $size = null, Int $page = null) {
		$params = array (
			'size' => $size,
			'page' => $page
		);

		return ThalamusRequest::get ( "/payitfoward/$payItForwardCode/gifts/chain/public" . \ThalamusSDK\ThalamusHelper::paramsToUrl ( $params ) )
								->noAuth ()
								->execute ()
								->getThalamusModel ( \ThalamusSDK\Model\Activity\PayItForward\Chain::classname (), array ('activityCode' => $payItForwardCode) );
	}

	/**
	 * 
	 * @param String $payItForwardCode
	 * @return \ThalamusSDK\Model\Activity\PayItForward\PayItForward
	 */
	public function getPayItForward(String $payItForwardCode) {
		return $this->getParty()->getActivity()->getPayItForward($payItForwardCode);
	}
	
	/**
	 * 
	 * @param Int $activityId
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function activityLogin(Int $activityId) {
		return ThalamusRequest::post ( "/activities/$activityId/login" )->execute ();
	}
	
	/**
	 * Returns test log.
	 * 
	 * @return string
	 */
	public static function test() {
		ThalamusTest::run();
	}
	
	/**
	 * 
	 * @param String $appId
	 * @param String $playerId
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function addPushNotificationPlayerId(String $appId, String $playerId) {
	    
	    $params = array (
	        "playerId" => $playerId
	    );
	    
	    return ThalamusRequest::put( "/communications/push-notifications/$appId/player-id", $params )->execute();
	}
	
	/**
	 * 
	 * @param String $principal
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function requestValidationCode(String $principal) {
	    
	    $params = array(
	        "principal" => str_replace( ':', '$', $principal )
	    );
	    
	    return ThalamusRequest::post( "/person/validationcode", $params)->noAuth()->execute();
	    
	}
	
	/**
	 * 
	 * @param String $principal
	 * @param String $code
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function validateCode(String $principal, String $code) {
	    
	    $params = array(
            "principal" => $principal, 
	        "validationCode" => $code
	    );
	    
	    return ThalamusRequest::put( "/person/validationcode", $params)->noAuth()->execute();
	    
	}
	
	/**
	 *
	 * @param String $email
	 * @param String $name
	 * @param String $tokenTemporal
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function validadorNameVerazArgentina(String $email,String $name,String $tokenTemporal) {
		$params = array(
				'email' => $email,
				'name' => $name,
				'tokenTemporal' => $tokenTemporal
		);
	
		$request =ThalamusRequest::post('/person/validadorVerazArgentina', $params);
	
		return $request->auth($email,$tokenTemporal)->execute();
	}
	
	public function validadorBirthdateVerazArgentina(String $email,String $birthdate,String $tokenTemporal) {
		$params = array(
				'email' => $email,
				'birthdate' => $birthdate,
				'tokenTemporal' => $tokenTemporal
		);
	
		$request =ThalamusRequest::post('/person/validadorVerazArgentina', $params);
	
		return $request->auth($email,$tokenTemporal)->execute();
	}
	
}