<?php
// dao.php
// class for saving and getting info to/from MySQL

class Dao {

    private $dbhost = "paleomedia-idleg-1299620";
    private $user = "paleomedia";
    private $password = "";
    private $database = "c9";
    private $dbport = 3306; 
   
  public function getConnection () {
    return
      new PDO("mysql:host={$this->dbhost};dbname={$this->database};port={$this->dbport}", $this->user, $this->password);
  }
  
  public function check_login($name, $password) {
    $conn = $this->getConnection();
    $name = $conn->quote($name);
    $rows = $conn->query("SELECT password FROM users WHERE username = $name");
    if ($rows) {
        foreach ($rows as $row) {             #only one row should match  
            if ($password === $row["password"]) {
                return TRUE;
            }
        }
    }
    return FALSE;    # user not found, or wrong password
  }

  public function ensure_logged_in() {
    if (!isset($_SESSION[$name])) {
    redirect("index.php", "You must login first");
    }
  }

  public function redirect($url, $flash_message = NULL) {
	  if ($flash_message) {
		$_SESSION["flash"] = $flash_message;
	  }
	  header("Location: $url");
	  die;
	}

  public function saveComment ($username, $comment, $bill, $comment_type) {
    $conn = $this->getConnection();
    $saveQuery =
        "INSERT INTO comments
        (username, comment, bill_id, comment_type)
        VALUES
        (:username, :comment, :bill,  :comment_type)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":username", $username);
    $q->bindParam(":comment", $comment);
    $q->bindParam(":bill", $bill);
    $q->bindParam(":comment_type", $comment_type);
    return $q->execute();
  }

  public function getComments ($bill, $comment_type) {
    $conn = $this->getConnection();
    return $conn->query("SELECT username, comment, date FROM comments WHERE bill_id = '$bill' AND comment_type = '$comment_type'");
  }
  
  public function getUserComments ($user) {
    $conn = $this->getConnection();
    return $conn->query("SELECT comment, date FROM comments
                        WHERE username = '$user'
                        ORDER BY date
                        LIMIT 5");
  }
  
  public function newUser ($username, $password, $email) {
    $conn = $this->getConnection();
    $saveQuery =
          "INSERT INTO users
          (username, password, email)
          VALUES
          (:username, :password, :email)";
      $q = $conn->prepare($saveQuery);
      $q->bindParam(":username", $username);
      $q->bindParam(":password", $password);
      $q->bindParam(":email", $email);
      return $q->execute();
  }
  
  public function saveBills ($bill_id, $year, $title, $bill_name, $connection) {
  
    $saveQuery =
          "INSERT INTO bills
          (bill_id, year, title, bill_name)
          VALUES
          (:bill_id, :year, :title, :bill_name)";
      $q = $connection->prepare($saveQuery);
      $q->bindParam(":bill_id", $bill_id);
      $q->bindParam(":year", $year);
      $q->bindParam(":title", $title);
      $q->bindParam(":bill_name", $bill_name);
      $q->execute();
      return $bill_name;
  }
  
  public function getBills () {
    $conn = $this->getConnection();
    return $conn->query("SELECT bill_name, bill_id, title, (votes_for + votes_against) AS total
      FROM bills
      ORDER BY total
      LIMIT 20");
  }
  
  public function getLegislators () {
    $conn = $this->getConnection();
    return $conn->query("SELECT first_name, last_name, middle_name, district, party, chamber, photo_url
      FROM lawmakers");
  }
  
} // end Dao
?>