<?php
if (isset($_POST['username'])) {
	include 'PDO.php'; 
	include 'functions.php';
	$lusername = strip_tags($_POST['username']);
	$name = strip_tags($_POST['name']);
	$email = strip_tags($_POST['addusremail']);
	$dept = strip_tags($_POST['dept']);
	$isdamin = strip_tags($_POST['isadmin']); 
	if(!isset($isadmin)){
		$isadmin = 0;
	}
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
	$sth->bindparam(1, $lusername, PDO::PARAM_STR);
	$sth->bindparam(2, $name, PDO::PARAM_STR);
	$sth->bindparam(3, $email, PDO::PARAM_STR);
	$sth->bindparam(4, $newpasshash, PDO::PARAM_STR);
	$sth->bindparam(5, $dept, PDO::PARAM_STR);
	$sth->bindparam(6, $isadmin, PDO::PARAM_INT);
	$sth->execute();
	


# Email confirm
	$mailto = "";
	$headers = "from".$from;
	$sub = "New User Created - Hangerworld Suppport";
	$msg = "Hi $name,\r\n A new user has been created for you to use on the Hangerworld support site.\r\n Username: $lusername \r\n Password: $newpass \r\n Log in via <a href=\"http://www.hangerworld.co.uk/tkt/\">http://www.hangerworld.co.uk/tkt/</a>\r\n Regards \r\n IT Dept.";
	$from = "info@hangerworld.co.uk";
	if (mail($mailto,$sub,$msg,$headers)){

echo "email on the way!";

	}; 
	 
	echo $newpass;
} else {
 echo "oops";
}
?>
