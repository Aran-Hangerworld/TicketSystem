\<?php
	if(isset($_POST['id'])){
		$dept = $_POST['dept'];
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$priority = $_POST['priority'];
		$status = $_POST['status'];
		$id = $_POST['id'];
		include 'PDO.php'; 
		try {
			$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
			} catch(Exception $e)  {
			    print "Error!: " . $e->getMessage();
		    }
		$sth = $db->prepare('CALL tkt_updateticket(?,?,?,?,?,?)');
		$sth->bindparam(1, $id, PDO::PARAM_INT);
		$sth->bindparam(2, $dept, PDO::PARAM_STR);
		$sth->bindparam(3, $title, PDO::PARAM_STR);
		$sth->bindparam(4, $desc, PDO::PARAM_STR);
		$sth->bindparam(5, $priority, PDO::PARAM_INT);
		$sth->bindparam(6, $status, PDO::PARAM_INT);
		$sth->execute(); 
	} else {
		echo "oops";	 
	}
?>