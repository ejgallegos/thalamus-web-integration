<?php

namespace ThalamusSDK;

use \ThalamusSDK\HttpClients\ThalamusHttpable;
use \ThalamusSDK\HttpClients\ThalamusCurlHttpClient;
use \ThalamusSDK\Entities\Mime;

/**
 * Class ThalamusMultiRequest
 *
 * @package ThalamusSDK
 * @version 2.0.1
 */
class ThalamusMultiRequest {
	
	/**
	 *
	 * @var $mh
	 */
	private $mh;
	
	/**
	 *
	 * @var $chs
	 */
	private $chs = array ();
	
	/**
	 */
	public function __construct() {
		$this->mh = curl_multi_init ();
	}
	
	/**
	 *
	 * @param ThalamusRequest $request        	
	 * @param string $responseType        	
	 * @param string $path        	
	 */
	public function addRequest(ThalamusRequest $request, $responseType = null, $path = null) {
		$ch = $request->buildConnection ();
		$this->chs [] = array (
				'ch' => $ch,
				'responseType' => $responseType,
				'path' => $path 
		);
		curl_multi_add_handle ( $this->mh, $ch );
	}
	
	/**
	 *
	 * @return \ThalamusSDK\ThalamusResponse
	 */
	public function execute() {
		do {
			
			curl_multi_exec ( $this->mh, $running );
			curl_multi_select ( $this->mh );
		} while ( $running > 0 );
		
		// Extract the content
		foreach ( $this->chs as $i => $arrCh ) {
			
			$thalamusCurl = new \ThalamusSDK\HttpClients\ThalamusCurl ( $arrCh ['ch'] );
			$r = new \ThalamusSDK\HttpClients\ThalamusCurlHttpClient ( $thalamusCurl );
			$result = $r->process ( curl_multi_getcontent ( $arrCh ['ch'] ) );
			
			$etagHit = 304 == $r->getResponseHttpStatusCode ();
			
			$headers = $r->getResponseHeaders ();
			$etagReceived = isset ( $headers ['ETag'] ) ? $headers ['ETag'] : null;
			
			$decodedResult = json_decode ( $result );
			
			if (isset ( $decodedResult->errors )) {
				throw ThalamusRequestException::create ( $result, $decodedResult->errors, $r->getResponseHttpStatusCode () );
				// $responses[$i] = ThalamusRequestException::create ( $result, $decodedResult->errors, $r->getResponseHttpStatusCode () );
				continue;
			}
			
			if ($r->getResponseHttpStatusCode () >= 400) {
				throw ThalamusRequestException::create ( $result, $decodedResult, $r->getResponseHttpStatusCode () );
				// $responses[$i] = ThalamusRequestException::create ( $result, $decodedResult, $r->getResponseHttpStatusCode () );
				continue;
			}
			
			$response = new ThalamusResponse ( $this, $decodedResult, $result, $r->getResponseHttpStatusCode (), $etagHit, $etagReceived );
			
			// if object array
			if ($arrCh ['path'] !== null and $arrCh ['responseType'] !== null) {
				$responses [$i] = $response->getThalamusModelList ( $arrCh ['responseType'], $arrCh ['path'] );
				// if object
			} else if ($arrCh ['responseType'] !== null) {
				$responses [$i] = $response->getThalamusModel ( $arrCh ['responseType'] );
			} else {
				$responses [$i] = $response;
			}
			
			// Remove and close the handle
			if (is_resource($arrCh['ch'])) 
                curl_multi_remove_handle ( $this->mh, $arrCh ['ch'] );
		}
		
		curl_multi_close ( $this->mh );
		
		return $responses;
	}
}