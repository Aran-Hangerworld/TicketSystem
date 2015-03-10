<?php
/* Check POST ID has been sent and execute delete command */
 if($_POST['id'] <> ""){
 $tmpid = strip_tags($_POST['id']);
 include 'PDO.php'; 
	 try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
	} catch(Exception $e)  {
	    print "Error!: " . $e->getMessage();
    }
	$query= 'delete from tkt_support_users where id ='. $tmpid;
    $sth = $db->prepare($query);	
	$sth->execute(); 
 }
?>


