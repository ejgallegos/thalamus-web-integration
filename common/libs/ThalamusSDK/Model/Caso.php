<?php

namespace ThalamusSDK\Model;

use \ThalamusSDK\ThalamusModel;
use \ThalamusSDK\Model\Other\Note;
use \ThalamusSDK\ThalamusRequest;
/**
 * Class Caso
 *
 * @package ThalamusSDK
 */
class Caso extends ThalamusModel {
	/**
	 */
	public function getId() {
		return $this->getProperty ( 'id' );
	}
	
	/**
	 */
	public function getCategoryCode() {
		return $this->getProperty ( 'categoryCode' );
	}
	
	/**
	 */
	public function getCategoryName() {
		return $this->getProperty ( 'categoryName' );
	}
	
	/**
	 */
	public function getTypeCode() {
		return $this->getProperty ( 'typeCode' );
	}
	
	/**
	 */
	public function getStatus() {
		return $this->getProperty ( 'status' );
	}
	
	/**
	 */
	public function getResolution() {
		return $this->getProperty ( 'resolution' );
	}
	
	/**
	 */
	public function getNotes() {
		return $this->getPropertyAsArray ( 'comments', Note::classname () );
	}
	
	/**
	 */
	public function addNote($description) {
		$params = array (
				'description' => $description 
		);
		
		$response = ThalamusRequest::post ( "/cases/{$this->getId()}/notes", $params )->execute ();
		
		$this->backingData ['comment'] [] = $description;
		
		return $this;
	}
	
	/**
	 */
	public function updateNote($id,$description) {
		$params = array (
				'id' => $id,
				'description' => $description
		);
	
		$response = ThalamusRequest::put( "/cases/{$this->getId()}/notes", $params )->execute ();
	
		return $this;
	}
	
	
	public function addFile($file) {
	
		$params = array(
				'file' => $file
		);
	
		return ThalamusRequest::post( "/cases/{$this->getId()}/files", $params )->sendFile()->execute();
	}
	
	public function deleteFile($fileId) {
		
		return ThalamusRequest::delete ( "/cases/{$this->getId()}/files/$fileId" )->execute();
		
	}
	
	/**
	 *
	 * @param string $caseField
	 * @return unknown
	 */
	public function getCaseData($caseField=null) {
	
		$caseData = $this->getProperty ( 'caseData' );
	
		if ($caseField!=null) {
			if (!empty($caseData)) {
				return $caseData->getProperty($caseField);
			}
		}
	
		return $caseData;
	}
	
	/**
	 *
	 */
	public function getAttachments() {
		return $this->getPropertyAsArray( 'attachements' );
	}
	
	/**
	 *
	 * @param unknown $id
	 */
	public static function getFileByAttachmentId($id) {
		return ThalamusRequest::get( '/cases/files/' . $id )->execute()->getRawResponse();
	}
}