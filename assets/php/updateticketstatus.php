<?php

include 'PDO.php'; 
	 try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
	} catch(Exception $e)  {
	    print "Error!: " . $e->getMessage();
    }
    $sth = $db->prepare('CALL updateticketstatus(?,?)');	
	$sth->bindparam(1, $_POST['id'], PDO::PARAM_INT);
	$sth->bindparam(2, $_POST['status'], PDO::PARAM_INT);
	$sth->execute();


?>

