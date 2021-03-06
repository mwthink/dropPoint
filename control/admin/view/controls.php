<?php
	if(isset($_GET['delete'])){
		if($db->has("hosts",["domain"=>$_GET['delete']])){
			$db->delete("hosts",["domain"=>$_GET['delete']]);
			if(dbHasError()){
			$noticeMessage="An error occurred while deleting host";
			}
			else{
				$noticeMessage="Successfully deleted host ".$_GET['delete'];
			}
		}
	}
	if(isset($_GET['updateGeneral'])){
		$db->update("settings",["value"=>$_POST['secretKey']],["setting"=>"secretKey"]);
		if(dbHasError()){
			$noticeMessage="An error occurred while saving settings";
		}
		else{
			$noticeMessage="Saved settings successfully";
		}
	}
	if(isset($_GET['manage']) and $db->has("hosts",["domain"=>$_GET['manage']])){
		include(TEMPLATES_PATH.'/management.php');
		exit();
	}
?>
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
			<?php if(isset($noticeMessage)){echo "<p>".$noticeMessage."</p>";} ?>
			<div class="pure-g">
				<div class="pure-u-1-3">
					<form method="post" action="index.php?updateGeneral">
						<h3>General Information</h3>
						<b>Secret Key</b> <input type="text" name="secretKey" value="<?php echo $db->get("settings","value",["setting"=>"secretKey"]) ?>">
						<br><br><input type="submit" value="Update">
					</form>
					<hr>
					<p>You are logged in</p>
					<a href="index.php?logout"><button>Logout</button></a>
				</div>
				<div class="pure-u-2-3">
					<table class="pure-table" style="text-align:center;margin:0 auto;">
						<thead>
							<tr>
								<th>Host Name</th>
								<th>Time Reported</th>
								<th>Manage</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$hosts=$db->select("hosts",["domain","checkInTime"]);
								foreach($hosts as $host){
									echo '<tr><td>'.$host['domain'].'</td><td>'.date('n-d-Y g:i A',$host['checkInTime']).'</td><td><a href="index.php?manage='.$host['domain'].'">Manage</a></td><td><a href="index.php?delete='.$host['domain'].'">Delete</a></td></tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</body>
</html>
