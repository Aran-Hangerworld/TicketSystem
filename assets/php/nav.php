 <div class="navbar navbar-default navbar-static-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <a type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"></a>
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <a class="navbar-brand" href="http://www.hangerworld.co.uk/tkt/index.php">Hangerworld Support</a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse" style="padding-top:10px"> 
		<ul class="nav navbar-nav navbar-right">
        <?php if($isadmin){ ?>        
			  <a class="active btn btn-primary btn-sm"  href="admin.php"><span class="glyphicon glyphicon-cog">&nbsp;</span>Admin</a>
         <?php } ?>
        <?php if(isset($_SESSION['name'])){
			 ?>
			  <a class="active btn btn-primary btn-sm"  href="logout.php"><span class="glyphicon glyphicon-log-out">&nbsp;</span>Log out</a>
		<?php 		  
		  } else {
			 ?>
			  <a class="active btn btn-block btn-primary btn-sm" href="login.php"
            ><span class="glyphicon glyphicon-log-in">&nbsp;</span>Log in</a>
		<?php	  
		  }
		  ?>

          
            
          </ul>
        </div>
      </div>
    </div>