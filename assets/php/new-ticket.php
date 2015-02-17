<div class="modal fade" id="form-content">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
			<?php    
			$sth = $db->prepare('select * from tkt_depts'); 
			$sth->execute();  
			?>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Submit new ticket</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form" id="newticket">
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="tkt-dept" class="control-label">Department</label>
                </div>
                <div class="col-sm-10">
                <select class="form-control" id="dept" name="dept">
                <?php  while ($row = $sth->fetch()){  ?>
					<option value="<?=$row['dcode']?>"><?=$row['dname']?></option>
				<?php } ?>
		      </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="tkt-title" class="control-label">Title</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="tkt-title" placeholder="Title"
                  name="tkt-title" id="title">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="tkt-desc" class="control-label">Description</label>
                </div>
                <div class="col-sm-10">
                  <textarea id="tkt-desc" name="tkt-desc" class="form-control" rows="3" id="desc"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="tkt-priority" class="control-label">Priority</label>
                </div>
                <div class="col-sm-10">
                      <select class="form-control" id="priority" name="priority">
            <?php $sth1 = $db->prepare('select * from tkt_priority'); 
			$sth1->execute();  ?>
        <?php while ($row1 = $sth1->fetch()){  ?>
				<option value="<?=$row1['priority_code']?>"><?=$row1['priority_desc']?></option>
				<?php } ?>  
		      </select>
                </div>
              </div>
              <input hidden="ownerid" value="<?=$_SESSION['name']?>"/>
            </form>
          </div>
          <div class="modal-footer">
          <div id="thanks" class="alert alert-success alert-dismissbale" style="display: none; text-align:left;" role="alert">Ticket Submitted. Thanks</div>                 
          <div id="error" class="alert alert-warning alert-dismissbale" style="display: none; text-align:left;" role="alert">Oh! A error has occurred.</div>
			<div id="success-buttons" style="display: none;"><a id="continuebtn" class="btn btn-success" data-dismiss="modal">Close</a></div>
			<div id="modal-buttons">
	            <a class="btn btn-default" id="closenewtkt" data-dismiss="modal">Close</a>
    	        <a class="btn btn-primary" id="submit">Submit</a>
            </div>
          </div>
        </div>
      </div>
    </div>