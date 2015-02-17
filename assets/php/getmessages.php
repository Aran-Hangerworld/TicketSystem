<table class="table table-condensed table-responsive">
<?php
	include 'functions.php';
	include 'PDO.php'; 
	$tkt_id = $_GET['ticket_id'];
	 try {
		$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
	} catch(Exception $e)  {
	    print "Error!: " . $e->getMessage();
    }
    $sth = $db->prepare('CALL GettktMessages(?)');	
	$sth->bindparam(1, $tkt_id, PDO::PARAM_INT);
	$sth->execute();
	while($msgrow = $sth->fetch()){ 
	$subtimedate = explode(" ",$msgrow['tkt_mess_submitted']);
	?>
    
    <tr><td><?=$msgrow['tkt_message']?><br /><small class="text-muted"><?=$msgrow['tkt_mess_user']?> - <?=reverse_date($subtimedate[0])?> - <?=$subtimedate[1]?></small></td></tr>
<?php } ?>
</table>