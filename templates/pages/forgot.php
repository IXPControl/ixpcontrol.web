			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">Forgot Password</p>
  
  <hr class="my-4">
  <p>Oh No!, You have forgotten your password.. Don't Worry, we can help you get access to your account again, fill in the form below, and you will recieve a email to your registered email account, after which you verify you are actually.. you, you will be able to set a new password.</p>
  <hr class="my-4">
  <div class="text-center">
  <p>
  <button type="button" class="btn btn-danger btn-block btn-round-lg" data-toggle="modal" data-target="#forgotModal">Forgot Password</button>
</div></p>
</div>
	</div>
	</div>
</div>


<!-- Modal HTML -->
<div id="forgotModal" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Forgot Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="/index.php" method="post">
<input type="hidden" name="act" value="doForgot">

<div class="form-group">
<label for="Index-Of" class="formbuilder-select-label">Enter Registered Email<span class="formbuilder-required">*</span></label>
<input type="email" name="email" id="email" class="form-control" placeholder="your@email.com" required />
</div>
					<div class="form-group">
						<input type="submit" class="btn btn-danger btn-block" value="Get Verification Email">
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
        $('#forgotModal').modal('show');
    });
</script>