			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">ERROR</p>
  
  <hr class="my-4">
  <p>Unfortunately, You hit an Error... Feel free to trial again, if it's something that you SHOULD be able to do.. if it's something you shouldn't be doing... please stop :)</p>
  <hr class="my-4">
  <div class="text-center">
  <p>
  <button type="button" class="btn btn-danger btn-block btn-round-lg" data-toggle="modal" data-target="#viewError">View Error <?=ucwords($_GET['eid'])?></button>
</div></p>
</div>
	</div>
	</div>
</div>


<!-- Modal HTML -->
<div id="viewError" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Error Notification ( <?=ucwords($_GET['eid'])?> )</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<code>
				This is where the error code will go, In red.. because RED means BAD!
			</code>

		
      </div>
      <div class="modal-footer">
	  <small>Please Note; All Errors are Logged!</small>
	  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	  <a type="button" href="javascript:history.go(-1)" class="btn btn-outline btn-info" data-dismiss="modal">Go Back</a>
      </div>
    </div>
  </div>
</div> 
</body>
</html>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#viewError').modal('show');
    });
</script>