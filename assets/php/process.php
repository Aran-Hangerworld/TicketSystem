<?php
if (isset($_POST['tkt-title'])) {
	
	include 'PDO.php';	
		
	$title = strip_tags($_POST['tkt-title']);
	$description = strip_tags($_POST['tkt-description']);
	$ownerid = strip_tags($_POST['ownerid']);
	$dept = strip_tags($_POST['dept']);
	$priority = strip_tags($_POST['priority']);
	$status = 1;
	$attachments = 0;
	$messages = 0;
	try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
		} catch(Exception $e)  {
		    print "Error!: " . $e->getMessage();
	    }
	$sth = $db->prepare('CALL add_ticket(?,?,?,?,?,?,?,?)');
	$sth->bindparam(1, $ownerid, PDO::PARAM_STR);
	$sth->bindparam(2, $dept, PDO::PARAM_STR);
	$sth->bindparam(3, $priority, PDO::PARAM_INT);
	$sth->bindparam(4, $title, PDO::PARAM_STR);
	$sth->bindparam(5, $description, PDO::PARAM_STR);
	$sth->bindparam(6, $status, PDO::PARAM_INT);
	$sth->bindparam(7, $attachments, PDO::PARAM_INT);
	$sth->bindparam(8, $messages, PDO::PARAM_INT);
	$sth->execute(); 

} else {
	echo "oops";
}
?>	