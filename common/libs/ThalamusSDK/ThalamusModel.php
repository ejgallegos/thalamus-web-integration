<?php

namespace ThalamusSDK;

/**
 * Class ThalamusModel
 *
 * @package ThalamusSDK
 */
class ThalamusModel {
	
	/**
	 *
	 * @var array - Holds the raw associative data for this object
	 */
	protected $backingData;
	
	/**
	 * Creates a ThalamusModel using the data provided.
	 *
	 * @param array $raw        	
	 */
	public function __construct($raw) {
		if ($raw instanceof \stdClass) {
			$raw = get_object_vars ( $raw );
		}
		$this->backingData = $raw;
		
		if (isset ( $this->backingData ) && count ( $this->backingData ) === 1) {
			if ($this->backingData instanceof \stdClass) {
				$this->backingData = get_object_vars ( $this->backingData );
			} else {
				$this->backingData = $this->backingData;
			}
		}
	}
	
	/**
	 * cast - Return a new instance of a ThalamusModel subclass for this
	 * objects underlying data.
	 *
	 * @param string $type
	 *        	The ThalamusModel subclass to cast to
	 *        	
	 * @return ThalamusModel
	 *
	 * @throws ThalamusSDKException
	 */
	public function cast(String $type) {
		if ($this instanceof $type) {
			return $this;
		}
		if (is_subclass_of ( $type, ThalamusModel::className () )) {
			return new $type ( $this->backingData );
		} else {
			throw new ThalamusSDKException ( 'Cannot cast to an object that is not a ThalamusModel subclass', 620 );
		}
	}
	
	/**
	 * asArray - Return a key-value associative array for the given tha object.
	 *
	 * @return array
	 */
	public function asArray() {
		return $this->backingData;
	}
	
	/**
	 * getProperty - Gets the value of the named property for this tha object,
	 * cast to the appropriate subclass type if provided.
	 *
	 * @param string $name
	 *        	The property to retrieve
	 * @param string $type
	 *        	The subclass of ThalamusModel, optionally
	 *        	
	 * @return mixed
	 */
	public function getProperty(String $name, String $type = 'ThalamusSDK\ThalamusModel', Array $additionalProperties = array()) {
		if (isset ( $this->backingData [$name] )) {
			$value = $this->backingData [$name];
			if (is_scalar ( $value )) {
				return $value;
			} else {
				// additional properties
				if (! empty ( $additionalProperties )) {
					foreach ( $additionalProperties as $property => $value ) {
						$value->$property = $value;
					}
				}
				$tObj = new ThalamusModel ( $value );
				return $tObj->cast ( $type );
			}
		} else {
			return null;
		}
	}
	
	/**
	 * getPropertyAsArray - Get the list value of a named property for this thalamus
	 * object, where each item has been cast to the appropriate subclass type
	 * if provided.
	 *
	 * Calling this for a property that is not an array, the behavior
	 * is undefined, so don’t do this.
	 *
	 * @param string $name
	 *        	The property to retrieve
	 * @param string $type
	 *        	The subclass of ThalamusModel, optionally
	 *        	
	 * @return array
	 */
	public function getPropertyAsArray(String $name, String $type = 'ThalamusSDK\ThalamusModel') {
		$target = array ();
		if (isset ( $this->backingData [$name] ['data'] )) {
			$target = $this->backingData [$name] ['data'];
		} else if (isset ( $this->backingData [$name] ) && ! is_scalar ( $this->backingData [$name] )) {
			$target = $this->backingData [$name];
		}
		$out = array ();
		foreach ( $target as $key => $value ) {
			if (is_scalar ( $value )) {
				$out [$key] = $value;
			} else {
				$tObj = new ThalamusModel ( $value );
				$out [$key] = $tObj->cast ( $type );
			}
		}
		return $out;
	}
	
	/**
	 * getPropertyNames - Returns a list of all properties set on the object.
	 *
	 * @return array
	 */
	public function getPropertyNames() {
		return array_keys ( $this->backingData );
	}
	
	/**
	 * Returns the string class name of the ThalamusModel or subclass.
	 *
	 * @return string
	 */
	public static function className() {
		return get_called_class ();
	}
}