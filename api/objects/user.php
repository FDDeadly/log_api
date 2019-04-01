<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $id;
    public $name;
    public $email;
    public $birthday;
    public $gender;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	function create(){
 
		
		$query = "INSERT INTO ".$this->table_name."
				SET
					name=:name,  
					email=:email, 
					birthday=:birthday, 
					gender=:gender";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->birthday=htmlspecialchars(strip_tags($this->birthday));
		$this->gender=htmlspecialchars(strip_tags($this->gender));

		// bind values
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":email", $this->email);
		$stmt->bindParam(":birthday", $this->birthday);
		$stmt->bindParam(":gender", $this->gender);

		// execute query
		if($stmt->execute()){
			return true;
		}

		return false;
		 
	}
	
	
	function read(){
 
		$query = "SELECT
					u.id,
					u.name,
					u.email, 
					u.birthday, 
					u.gender
				FROM
					".$this->table_name." as u
				ORDER BY
					u.name ASC";
					
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}
	
	function readOne(){
 
		// query to read single record
		$query = "SELECT
					u.id,
					u.name,
					u.email, 
					u.birthday, 
					u.gender
				FROM ".$this->table_name." as u
				WHERE u.id = ?
				LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// bind id of product to be updated
		$stmt->bindParam(1, $this->id);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		// set values to object properties
		$this->name = $row['name'];
		$this->email = $row['email'];
		$this->birthday = $row['birthday'];
		$this->gender = $row['gender'];
	}
	
	function update(){
 
		// update query
		$query = "UPDATE ".$this->table_name."
				SET
					name = :name,
					email = :email,
					birthday = :birthday,
					gender = :gender
				WHERE
					id = :id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->birthday=htmlspecialchars(strip_tags($this->birthday));
		$this->gender=htmlspecialchars(strip_tags($this->gender));
		$this->id=htmlspecialchars(strip_tags($this->id));
	 
		// bind new values
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':birthday', $this->birthday);
		$stmt->bindParam(':gender', $this->gender);
		$stmt->bindParam(':id', $this->id);
	 
		// execute the query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	function delete(){
 
		// delete query
		$query = "DELETE FROM ".$this->table_name." WHERE id = ?";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}

}
