<?php
if (isset($_POST['username'])) {
	include 'PDO.php'; 
	include 'functions.php';
	$username = strip_tags($_POST['username']);
	$name = strip_tags($_POST['name']);
	$email = strip_tags($_POST['email']);
	$dept = strip_tags($_POST['dept']);
	$isdamin = strip_tags($_POST['isadmin']);
	
	
	# Get new password
	$response = CallAPI("GET","http://randomword.setgetgo.com/get.php");
	$num = rand(10,99);
	$newpasshash = md5(trim($response) . $num);
	$newpass = trim($response) . $num;
	# End of password
	
	try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
		} catch(Exception $e)  {
		    print "Error!: " . $e->getMessage();
	    }
	$sth = $db->prepare('CALL adduser(?,?,?,?,?,?)');
	$sth->bindparam(1, $username, PDO::PARAM_STR);
	$sth->bindparam(2, $name, PDO::PARAM_STR);
	$sth->bindparam(3, $email, PDO::PARAM_STR);
	$sth->bindparam(4, $newpasshash, PDO::PARAM_STR);
	$sth->bindparam(5, $dept, PDO::PARAM_STR);
	$sth->bindparam(6, $isadmin, PDO::PARAM_int);

	$sth->execute(); 

	echo $newpass;
} else {
 echo "oops";
}
?>	
