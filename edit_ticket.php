<?php
	//Start the session in here!
	session_start();
	$isadmin = $_SESSION['isadmin'];
	$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);	
	include 'assets/php/functions.php';
	include 'assets/php/PDO.php'; 
	//start DB connection
	  	try {
	$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
	} catch(Exception $e)  {
	    print "Error!: " . $e->getMessage();
    }
	include 'assets/php/header.php'; 
	?>
<body>
<?php include 'assets/php/nav.php'; ?>
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="col-md-6 col-sm-12">
        <h1 class="page-header pull-left">Edit Ticket</h1>
      </div>
      <div class="col-md-6 col-sm-12"></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12">  
      <?php
	$sth = $db->prepare('CALL GetTicket(?)');
	$sth->bindparam(1, $id, PDO::PARAM_STR);
	$sth->execute();
	if($row = $sth-> fetch()){
   ?>
      <form class="form-horizontal" role="form" id="editticket">
        <div class="form-group">
          <div class="col-sm-2">
            <div for="tkt-title"> <strong>Ticket No.</strong> </div>
          </div>
          <div class="col-sm-8">
            <p class="text-muted">
              <?=$row['tkt_id']?><input type="hidden" name="id" value="<?=$row['tkt_id']?>">
              <input type="hidden" name="status" value="<?=$row['tkt_status']?>" />
            </p>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-2">
            <label for="tkt-dept" class="control-label">Department</label>
          </div>
          <div class="col-sm-8">
            <select class="form-control" id="dept" name="dept">
              <option value="<?=$row['tkt_dept']?>">
              <?=$row['tkt_dept']?>
              </option>
              <option value="WH">Warehouse</option>
              <option value="AW">Amazon Warehouse</option>
              <option value="PR">Packing Room</option>
              <option value="AM">Amazon Admin</option>
              <option value="AD">Admin</option>
              <option value="CN">Content Team</option>
              <option value="IT">IT</option>
              <option value="HR">Human Resources</option>
              <option value="DI">Directors</option>
            </select>  
          </div>
          
        </div>
        <div class="form-group">
          <div class="col-sm-2">
            <label for="tkt-title" class="control-label">Title</label>
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="tkt-title" placeholder="Title"
                  name="title" value="<?=$row['tkt_title']?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-2">
            <label for="tkt-desc" class="control-label">Description</label>
          </div>
          <div class="col-sm-8">
            <textarea id="tkt-desc" name="desc" class="form-control" rows="3"><?=$row['tkt_description']?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-2">
            <label for="tkt-priority" class="control-label">Priority</label>
          </div>
          <div class="col-sm-8"><?php $priority = parse_priority($row['tkt_priority'])?>
            <select class="form-control" id="priority" name="priority">
              <option selected value="<?=$row['tkt_priority']?>"><?=$priority[0]?></option>
              <option value="1">Low</option>
              <option value="2">Medium</option>
              <option value="3">High</option>
              <option value="4">Urgent</option>
              <option value="5">We're all gonna die!</option>
            </select>
          </div>
          </div>
          <div class="form-group">
          <div class ="col-sm-2">
             <label for="tkt-status" class="control-label">Status</label>
          </div>
           <div class="col-sm-8"><?php $status = parse_status($row['tkt_status'])?>
            <select class="form-control" id="status" name="status">
              <option selected value="<?=$row['tkt_status']?>"><?=$status[0]?></option>
              <option value="1">Pending</option>
              <option value="2">Open</option>
              <option value="3">Resolved</option>
              <option value="4">On Hold</option>
              <option value="5">Cancelled</option>
            </select>
          </div>
        </div>
      <div class="col-md-10 alert alert-success" style="display:none" id="editticketsuccess" role="alert">Ticket Updated! <span class="text-right"><a class="goback btn-sm btn-success">Continue</a></span></div>
    <div class="col-md-10 text-right" id="editticketfail">
        <button type="button" class="btn btn-default goback" id="canceledit">Cancel</button>
		<button type="button" class="btn btn-warning edit-btn" id="edit-ticket-btn">Save Changes</button>
      </div>
 </form>
    </div>
  </div>
  <?php } ?>
</div>
</body>
<script>
$(document).ready(function(){

	$("#edit-ticket-btn").click(function(){
			 $.ajax({
    			 type: "POST",
				 url: "assets/php/editticket.php",
				 data: $('#editticket').serialize(),	
    		     success: function(){	
		 			$('#editticketsuccess').show();
					$('#editticketfail').hide();
         	},
			 error: function(){				
				alert("An error occurred: " & result.errorMessage);
			}
    	 	});
	 });
	 	$(".goback").click(function(){
			location.href = "admin.php";
	});
 });
</script>

</html>