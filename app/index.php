<?php
/// TRY AND GET XML OR JSON WORKING
require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object
require_once "conf/config.inc.php"; 

function authenticate(\Slim\Route $route) {
    $app = \Slim\Slim::getInstance();
	$app->request->headers;
	$username = $app->request->headers->get('username');
	$password = $app->request->headers->get('password');
	$parameters['username'] = $username;
	$parameters['password'] = $password;
	$action = ACTION_GET_HEADER;
	$mvc = new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
    if ($mvc->model->apiResponse === false) {
      $app->halt(401);
    }
}

function JSONorXML() {
    $app = \Slim\Slim::getInstance();
	$app->request->headers;
	$view = $app->request->headers->get('view');
	if ($view == 'json'){
		return 'jsonView';
	}
	if ($view == 'xml'){
		return 'xmlView';
	}
}


$app->map ( "/users(/:id)", "authenticate", function ($userID = null) use($app) {
	
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$view = JSONorXML();
	$parameters ["id"] = $userID; // prepare parameters to be passed to the controller (example: ID)
	
	if (($userID == null) or is_numeric ( $userID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($userID != null)
					$action = ACTION_GET_USER;
				else
					$action = ACTION_GET_USERS;
				break;
			case "POST" :
				$action = ACTION_CREATE_USER;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_USER;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_USER;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "UserModel", "UserController", $view, $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->map ( "/users(/search/:str)", "authenticate",function ($string=null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$view = JSONorXML();
	$parameters ["str"] = $string; // prepare parameters to be passed to the controller (example: ID)
	
	if ($string == null or !is_numeric ( $string )) {
		switch ($httpMethod) {
			case "GET" :
					$action = ACTION_SEARCH_USERS;
					break;
			default :
		}
	}
	return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
} )->via ( "GET" );

$app->map ( "/movies(/:name)", "authenticate", "JSONorXML" , function ($mName = null) use($app) {
	
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$view = JSONorXML();
	$parameters ["name"] = $mName; // prepare parameters to be passed to the controller (example: ID)
	
	if (($mName == null or ! empty($mName))) {
		switch ($httpMethod) {
			case "GET" :
				if ($mName != null)
					$action = ACTION_GET_MOVIE;
				else
					$action = ACTION_GET_MOVIES;
				break;
			case "POST" :
				$action = ACTION_CREATE_MOVIE;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_MOVIE;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_MOVIE;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "MoviesModel", "MoviesController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->map ( "/movies(/search/:str)", "authenticate", "JSONorXML", function ($string=null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$view = JSONorXML();
	$parameters ["str"] = $string; // prepare parameters to be passed to the controller (example: ID)
	
	if ($string == null or !is_numeric ( $string )) {
		switch ($httpMethod) {
			case "GET" :
					$action = ACTION_SEARCH_MOVIES;
					break;
			default :
		}
	}
	return new loadRunMVCComponents ( "MoviesModel", "MoviesController", "jsonView", $action, $app, $parameters );
} )->via ( "GET" );

$app->map ( "/movieratings(/:name)", "authenticate", "JSONorXML", function ($mName = null) use($app) {
	
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$view = JSONorXML();
	$parameters ["name"] = $mName; // prepare parameters to be passed to the controller (example: ID)
	
	if (($mName == null or ! empty($mName))) {
		switch ($httpMethod) {
			case "GET" :
				if ($mName != null)
					$action = ACTION_GET_MOVIE_RATING;
				else
					$action = ACTION_GET_MOVIES_RATING;
				break;
			case "POST" :
				$action = ACTION_CREATE_MOVIE_RATING;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_MOVIE_RATING;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_MOVIE_RATING;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "MovieRatingModel", "MovieRatingController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->map ( "/movieratings(/search/:str)", "authenticate", "JSONorXML", function ($string=null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$view = JSONorXML();
	$parameters ["str"] = $string; // prepare parameters to be passed to the controller (example: ID)
	
	if ($string == null or !is_numeric ( $string )) {
		switch ($httpMethod) {
			case "GET" :
					$action = ACTION_SEARCH_MOVIES_RATING;
					break;
			default :
		}
	}
	return new loadRunMVCComponents ( "MovieRatingModel", "MovieRatingController", "jsonView", $action, $app, $parameters );
} )->via ( "GET" );

$app->run ();
class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$this->model = new $modelName (); // common model
		$this->controller = new $controllerName ( $this->model, $action, $app, $parameters );
		$this->view = new $viewName ( $this->controller, $this->model, $app, $app->headers ); // common view
		$this->view->output (); // this returns the response to the requesting client
	}
}

?>