<?php
	if(isset($_POST['username'])){
		$username = $_POST['username'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$dept = $_POST['dept'];
		$isitadmin = $_POST['isadmin'];
		$id = $_POST['id'];
	
		include 'PDO.php'; 
		try {
			$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
			} catch(Exception $e)  {
			    print "Error!: " . $e->getMessage();
		    }
		$sth = $db->prepare('CALL tkt_updateuser(?,?,?,?,?)');
		$sth->bindparam(1, $username, PDO::PARAM_STR);
		$sth->bindparam(2, $name, PDO::PARAM_STR);
		$sth->bindparam(3, $email, PDO::PARAM_STR);
		$sth->bindparam(4, $dept, PDO::PARAM_STR);
		$sth->bindparam(5, $isitadmin, PDO::PARAM_STR);
		$sth->bindParam(6, $id, PDO::PARAM_STR);
		$sth->execute(); 
	}
?>