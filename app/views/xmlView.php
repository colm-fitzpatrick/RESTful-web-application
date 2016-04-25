<?php
class xmlView {
	private $model, $controller, $slimApp;
	public function __construct($controller, $model, $slimApp) {
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;
	}
	public function output() {
		// prepare xml response
		$xml = new SimpleXMLElement('<root/>');
		array_walk_recursive($this->model->apiResponse, array ($xml, 'addChild'));
		//$xmlResponse = simplexml_load_string ( $this->model->apiResponse );
		$this->slimApp->response->write ( $xml->asXML() );
	}
}
?>