<?php
class MoviesController {
	private $slimApp;
	private $model;
	private $requestBody;
	public function __construct($model, $action = null, $slimApp, $parameteres = null) {
		$this->model = $model;
		$this->slimApp = $slimApp;
		$this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new user
		
		if (! empty ( $parameteres ["name"] ))
			$name = $parameteres ["name"];
		
		switch ($action) {
			case ACTION_GET_MOVIE :
				$this->getMovie ( $name );
				break;
			case ACTION_GET_MOVIES :
				$this->getMovies ();
				break;
			case ACTION_UPDATE_MOVIE :
				$this->updateMovie ( $name, $this->requestBody );
				break;
			case ACTION_CREATE_MOVIE :
				$this->createNewMovie ( $this->requestBody );
				break;
			case ACTION_DELETE_MOVIE :
				$this->deleteMovie ( $name );
				break;
			case ACTION_SEARCH_MOVIES :
				$string = $parameteres ["str"];
				$this->searchMovies ( $string );
				break;
			case ACTION_GET_HEADER :
				$username = $parameteres ["username"];
				$password = $parameteres ["password"];
				$this->getUserHeader($username, $password);
				break;
			case null :
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
				$Message = array (
						GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR
				);
				
				$this->model->apiResponse = $Message;
				break;
		}
	}
	
	private function getMovies() {
		$answer = $this->model->getMovies ();
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
	private function getMovie($movName) {
		$answer = $this->model->getMovie ( $movName );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
	private function getUserHeader($username, $password) {
		//$answer = $this->model->getUserHeader ( $username, $password );
		if ($this->model->getUserHeader ( $username, $password )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = true;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_UNAUTHORIZED );
			$this->model->apiResponse = false;
		}
	}
	
	private function createNewMovie($newMovie) {
		if ($newMoviename = $this->model->createNewMovie ( $newMovie )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_CREATED,
					"name" => "$newMoviename" 
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY 
			);
			$this->model->apiResponse = $Message;
		}
	}
	private function deleteMovie($movName) {
		//$isSuccessfull = $this->model->deleteUser ( $userId );
		//var_dump($isSuccessfull);
		//die($isSuccessfull);
		if ($this->model->deleteMovie ( $movName )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_DELETED 
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_ERROR_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
	private function searchMovies($string) {
		$answer = $this->model->searchMovies ( $string );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			
			$this->model->apiResponse = $Message;
		}
	}
	private function updateMovie($movName, $movieDetails) {
		if ($this->model->updateMovie ( $movName, $movieDetails )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_UPDATED,
					"movieName" => "$movName" 
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY 
			);
			$this->model->apiResponse = $Message;
		}
	}
}
?>