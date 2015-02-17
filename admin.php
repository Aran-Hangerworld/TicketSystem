<?php
	//Start the session in here!
	session_start();
	$isadmin = $_SESSION['isadmin'];
	$func = filter_var($_GET['func'], FILTER_SANITIZE_STRING);	
	if($func == "" || $func == NULL){
		$table_cols = 7;
		$func ="t";
	}
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
<div class="modal fade" id="deleteuser">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
      <div class="modal-body">
        <p draggable="true">Are you sure you want to delete [Real Name] from [Department?]</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="delete-user-btn">Detele user</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteticket">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
      <div class="modal-body">
        <p draggable="true">Are you sure you want to delete [Ticket #] - [Ticket Title?]</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="delete-tkt-btn">Detele Ticket</button>
      </div>
    </div>
  </div>
</div>
<?php include 'assets/php/nav.php'; ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-6 col-sm-12">
        <h1 class="page-header pull-left">Administration</h1>
      </div>
      <div class="col-md-6 col-sm-12"></div>
    </div>
  </div>
  <div class="row">
    <?php if($isadmin == "0" || $isadmin == "" || $isadmin == NULL){
            
			echo "<div class=\"alert alert-warning text-center\">Please log in to view or create tickets<br ><a href=\"login.php\" class=\"btn btn-warning\"><span class=\"glyphicon glyphicon-log-in\">&nbsp;</span>Login in</a></div>";
		} else {
 ?>
    <div class="col-md-4 col-sm-6">
      <div class="panel panel-info">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6"> <i class="glyphicon glyphicon-user" style="font-size:5em;"></i> </div>
            <div class="col-xs-6 text-right">
              <p class="announcement-heading">&nbsp;</p>
              <p class="announcement-text">Users</p>
              <p class="announcement-text"> <a href="admin.php?func=u" id="manage_users" class="btn btn-sm btn-info">Manage Users</a> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="panel panel-success">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6"> <i class="glyphicon glyphicon-list-alt" style="font-size:5em;"></i> </div>
            <div class="col-xs-6 text-right">
              <p class="announcement-heading">&nbsp;</p>
              <p class="announcement-text">Tickets</p>
              <p class="announcement-text"> <a href="admin.php?func=t" id="manage_tickets" class="btn btn-sm btn-info">Manage Tickets</a> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="panel panel-warning">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6"> <i class="glyphicon glyphicon-cog" style="font-size:5em;"></i> </div>
            <div class="col-xs-6 text-right">
              <p class="announcement-heading">&nbsp;</p>
              <p class="announcement-text">Settings</p>
              <p class="announcement-text" draggable="true"> <a href="admin.php?func=s" id="manage-settings" class="btn btn-sm btn-info">Manage Settings</a> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="fixed-table-toolbar">
        <?php 
			if($func == "u"){
				$page_title = "User Administration";
				$sth = $db->prepare('Select * from tkt_support_users order by rname');
				$sth->execute();
			} else if($func == "t") {
				$page_title = "Ticket Administration";
				$sth = $db->prepare('SELECT * FROM tkt_support_tickets as A inner join tkt_support_users as B on A.tkt_ownerid = B.id');
				$sth->execute();
				
			
			} else if ($func == "s"){
				$page_title = "Settings - Under Construction";				
			} else {
				$page_title = "Error!";		
			}	
		?>
        <div class="modal fade" id="addusermodal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add New User</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" role="form" id="adduser">
                  <input type="hidden" name="id" id="id" value="<?=$row['id']?>">
                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="username" class="control-label"> Username</label>
                    </div>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="username">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="name" class="control-label">Name</label>
                    </div>
                    <div class="col-sm-10">
                      <input type="text"  class="form-control" name="name">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="email" class="control-label">Email</label>
                    </div>
                    <div class="col-sm-10">
                      <input type="text"  class="form-control" name="email">
                    </div>
                  </div>
                  <?php    
			$dsth = $db->prepare('select * from tkt_depts'); 
			$dsth->execute();  
			?>
                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="dept" class="control-label">Department</label>
                    </div>
                    <div class="col-sm-10">
                      <select class="form-control" id="dept" name="dept">
                        <?php  while ($deptrow = $dsth->fetch()){  ?>
                        <option value="<?=$deptrow['dcode']?>">
                        <?=$deptrow['dname']?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="isadmin" class="control-label">Admin</label>
                    </div>
                    <div class="col-sm-10">
                      <input type="checkbox" class="checkbox" name="isadmin" />
                    </div>
                  </div>
                </form>
              </div>
	        
            <div class="modal-footer">
              <div id="adduser-successmsg" style="display: none">
                <div class="alert alert-dimissable alert-success text-center"  >
                  <h4>User Added Successfully</h4>
                 <p>Password Changed to
                  <h3><span id="passblock"></span></h3></p>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
              </div>
              <div id="add-modal-buttons">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add-user-btn">Add User</button>
              </div>
            </div>
          </div>
        </div>
        </div>
        <h1 class="text-success" style="float: left">
          <?=$page_title?>
        </h1>
        <span style="float: right"><a class="btn btn-info" data-toggle="modal" data-target="#addusermodal"><span class="glyphicon glyphicon-user"></span> Add User</a></span>
        <table class="table table-hover table-striped" style=""
              data-search="true" data-select-item-name="toolbar1" id="admintable">
          <thead>
            <?php if($func =="u"){ 
$table_cols = 9; ?>
            <tr>
              <th class="info col-md-1" data-sortable="true">ID</th>
              <th class="info col-md-1" data-sortable="true">Username</th>
              <th class="info col-md-2" data-sortable="true">Name</th>
              <th class="info col-md-3" data-sortable="true">Email</th>
              <th class="info col-md-1" data-sortable="true">Dept</th>
              <th class="info col-md-1" data-sortable="true">Is Admin?</th>
              <th class="info col-md-1 text-center">Edit</th>
              <th class="info col-md-1 text-center">Password</th>
              <th class="info col-md-1 text-center">Delete</th>
            </tr>
            <?php while ($row = $sth->fetch()){ ?>
          <div class="modal fade changepass<?=$row['id']?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Change User Password</h4>
              </div>
              <div class="modal-body text-center" style="background-color: white">
                <div id="passsuccess" style="display: none;">
                  <p>Password Changed to
                  <h3><span id="passblock"></span></h3>
                    </p>
                  
                  <a class="btn btn-success" data-dismiss="modal" data-target="changepass<?=$row['id']?>">Continue</a> </div>
                <div id="passfailure">
                  <form class="form" role="form" id="changepass">
                    <input type="hidden" name="userid" value="<?=$row['id']?>" />
                    <input type="hidden" name="isadmin" value="<?=$isadmin?>" />
                    <input type="hidden" name="email" value="<?=$_session['email']?>"/>
                    <p>Changing the password will change it forever and render the old password useless</p>
                    <a class="btn btn-danger" id="changepassbtn">Change Password</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade edituser<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title">Edit User</h4>
                </div>
                <div class="modal-body">
                  <div id="edit-user-form">
                    <form class="form-horizontal" role="form" id="edituser">
                      <input type="hidden" name="id" id="id" value="<?=$row['id']?>">
                      <div class="form-group">
                        <div class="col-sm-2">
                          <label for="username" class="control-label"> Username</label>
                        </div>
                        <div class="col-sm-10">
                          <input type="text" value="<?=$row['username']?>" class="form-control" name="username">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-2">
                          <label for="name" class="control-label">Name</label>
                        </div>
                        <div class="col-sm-10">
                          <input type="text" value="<?=$row['rname']?>" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-2">
                          <label for="email" class="control-label">Email</label>
                        </div>
                        <div class="col-sm-10">
                          <input type="text" value="<?=$row['email']?>" class="form-control" name="email">
                        </div>
                      </div>
                      <?php    
			$dsth = $db->prepare('select * from tkt_depts'); 
			$dsth->execute();  
			?>
                      <div class="form-group">
                        <div class="col-sm-2">
                          <label for="dept" class="control-label">Department</label>
                        </div>
                        <div class="col-sm-10">
                          <select class="form-control" id="dept" name="dept">
                            <?php  while ($deptrow = $dsth->fetch()){  ?>
                            <option value="<?=$deptrow['dcode']?>" <?php if($row['dept'] == $deptrow['dcode']){ echo "Selected";} ?>>
                            <?=$deptrow['dname']?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-2">
                          <label for="isadmin" class="control-label">Admin</label>
                        </div>
                        <div class="col-sm-10">
                          <input type="checkbox" class="checkbox" name="isadmin" <?php if($row['isadmin'] == 1){echo "Checked";}?>  />
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="alert alert-dimissable alert-success" style="display: none;" id="update-success">User Details Changed!</div>
                </div>
                <div class="modal-footer">
                  <div id="success-buttons" style="display: none">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
                  </div>
                  <div id="modal-buttons">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit-user-btn">Update</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <tr class="">
            <td class="linkable"><?=$row['id']?></td>
            <td class="linkable"><?=$row['username']?></td>
            <td class="linkable"><?=$row['rname']?></td>
            <td class="linkable"><?=$row['email']?></td>
            <td class="linkable"><?=$row['dept']?></td>
            <td class="text-center"><?php if($row['isadmin'] = 1){
						echo "<span class=\"glyphicon glyphicon-ok\"></span>";
					} else {
						echo "<span class=\"glyphicon glyphicon-remove\"></span>";
					}?></td>
            <td class="text-center"><a data-toggle="modal" class="btn btn-md" data-target=".edituser<?=$row['id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>
            <td class="text-center"><a class="btn btn-md" data-toggle="modal" data-target=".changepass<?=$row['id'];?>"><span class="glyphicon glyphicon-cog"></span></a></td>
            <td class="text-center"><a class="btn btn-md" href="" id="delete-user-btn"><span class="glyphicon glyphicon-trash"></span></a></td>
          </tr>
          <?php } ?>
          <?php } else if($func == "t"){
	$table_cols = 7; ?>
          <tr>
            <th class="info col-md-1" data-sortable="true">Ticket #</th>
            <th class="info col-md-4" data-sortable="true">Title</th>
            <th class="info col-md-2" data-sortable="true">Name</th>
            <th class="info col-md-1" data-sortable="true">Dept</th>
            <th class="info col-md-2" data-sortable="true">Date</th>
            <th class="info col-md-1" data-sortable="true">Priority</th>
            <th class="info col-md-1">Delete</th>
          </tr>
          <?php while ($row = $sth->fetch()){ ?>
          <tr class="">
            <td class="linkable"><a href="edit_ticket.php?id=<?=$row['tkt_id']?>">
              <?=$row['tkt_id']?>
              </a></td>
            <td class="linkable"><?=$row['tkt_title']?></td>
            <td class="linkable"><?=$row['rname']?></td>
            <td class="linkable"><?=$row['tkt_dept']?></td>
            <td class="linkable"><?=reverse_date($row['tkt_created'])?></td>
            <td class="text-right"><?php $mypriority = parse_priority($row['tkt_priority']);?>
              <small>
              <?php if(isset($mypriority[1])){ ?>
              <span class="glyphicon glyphicon-<?=$mypriority[1];?>"></span>
              <?=$mypriority[0]?>
              <?php } ?>
              </small></td>
            <td><a class="btn btn-sm btn-block" href="" id="delete-ticket-btn"><span class="glyphicon glyphicon-trash"></span></a></td>
          </tr>
          <?php  }
 } ?>
            </thead>
          
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="<?php echo $table_cols;?>" class="info text-center"><ul class="pagination">
                  <li> <a href="#">Prev</a> </li>
                  <li> <a href="#">1</a> </li>
                  <li> <a href="#">2</a> </li>
                  <li> <a href="#">3</a> </li>
                  <li> <a href="#">4</a> </li>
                  <li> <a href="#">5</a> </li>
                  <li> <a href="#">Next</a> </li>
                </ul></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <script>
            $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {
             var $target = $( event.currentTarget );
             $target.closest( '.btn-group' )
                .find( '[data-bind="label"]' ).text( $target.text() )
                   .end()
                .children( '.dropdown-toggle' ).dropdown( 'toggle' );
             return false;    
          });
          </script> 
    <script>
            $(document).ready(function(){
            		$("#edit-user-btn").click(function(){
            	        $.ajax({
                		type: "POST",
            			url: "assets/php/edituser.php",
            			data: $('form.form-horizontal').serialize(),	
                	    success: function(){
                 		    $("#update-success").show();
            				$("#modal-buttons").hide();
							$("#edit-user-form").hide();
                    		$("#success-buttons").show();
                     	},
            			error: function(){
            				alert("An error occurred: " & result.errorMessage);
            			}
                		});
            		});			
			$("#add-user-btn").click(function(){
            	        $.ajax({
                		type: "POST",
            			url: "assets/php/adduser.php",
            			data: $('form.form-horizontal').serialize(),	
                	    success: function(response){
                 		    $("#adduser-successmsg").show();
                 		    $("#adduser-successbtns").show();
							$('#passblock').html(response);
            				$("#add-modal-buttons").hide();
							$("#adduser").hide();
       
                     	},
            			error: function(){
            				alert("An error occurred: " & result.errorMessage);
            			}
                		});
            		});						
						
				$("#changepassbtn").click(function(){
            	        $.ajax({
                		type: "POST",
            			url: "assets/php/changepass.php",
            			data: $('#changepass').serialize(),	
                	    success: function(response){
							$('#passsuccess').show();
							$('#passfailure').hide();
							$('#passblock').html(response);
							
                     	},
            			error: function(){
            				alert("An error occurred: " & result.errorMessage);
            			}
                		});
            		});				
            	});
          </script> 
  </div>
  <?php } ?>
</div>
</div>
</body>
</html>