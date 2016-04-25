<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/MoviesDAO.php";
require_once "Validation.php";
class MoviesModel {
	private $MoviesDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->MoviesDAO = new MoviesDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getMovies() {
		return ($this->MoviesDAO->get ());
	}
	public function getMovie($movName) {
		if (! empty ( $movName ))
			return ($this->MoviesDAO->get ( $movName ));
		
		return false;
	}
	public function getUserHeader($username, $password) {
		if (! empty ( $username ) && ! empty ( $password ))	
			if ($this->UsersDAO->getheader ( $username, $password ))
				return true;
			
		return false;
	}
	/**
	 *
	 * @param array $UserRepresentation:
	 *        	an associative array containing the detail of the new user
	 */
	public function createNewMovie($newMovie) {
		// validation of the values of the new user
		
		// compulsory values
		if (! empty ( $newMovie ["name"] ) && ! empty ( $newMovie ["genre"] ) && ! empty ( $newMovie ["description"] )) {
			/*
			 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newMovie ["name"], TABLE_MOVIES_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newMovie ["genre"], TABLE_MOVIES_GENRE_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newMovie ["description"], TABLE_MOVIES_DESCRIPTION_LENGTH ))) {
				if ($newId = $this->MoviesDAO->insert ( $newMovie ))
					return ($newId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	public function searchMovies($string) {
		if (! empty ( $string )) {
			$resultSet = $this->MoviesDAO->search ( $string );
			return $resultSet;
		}
		
		return false;
	}
	public function deleteMovie($movName) {
		if ( ! empty ( $movName )) {
			$deletedRows = $this->MoviesDAO->delete ( $movName );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	public function updateMovie($movName, $movieNewRepresentation) {
		if (! empty ( $movName )) {
			// compulsory values
			if (! empty ( $movieNewRepresentation ["name"] ) && ! empty ( $movieNewRepresentation ["genre"] ) && ! empty ( $movieNewRepresentation ["description"] )) {
				/*
				 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
				 */
				if (($this->validationSuite->isLengthStringValid ( $movieNewRepresentation ["name"], TABLE_MOVIES_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $movieNewRepresentation ["genre"], TABLE_MOVIES_GENRE_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $movieNewRepresentation ["description"], TABLE_MOVIES_DESCRIPTION_LENGTH ))) {
					$updatedRows = $this->MoviesDAO->update ( $movieNewRepresentation, $movName );
					if ($updatedRows > 0)
						return (true);
				}
			}
		}
		return (false);
	}
	public function __destruct() {
		$this->MoviesDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>