<?php session_start();
include 'assets/php/PDO.php';
	// if post arrary is populated carry on. other wise show login form.
	if (isset($_POST['user']) && isset($_POST['pass'])) {
		$myusername=$_POST['user']; 
		$mypassword=$_POST['pass'];
		$myusername = stripslashes($myusername);
		$mypassword = stripslashes($mypassword);
		$mypassword = md5($mypassword); 
		try {
			$db = new PDO("mysql:host=$hostname;dbname=$username", $username, $password);	
		} catch(Exception $e)  {
		    print "Error!: " . $e->getMessage();
	    }
		//check the login details with a select stmt
		$sth = $db->prepare('Call CheckLogin1(:uservar,:passvar)');
		$sth->bindparam(':uservar', $myusername, PDO::PARAM_STR);
		$sth->bindparam(':passvar', $mypassword, PDO::PARAM_STR);
		$sth->execute();	
		//if there are records, then check how many. $row will always have records since cnt is a var

		if($row = $sth->fetch()){
			if($row['cnt'] == 1){
			//create a session to store user data
			$_SESSION['uid'] = $row['id'];
			$_SESSION['user'] = $row['username'];
			$_SESSION['name'] = $row['rname'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['dept'] = $row['dname'];
			$_SESSION['deptid'] = $row['dcode'];
			$_SESSION['lastlogin'] = $row['lastlogin'];	
			$_SESSION['isadmin'] = $row['isadmin'];
				
			// Update the last known login date				
			$sth = $db->prepare('Call updatelastloggedin(:uservar,:lastloggedin)');
			$sth->bindparam(':uservar', $myusername, PDO::PARAM_STR);
			$today = date("Y-n-j"); 	
			$sth->bindparam(':lastloggedin', $today , PDO::PARAM_STR);
			$sth->execute();
			header('Location: index.php');
			?>          
   <?php include 'assets/php/header.php'; ?>
   <body>
   <?php include 'assets/php/nav.php'; ?>

    <div class="container">
    <div class="row">
    <div class="col-md-6 center-block" style="float:none">        
				<div class="panel panel-success">
					<div class="panel-heading">
		    	   		<h1 class="panel-title">Thanks for logging in</h1>
				    </div>
		        	<div class="panel-body text-center">
			      		<h2>Welcome back <?=$row['rname']?></h2><br /><a href="index.php" class="btn btn-success">Continue <span class="glyphicon glyphicon-share-alt"></span></a>
			   		</div>
			   </div> 
<?php 	
		} else {
			header('Location: login.php?err=1');	
		}
		} else {
			header('Location: login.php?err=1');
			
		}
	} else { ?>
       <?php include 'assets/php/header.php'; ?>
  <body>
   <?php include 'assets/php/nav.php'; ?>

        <div class="container">
    <div class="row">
    <div class="col-md-6 center-block" style="float:none">
    <?
		if(isset($_GET['err'])){
			$errmsg = $_GET['err'];
			if($errmsg == "1"){$errtxt = "Login Details Incorrect!";}
			if($errmsg == "2"){$errtxt = "Session Timed out!";}
			 ?>
				<div class="panel panel-warning">
				<div class="panel-heading">
			        <h3 class="panel-title"><?=$errtxt; ?></h1>
			    </div>
            	<?php
		
		} else {
		?>
            <div class="panel panel-info">
				<div class="panel-heading">
			        <h1 class="panel-title">Please sign in</h1>
			    </div>
			
<?php } ?>
		

     <div class="panel-body">
      <form class="form-signin" method="POST" action="login.php">

        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="user" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="pass">
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
	</div>
	</div>
    <?php } ?>
    </div>
    </div>
    </div> <!-- /container -->
    <?php 
	include 'assets/php/footer.php'; 
	?>
	</body>
</html>