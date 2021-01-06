<?php

namespace ThalamusSDK\Model\Party;

use \ThalamusSDK\ThalamusModel;

/**
 * Class SocialConnection
 *
 * @package ThalamusSDK
 */
class SocialConnection extends ThalamusModel {
	
	/**
	 */
	public function getLinks() {
		return $this->getProperty ( 'links' );
	}
	
	/**
	 */
	public function getPartyId() {
		return $this->getProperty ( 'partyId' );
	}
	
	/**
	 */
	public function getProviderId() {
		return $this->getProperty ( 'providerId' );
	}
	
	/**
	 */
	public function getProviderUserId() {
		return $this->getProperty ( 'providerUserId' );
	}
	
	/**
	 */
	public function getDisplayName() {
		return $this->getProperty ( 'displayName' );
	}
	
	/**
	 */
	public function getProfileUrl() {
		return $this->getProperty ( 'profileUrl' );
	}
	
	/**
	 */
	public function getImageUrl() {
		return $this->getProperty ( 'imageUrl' );
	}
	
	/**
	 */
	public function getAccessToken() {
		return $this->getProperty ( 'accessToken' );
	}
	
	/**
	 */
	public function getSecret() {
		return $this->getProperty ( 'secret' );
	}
	
	/**
	 */
	public function getRefreshToken() {
		return $this->getProperty ( 'refreshToken' );
	}
	
	/**
	 */
	public function getExpireTime() {
		return $this->getProperty ( 'expireTime' );
	}
}