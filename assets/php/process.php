<?php
include "PDO.php";
try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
		} catch(Exception $e)  {
		    print "Error!: " . $e->getMessage();
	    }
if (isset($_POST['tkt-title'])) {
				
	$title = strip_tags($_POST['tkt-title']);
	$description = strip_tags($_POST['tkt-desc']);
	$ownerid = strip_tags($_POST['ownerid']);
	$dept = strip_tags($_POST['dept']);
	$priority = strip_tags($_POST['priority']);
	$status = 1;
	$attachments = 0;
	$messages = 0;
	
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
	/*$sub = "New ticket submitted - $title";
	$msg = "A new ticket has been submitted. \r\n Please log into the Hangerworld support \r\n Ticket Priority: $priority";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	if(isset($_session['email'])){
		sendSMTP($_session['email'],$sub,$msg,$headers);			
	} else {
	echo "Session Expired!";	
	}
*/

};


if (isset($_POST['username'])){
	$lusername = strip_tags($_POST['username']);	
};
$sth = $db->prepare('Select COUNT(username) as cnt FROM tkt_support_users WHERE username ="'.$lusername.'"');
$sth->execute();
while ($row = $sth->fetch()){
echo $row['cnt'];	
}
?>	