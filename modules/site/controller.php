<?php
require_once "modules/site/view.php";


class SiteController {

	function __construct() {
		$this->view = new SiteView();
	}
	
    function home() {
		$this->view->home();
	}
	
	function person() {
		$thalamus = \ThalamusSDK\Thalamus::getInstance();
		try {
			
			$thalamus->login($_POST["email"], $_POST["password"]);
			$profile = $thalamus->getParty()->getProfile();
			
			$person = new \stdClass;
			$person->name = $profile->getName();
			$person->email = $profile->getEmail();
			$person->gender = $profile->getGender();
			$person->birthday = $profile->getBirthday();
			$person->document = $profile->getDocument();
			$person->cell = $profile->getCellphone();
			
			$this->view->person($person);
			
		} catch ( \ThalamusSDK\ThalamusRequestException $e ) {
			$error = $e->getErrors();

			$error_message = new \stdClass;
			$error_message->error_message = $error[0]["message_thalamus"];
			$error_message->display = "block";

			$this->view->home($error_message);
		}
	}

	function logout(){
		$thalamus = \ThalamusSDK\Thalamus::getInstance();
		try {
			$thalamus->logout();
			header("Location: " . URL_APP);
			
		} catch ( \ThalamusSDK\ThalamusRequestException $e ) {
			
			$error = $e->getErrors();
			print_r($error);exit;
		}
	}
	
	function updateFormPerson(){
		$this->view->updateFormPerson();
	}

	function updatePerson(){
		
		$name = filter_input(INPUT_POST, "name");
		$lastname = filter_input(INPUT_POST, "lastname");

		$thalamus = \ThalamusSDK\Thalamus::getInstance();
		try {
            $person = $thalamus->getParty();
            $profile['firstname'] = $name;
            $profile['lastname'] = $lastname;
     
			$person->update($profile);
			print_r($person);exit;
			//header("Location: " . URL_APP . "/site/person");
        } catch ( \ThalamusSDK\ThalamusRequestException $e ) {

            $errors = $e->getErrors();

        }
	}

}
?>
