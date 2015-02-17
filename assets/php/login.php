	<div class="modal fade" id="login">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
			<div id="loginsuccess" style="display:none"><h3>Welcome back <?=$_session['name']?></h3></div>
            <div id="loginfailure" style="display:none"><h3>Login credential were incorrect</h3></div>
          	<div id="loginbox">	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            <h4 class="modal-title">Please log in with your username and password
    	          <br>
        	    </h4>
				          </div>	          </div>
    	      <div class="modal-body" id="logininformbox">
        	    <form class="loginform" role="form">
            	  <div class="form-group">
               	 <div class="col-sm-2">
	                  <label for="user" class="control-label">Name</label>
    	            </div>
        	        <div class="col-sm-10">
            	      <input type="email" class="form-control" id="user" placeholder="FirstName.LastName">
	                </div>
    	          </div>
        	       <div class="form-group">
            	    <div class="col-sm-2">
	                  <label for="pass" class="control-label">Password</label>
    	            </div>
        	        <div class="col-sm-10">
	                  <input type="password" class="form-control" id="pass" placeholder="Password">
	                </div>
	              </div>
	              <div class="form-group">
	                <div class="modal-footer">
	                  <a class="btn btn-default" data-dismiss="modal">Cancel</a>
	                  <a class="btn btn-primary" id="login-btn"><span class="glyphicon glyphicon-log-in">&nbsp;</span>Log in</a>	
    	            </div>
        	      </div>
            	</form>
                <div id="continuebtn" style="display: none;"><a class="btn btn-success" data-dimiss="modal">Continue</a></div>
	          </div>
          </div>
        </div>
   	  </div>
    </div>