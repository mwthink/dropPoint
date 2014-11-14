<!DOCTYPE html>
<html>
	<head>
		<title>DropPoint Control Panel</title>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<style>
			body{
				background-color:#94A499;
			}
			#wrapper{
				width:900px;
				background-color:#7A7A7A;
				padding:5px 5px 5px 5px;
				margin:0 auto;
			}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<div class="pure-g">
				<div class="pure-u-1-3">
					<p>You are logged in</p>
					<a href="index.php?logout"><button>Logout</button></a>
				</div>
				<div class="pure-u-2-3">
					<table class="pure-table" style="text-align:center;margin:0 auto;">
						<thead>
							<tr>
								<th>Host Name</th>
								<th>Time Reported</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$hosts=$db->select("hosts",["domain","checkInTime"]);
								foreach($hosts as $host){
									echo "<tr><td>".$host['domain']."</td><td>".date('n-d-Y g:i A',$host['checkInTime'])."</td></tr>";
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</body>
</html>
