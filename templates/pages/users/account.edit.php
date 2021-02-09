 			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">Edit Account</p>
  
  <hr class="my-4">
  <p>Account: Active</p>
  <hr class="my-4">
  <div class="text-center">
  <p>
  <button type="button" class="btn btn-info btn-block btn-round-lg" data-toggle="modal" data-target="#account">Edit Account</button>
</div></p>
</div>
	</div>
	</div>
</div>


<!-- Modal HTML -->
<div id="account" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit User Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="/index.php" method="post">
<input type="hidden" name="act" value="doAccount">

<div class="form-group">
<?php
	//$r = dbQuery("SELECT", "ix_clients", "WHERE uid='$sessionID' LIMIT 1");
	
?>
<label for="Index-Of" class="formbuilder-select-label">Company Name<span class="formbuilder-required">*</span></label>
<input type="text" name="companyName" id="verify" class="form-control" value="<?=$r['userCompany']?>" required />

<label for="Index-Of" class="formbuilder-select-label">Contact First Name<span class="formbuilder-required">*</span></label>
<input type="text" name="userFirstname" id="verify" class="form-control" value="<?=$r['userFirstname']?>" required />

<label for="Index-Of" class="formbuilder-select-label">Contact Last Name<span class="formbuilder-required">*</span></label>
<input type="text" name="userLastname" id="verify" class="form-control" value="<?=$r['userLastname']?>" required />

<label for="Index-Of" class="formbuilder-select-label">Registered Email<span class="formbuilder-required">*</span></label>
<input type="text" name="userEmail" id="verify" class="form-control" value="<?=$r['userFirstname']?>" required />

<label for="Index-Of" class="formbuilder-select-label">Account Password<span class="formbuilder-required">*</span></label>
<input type="text" name="userPassword" id="verify" class="form-control" />


</div>
					<div class="form-group">
						<input type="submit" class="btn btn-info btn-block" value="Edit Account">
					</div>
</form>
	
      </div>
      <div class="modal-footer">
	  <small>Please Note; All Account Changes are logged.</small>
      </div>
    </div>
  </div>
</div> 
</body>
</html>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#account').modal('show');
    });
</script>