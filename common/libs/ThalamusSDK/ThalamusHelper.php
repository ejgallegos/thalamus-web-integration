<?php

namespace ThalamusSDK;

use DateTime;

class ThalamusHelper {
	/**
	 * channels de comunicaciones de Thalamus
	 *
	 * @var array channels
	 */
	public static $channels = array (
			'Email' => 6001,
			'Phone' => 6002,
			'SMS' => 6003,
			'Mail' => 6004,
			'Facebook' => 6005,
			'Twitter' => 6006,
			// 'LinkedIn' => 6007,
			// 'Link' => 6008,
			'Inbox' => 6009 
	);
	
	/**
	 * 
	 * @param String $name
	 * @return boolean|number
	 */
	public static function getChannelIdByName(String $name) {
		return isset ( self::$channels [$name] ) ? self::$channels [$name] : false;
	}
	
	/**
	 * 
	 * @param Int $channelId
	 * @return array|number[]|boolean
	 */
	public static function getChannelNameById(Int $channelId) {
		foreach ( self::$channels as $name => $id ) {
			if ($channelId == $id)
				return $name;
		}
		return false;
	}
	
	/**
	 * convierte una fecha a timestamp con milisegundos
	 *
	 * @param string $date
	 *        	'dd-mm-yyyy' or 'dd/mm/yyyy'
	 * @return number
	 */
	public static function dateToTimestamp(String $date) {
		return strtotime ( implode ( "/", array_reverse ( explode ( "/", str_replace ( "-", "/", $date ) ) ) ) ) * 1000;
	}
	
	/**
	 * convierte timestamp con milisegundos a fecha
	 *
	 * @param Int $timestamp        	
	 * @return String in 'dd/mm/YYYY' format
	 */
	public static function timestampToDate(Int  $timestamp) {
		return date ( 'd/m/Y', $timestamp / 1000 );
	}
	
	/**
	 *
	 * @param string $servicePath        	
	 * @return string
	 */
	public static function getFullPath(String $servicePath = "") {
		$touchpointAndToken = '?touchpoint=' . Thalamus::THALAMUS_TOUCHPOINT . '&token=' . Thalamus::THALAMUS_TOKEN;
		if (strpos($servicePath, "?" ) !== false) { //tiene params.
			list($servicePath, $params) = explode ( "?", $servicePath, 2);
			return self::getHost ( Thalamus::THALAMUS_ENVIRONMENT, Thalamus::THALAMUS_CLIENT ).$servicePath.$touchpointAndToken."&".$params;
		}
		return self::getHost ( Thalamus::THALAMUS_ENVIRONMENT, Thalamus::THALAMUS_CLIENT ).$servicePath.$touchpointAndToken;
	}
	
	/**
	 *
	 * @param string $environment        	
	 * @param string $client        	
	 * @param string $apiVersion        	
	 * @return string
	 */
	public static function getHost(String $environment, String $client, String $apiVersion = Thalamus::VERSION_API) {
		return "https://" . $environment . "-" . $client . "-rest.thalamuslive.com/" . $client . "/api/" . $apiVersion;
	}
	
	/**
	 * Devuelve arreglo optin comun para todos los canales.
	 *
	 * @param boolean $optIn        	
	 * @return array
	 */
	public static function generateOptInsCompany(Bool $optIn = false) {
		return array (
				array (
						"brandFamilyId" => - 1,
						"channel" => - 1,
						"accepted" => $optIn 
				) 
		);
	}
	
	/**
	 * Devuelve arreglo de optins con canales individuales
	 * Recibe array con los canales como key y el valor como boolean, los canales que no esten en el array
	 * se asigna FALSE.
	 *
	 * $optInByDefault, se asignara este valor a todos los canales que no hayan sido incluidos en el array $optIns.
	 *
	 * @param array|boolean $optIns        	
	 * @param boolean $optInByDefault|FALSE
	 *        	by default
	 * @param integer $brandFamilyId|
	 *        	-1 by default
	 * @return multitype:multitype:number string unknown
	 */
	public static function generateOptInsByChannel(Array $optIns = array(), Bool $optInByDefault = false, Int $brandFamilyId = -1) {
		$arrOptIn = array ();
		
		foreach ( self::$channels as $name => $channel ) {
			
			$optIn = $optInByDefault;
			
			if (isset ( $optIns [$name] )) {
				$optIn = $optIns [$name];
			} elseif (isset ( $optIns [$channel] )) {
				$optIn = $optIns [$channel];
			}
			
			$arrOptIn [] = array (
					"brandFamilyId" => $brandFamilyId,
					"channel" => $channel,
					"accepted" => $optIn 
			);
		}
		
		return $arrOptIn;
	}
	
	/**
	 *
	 * @param array $brandIds        	
	 */
	public static function generateOptInsByBrandFamily(Array $brandIds = array()) {
		$arrOptIn = array ();
		
		foreach ( self::$channels as $channel ) {
			
			foreach ( $brandIds as $brandId => $optIn ) {
				
				$arrOptIn [] = array (
						"brandFamilyId" => $brandId,
						"channel" => $channel,
						"accepted" => $optIn 
				);
			}
		}
		
		return $arrOptIn;
	}
	
	/**
	 * Convierte un array en url query param.
	 *
	 * @param array $params        	
	 * @return string
	 */
	public static function paramsToUrl(Array $params) {
		$r = http_build_query ( $params );
		return ! empty ( $r ) ? '?' . $r : $r;
	}

	/**
	 * Checkea que sea un timestamp valido
	 * @param Int $timestamp
	 * @return boolean
	 */
	public static function isValidTimeStamp(Int $timestamp) {
	    return ((string) (int) $timestamp === $timestamp)
	    && ($timestamp <= PHP_INT_MAX)
	    && ($timestamp >= ~PHP_INT_MAX);
	}
	
	/**
	 * Checkea que la sea una fecha valida
	 * @param string $date
	 * @param string $format
	 * @return boolean
	 */
	public static function validateDate(String $date, String $format = 'Y/m/d') {
	    $date = str_replace ( "-", "/", $date );
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) === $date;
	}
    
	/**
	 * Helper function courtesy of https://github.com/guzzle/guzzle/blob/3a0787217e6c0246b457e637ddd33332efea1d2a/src/Guzzle/Http/Message/PostFile.php#L90
	 *
	 * @param String $filename
	 * @param String $contentType
	 * @param String $postname
	 * @return string
	 */
	public static function getCurlValue(String $filename, String $contentType = null, String $postname = null)
	{
		// PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
		// See: https://wiki.php.net/rfc/curl-file-upload
		if (function_exists('curl_file_create')) {
			return curl_file_create($filename, $contentType, $postname);
		}
			
		// Use the old style if using an older version of PHP
		$value = "@{$filename};filename=" . $postname;
		if ($contentType) {
			$value .= ';type=' . $contentType;
		}
			
		return $value;

	}
	
}