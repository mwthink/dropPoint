<?php
	if(isset($_GET['update']) and isset($_POST['description'])){
		$db->update("hosts",["description"=>$_POST['description']],["domain"=>$_GET['manage']]);
		if(dbHasError()){
			$noticeMessage="An error occurred while saving data";
		}
		else{
			$noticeMessage="Saved data successfully";
		}
	}
?>
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
			<?php 
				$hostInfo=$db->select("hosts","*",["domain"=>$_GET['manage']]);
				if(isset($noticeMessage)){echo "<p>".$noticeMessage."</p>";} 
			?>
			<div class="pure-g">
				<div class="pure-u-1-3">
					<form method="post" action="index.php?manage=<?php echo $_GET['manage'] ?>&update">
						Hostname - <?php echo $hostInfo[0]['domain']; ?>
						Description -
						<textarea rows=10 cols=30 name="description"><?php echo $hostInfo[0]['description'];?></textarea>
						<input type="submit" value="Update Information">
					</form>
				</div>
			</div>
			<hr>
			<p><a href="index.php">Back to Control Panel</a></p>
		</div>
		
	</body>
</html>
