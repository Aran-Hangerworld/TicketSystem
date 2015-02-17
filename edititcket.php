<?php
	//Start the session in here!
	session_start();
	$isadmin = $_SESSION['isadmin'];
	$id = var_dump(filter_var($_GET['id'], FILTER_SANITIZE_STRING));	
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
          <div class="col-md-12">
            <div class="col-md-6 col-sm-12">
              <h1 class="page-header pull-left">Administration</h1>
            </div>
            <div class="col-md-6 col-sm-12"></div>
          </div>
        </div>       
        <div class="row">
           
            <h4 class="modal-title">Edit ticket</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form" id="editticket">
              <div class="form-group">
                <div class="col-sm-2">
                  <div for="tkt-title">
                    <strong>Ticket No.</strong>
                  </div>
                </div>
                <div class="col-sm-10">
                  <p class="text-muted">[Ticket No]</p>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="tkt-dept" class="control-label">Department</label>
                </div>
                <div class="col-sm-10">
                  <select class="form-control" id="dept" name="dept">
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
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="tkt-title" placeholder="Title"
                  name="tkt-title">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="tkt-desc" class="control-label">Description</label>
                </div>
                <div class="col-sm-10">
                  <textarea id="tkt-desc" name="tkt-desc" class="form-control" rows="3">[Description]</textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="tkt-priority" class="control-label">Priority</label>
                </div>
                <div class="col-sm-10">
                  <select class="form-control" id="priority" name="priority">
                    <option value="1">Low</option>
                    <option value="2">Medium</option>
                    <option value="3">High</option>
                    <option value="4">Urgent</option>
                    <option value="5">We're all gonna die!</option>
                  </select>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="delete-user-btn">Detele user</button>
          </div>
        </div>
      </div>