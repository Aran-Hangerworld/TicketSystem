<?php 	
	//Start the session in here!
	session_start();
	$isadmin = $_SESSION['isadmin'];
	$ownerid = $_SESSION['uid'];
	if($isadmin){$isadminstr = "1";} else {$isadminstr = "0";}
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
  <?php

 	include 'assets/php/new-ticket.php';
	include 'assets/php/nav.php'; 
	?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6">
            <h1 class="page-header pull-left">
				<?php if(isset($_SESSION['name'])){ ?>Welcome <SMALL><?=$_SESSION['name']?> - <small><?=$_SESSION['dept']?></small></SMALL>
				<?php } else { 
					echo "Support Dashboard"; 
					} ?></h1>
          </div>
          <div class="col-md-3">
           <?php 
			if(isset($_SESSION['name'])){ 
				$sth = $db->prepare('CALL GetResolved(?,?,?)');
				$status = "3";
				$dept = $_SESSION['dept'];
				$sth->bindparam(1, $status, PDO::PARAM_INT);
				$sth->bindparam(2, $dept, PDO::PARAM_INT);
				$sth->bindparam(3, $isadminstr, PDO::PARAM_INT);
				$sth->execute();
				$resolved = $sth->fetchColumn(0);
				$sth = $db->prepare('CALL GetResolved(?,?,?)');
				$status = "1";		
				$sth->bindparam(1, $status, PDO::PARAM_INT);
				$sth->bindparam(2, $dept, PDO::PARAM_INT);
				$sth->bindparam(3, $isadminstr, PDO::PARAM_INT);	
				$sth->execute();
				$pending = $sth->fetchColumn(0);		
			?>
            <div class="clearfix visible-xs visible-sm"></div>
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="glyphicon glyphicon-check" style="font-size:5em;"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?=$resolved; ?></p>
                    <p class="announcement-text">Resolved</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="glyphicon glyphicon-edit" style="font-size:5em;"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading" ><?php echo $pending; ?></p>
                    <p class="announcement-text">Open</p>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <?php } ?>
        </div>
        <div class="row">
          <div class="col-md-12">
            <?php if(!isset($_SESSION['name'])){
            
			echo "<div class=\"alert alert-warning text-center\"><p>Please log in to view or create tickets</p><a href=\"login.php\" class=\"btn btn-warning\"><span class=\"glyphicon glyphicon-log-in\">&nbsp;</span>Login in</a></div>";
		} else { ?>
            <div class="fixed-table-toolbar">        <div style="position: relative; top:30px; left:175px; z-index:1" z-index="1"><a class="active btn btn-primary pull-left" style="margin-top:10px;"
              data-toggle="modal" data-target="#form-content" id="new-ticket-btn"><span class="glyphicon glyphicon-pencil"></span> New Ticket</a> </div>
                   
              <table class="table table-hover table-striped" style="" data-search="true"
              data-select-item-name="toolbar1" id="tickets">            
                <thead>
                  <tr>
                    <th class="info col-md-1" draggable="true">Ticket #</th>
                    <th class="info col-md-5">Title</th>
               <?php if($isadmin){ ?>
                    <th class="info col-md-2">Name</th> 
					<th class="info col-md-1">Dept</th>
					<?php } else { ?>                    
	                    <th class="info col-md-3">Name</th> 
                    <?php } ?>
                    <th class="info col-md-2" data-sortable="true">Date</th>
                    <th class="info col-md-1" data-sortable="true">Priority</th>
                  </tr>
                </thead>
                <tbody>
	<?php $sth = $db->prepare('CALL GetOpenTickets(?,?,?)');
	$department = $_SESSION['deptid'];
	$sth->bindparam(1, $department, PDO::PARAM_STR);
	$sth->bindparam(2, $isadminstr, PDO::PARAM_INT);
	$sth->bindparam(3, $ownerid, PDO::PARAM_STR);
	$sth->execute();
	while ($row = $sth->fetch()){
	 ?>               
                  <tr class="">
                    <td><a href="viewticket.php?id=<?=$row['tkt_id']?>"></a><?=$row['tkt_id']?></td>
                    <td><?=$row['tkt_title']?></td>
                    <td><?=$row['rname']?></td>
       <?php 
	   $cols=5;
	   if($isadmin){ 
	   $cols=6; 
	   ?>
       	            <td><?=$row['tkt_dept']?></td>
       <?php }  ?>
                    <td><? reverse_date($row['tkt_created']) ?></td>
		<?php 	$mypriority = parse_priority($row['tkt_priority']); ?>
                    <td class="text-right"><small><?php if(isset($mypriority[1])){ ?><span class="glyphicon glyphicon-<?=$mypriority[1];?>"></span> <?=$mypriority[0]?><?php } ?></small></td>
                  </tr>
       <?php } ?>      
		          </tbody>
                  <tfoot>
                  <tr><td colspan="<?=$cols?>" class="info"></td></tr>
                  </tfoot>
              </table>
            </div>
       <?php } ?>
          </div>
        </div>
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
   	     $('#tickets').dataTable({
			 "iDisplayLength": 25	
		});
		 $("#submit").click(function(){
	         $.ajax({
    		 type: "POST",
			 url: "assets/php/process.php",
			 data: $('form.form-horizontal').serialize(),	
    	     success: function(){
				 
     		    $("#thanks").show();
				$("#modal-buttons").hide();
        		$("#success-buttons").show();
				location.reload();
         	},
			 error: function(){
				
				alert("An error occurred: " & result.errorMessage);
			}
    	 	});
		 });
	   $('#tickets tr').click(function() {
        var href = $(this).find("a").attr("href");
        if(href) {
            window.location = href;
        }
    });
	$('#tickets tr').hover(function() {
        $(this).css('cursor','pointer');
    });
	 
	 });
</script>



 <script>
	 $(document).ready(function(){
		 $("#login-btn").click(function(){
	         $.ajax({
    		 type: "POST",
			 url: "assets/php/logincheck.php",
			 data: $('form#loginform').serialize(),	
    	     success: function(){
				 
				$("#loginbox").hide();
				$("#loginsuccess").show();
				$("#continuebtn").show();
				$("form.loginform").hide();
				 
         	},
			 error: function(){				
				alert("An error occurred: " & result.errorMessage);
			}
    	 	});
		 });
		$('#closenewtkt').click(function(){
			location.reload();
		});
		$('#continuebtn').click(function(){

			$('#login').modal('hide');
			$('#dept').val(0);
			$('#tkt-title').val('');
			$('textarea').val('');
			$('#priority').val(0);
			$("#thanks").hide();
			$("#success-buttons").hide();
			$("#modal-buttons").show();
			
		});
	 });
</script>
  </body>

</html>
<?php 	
	$db = null;
?>
      
      
      
      