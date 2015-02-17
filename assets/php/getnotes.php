<br />
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
	$notesth = $db->prepare('CALL Gettktnotes(?)');
	$notesth->bindparam(1, $tkt_id, PDO::PARAM_INT);
	$notesth->execute();
	while ($noterow = $notesth->fetch()){ ?>
          <tr><td><p><?=$noterow['note_content']?><br /><span class="text-muted text-right"><?=$noterow['note_owner']?> - <?=$noterow['note_submitted']?></span></p></td></tr>
	<?php } 
	$db = null;
	?>		  
</table>