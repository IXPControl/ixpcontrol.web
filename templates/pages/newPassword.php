			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">Set New Password</p>
  
  <hr class="my-4">
  <p>Well, Seems you are who you say you are... That's good, So.. lets set a new password, make sure it's complex enough that someone won't guess it, but simple enough that you'll remember!</p>
  <hr class="my-4">
  <div class="text-center">
  <p>
  <button type="button" class="btn btn-success btn-block btn-round-lg" data-toggle="modal" data-target="#newPassword">Set Net Password</button>
</div></p>
</div>
	</div>
	</div>
</div>


<!-- Modal HTML -->
<div id="newPassword" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Set Password (Verified)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="/index.php" method="post">
<input type="hidden" name="act" value="doForgot">

<div class="form-group">
<label for="Index-Of" class="formbuilder-select-label">Set Password<span class="formbuilder-required">*</span></label>
<input type="password" name="password1" class="form-control" placeholder="password123" maxlength="48" required />
</div>
<div class="form-group">
<label for="Index-Of" class="formbuilder-select-label">Set Password<span class="formbuilder-required">*</span></label>
<input type="password" name="password2" class="form-control" placeholder="password123" maxlength="48" required />
</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success btn-block" value="Set New Password">
					</div>
</form>
	
      </div>
      <div class="modal-footer">
	  <small>Please Note; All Password Reset Attempts are Logged!</small>
      </div>
    </div>
  </div>
</div> 
</body>
</html>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#newPassword').modal('show');
    });
</script>