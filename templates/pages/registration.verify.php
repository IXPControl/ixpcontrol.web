			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">Account Verification</p>
  
  <hr class="my-4">
  <p>Thank you for Registering, Now.. we just need to confirm you are.. you... so, We've sent an email off to your registered account, Please click the link, or copy and paste the Verification Code in the form Below.</p>
  <hr class="my-4">
  <div class="text-center">
  <p>
  <button type="button" class="btn btn-info btn-block btn-round-lg" data-toggle="modal" data-target="#verifyModal">Verify Account</button>
</div></p>
</div>
	</div>
	</div>
</div>


<!-- Modal HTML -->
<div id="verifyModal" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Activate IXPControl Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="/index.php" method="post">
<input type="hidden" name="act" value="doVerify">

<div class="form-group">
<label for="Index-Of" class="formbuilder-select-label">Enter Account Verification Code<span class="formbuilder-required">*</span></label>
<?php if(isset($_GET['verifyCode'])){ ?>
<input type="text" name="userVerify" id="verify" class="form-control" value="<?=$_GET['verifyCode']?>" required />
<?php }else{ ?>
<input type="text" name="userVerify" id="verify" class="form-control" placeholder="abc123def456" required />
<?php } ?>
</div>
					<div class="form-group">
						<input type="submit" class="btn btn-info btn-block" value="Verify Account">
					</div>
</form>
	
      </div>
      <div class="modal-footer">
	  <small>Verification Email Sent to: <?=base64_decode(base64_decode($_GET['eCode']))?></small>
      </div>
    </div>
  </div>
</div> 
</body>
</html>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#verifyModal').modal('show');
    });
</script>