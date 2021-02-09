 			<div class="jumbotron">
  <div class="text-center"><a href="<?=$cfg['siteURL']?>"><img src="<?=$cfg['logoURL']?>"/></a></div><br />
  <p class="lead">Peering Manager</p>
  
  <hr class="my-4">
  <p>While, we do operate RouteServers for the use of members on <?=$cfg['siteName']?>, We do also encorage direct peering where possible. </p>
  <p>Below is the list of connected networks that are on the same Internet Exchange Point as you, With Option to send a Peering Request Email, with all relevant information to the Peering Admin.</p>
</div>
				<div class="table100 ver5 m-b-110">
					<table data-vertable="ver2">
						<thead>
							<tr class="row100 head">
								<th class="column100 column1" data-column="column1">Member</th>
								<th class="column100 column2" data-column="column2">ASN</th>
								<th class="column100 column3" data-column="column3">Peering</th>
								<th class="column100 column4" data-column="column5">Protocol</th>
								<th class="column100 column5" data-column="column7">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
					
						
						?>
						<tr class="row100">
								<td class="column100 column1" data-column="column1">User</td>
								<td class="column100 column2" data-column="column2">
								<div class="btn-group">
									<button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">AS123456</button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="https://bgp.he.net/AS123456">BGP.HE.NET</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="#">PeeringDB</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="https://www.bgpview.io/asn/123456">BGPView</a>
										</div>
								</div>
								</td>
								<td class="column100 column3" data-column="column5">OPEN</td>
								<td class="column100 column4" data-column="column6">
									<div class="btn-group" role="group" aria-label="Basic example">
										<button type="button" class="btn btn-sm btn-round-sm btn-success">IPv4</button>
										<button type="button" class="btn btn-sm btn-round-sm btn-success">IPv6</button>
									</div>
								</td>
								<td class="column100 column5" data-column="column8"><button type="button" class="btn btn-sm btn-round-sm btn-outline-info">Peering Request</button></td>
						</tr>
						</tbody>
						</table>
						
						<br /><br />
</body>
</html>