			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">IXPControl.</p>
  <p>Development Room</p>
   
  <hr class="my-4">
  <div class="text-center">
  <p><div class="btn-group" role="group" aria-label="Links">
  <button type="button" class="btn btn-primary btn-round-lg" data-toggle="modal" data-target="#About">About</a></button>
  <button type="button" class="btn btn-primary btn-round-lg" data-toggle="modal" data-target="#Policy">Policy</a></button>
  <button type="button" class="btn btn-primary btn-round-lg" data-toggle="modal" data-target="#FAQ">FAQ</a></button>
  <?php if(isset($cfg['showSponsors'])){ ?>
  <button type="button" class="btn btn-primary btn-round-lg" data-toggle="modal" data-target="#Sponsors">Sponsors</a></button>
  <?php } ?>
  <?php if(isset($cfg['showBlog'])){ ?>
  <a href="/?act=viewBlog" class="btn btn-primary btn-round-lg">Blog</a></button>
  <?php } ?>
  <?php if(isset($cfg['telegramID'])){ ?>
  <a href="https://t.me/<?=$cfg['telegramID']?>" class="btn btn-danger btn-round-lg">Telegram</a></button>
  <?php } ?>
  </div>
</div></p>
  
  <hr class="my-4">
  <div class="text-center">
  <p><div class="btn-group" role="group" aria-label="Location List">
  <button ="#" class="btn btn-primary">Locations: </button>
  <?php
	$a = dbQuery('SELECT', 'ix_ixs', 'ixName,ixCity,ixCountry', 'ORDER BY listorder ASC');
	foreach($a as $b){
		echo "<button type=\"button\" class=\"btn btn-primary btn-round-lg\" data-toggle=\"modal\" data-target=\"#".$b['ixName']."\">".$b['ixCity'].",".$b['ixCountry']."</button>";
	}
  ?>
  </div>
</div></p>
</div>
<?php
$a = dbQuery('SELECT', 'ix_ixs');
	foreach($a as $b){
?>
<div class="modal fade" id="<?=$b['ixName']?>" tabindex="-1" role="dialog" aria-labelledby="<?=$b['ixName']?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
			<div class="modal-body">
<button type="button" class="btn btn-block btn-danger btn-round-lg" id="adelaideAU">
  <?=$b['ixName']?> - <?=$b['ixCity'].', '.$b['ixCountry']?>
</button>
<div class="text-center">
<div class="btn-group" role="group" aria-label="Location List">
<?php if(isset($cfg['showSponsors']) && $b['ixSponsored'] == 'true'){ ?>
<a href="<?=$b['ixSponsor_Web']?>" class="btn btn-success btn-round-lg">Sponsor: <?=$b['ixSponsor']?></a>
<?php } ?>
<button class="btn btn-success btn-round-lg">Datacenter: <?=$b['ixDatacenter']?></button>
<a target="_blank" href="https://www.peeringdb.com/ix/<?=$b['ixPeeringDB']?>" class="btn btn-info btn-round-lg">PeeringDB</a>
</div></div>
				<div class="table100 ver6 m-b-110">
					<table data-vertable="ver2">
						<thead>
							<tr class="row100 head">
								<th class="column100 column1" data-column="column1">Member</th>
								<th class="column100 column2" data-column="column2">ASN</th>
								<th class="column100 column3" data-column="column3">IPv4</th>
								<th class="column100 column4" data-column="column4">IPv6</th>
								<th class="column100 column5" data-column="column5">Peering</th>
								<th class="column100 column6" data-column="column7">Port</th>
								<th class="column100 column8" data-column="column8">Tunnel Type</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$rsDecode = json_decode($b['ixRSInfo'], true);
							foreach($rsDecode as $rs){
						?>
						<tr class="row100">
								<td class="column100 column1" data-column="column1"><?=$b['ixName']?> Route Server</td>
								<td class="column100 column2" data-column="3column2"><a target="_blank" href="https://bgp.he.net/AS<?=$rs['RS_ASN']?>">AS<?=$rs['RS_ASN']?></a></td>
								<td class="column100 column3" data-column="column3"><?=$rs['RS_IPv4']?></td>
								<td class="column100 column4" data-column="column4"><?=$rs['RS_IPv6']?></td>
								<td class="column100 column5" data-column="column5">MANDITORY</td>
								<td class="column100 column7" data-column="column6">10 GB/s</td>
								<td class="column100 column8" data-column="column8">LOCAL</td>
						</tr>
							<?php } ?>
<?php
$ixid = "LEFT JOIN ix_clients ON ix_session.suid = ix_clients.uid WHERE sixid ='".$b['ixid']."'";
$session = dbQuery('SELECT', 'ix_session', '*', $ixid);
foreach($session as $ixUser){
	if(empty($ixUser['sNeighbor_v4'])){ $ixUser['sNeighbor_v4'] = "--"; }
	if(empty($ixUser['sNeighbor_v6'])){ $ixUser['sNeighbor_v6'] = "--"; }
?>
						<tr class="row100">
								<td class="column100 column1" data-column="column1"><?=$ixUser['userCompany']?></td>
								<td class="column100 column2" data-column="column2"><a target="_blank" href="https://bgp.he.net/AS<?=$ixUser['sASN']?>">AS<?=$ixUser['sASN']?></a></td>
								<td class="column100 column3" data-column="column3"><?=$ixUser['sNeighbor_v4']?></td>
								<td class="column100 column4" data-column="column4"><?=$ixUser['sNeighbor_v6']?></td>
								<td class="column100 column5" data-column="column5"><?=$ixUser['sPeering']?></td>
								<td class="column100 column7" data-column="column6"><?=$ixUser['sPeerSpeed']?></td>
								<td class="column100 column8" data-column="column8"><?=$ixUser['sConnect']?></td>
						</tr>
<?php } ?>
						</tbody>
					</table>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
	</form>
  </div>
</div>

<?php } ?>

<!-- Modal -->
<div class="modal fade" id="About" tabindex="-1" role="dialog" aria-labelledby="aboutOceanix" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="aboutOceanix">About OceanIX</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3>What is OceanIX</h3>
		<p>OceanIX is a small non-for-profit Oceanic Internet Exchange Point (<a style="color:blue;" href="https://en.wikipedia.org/wiki/Internet_exchange_point">IXP</a>) aimed to provide a zero cost point for users hodling public resources to experiment with BGP and Routing, as well as Transit Providers (if possible). Starting in early 2021, aimed at all key locations in the Oceanic area (AU and NZ). </p>
		<br /><p>We openly encorage all members of our Internet Exchange Points to peer with one another.</p>
		<br /><p>Initially, We are only offering IPv6 based IX Services, while we secure sponsorship and resources for use with the IX. as well as experimentation with our own Docker based control systems for our IXPs. </p>
		<br /><p>Sponsors that have provided us with resources such as Colocation, Dedicated servers and/or VPS Services, can provide Local "On-Net" connection to the Internet Exchange, otherwise Tunnel based services can be utilized to connect to OceanIX at various POPs in Oceania.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="FAQ" tabindex="-1" role="dialog" aria-labelledby="FAQOceanix" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="FAQOceanix">OceanIX FAQ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<h4>How do I Connect to OCIX (OceanIX)</h4>
		 <hr class="my-4">
		 <p>To connect to OCIX, Fill in the form found via the link on our main page, or Join our Telegram Group and Talk to our Administrator to connect to any of the POPs that you require.</p>
		 <br />%A
		 <h4>How do I Contact OCIX (OceanIX)</h4>
		 <hr class="my-4">
		 <p>You can contact us via <a style="color:blue;" href="https://t.me/oceanixau">Telegram</a> or via <a style="color:blue;" href="mailto:connect@oceanix.net.au">Email </a>.</p>
		 <br />
		 <h4>How do we donate to OCIX (OceanIX)</h4>
		 <hr class="my-4">
		 <p>Want to donate to OCIX, well.. that's great, our entire network has been built off donations, either monetory or service based, and we cannot be happier with the support provided from our partners and supporters.</p>
		 <p>If you  are interested in donating resources to OCIX, Please do contact us via <a style="color:blue;" href="https://t.me/oceanixau">Telegram</a> or via <a style="color:blue;" href="mailto:connect@oceanix.net.au">Email </a>. or via monetary donation via <a style="color:blue;" href="https://paypal.me/oceanixau">PayPal, Click here.</a></p>
		 <br />
		 <h4>Does OCIX Operate a Route Server?</h4>
		 <hr class="my-4">
		 <p>Yes, OceanIX Operates Route Servers from AS139882 and can be found at ::1 (ipv6) on all our IX Subnets</p>
		 <br />
		 <h4>What Subnets are Used for OCIX (OceanIX)</h4>
		 <hr class="my-4">
		 <p>We have multiple subnets in use, We will try and keep this as up to date as possible.</p>
		 <p><i>(IX) - IX Subnet, (AC) - Anycast Subnet, (AN) - Anchor Subnet, (TS) - Testing Subnet</i></p>
		 <table>
		 <thead>
							<tr class="row100 head">
								<th class="column100 column1" data-column="column1">IX</th>
								<th class="column100 column1" data-column="column1">Location</th>
								<th class="column100 column2" data-column="column2">IPv4</th>
								<th class="column100 column3" data-column="column3">IPv6</th>
							</tr>
						</thead>
						<tbody>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-SA</td>
								<td class="column100 column1" data-column="column1">Adelaide, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:a6::/48 (AN)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-SA</td>
								<td class="column100 column1" data-column="column1">Adelaide, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:d6::/64 (IX)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-NZ</td>
								<td class="column100 column1" data-column="column1">Auckland, NZ</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:a1::/48 (AN)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-NZ</td>
								<td class="column100 column1" data-column="column1">Auckland, NZ</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:d1::/64 (IX)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-QLD</td>
								<td class="column100 column1" data-column="column1">Brisbane, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:a3::/48 (AN)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-NZ</td>
								<td class="column100 column1" data-column="column1">Brisbane, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:d3::/64 (IX)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-WA</td>
								<td class="column100 column1" data-column="column1">Perth, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:a3::/48 (AN)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-WA</td>
								<td class="column100 column1" data-column="column1">Perth, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:d3::/64 (IX)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-NSW</td>
								<td class="column100 column1" data-column="column1">Sydney, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:a5::/48 (AN)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-NSW</td>
								<td class="column100 column1" data-column="column1">Sydney, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:d5::/64 (IX)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-APAC</td>
								<td class="column100 column1" data-column="column1">Sydney, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:beef::/48 (AC)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-APAC</td>
								<td class="column100 column1" data-column="column1">Sydney, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:dead::/48 (AC)</td>
						</tr>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">OCIX-APAC</td>
								<td class="column100 column1" data-column="column1">Sydney, AU</td>
								<td class="column100 column2" data-column="column2">--</td>
								<td class="column100 column3" data-column="column3">2a0a:6040:d0::/64 (IX)</td>
						</tr>
		 </table>
		 <br />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="Policy" tabindex="-1" role="dialog" aria-labelledby="policyOceanix" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sponsorsOceanix">OceanIX IXP Policy</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>OceanIX aims to ensure its members reliable and uninterrupted Service as well as to limit the risks of deliberate or accidental mistakes, that might degrade/damage our infrastructure or service of our members. All members should follow the rules listed below:</p>
			<ul class="list-group">
				<li class="list-group-item">ARP proxy must be disabled.</li>
				<li class="list-group-item">Private AS numbers must not be used.</li>
				<li class="list-group-item">Internal L2/L3 protocols must be disabled DHCP, CDP, MOP, RIP, OSPF, IS-IS, (R)STP, VTP, any kind of L2 keep alive.</li>
				<li class="list-group-item">A members must not point default route at any other member.</li>
				<li class="list-group-item">A member may in no way interfere with traffic to/from any other member.</li>
				<li class="list-group-item">On the Peering VLAN, only ethertypes 0x0800 (IPv4), 0x08dd (IPv6) and 0x0806 (ARP) are permitted.</li>
				<li class="list-group-item">A member should not advertise our internet exchange address space to any other network.</li>
			</ul>
		<p>Requirements for Peering</p>
			<ul class="list-group">
				<li class="list-group-item">You must own a public ASN and a minimum /48 IPv6 Subnet.</li>
				<li class="list-group-item">You are willing to peer with other members directly with other members or over Route Server.</li>
				<li class="list-group-item">OceanIX does not provide transit for your ipv6 network. However, some peers might be interested in providing you transit over the ixp port.</li>
				<li class="list-group-item">You abide by the rules listed above.</li>
			</ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Sponsors" tabindex="-1" role="dialog" aria-labelledby="sponsorsOceanix" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sponsorsOceanix">OceanIX Sponsors</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">
        <p>OceanIX could not be possible without the assistance from our wonderful sponsors, If you have the ability to help us wherever possible, Please don't hesitate to contact us!</p>
		<p>Below is a table of our current sponsor list, also with what services they supply and what they have supplied for the operation of OceanIX. </p>
						<div class="table100 ver1 m-b-110">
					<table data-vertable="ver6">
						<thead> 
							<tr class="row100 head">
								<th class="column100 column2" data-column="column1" width="30%">Sponsor</th>
								<th class="column100 column3" data-column="column2">Services Provided</th>
								<th class="column100 column4" data-column="column3">Services Offered</th>
							</tr>
						</thead>
						<tbody> 
						<tr class="row100">
								<td class="column100 column2" data-column="column1" width="30%"><a href="https://www.zappiehost.com"><img src="/assets/img/sponsors/zappiehost_logo.png" height="50px"/></a></td>
								<td class="column100 column2" data-column="column3">Auckland KVM VPS Server, /32 IPv6</td>
								<td class="column100 column3" data-column="column4">LXC & KVM VPS Servers in New Zealand and South Africa, Colocation in New Zealand</td>
						</tr>
						<tr class="row100">
								<td class="column100 column2" data-column="column1" width="30%"><a href="https://www.networkpresence.com.au"><img src="/assets/img/sponsors/networkpresence_logo.png" height="50px"/></a></td>
								<td class="column100 column2" data-column="column3">Adealide KVM VPS Server</td>
								<td class="column100 column3" data-column="column4">KVM VPS Servers in Adelaide and Sydney Australia, Colocation in Sydney</td>
						</tr>
						
						<tr class="row100">
								<td class="column100 column2" data-column="column1" width="30%"><a href="https://www.routeix.net"><img src="/assets/img/sponsors/routeix_logo.png" height="50px"/></a></td>
								<td class="column100 column2" data-column="column3">Everything Else :)</td>
								<td class="column100 column3" data-column="column4">... my personal wallet.</td>
						</tr>
						</tbody>
					</table>
      </div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary btn-lg btn-block login-btn">Login</button>
      </div>
    </div>
	</form>
  </div>
</div>



