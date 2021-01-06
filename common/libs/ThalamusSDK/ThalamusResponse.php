<?php

namespace ThalamusSDK;

use \ThalamusSDK\ThalamusModel;

/**
 * Class ThalamusResponse
 *
 * @package ThalamusSDK
 */
class ThalamusResponse {
	
	/**
	 *
	 * @var ThalamusRequest The request which produced this response
	 */
	private $request;
	
	/**
	 *
	 * @var array The decoded response from the Thalamus API
	 */
	private $responseData;
	
	/**
	 *
	 * @var string The raw response from the Thalamus API
	 */
	private $rawResponse;
	
	/**
	 *
	 * @var int Http Code
	 */
	private $httpCode;
	
	/**
	 *
	 * @var bool Indicates whether sent ETag matched the one on the FB side
	 */
	private $etagHit;
	
	/**
	 *
	 * @var string ETag received with the response. `null` in case of ETag hit.
	 */
	private $etag;
	
	/**
	 * @var $headers
	 */
	private $headers;
	
	/**
	 * Creates a ThalamusResponse object for a given request and response.
	 *
	 * @param ThalamusRequest $request
	 * @param \stdClass $responseData
	 * @param String $rawResponse
	 * @param Int $httpCode
	 * @param Bool $etagHit
	 * @param String $etag
	 * @param array $headers
	 */
	public function __construct(ThalamusRequest $request, \stdClass $responseData = null, String $rawResponse, Int $httpCode, Bool $etagHit = null, String $etag = null, Array $headers = array()) {
	    $this->request = $request;
		$this->responseData = $responseData;
		$this->rawResponse = $rawResponse;
		$this->httpCode = $httpCode;
		$this->etagHit = $etagHit;
		$this->etag = $etag;
		$this->headers = $headers;
	}
	
	/**
	 * Returns the request which produced this response.
	 *
	 * @return ThalamusRequest
	 */
	public function getRequest() {
		return $this->request;
	}
	
	/**
	 * 
	 * @param String $idx
	 * @return string
	 */
	public function getHeaders(String $idx = null) {
		return isset($this->headers[$idx]) ? $this->headers[$idx] : $this->headers;
	}
	
	/**
	 * Returns the decoded response data.
	 *
	 * @return array
	 */
	public function getResponse() {
		return $this->responseData;
	}
	
	/**
	 * Returns the raw response
	 *
	 * @return string
	 */
	public function getRawResponse() {
		return $this->rawResponse;
	}
	
	/**
	 * Returns the Http Code
	 *
	 * @return integer
	 */
	public function getHttpCode() {
		return $this->httpCode;
	}
	
	/**
	 * Returns true if ETag matched the one sent with a request
	 *
	 * @return bool
	 */
	public function isETagHit() {
		return $this->etagHit;
	}
	
	/**
	 * Returns the ETag
	 *
	 * @return string
	 */
	public function getETag() {
		return $this->etag;
	}
	
	/**
	 * Gets the result as a ThalamusModel.
	 * If a type is specified, returns the
	 * strongly-typed subclass of ThalamusModel for the data.
	 * 
	 * @param String $type
	 * @param array $additionalProperties
	 * @return \ThalamusSDK\ThalamusModel
	 */
	public function getThalamusModel(String $type = 'ThalamusSDK\ThalamusModel', Array $additionalProperties = array()) {
		// fix cabeza hasta que se defina la respuesta de Thalamus
		$responseData = $this->responseData;
		$data = "";
		switch ($type) {
			case 'ThalamusSDK\Model\Party\Person' :
				if (isset ( $responseData->person )) {
					$data = $responseData->person;
					if (isset ( $responseData->context->activities )) {
						$data->activities = $responseData->context->activities;
					}
				}
				break;
			case 'ThalamusSDK\Model\Party\Company' :
				if (isset ( $responseData->company )) {
					$data = $responseData->company;
					if (isset ( $responseData->context->activities )) {
						$data->activities = $responseData->context->activities;
					}
				}
				break;
			case 'ThalamusSDK\Model\Party\PhysicalLocation' :
				if (isset ( $responseData->physical_location )) {
					$data = $responseData->physical_location;
					if (isset ( $responseData->context->activities )) {
						$data->activities = $responseData->context->activities;
					}
				}
				break;
			case 'ThalamusSDK\Model\Activity' :
				if (isset ( $responseData->context->activities )) {
					$data = $responseData->context->activities;
				}
				break;
			case 'ThalamusSDK\Model\Activity\PayItForward\Chain' :
				if (isset ( $responseData->context->pagination ) and isset ( $responseData->gifts )) {
					$chain = new \stdClass ();
					$chain->pagination = $responseData->context->pagination;
					$chain->gifts = $responseData->gifts->gifts;
					$data = $chain;
				}
				break;
			case 'ThalamusSDK\Model\Activity\Survey\Question' :
				if (isset ( $responseData->surveyQuestion )) {
					$data = $responseData->surveyQuestion;
				}
				break;
			case 'ThalamusSDK\Model\Activity\PayItForward\Gift' :
				if (isset ( $responseData->gift )) {
					$data = $responseData->gift;
				}
				break;
			case 'ThalamusSDK\Model\Activity\Mileage\Payment':
			    if (isset ( $responseData->payment )) {
			        $data = $responseData->payment;
			    }
			    break;
			default :
				$data = $responseData;
		}
		
		// additional properties
		if (! empty ( $additionalProperties )) {
			foreach ( $additionalProperties as $property => $value ) {
				$data->$property = $value;
			}
		}
		
		$thalamusModel = new ThalamusModel ( $data );
		
		return $thalamusModel->cast ( $type );
	}
	
	/**
	 * Returns an array of ThalamusModel returned by the request.
	 * If a type is
	 * specified, returns the strongly-typed subclass of ThalamusModel for the data.
	 *
	 * @param String $type
	 * @param String $path
	 * @return \ThalamusSDK\ThalamusModel[]
	 */
	public function getThalamusModelList(String $type = 'ThalamusSDK\ThalamusModel', String $path) {
		$out = array ();
		$data = $this->responseData->$path;
		$dataLength = count ( $data );
		for($i = 0; $i < $dataLength; $i ++) {
			$thalamusModel = new ThalamusModel ( $data [$i] );
			
			$out [] = $thalamusModel->cast ( $type );
		}
		return $out;
	}
}