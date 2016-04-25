<?php
/**
 * @author Luca
 * definition of the User DAO (database access object)
 */
class MoviesDAO {
	private $dbManager;
	function MoviesDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($movName = null) {
		$sql = "SELECT * ";
		$sql .= "FROM movies ";
		if ($movName != null)
			$sql .= "WHERE movies.name=? ";
		$sql .= "ORDER BY movies.genre ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $movName, $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	public function getheader($username, $password) {
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		if ($username != null && $password != null)
			$sql .= "WHERE users.email=? ";
			$sql .= "AND users.password=? ";
		$sql .= "ORDER BY users.name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $username, $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $password, $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return $rows;
	}
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO movies (name, genre, description) ";
		$sql .= "VALUES (?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["genre"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["description"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return $parametersArray["name"];
		//return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray, $movName) {
		// /create an UPDATE sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)
		$sql = "UPDATE movies SET name = ?, genre = ?, description = ? WHERE name = ?";
		
		$this->dbManager->openConnection ();
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["genre"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["description"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt,4, $movName, PDO::PARAM_STR );
		$this->dbManager->executeQuery ( $stmt );
		
		//check for number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		return ($rowCount);
	}
	public function delete($movName) {
		$sql = "DELETE FROM movies ";
		$sql .= "WHERE movies.name = ?";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $movName, $this->dbManager->STRING_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	public function search($str) {
		$sql = "SELECT * ";
		$sql .= "FROM movies ";
		$sql .= "WHERE movies.name LIKE CONCAT('%', ?, '%') ";
		$sql .= "ORDER BY movies.name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, $this->dbManager->STRING_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
}
?>
