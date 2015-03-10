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
<?php include 'assets/php/nav.php'; ?>
<div class="container">
  <div class="row">
    <?php if($isadmin == "0" || $isadmin == "" || $isadmin == NULL){
            
			echo "<div class=\"alert alert-warning text-center\">Please log in to view or create tickets<br ><a href=\"login.php\" class=\"btn btn-warning\"><span class=\"glyphicon glyphicon-log-in\">&nbsp;</span>Login in</a></div>";
		} else {
 ?>
    <div class="col-md-6 col-sm-6">
      <h2 class="page-header pull-left">Administration</h2>
    </div>
    <div class="col-md-3 col-sm-8">
      <div class="panel panel-info">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6"> <i class="glyphicon glyphicon-user" style="font-size:5em;"></i></div>
            <div class="col-xs-6 text-right">
              <p class="announcement-heading"></p>
              <p class="announcement-text">Users</p>
              <p class="announcement-text"> <a href="admin.php?func=u" id="manage_users" class="btn btn-sm btn-info">Manage Users</a> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-8">
      <div class="panel panel-success">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6"> <i class="glyphicon glyphicon-list-alt" style="font-size:5em;"></i> </div>
            <div class="col-xs-6 text-right">
              <p class="announcement-heading"></p>
              <p class="announcement-text">Tickets</p>
              <p class="announcement-text"> <a href="admin.php?func=t" id="manage_tickets" class="btn btn-sm btn-info">Manage Tickets</a> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--    <div class="col-md-4 col-sm-6">
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
    </div>--> 
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
                      <input type="text" class="form-control" name="username" id="username">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="name" class="control-label">Name</label>
                    </div>
                    <div class="col-sm-10">
                      <input type="text"  class="form-control" name="name" id="name">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="email" class="control-label">Email</label>
                    </div>
                    <div class="col-sm-10">
                      <input type="text"  class="form-control" name="addusremail" id="addusremail">
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
                    <p>Password set to
                    <h3><span id="passblock"></span></h3>
                    </p>
                  </div>
                  <button type="button" class="btn btn-default" id="addusr-continue" data-dismiss="modal">Continue</button>
                </div>
                <div id="add-modal-buttons">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="add-user-btn">Add User</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h1 class="text-success text-left">
          <?=$page_title?>
        </h1>
        <span style="float: right; margin:5px;"><a class="btn btn-info" data-toggle="modal" data-target="#addusermodal"><span class="glyphicon glyphicon-user"></span>Add User</a></span>
        <table class="table table-hover table-striped" style=""
              data-search="true" data-select-item-name="toolbar1" id="admintable">
          <?php if($func =="u"){ 
$table_cols = 9; ?>
          <thead>
            <tr>
              <th class="info col-md-1" data-sortable="true">ID</th>
              <th class="info col-md-1" data-sortable="true">Username</th>
              <th class="info col-md-2" data-sortable="true">Name</th>
              <th class="info col-md-3" data-sortable="true">Email</th>
              <th class="info col-md-1" data-sortable="true">Dept</th>
              <th class="info col-md-1" data-sortable="true">Admin</th>
              <th class="info col-md-1 text-center">Edit</th>
              <th class="info col-md-1 text-center">Password</th>
              <th class="info col-md-1 text-center">Delete</th> 
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $sth->fetch()){ ?>
            <div class="modal fade deluser<?=$row['id']?>"  tabindex="-1" role="dialog" aria-hidden="true"> 
          
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Confirmation</h4>
              </div>
              <div class="modal-body">
                <form class="form" role="form" id="delconfirm<?=$row['id']?>">
                  <input type="hidden" name="id" value="<?=$row['id']?>">
                </form>
                <p>Are you sure you want to delete
                  <?=$row['rname']?>
                  from
                  <?=$row['dept']?>
                  ?</p>
              </div>
              <div class="modal-footer">
                <div class="alert alert-dimissable alert-success fade" style="display: none;" id="delusersuccess<?=$row['id']?>">User Deleted...Adios!! <a class="btn btn-success refresh" data-target="deluser<?=$row['id']?>" data-dismiss="modal"></a></div>
                <div  id="deluserfail<?=$row['id']?>">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary del-user-btn" id="<?=$row['id']?>">Detele user</button>
                </div>
              </div>
            </div>
          </div>
          </div>
            <div class="modal fade changepass<?=$row['id']?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Change User Password</h4>
              </div>
              <div class="modal-body text-center" style="background-color: white">
                <div id="passsuccess<?=$row['id']?>" style="display: none;">
                  <p>Password Changed to
                  <h3><span id="passblock<?=$row['id']?>"></span></h3>
                    </p>
                  
                  <a class="btn btn-success" data-dismiss="modal" data-target="changepass<?=$row['id']?>">Continue</a> </div>
                <div id="passfailure<?=$row['id']?>">
                  <form class="form" role="form" id="changepass<?=$row['id']?>">
                    <input type="hidden" name="userid" value="<?=$row['id']?>" />
                    <input type="hidden" name="isadmin" value="<?=$isadmin?>" />
                    <input type="hidden" name="email" value="<?=$_session['email']?>"/>
                    <p>Changing the password will change it forever and render the old password useless</p>
                    <a class="btn btn-danger changepassbtn" id="<?=$row['id']?>">Change Password</a>
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
                    <form class="form-horizontal<?=$row['id']?>" role="form" id="update<?=$row['id']?>">
                      <input type="hidden" name="id" id="id" value="<?=$row['id']?>">
                      <div class="form-group">
                        <div class="col-sm-2">
                          <label for="username" class="control-label"> Username</label>
                        </div>
                        <div class="col-sm-10">
                          <input type="text" value="<?=$row['username']?>" class="form-control" name="lusername">
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
                          <input type="checkbox" class="checkbox" name="isadmin" <?php if($row['isadmin'] == 1){echo "Checked";}?>  value="1" />
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="modal-footer">
                  <div id="success-buttons<?=$row['id']?>" style="display: none">
                    <div class="alert alert-dimissable alert-success" style="display: none;" id="update-success<?=$row['id']?>">User Details Changed!</div>
                    <button type="button" class="btn btn-default refresh" data-dismiss="modal">Continue</button>
                  </div>
                  <div id="modal-buttons<?=$row['id']?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary edituser" id="<?=$row['id']?>">Update</button>
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
            <td class="text-center"><?php if($row['isadmin'] == 1){
						echo "<span class=\"glyphicon glyphicon-ok\"></span>";
					} else {
						echo "<span class=\"glyphicon glyphicon-remove\"></span>";
					}?></td>
            <td class="text-center"><a data-toggle="modal" class="btn btn-md" data-target=".edituser<?=$row['id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>
            <td class="text-center"><a class="btn btn-md" data-toggle="modal" data-target=".changepass<?=$row['id'];?>"><span class="glyphicon glyphicon-cog"></span></a></td>
            <td class="text-center"><a class="btn btn-md" id="delete-user-btn<?=$row['id']?>" data-toggle="modal" data-target=".deluser<?=$row['id']?>"><span class="glyphicon glyphicon-trash"></span></a></td>
          </tr>
          <?php } ?>
          <?php } else if($func == "t"){
	$table_cols = 8; ?>
          <thead>
            <tr>
              <th class="info col-md-1" data-sortable="true">#</th>
              <th class="info col-md-3" data-sortable="true">Title</th>
              <th class="info col-md-2" data-sortable="true">Name</th>
              <th class="info col-md-1" data-sortable="true">Dept</th>
              <th class="info col-md-2" data-sortable="true">Date</th>
              <th class="info col-md-1" data-sortable="true">Priority</th>
              <th class="info col-md-1" data-sortable="true">Status</th>
             <!--  <th class="info col-md-1">Delete</th>-->
            </tr>
          </thead>
          <tbody>
             <?php while ($row = $sth->fetch()){ ?>
         <div class="modal fade deleteticket" id="deltktmodal<?=$row['tkt_id']?>">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                  <p draggable="true">Are you sure you want to delete
                    <?=$row['tkt_id']?>
                    -
                    <?=$row['tkt_title']?>
                    ?</p>
                <form role="form" id="del-tkt-form<?=$row['tkt_id']?>">
                    <input type="hidden" name="id" value="<?=$row['tkt_id']?>">
                  </form>
                </div>
                <div class="modal-footer" id="deltkt<?=$row['tkt_id']?>">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="delete-tkt-btn">Detele Ticket</button>
                </div> 
                <div id="modal-foot-sucess<?=$row['tkt_id']?>">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
                </div>
              </div>
            </div> 
          </div>
          <tr class="">
            <td class="linkable"><a href="edit_ticket.php?id=<?=$row['tkt_id']?>"> </a>
              <?=$row['tkt_id']?></td>
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
            <td><?php $tmpstatus = parse_status($row['tkt_status']);
			echo $tmpstatus[0];
			?></td>
          <!--<td><a class="btn btn-sm btn-block delete-ticket-btn" id="<?=$row['tkt_id']?>"><span class="glyphicon glyphicon-trash"></span></a></td> -->
          </tr>
          <?php  }
 } ?>
            </tbody>
          
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
        $(document).ready(function(){
			$('#add-user-btn').attr("disabled","disabled");   
			$('#addusremail').blur(function(){
	        	var v = $('#addusremail').val();
    	    	if(v.match(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i)){
        	   	 $('#add-user-btn').removeAttr('disabled');          
				}
			});

				$('#addusr-continue').click(function(){
					location.reload();	
				});
				$('#admintable').dataTable({
			            "iDisplayLength": 25
						
					});
			   
			    $('#admintable tr').click(function() {
			        var href = $(this).find("a").attr("href");
			        if(href) {
            			window.location = href;
			        }
			    });
				
				$('.refresh').click(function(){
					location.reload();
				});
				$('#admintable tr').hover(function() {
				      $(this).css('cursor','pointer');
				});
            	$(".edituser").click(function(){
						var x = this.id;
            	        $.ajax({
                		type: "POST",
            			url: "assets/php/edituser.php",
            			data: $('#update'+x).serialize(),	
                	    success: function(response){
                 		    $("#update-success"+x).show();
            				$("#modal-buttons"+x).hide();
							$("#edit-user-form"+x).hide();
                    		$("#success-buttons"+x).show();
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
            			data: $('#adduser').serialize(),	
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
						
				$(".changepassbtn").click(function(){
						var y = this.id;
            	        $.ajax({
                		type: "POST",
            			url: "assets/php/changepass.php",
            			data: $('#changepass'+y).serialize(),	
                	    success: function(response){
							$('#passsuccess'+y).show();
							$('#passfailure'+y).hide();
							$('#passblock'+y).html(response);
							
                     	},
            			error: function(){
            				alert("An error occurred: " & result.errorMessage);
            			}
                		});
            		});
				$(".del-user-btn").click(function(){
						var y = this.id;
            	        $.ajax({
                		type: "POST",
            			url: "assets/php/deleteuser.php",
            			data: $('#delconfirm'+y).serialize(),	
                	    success: function(response){
							$('#deluserfail'+y).hide();
							location.reload();							
                     	},
            			error: function(){
            				alert("An error occurred: " & result.errorMessage);
            			}
                		});
            	});		
        /*$(".delete-ticket-btn").click(function(){
						var y = this.id;
            	     	$.ajax({
                		type: "POST",
            			url: "assets/php/updateticketstatus.php",
            			data: $('#del-tkt-form'+y).serialize(),	
                	    success: function(response){
							 $('#deltkt'+y).hide();
							$('#modal-foot-sucess'+y).show();
							
                     	},
            			error: function(){
            				alert("An error occurred: " & result.errorMessage);
            			}
              		});
            		});	*/										
            	});
          </script> 
  </div>
  <?php } ?>
</div>
</div>
</body>
</html>