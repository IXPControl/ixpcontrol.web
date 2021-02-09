  			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">IRR Filter (IPv4 + IPv6)</p>
  
  <hr class="my-4">
  <p>Here at <?=$cfg['siteName']?> we utilize IRR Based Filtering on all prefixes announced to us, to protect yourself, your customers and the Exchange. In the options below, You will find the IPv4 &amp; IPv6 Filter Lists, as well as a list of any Subnets that we have detected no IRR For (and therefore Rejected from the RouteServers.)</p>
  <hr class="my-4">
  <div class="text-center">
//foreach ASN - do this...?
<p><div class="btn-group" role="group" aria-label="Links">
  <button type="button" class="btn btn-success btn-round-lg" data-toggle="modal" data-target="#About">AS123456 - IPv4 - Accepted</a></button>
  <button type="button" class="btn btn-danger btn-round-lg" data-toggle="modal" data-target="#About">AS123456 - IPv4 - Filtered</a></button>
 </div></p>
   <hr class="my-4">
<p><div class="btn-group" role="group" aria-label="Links">
  <button type="button" class="btn btn-success btn-round-lg" data-toggle="modal" data-target="#About">AS123456 - IPv6 - Accepted</a></button>
  <button type="button" class="btn btn-danger btn-round-lg" data-toggle="modal" data-target="#About">AS123456 - IPv6 - Filtered</a></button>
 </div></p>
</div>
</div>
	</div>
	</div>
</div>


<!-- Modal HTML -->
<div id="account" class="modal fade">
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
<input type="hidden" name="act" value="doAccount">

<div class="form-group">


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