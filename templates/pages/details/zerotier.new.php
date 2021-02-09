	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
			<div class="text-right">
			<div class="dropdown show">
  <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Control
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="#oceanIXPLogin" data-toggle="modal" data-target="#oceanIXPLogin">Login/Manage</a>
  </div>
</div>
			</div>
			<div class="jumbotron">
  <div class="text-center"><img src="/assets/img/oceanix_logo.png"/></div><br />
  <p class="lead">New ZeroTier Connection - <?=$ixloc?></p>
  
  <hr class="my-4">
  <p>Congratulations, Your Session is nearly setup!, now.. for your side.. You need to connect to our ZeroTier Network. Please use the following ZeroTier Commands to join our Network, It should already be approved our side, so you will get your IPv6 address assigned automatically</p>
  <hr class="my-4">
  <code>
curl -s https://install.zerotier.com | bash<br />
zerotier-cli join <?=$ztNetwork?><br />
zerotier-cli set <?=$ztNetwork?> allowGlobal=true
  </code>
  <hr class="my-4">
  <p>RouteServer Configuration</p>
  <code>
  IPv6: <?=$IXNode[$ixloc]["IPSub"]?>1<br />
  ASN: 65535
  </code>
  
  <hr class="my-4">
  <div class="text-center">
  <p><div class="btn-group" role="group" aria-label="Location List">
  <button ="#" class="btn btn-primary">Configuration Examples: </button>
  <button type="button" class="btn btn-primary btn-round-lg" data-toggle="modal" data-ocix="OCIX-SA"  data-target="#">BIRD</button>
  <button type="button" class="btn btn-primary btn-round-lg" data-toggle="modal" data-ocix="OCIX-NZ"  data-target="#">OpenBGPd</button>
  <!--<a href="#regional" class="btn btn-primary btn-round-lg">Regional</a>-->
  </div>
</div></p>
</div>
	</div>
	</div>
</div>