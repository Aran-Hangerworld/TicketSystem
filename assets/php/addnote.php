<?php
if (isset($_POST['notes']) && $_POST['notes'] <> "") {
	include 'PDO.php'; 
	$note = strip_tags($_POST['notes']);
	$name = strip_tags($_POST['name']);
	$id = strip_tags($_POST['id']);
	
	try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
		} catch(Exception $e)  {
		    print "Error!: " . $e->getMessage();
	    }
	$sth = $db->prepare('CALL add_note(?,?,?)');
	$sth->bindparam(1, $note, PDO::PARAM_STR);
	$sth->bindparam(2, $name, PDO::PARAM_STR);
	$sth->bindparam(3, $id, PDO::PARAM_INT);
	$sth->execute(); 
	
} else {
 echo "oops";
}
?>	