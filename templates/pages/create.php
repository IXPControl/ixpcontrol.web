			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">Create New IXP Connection</p>
  
  <hr class="my-4">
  <p>That's Great!, You want to connect!.. lets get you to fill in this form.. and we'll be on our way!</p>
  <hr class="my-4">
  <div class="text-center">
  <p>
  <button type="button" class="btn btn-success btn-block btn-round-lg" data-toggle="modal" data-target="#connect">Create IXP Connection</button>
</div></p>
</div>
	</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="connect" tabindex="-1" role="dialog" aria-labelledby="connect" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="connect">Connect to OceanIX</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/?act=createIXP" method="post">
  <div class="form-group">
    <label for="exampleFormControlInput1">Company / Name</label>
    <input type="text" class="form-control" id="company" name="company" placeholder="OceanIX Internet Exchange" maxlength="40" required>
  </div>
   <div class="form-group">
    <label for="exampleFormControlInput1">NOC Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">ASN</label>
    <input type="text" class="form-control" id="asn" name="asn" placeholder="AS123456" maxlength="20" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Peering AS-SET</label>
    <input type="text" class="form-control" id="asset" name="asset" placeholder="AS-OCEANIX" maxlength="30" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Location</label>
    <select class="form-control" name="ocix-location" id="location" required>
	  <option selected disabled>SELECT</option>
      <option value="OCIX-SA">OCIX-SA (Adelaide, South Australia) - Sponsored By NetworkPresence</option>
	  <option value="OCIX-NZ">OCIX-NZ (Auckland, New Zealand) - Sponsored By ZappieHost</option>
	  <option value="OCIX-QLD">OCIX-QLD (Brisbane, Queensland) - Sponsored By RouteIX Networks</option>
	  <option value="OCIX-WA">OCIX-VIC (Melbourne, Victoria) - Sponsored By RouteIX Networks</option>
	  <option value="OCIX-WA">OCIX-WA (Perth, Western Australia) - Sponsored By RouteIX Networks</option>
	  <option value="OCIX-NSW">OCIX-NSW (Sydney, New South Wales) - Sponsored By RouteIX Networks</option>
    </select>
  </div>
<div id="Location">
    <div class="form-group">
    <label for="exampleFormControlSelect2">Connection VIA</label>
    <select class="form-control" id="conntype" name="conntype">
	  <option selected disabled>SELECT</option>
      <option value="Local">LOCAL (Via Sponsor VM)</option>
      <option value="ZeroTier">ZeroTier (Tunnel)</option>
      <option disabled>WireGuard (Tunnel)</option>
      <option disabled>GRETAP (Tunnel)</option>
	  <option disabled>EoIP (Tunnel)</option>
	  <option disabled>VxLAN (Tunnel)</option>
      <option disabled>OpenVPN (Tunnel)</option>
    </select>
  </div>
</div>

  <div id="Local_Connection">
  <div class="form-group">
    <label for="exampleFormControlSelect2">If Local Connection, Please include Endpoint IP Addresses</label>
  <input type="text" class="form-control" name="localAddress" placeholder="123.456.789.0/2a0a:2a0a:2a0a::2222" maxlength="60">
  </div>
  </div>
  
    <div id="Local_Connection">
  <div class="form-group">
    <label for="exampleFormControlSelect2">If ZeroTier Connection, Please provide your ZeroTier ID ( zerotier-cli info | awk '{print $3}' )</label>
  <input type="text" class="form-control" name="ztAddress" placeholder="abcdefghijk" maxlength="10">
  </div>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Submit</button>
		</form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">



    $(window).on('load',function(){
        $('#connect').modal('show');
    });
</script>