<?php
if(isset($_POST['userid'])){
	include 'functions.php'; 
	include 'PDO.php'; 
	$response = CallAPI("GET","http://randomword.setgetgo.com/get.php");
	$num = rand(10,99);
	$newpasshash = md5(trim($response) . $num);
	$newpass = trim($response) . $num;
	echo $newpass;
	$uid = $_POST['userid'];
	try {
			$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
			} catch(Exception $e)  {
			    print "Error!: " . $e->getMessage();
		    }
		$sth = $db->prepare('CALL tkt_updatepass(?,?)');
		$sth->bindparam(1, $uid, PDO::PARAM_STR);
		$sth->bindParam(2, $newpasshash, PDO::PARAM_STR);
		$sth->execute(); 
} else {
echo "Oops - ". $_SESSION['isadmin'];
}
?>