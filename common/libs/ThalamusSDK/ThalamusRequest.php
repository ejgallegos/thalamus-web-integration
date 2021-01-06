<?php

namespace ThalamusSDK;

use \ThalamusSDK\HttpClients\ThalamusHttpable;
use \ThalamusSDK\HttpClients\ThalamusCurlHttpClient;
use \ThalamusSDK\Entities\Mime;

/**
 * Class ThalamusRequest
 *
 * @package ThalamusSDK
 * @version 2.0.1
 */
class ThalamusRequest {
	/**
	 * @const string Version number of the Thalamus PHP SDK.
	 */
	const VERSION = 'v2.0.1';
	
	/**
	 *
	 * @var string The HTTP method for the request
	 */
	private $method;
	
	/**
	 *
	 * @var string The path for the request
	 */
	private $path;
	
	/**
	 *
	 * @var array The parameters for the request
	 */
	private $params;
	
	/**
	 *
	 * @var ThalamusHttpable HTTP client handler
	 */
	private static $httpClientHandler;
	
	/**
	 *
	 * @var string Basic Auth User
	 */
	private $basicAuthUser = '';
	
	/**
	 *
	 * @var string Basic Auth Password
	 */
	private $basicAuthPass = '';
	
	/**
	 *
	 * @var string $tags
	 */
	private $tags;
	
	/**
	 *
	 * @var string $source
	 */
	public $source;
	
	/**
	 *
	 * @var string ETag sent with the request
	 */
	private $etag;
	
	/**
	 * 
	 */
	private $sendFile = false;
	
	/**
	 *
	 * @var int The number of calls that have been made to API.
	 */
	public static $requestCount = 0;
	
	/**
	 *
	 * @return String Basic Auth User
	 */
	public function getBasicAuthUser() {
		return $this->basicAuthUser;
	}
	
	/**
	 *
	 * @return String Basic Auth Password
	 */
	public function getBasicAuthPassword() {
		return $this->basicAuthPass;
	}
	
	/**
	 * setTags
	 *
	 * @var string $tags
	 */
	public function setTags($tags) {
		$this->tags = $tags;
		return $this;
	}
	
	/**
	 * setSource
	 *
	 * @var string $source
	 */
	public function setSource($source) {
		$this->source = $source;
		return $this;
	}
	
	/**
	 * authenticateWith sets Basic Auth User and Password
	 *
	 * @var $user string
	 * @var $pass string (optional), empty by default
	 * @return ThalamusRequest object
	 */
	public function auth($user, $pass = "") {
		$this->basicAuthUser = $user;
		$this->basicAuthPass = $pass;
		return $this;
	}
	
	/**
	 * Request without Basic Auth authentication
	 *
	 * @return \ThalamusSDK\ThalamusRequest
	 */
	public function noAuth() {
		$this->basicAuthUser = '';
		$this->basicAuthPass = '';
		return $this;
	}
	
	/**
	 * Request without tags
	 *
	 * @return \ThalamusSDK\ThalamusRequest
	 */
	public function noTags() {
		unset ( $this->tags );
		return $this;
	}
	
	/**
	 * Request without source
	 *
	 * @return \ThalamusSDK\ThalamusRequest
	 */
	public function noSource() {
		unset ( $this->source );
		return $this;
	}
	
	/**
	 * hasBasicAuth checks if the request has basic auth
	 *
	 * @return boolean
	 */
	public function hasBasicAuth() {
		return ($this->basicAuthUser != "") ? true : false;
	}
	
	/**
	 * getPath - Returns the associated path.
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}
	
	/**
	 * getParameters - Returns the associated parameters.
	 *
	 * @return array
	 */
	public function getParameters() {
		return $this->params;
	}
	
	/**
	 * getMethod - Returns the associated method.
	 *
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}
	
	/**
	 * getETag - Returns the ETag sent with the request.
	 *
	 * @return string
	 */
	public function getETag() {
		return $this->etag;
	}
	
	/**
	 * setHttpClientHandler - Returns an instance of the HTTP client
	 * handler
	 *
	 * @param
	 *        	\ThalamusSDK\HttpClients\ThalamusHttpable
	 */
	public static function setHttpClientHandler(ThalamusHttpable $handler) {
		static::$httpClientHandler = $handler;
	}
	
	/**
	 * getHttpClientHandler - Returns an instance of the HTTP client
	 * data handler
	 *
	 * @return ThalamusHttpable
	 */
	public static function getHttpClientHandler() {
		if (static::$httpClientHandler) {
			return static::$httpClientHandler;
		}
		return function_exists ( 'curl_init' ) ? new ThalamusCurlHttpClient () : null;
	}
	
	/**
	 * ThalamusRequest - Returns a new request using the given params
	 * parameters hash will be sent with the request.
	 * This object is
	 * immutable.
	 *
	 * @param ThalamusSession $session        	
	 * @param string $method        	
	 * @param string $path        	
	 * @param array|null $parameters        	
	 */
	public function __construct($method, $path, $parameters = null) {
		$this->method = $method;
		$this->path = $path;
		$this->params = ($parameters ?  : array ());
		
		$session = ThalamusSession::getSession ();
		
		$this->auth ( $session->getUser (), $session->getAccessToken () );
		$this->setTags ( $session->getTags () );
		$this->setSource ( $session->getSource () );
	}
	
	/**
	 * Returns the URL.
	 *
	 * @return string
	 */
	protected function getRequestURL() {
		return $this->path;
	}
	
	/**
	 * execute - Makes the request to Thalamus and returns the result.
	 *
	 * @return ThalamusResponse
	 *
	 * @throws ThalamusSDKException
	 * @throws ThalamusRequestException
	 */
	public function execute() {
		$url = $this->getRequestURL ();
		$params = $this->getParameters ();
		
		$connection = self::getHttpClientHandler ();
		$connection->addRequestHeader ( 'User-Agent', 'thalamus-sdk-php-' . self::VERSION );
		$connection->addRequestHeader ( 'Accept-Encoding', '*' ); // Support all available encodings.
		                                                          
		// ETag
		if (isset ( $this->etag )) {
			$connection->addRequestHeader ( 'If-None-Match', $this->etag );
		}
		
		// Tags
		if (isset ( $this->tags )) {
			$connection->addRequestHeader ( 'Thalamus-Tags', $this->tags );
		}
		
		// Source
		if (isset ( $this->source )) {
			$connection->addRequestHeader ( 'Thalamus-Source', $this->source );
		}
		
		// BasicAuth
		if ($this->hasBasicAuth ()) {
			$connection->setBasicAuthHeader ( $this->getBasicAuthUser (), $this->getBasicAuthPassword () );
		}
		
		if ($this->method === "GET") {
			$url = self::appendParamsToUrl ( $url, $params );
			$params = array ();
		} else {
			
			if (!$this->sendFile) {
				$connection->addRequestHeader ( 'Content-Type', Mime::getFullMime ( Mime::JSON ) );
				$connection->addRequestHeader ( 'Content-Length', strlen ( json_encode ( $params ) ) );
			} else {
				$connection->sendFile();
			}
		}
		// Should throw `ThalamusSDKException` exception on HTTP client error.
		// Don't catch to allow it to bubble up.
		
		//var_dump($url, $this->method, $params);
		//echo json_encode($params);
		$result = $connection->send ( $url, $this->method, $params );
		
		static::$requestCount ++;
		
		$etagHit = 304 == $connection->getResponseHttpStatusCode ();
		
		$headers = $connection->getResponseHeaders ();
		$etagReceived = isset ( $headers ['ETag'] ) ? $headers ['ETag'] : null;
		
		if ($result == "true" || $result == "false") {
			$decodedResult = null;
		}else {
			$decodedResult = json_decode ( $result );
		}		
		
		if (isset ( $decodedResult->errors )) {
			throw ThalamusRequestException::create ( $result, $decodedResult->errors, $connection->getResponseHttpStatusCode () );
		}
		
		if ($connection->getResponseHttpStatusCode () >= 400) {
			throw ThalamusRequestException::create ( $result, $decodedResult, $connection->getResponseHttpStatusCode () );
		}
		
		return new ThalamusResponse ( $this, $decodedResult, $result, $connection->getResponseHttpStatusCode (), $etagHit, $etagReceived, $headers );
		
	}
	
	/**
	 * appendParamsToUrl - Gracefully appends params to the URL.
	 *
	 * @param string $url        	
	 * @param array $params        	
	 *
	 * @return string
	 */
	public static function appendParamsToUrl($url, $params = array()) {
		if (! $params) {
			return $url;
		}
		
		if (strpos ( $url, '?' ) === false) {
			return $url . '?' . http_build_query ( $params, null, '&' );
		}
		
		list ( $path, $query_string ) = explode ( '?', $url, 2 );
		parse_str ( $query_string, $query_array );
		
		// Favor params from the original URL over $params
		$params = array_merge ( $params, $query_array );
		
		return $path . '?' . http_build_query ( $params, null, '&' );
	}
	
	/**
	 * Create a new ThalamusRequest object w/ POST as request method
	 *
	 * @param string $path        	
	 * @param array $parameters        	
	 * @return \ThalamusSDK\ThalamusRequest
	 */
	public static function post($path, $parameters = null) {
		return new ThalamusRequest ( 'POST', ThalamusHelper::getFullPath ( $path ), $parameters );
	}
	
	/**
	 * Create a new ThalamusRequest object w/ GET as request method
	 *
	 * @param string $path        	
	 * @param array $parameters        	
	 * @return \ThalamusSDK\ThalamusRequest
	 */
	public static function get($path, $parameters = null) {
		return new ThalamusRequest ( 'GET', ThalamusHelper::getFullPath ( $path ), $parameters );
	}
	
	/**
	 * Create a new ThalamusRequest object w/ PUT as request method
	 *
	 * @param string $path        	
	 * @param array $parameters        	
	 * @return \ThalamusSDK\ThalamusRequest
	 */
	public static function put($path, $parameters = null) {
		return new ThalamusRequest ( 'PUT', ThalamusHelper::getFullPath ( $path ), $parameters );
	}
	
	/**
	 * Create a new ThalamusRequest object w/ DELETE as request method
	 *
	 * @param string $path        	
	 * @param array $parameters        	
	 * @return \ThalamusSDK\ThalamusRequest
	 */
	public static function delete($path, $parameters = null) {
		return new ThalamusRequest ( 'DELETE', ThalamusHelper::getFullPath ( $path ), $parameters );
	}
	
	/**
	 * 
	 * @return object Curl connection
	 */
	public function buildConnection() {
		$url = $this->getRequestURL ();
		$params = $this->getParameters ();
		
		$connection = self::getHttpClientHandler ();
		$connection->addRequestHeader ( 'User-Agent', 'thalamus-sdk-php-' . self::VERSION );
		$connection->addRequestHeader ( 'Accept-Encoding', '*' ); // Support all available encodings.
		                                                          
		// ETag
		if (isset ( $this->etag )) {
			$connection->addRequestHeader ( 'If-None-Match', $this->etag );
		}
		
		// Tags
		if (isset ( $this->tags )) {
			$connection->addRequestHeader ( 'Thalamus-Tags', $this->tags );
		}
		
		// Source
		if (isset ( $this->source )) {
			$connection->addRequestHeader ( 'Thalamus-Source', $this->source );
		}
		
		// BasicAuth
		if ($this->hasBasicAuth ()) {
			$connection->setBasicAuthHeader ( $this->getBasicAuthUser (), $this->getBasicAuthPassword () );
		}
		
		if ($this->method === "GET") {
			$url = self::appendParamsToUrl ( $url, $params );
			$params = array ();
		} else {
			
			if (!$this->sendFile) {
				$connection->addRequestHeader ( 'Content-Type', Mime::getFullMime ( Mime::JSON ) );
				$connection->addRequestHeader ( 'Content-Length', strlen ( json_encode ( $params ) ) );
			} else {
				$connection->sendFile();
			}
		}
		// Should throw `ThalamusSDKException` exception on HTTP client error.
		// Don't catch to allow it to bubble up.
		
		return $connection->getConnection ( $url, $this->method, $params );
	}
	
	/**
	 * 
	 * @return \ThalamusSDK\ThalamusRequest
	 */
	public function sendFile() {
		$this->sendFile = true;
		return $this;
	}
}