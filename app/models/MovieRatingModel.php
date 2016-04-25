<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/MovieRatingDAO.php";
require_once "Validation.php";
class MovieRatingModel {
	private $MovieRatingDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->MovieRatingDAO = new MovieRatingDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getMoviesRating() {
		return ($this->MovieRatingDAO->get ());
	}
	public function getMovieRating($movName) {
		if (! empty ( $movName ))
			return ($this->MovieRatingDAO->get ( $movName ));
		
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
	public function createNewMovieRating($newMovie) {
		// validation of the values of the new user
		
		// compulsory values
		if (! empty ( $newMovie ["name"] ) && ! empty ( $newMovie ["rating"] ) && ! empty ( $newMovie ["comment"] )) {
			/*
			 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			$min = 1;
			$max= 10;
			if (($this->validationSuite->isLengthStringValid ( $newMovie ["name"], TABLE_MOVIESRATING_NAME_LENGTH )) && ($this->validationSuite->isNumberInRangeValid ( $newMovie ["rating"],TABLE_MOVIESRATING_RATING_MIN, TABLE_MOVIESRATING_RATING_MAX )) && ($this->validationSuite->isLengthStringValid ( $newMovie ["comment"], TABLE_MOVIESRATING_COMMENT_LENGTH ))) {
				if ($newId = $this->MovieRatingDAO->insert ( $newMovie ))
					return ($newId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	public function searchMoviesRating($string) {
		if (! empty ( $string )) {
			$resultSet = $this->MovieRatingDAO->search ( $string );
			return $resultSet;
		}
		
		return false;
	}
	public function deleteMovieRating($movName) {
		if ( ! empty ( $movName )) {
			$deletedRows = $this->MovieRatingDAO->delete ( $movName );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	public function updateMovieRating($movName, $movieRatingNewRepresentation) {
		if (! empty ( $movName )) {
			// compulsory values
			if (! empty ( $movieRatingNewRepresentation ["name"] ) && ! empty ( $movieRatingNewRepresentation ["comment"] )) {
				/*
				 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
				 */
				if (($this->validationSuite->isLengthStringValid ( $movieRatingNewRepresentation ["name"], TABLE_MOVIESRATING_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $movieRatingNewRepresentation ["comment"], TABLE_MOVIESRATING_COMMENT_LENGTH ))) {
					$updatedRows = $this->MovieRatingDAO->update ( $movieRatingNewRepresentation, $movName );
					if ($updatedRows > 0)
						return (true);
				}
			}
		}
		return (false);
	}
	public function __destruct() {
		$this->MovieRatingDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>