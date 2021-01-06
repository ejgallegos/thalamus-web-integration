<?php

namespace ThalamusSDK\HttpClients;

use \ThalamusSDK\ThalamusSDKException;

/**
 * Class ThalamusCurlHttpClient
 *
 * @package Thalamus
 */
class ThalamusCurlHttpClient implements ThalamusHttpable {
	
	/**
	 *
	 * @var string The Basic Auth User
	 */
	protected $basicAuthUser = '';
	
	/**
	 *
	 * @var string The Basic Auth Pwd
	 */
	protected $basicAuthPwd = '';
	
	/**
	 *
	 * @var array The headers to be sent with the request
	 */
	protected $requestHeaders = array ();
	
	/**
	 *
	 * @var array The headers received from the response
	 */
	protected $responseHeaders = array ();
	
	/**
	 *
	 * @var int The HTTP status code returned from the server
	 */
	protected $responseHttpStatusCode = 0;
	
	/**
	 *
	 * @var string The client error message
	 */
	protected $curlErrorMessage = '';
	
	/**
	 *
	 * @var int The curl client error code
	 */
	protected $curlErrorCode = 0;
	
	/**
	 *
	 * @var string|boolean The raw response from the server
	 */
	protected $rawResponse;
	
	/**
	 *
	 * @var boolean
	 */
	protected $sendFile = false;
	
	/**
	 *
	 * @var ThalamusCurl Procedural curl as object
	 */
	protected static $thalamusCurl;
	
	/**
	 *
	 * @var boolean If IPv6 should be disabled
	 */
	protected static $disableIPv6;
	
	/**
	 * @const Curl Version which is unaffected by the proxy header length error.
	 */
	const CURL_PROXY_QUIRK_VER = 0x071E00;
	
	/**
	 * @const "Connection Established" header text
	 */
	const CONNECTION_ESTABLISHED = "HTTP/1.0 200 Connection established\r\n\r\n";
	
	/**
	 *
	 * @param
	 *        	ThalamusCurl|null Procedural curl as object
	 */
	public function __construct(ThalamusCurl $thalamusCurl = null) {
		self::$thalamusCurl = $thalamusCurl ?  : new ThalamusCurl ();
		self::$disableIPv6 = self::$disableIPv6 ?  : false;
	}
	
	/**
	 * Disable IPv6 resolution
	 */
	public function disableIPv6() {
		self::$disableIPv6 = true;
	}
	
	/**
	 * The headers we want to send with the request
	 *
	 * @param string $key        	
	 * @param string $value        	
	 */
	public function addRequestHeader(String $key, String $value) {
		$this->requestHeaders [$key] = $value;
	}
	
	/**
	 * The BASIC AUTH User and Pass we want to send with the request
	 *
	 * @param string $user        	
	 * @param string $pwd        	
	 */
	public function setBasicAuthHeader(String $user, String $pwd) {
		$this->basicAuthUser = $user;
		$this->basicAuthPwd = $pwd;
	}
	
	/**
	 * The Basic Auth credentials
	 *
	 * @return string
	 */
	public function getBasicAuth() {
		return $this->basicAuthUser . ":" . $this->basicAuthPwd;
	}
	
	/**
	 * The headers returned in the response
	 *
	 * @return array
	 */
	public function getResponseHeaders() {
		return $this->responseHeaders;
	}
	
	/**
	 * The HTTP status response code
	 *
	 * @return int
	 */
	public function getResponseHttpStatusCode() {
		return $this->responseHttpStatusCode;
	}
	
	/**
	 * Sends a request to the server
	 *
	 * @param string $url
	 *        	The endpoint to send the request to
	 * @param string $method
	 *        	The request method
	 * @param array $parameters
	 *        	The key value pairs to be sent in the body
	 *        	
	 * @return string Raw response from the server
	 *        
	 * @throws \ThalamusSDK\ThalamusSDKException
	 */
	public function send(String $url, String $method = 'GET', Array $parameters = array()) {
		$this->openConnection ( $url, $method, $parameters );
		$this->tryToSendRequest ();
		
		if ($this->curlErrorCode) {
			throw new ThalamusSDKException ( $this->curlErrorMessage, $this->curlErrorCode );
		}
		
		// Separate the raw headers from the raw body
		list ( $rawHeaders, $rawBody ) = $this->extractResponseHeadersAndBody ();
		
		$this->responseHeaders = self::headersToArray ( $rawHeaders );
		
		$this->closeConnection ();
		
		return $rawBody;
	}
	
	/**
	 * Opens a new curl connection
	 *
	 * @param string $url
	 *        	The endpoint to send the request to
	 * @param string $method
	 *        	The request method
	 * @param array $parameters
	 *        	The key value pairs to be sent in the body
	 */
	public function openConnection(String $url, String $method = 'GET', Array $parameters = array()) {
		$options = array (
				CURLOPT_VERBOSE => true,
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_FOLLOWLOCATION => 0,
				CURLOPT_CONNECTTIMEOUT => 10,
				CURLOPT_TIMEOUT => 60,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HEADER => true 
		);
		
		if ($method !== "GET") {
			$options [CURLOPT_POST] = true;
			
			if ( !$this->sendFile ) {
				$parameters = json_encode ( $parameters );
			}
			
			$options [CURLOPT_POSTFIELDS] = $parameters;
		}
		if ($method === 'DELETE' || $method === 'PUT') {
			$options [CURLOPT_CUSTOMREQUEST] = $method;
		}
		
		if (! empty ( $this->requestHeaders )) {
			$options [CURLOPT_HTTPHEADER] = $this->compileRequestHeaders ();
		}
		
		if (! empty ( $this->basicAuthUser )) {
			$options [CURLOPT_USERPWD] = $this->getBasicAuth ();
		}
		
		if (self::$disableIPv6) {
			$options [CURLOPT_IPRESOLVE] = CURL_IPRESOLVE_V4;
		}
		
		self::$thalamusCurl->init ();
		self::$thalamusCurl->setopt_array ( $options );
	}
	
	/**
	 * Closes an existing curl connection
	 */
	public function closeConnection() {
		self::$thalamusCurl->close ();
	}
	
	/**
	 * Try to send the request
	 */
	public function tryToSendRequest() {
		$this->sendRequest ();
		$this->curlErrorMessage = self::$thalamusCurl->error ();
		$this->curlErrorCode = self::$thalamusCurl->errno ();
		$this->responseHttpStatusCode = self::$thalamusCurl->getinfo ( CURLINFO_HTTP_CODE );
	}
	
	/**
	 * Send the request and get the raw response from curl
	 */
	public function sendRequest() {
		$this->rawResponse = self::$thalamusCurl->exec ();
	}
	
	/**
	 * Compiles the request headers into a curl-friendly format
	 *
	 * @return array
	 */
	public function compileRequestHeaders() {
		$return = array ();
		
		foreach ( $this->requestHeaders as $key => $value ) {
			$return [] = $key . ': ' . $value;
		}
		
		return $return;
	}
	
	/**
	 * Extracts the headers and the body into a two-part array
	 *
	 * @return array
	 */
	public function extractResponseHeadersAndBody() {
		$headerSize = self::getHeaderSize ();
		
		$rawHeaders = mb_substr ( $this->rawResponse, 0, $headerSize );
		$rawBody = mb_substr ( $this->rawResponse, $headerSize );
		
		return array (
				trim ( $rawHeaders ),
				trim ( $rawBody ) 
		);
	}
	
	/**
	 * Converts raw header responses into an array
	 *
	 * @param string $rawHeaders        	
	 *
	 * @return array
	 */
	public static function headersToArray(String $rawHeaders) {
		$headers = array ();
		
		// Normalize line breaks
		$rawHeaders = str_replace ( "\r\n", "\n", $rawHeaders );
		
		// There will be multiple headers if a 301 was followed
		// or a proxy was followed, etc
		$headerCollection = explode ( "\n\n", trim ( $rawHeaders ) );
		// We just want the last response (at the end)
		$rawHeader = array_pop ( $headerCollection );
		
		$headerComponents = explode ( "\n", $rawHeader );
		foreach ( $headerComponents as $line ) {
			if (strpos ( $line, ': ' ) === false) {
				$headers ['http_code'] = $line;
			} else {
				list ( $key, $value ) = explode ( ': ', $line );
				$headers [$key] = $value;
			}
		}
		
		return $headers;
	}
	
	/**
	 * Return proper header size
	 *
	 * @return integer
	 */
	private function getHeaderSize() {
		$headerSize = self::$thalamusCurl->getinfo ( CURLINFO_HEADER_SIZE );
		// This corrects a Curl bug where header size does not account
		// for additional Proxy headers.
		if (self::needsCurlProxyFix ()) {
			// Additional way to calculate the request body size.
			if (preg_match ( '/Content-Length: (\d+)/', $this->rawResponse, $m )) {
				$headerSize = mb_strlen ( $this->rawResponse ) - $m [1];
			} elseif (stripos ( $this->rawResponse, self::CONNECTION_ESTABLISHED ) !== false) {
				$headerSize += mb_strlen ( self::CONNECTION_ESTABLISHED );
			}
		}
		
		return $headerSize;
	}
	
	/**
	 * Detect versions of Curl which report incorrect header lengths when
	 * using Proxies.
	 *
	 * @return boolean
	 */
	private static function needsCurlProxyFix() {
		$ver = self::$thalamusCurl->version ();
		$version = $ver ['version_number'];
		
		return $version < self::CURL_PROXY_QUIRK_VER;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \ThalamusSDK\HttpClients\ThalamusHttpable::getConnection()
	 */
	public function getConnection(String $url, String $method = 'GET', Array $parameters = array()) {
		$this->openConnection ( $url, $method, $parameters );
		return self::$thalamusCurl->getCh ();
	}
	
	/**
	 * 
	 * @param String $response
	 * @throws ThalamusSDKException
	 * @return array|string[]
	 */
	public function process(String $response) {
		$this->rawResponse = $response;
		$this->curlErrorMessage = self::$thalamusCurl->error ();
		$this->curlErrorCode = self::$thalamusCurl->errno ();
		$this->responseHttpStatusCode = self::$thalamusCurl->getinfo ( CURLINFO_HTTP_CODE );
		
		if ($this->curlErrorCode) {
			throw new ThalamusSDKException ( $this->curlErrorMessage, $this->curlErrorCode );
		}
		
		// Separate the raw headers from the raw body
		list ( $rawHeaders, $rawBody ) = $this->extractResponseHeadersAndBody ();
		
		$this->responseHeaders = self::headersToArray ( $rawHeaders );
		
		$this->closeConnection ();
		
		return $rawBody;
	}
	
	public function sendFile() {
		$this->sendFile = true;
	}
}
