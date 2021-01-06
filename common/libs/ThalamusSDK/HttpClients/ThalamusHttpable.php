<?php

namespace ThalamusSDK\HttpClients;

/**
 * Interface ThalamusHttpable
 *
 * @package Thalamus
 */
interface ThalamusHttpable {
	
	/**
	 * The headers we want to send with the request
	 *
	 * @param string $key        	
	 * @param string $value        	
	 */
	public function addRequestHeader(String $key, String $value);
	
	/**
	 * The BASIC AUTH User and Pass we want to send with the request
	 *
	 * @param string $user        	
	 * @param string $pwd        	
	 */
	public function setBasicAuthHeader(String $user, String $pwd);
	
	/**
	 *
	 */
	public function sendFile();
	
	/**
	 * The headers returned in the response
	 *
	 * @return array
	 */
	public function getResponseHeaders();
	
	/**
	 * The HTTP status response code
	 *
	 * @return int
	 */
	public function getResponseHttpStatusCode();
	
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
	public function send(String $url, String $method = 'GET', Array $parameters = array());
	
	/**
	 * 
	 * @param String $url
	 * @param String $method
	 * @param array $parameters
	 */
	public function getConnection(String $url, String $method = 'GET', Array $parameters = array());
}
