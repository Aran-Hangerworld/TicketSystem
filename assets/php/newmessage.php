<?php
if (isset($_POST['message']) && $_POST['message'] <> "") {
	include 'PDO.php'; 
	$msg = strip_tags($_POST['message']);
	$name = strip_tags($_POST['name']);
	$id = strip_tags($_POST['id']);
	
	try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
		} catch(Exception $e)  {
		    print "Error!: " . $e->getMessage();
	    }
	$sth = $db->prepare('CALL add_message(?,?,?)');
	$sth->bindparam(1, $msg, PDO::PARAM_STR);
	$sth->bindparam(2, $name, PDO::PARAM_STR);
	$sth->bindparam(3, $id, PDO::PARAM_INT);
	$sth->execute(); 
	
} else {
 echo "oops";
}
?>	