<?php
if (isset($_POST['user']) && isset($_POST['pass'])) {
	$myusername=$_POST['username']; 
	$mypassword=$_POST['password'];
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	$mypassword = md5($mypassword);
	include 'PDO.php';
	try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
		} catch(Exception $e)  {
		    print "Error!: " . $e->getMessage();
	    }
	$sth = $db->prepare('CALL CheckLogin1(?,?)');
	$sth->bindparam(1, $myusername, PDO::PARAM_STR);
	$sth->bindparam(2, $mypassword, PDO::PARAM_STR);
	$sth->execute();
	echo $myusername . $mypassword;
	while ($row = $sth->fetch()){
		if($row['cnt'] == 1){
			session_start();
			$_session['user'] = $myusername;
			$_session['name'] = $row['rname'];
			$_session['email'] = $row['email'];
			$_session['lastlogin'] = $row['lastlogin'];		
		}
	} 
}
?>