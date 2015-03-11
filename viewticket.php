<?php session_start();
	if(!isset($_SESSION['name'])){header('Location: login.php?err=2');}
	$isadmin = $_SESSION['isadmin'];
	include 'assets/php/functions.php';
	include 'assets/php/PDO.php'; 
	//start DB connection
	  	try {
	$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
	} catch(Exception $e)  {
	    print "Error!: " . $e->getMessage();
    }		
 	include 'assets/php/header.php';   ?>
<body>
<?php 	include 'assets/php/nav.php'; 	?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <?php $id = $_GET['id'];
	    $sth = $db->prepare('CALL GetTicket(?)');
		$sth->bindparam(1, $id, PDO::PARAM_STR);
		$sth->execute();
	 	if($row = $sth-> fetch()){
		 ?>
      <h1 class="page-header pull-left"> <span class="text-muted">#
        <?=$row['tkt_id']?>
        </span> -
        <?=$row['tkt_title']?>
        &nbsp;&nbsp;<small>
        <?=$row['rname']?>
        &nbsp; -
        <?=$row['tkt_dept']?>
        </Small></h1>
<?php $tktstatus = parse_status($row['tkt_status']);  ?>
      <div class="pull-right panel panel-<?=$tktstatus[1]?>">
        <div class="panel-heading">
          <?=$tktstatus[0]?>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title">
            <?=$row['tkt_title']?>
            <small>
            <?php reverse_date($row['tkt_created'])?>
            </small></h3>
        </div>
        <div class="panel-body">
          <p>
            <?=$row['tkt_description']?>
          </p>
        </div>
        <div class="panel-footer"><Small>Last Updated:
          <?=$row['tkt_lastmod']?>
          </Small></div>
      </div>


  <div class="panel panel-info">
    <div class="panel-heading">
      <h3 class="panel-title">Notes</h3>
    </div>
    <div class="panel-body">
      <form class="form-horizontal" role="form" id="updatenotes">
        <div class="col-md-12">
          <label for="notes" class="control-label">Add Notes for this ticket</label>
        </div>
        <div class="col-md-10">
          <textarea rows="2" id="notes" name="notes" class="form-control"></textarea>
          <input type="hidden" name="name" value="<?=$_SESSION['name'];?>" />
          <input type="hidden" name="id" value="<?=$row['tkt_id'];?>" />
        </div>
        <div class="col-md-2"> <a class="btn btn-info" id="addnotebtn">Add note</a> </div>
        <div id="updatenotesuccess" style="display: none">
          <h4 class="text-center text-success">Note added</h4>
        </div>
      </form>
      <div id="notestable"> </div>
    </div>
  </div>
</div>

<div class="col-md-4">
      <div class="panel panel-warning">
        <div class="panel-heading">
          <h3 class="panel-title">Tools</h3>
        </div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" id="tools" method="POST">
            <?php 
			$sth = $db->prepare('select * from tkt_status'); 
			$sth->execute();
			?>
            <div class="form-group updategroup" id="updategroup">
            <div class="col-md-12">
              <label for="status" class="control-label">Change Status?</label>
            </div>
            <div class="col-md-6">
            <?php $status = parse_status($row['tkt_status'])?>
            <select class="form-control" id="status" name="status">
              <?php  while ($strow = $sth->fetch()){  ?>
              <option value="<?=$strow['status_code']?>">
              <?=$strow['status_desc']?>
              </option>
              <?php } ?>
            </select>
            <input type="hidden" name="id" value="<?=$row['tkt_id']?>"/>
          </form>
        </div>
        <div class="col-md-6"><a class="btn btn-warning btn-md" id="updatebtn"><span class="glyphicon glyphicon-chevron-right"></span></a></div>
        
      </div>
      <div id="updategroupsuccess" style="display: none;">
        <h4 class="text-center text-success">Ticket updated</h4>
      </div>
    </div>
  </div>
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Discuss</h3>
    </div>
    <div class="panel-body" id="messages"> </div>
    <div class="panel-footer">
    <div id="success" style="display: none;" class="alert alert-success alert-dismissable text-center"> Message Added!
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    </div>
    <div id="msgform" style="margin-bottom: 5px">
    <form class="form-horizontal" role="form" id="newmessage" method="POST">
      <input type="text" name="message" class="form-control" id="message" placeholder="Message">
      <a class="btn btn-primary btn-block" id="submit">Submit</a>
      </div>
      </div>
      <input type="hidden" name="name" value="<?=$_SESSION['name'];?>" />
      <input type="hidden" name="id" value="<?=$row['tkt_id'];?>" />
    </form>
  </div>
  <?php }

$db = null; ?>
</div>
</div>
</div>
</body>
<script>
 $(document).ready(function(){
	$("#updatebtn").click(function() {
	$.ajax({
    	type: "POST",
		url: "assets/php/updateticketstatus.php",
		data: $('#tools').serialize(),	
    	success: function(){
     		    $("#updategroup").hide(); 
				$("#updategroupsuccess").show();
				location.reload();
		},
		 error: function(){	
				alert("An error occurred: " & result.errorMessage);
			}
    	 	});
		 });
	$("#addnotebtn").click(function() {
	$.ajax({
    	type: "POST",
		url: "assets/php/addnote.php",
		data: $('#updatenotes').serialize(),	
    	success: function(){				
				$("#updatenotessuccess").show();
				$("#updatenotessuccess").delay(3000).fadeOut('slow');	
				$("#notes").val('');			     
				$('#notestable').load('assets/php/getnotes.php?ticket_id=<?=$row['tkt_id']?>').fadeIn("fast");   		
		},
		 error: function(){	
				alert("An error occurred: " & result.errorMessage);
			}
    	 	});
		 });	 
	 
	$('#messages').load('assets/php/getmessages.php?ticket_id=<?=$row['tkt_id']?>').fadeIn("fast");
	$('#notestable').load('assets/php/getnotes.php?ticket_id=<?=$row['tkt_id']?>').fadeIn("fast");   
	
	$("#submit").click(function(){
		$.ajax({
    	type: "POST",
		url: "assets/php/newmessage.php",
		data: $('#newmessage').serialize(),	
    	success: function(){
     		    
				$("#success").show();
				$('#success').delay(3000).fadeOut('slow');
        		
		},
		 error: function(){	
				alert("An error occurred: " & result.errorMessage);
			}
    	 	});
		 });


		function auto_refresh(){
			var randomnumber = Math.floor(Math.random() * 100);0
			$('#messages').load('assets/php/getmessages.php?ticket_id=<?=$row['tkt_id']?>').fadeIn("fast");
		}
		var refreshId = setInterval(auto_refresh, 10000);
		auto_refresh(); 
});
</script>
</html>