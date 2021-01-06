<?php

namespace ThalamusSDK;

/**
 * Class ThalamusRequestException
 *
 * @package ThalamusSDK
 */
class ThalamusRequestException extends ThalamusSDKException {
	
	/**
	 *
	 * @var $errors Array
	 */
	private $errors = array ();
	
	/**
	 *
	 * @var int Status code for the response causing the exception
	 */
	private $httpCode;
	
	/**
	 *
	 * @var string Raw response
	 */
	private $rawResponse;
	
	/**
	 *
	 * @var array Decoded response
	 */
	private $responseData;
	
	/**
	 * Creates a ThalamusRequestException.
	 *
	 * @param string $rawResponse
	 *        	The raw response from the Graph API
	 * @param array $responseData
	 *        	The decoded response from the Graph API
	 * @param int $statusCode        	
	 */
	public function __construct($rawResponse, $responseData, $httpCode) {
		$this->rawResponse = $rawResponse;
		$this->httpCode = $httpCode;
		$this->responseData = ($httpCode < 400) ? self::convertToArray ( $responseData ) : $responseData;
		parent::__construct ( $this->get ( 'error_name', $rawResponse ), $this->get ( 'code', $httpCode ), null );
	}
	
	/**
	 * Process an error payload from the Graph API and return the appropriate
	 * exception subclass.
	 *
	 * @param string $raw
	 *        	the raw response from the Graph API
	 * @param array $data
	 *        	the decoded response from the Graph API (array)
	 * @param int $statusCode
	 *        	the HTTP response code
	 * @return ThalamusRequestException
	 */
	public static function create($raw, $data, $httpCode) {
		
		// Errors API v3 => API v4
		$d = self::convertToThalamusErrorArray ( $data );
		
		// TOMCAT SERVER ERROR
		if (strpos ( $raw, 'Tomcat' )) {
			$data = array (
					array (
							'code' => 4001,
							'code_thalamus' => 'TOMCAT_SERVER_ERROR',
							'message_thalamus' => 'TOMCAT_SERVER_ERROR',
							'error_name' => 'TOMCAT_SERVER_ERROR',
							'error_description' => 'Tomcat server error.' 
					) 
			);
			return new ThalamusServerException ( strip_tags ( $raw ), $data, $httpCode );
		}

		switch ($httpCode) {
			case 400 :
			case 403 :
			case 404 :
			case 405 :
				return new ThalamusClientException ( $raw, $d, $httpCode );
				break;
			case 401 :
				return new ThalamusAuthorizationException ( $raw, $d, $httpCode );
				break;
			// Server issue, possible downtime
			case 500 :
			case 501 :
			case 502 :
			case 503 :
			case 504 :
			case 505 :
				$data = array (
						array (
								'code' => 999,
								'code_thalamus' => 'SERVER_ERROR',
								'message_thalamus' => 'SERVER_ERROR',
								'error_name' => 'SERVER_ERROR',
								'error_description' => 'Server error.' 
						) 
				);
				return new ThalamusServerException ( 'SERVER_ERROR', $data, $httpCode );
				break;
			// All others
			default :
				return new ThalamusOtherException ( $raw, $d, $httpCode );
		}
	}
	
	/**
	 * Checks isset and returns that or a default value.
	 *
	 * @param string $key        	
	 * @param mixed $default        	
	 *
	 * @return mixed
	 */
	private function get($key, $default = null) {
		if (isset ( $this->responseData [$key] )) {
			return $this->responseData [$key];
		} else if (isset ( $this->responseData [0] [$key] )) {
			return $this->responseData [0] [$key];
		}
		return $default;
	}
	
	/**
	 * Returns the HTTP status code
	 *
	 * @return int
	 */
	public function getHttpStatusCode() {
		return $this->statusCode;
	}
	
	/**
	 * Returns the sub-error code
	 *
	 * @return int
	 */
	public function getSubErrorCode() {
		return $this->get ( 'error_subcode', - 1 );
	}
	
	/**
	 * Returns the error type
	 *
	 * @return string
	 */
	public function getErrorType() {
		return $this->get ( 'type', '' );
	}
	
	/**
	 * Returns the raw response used to create the exception.
	 *
	 * @return string
	 */
	public function getRawResponse() {
		return $this->rawResponse;
	}
	
	/**
	 * Returns the decoded response used to create the exception.
	 *
	 * @return array
	 */
	public function getResponse($key = null) {
		if ($key != null) {
			return isset ( $this->responseData [$key] ) ? $this->responseData [$key] : null;
		}
		return $this->responseData;
	}
	
	/**
	 */
	public function getErrors() {
		return $this->getResponse ();
	}
	
	/**
	 * Converts a stdClass object to an array
	 *
	 * @param mixed $object        	
	 *
	 * @return array
	 */
	private static function convertToThalamusErrorArray($object) {
		if ($object instanceof \stdClass) {
			
			$data = get_object_vars ( $object );
			
			$err = array ();
			
			// convert to API v4 errors
			foreach ( $data as $code => $message ) {
				$r = ThalamusErrors::getErrorNameAndDescription ( $code, $message );
				
				$err [] = array (
						'code' => $r [0],
						'code_thalamus' => $code,
						'message_thalamus' => $message,
						'error_name' => $r [1],
						'error_description' => $r [2] 
				);
			}
			
			return ! empty ( $err ) ? $err : $data;
		}
		return $object;
	}
	
	/**
	 * Converts a stdClass object to an array
	 *
	 * @param mixed $object        	
	 *
	 * @return array
	 */
	private static function convertToArray($object) {
		if ($object instanceof \stdClass) {
			return get_object_vars ( $object );
		}
		return $object;
	}
}