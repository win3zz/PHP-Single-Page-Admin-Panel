<?php
if( strpos($_SERVER['HTTP_USER_AGENT'],'Google') !== false ) { 
    header('HTTP/1.0 404 Not Found'); 
    exit; 
}

/*===========================================
>>>>>>>>>> CODED BY BIPIN JITIYA <<<<<<<<<<<<
	Author Email: bipinjitiya77@gmail.com
	Year: 2017
===========================================*/

require_once('../config.php');

session_start();

if(isset($_GET['logout']))
{
    $_SESSION['admin'] = 0;
    session_destroy();
    header("location: ".$_SERVER['PHP_SELF']);
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] == "log"){
	$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die(mysqli_connect_error());
?>
<html>
<head>
<title>Admin</title>
<link rel='stylesheet' href='../css/bootstrap.css' type='text/css'/>
<style type="text/css">
.toast {
	width:200px;
	height:20px;
	height:auto;
	position:absolute;
	left:50%;
	margin-left:-100px;
	bottom:10px;
	background-color: #383838;
	color: #F0F0F0;
	font-family: Calibri;
	font-size: 20px;
	padding:10px;
	text-align:center;
	border-radius: 2px;
	-webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
	-moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
	box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
}
</style>
<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
</head>
<body>
	<div id="myElemAdd" class="toast" style="display: none;"><b>News Succesfully Added.</b></div>
	<div id="myElemDel" class="toast" style="display: none;"><b>News Succesfully Deleted.</b></div>
	<div id="myElemUpd" class="toast" style="display: none;"><b>News Succesfully Updated.</b></div>
	
	<div class="container" style="margin-top:15px;">
		<div class="panel panel-info">
			<div class="panel-heading"><h3><strong><center>NEWS</center></strong></h3></div>
			<div class="panel-body">
				<center><i><strong> We can use HTML tags like <code>&lt;b&gt; &lt;i&gt; &lt;u&gt; &lt;strong&gt; &lt;center&gt;</code> etc.. </strong></i></center><br/>
				
				<?php
				if(isset($_GET['edit_key']))
				{
					$edit_key = $_GET['edit_key'];
					?>
				<form action="<?php echo $_SERVER['PHP_SELF']."?update_key=".$edit_key ?>" method="POST">
					<div class="form-group col-lg-10">
					<?php
						$result = mysqli_query($con,"SELECT subject FROM `news` WHERE id = '$edit_key'") or die(mysqli_connect_error());
						$row = mysqli_fetch_assoc($result);
						echo "<textarea name='news' class='form-control' rows='5' required='1'>".$row['subject']."</textarea>";
					?>
					</div>
					<input type="submit" name="update" class="btn btn-primary" value="Update News"/>
				</form>
				<?php
				}
				else{?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					<div class="form-group col-lg-10">
						<textarea name="news" class="form-control" rows="5" placeholder="News Subject" required="1"></textarea>
					</div>
					<input type="submit" name="submit" class="btn btn-primary" value="Add News"/>
					<input type="reset" name="reset" class="btn btn-primary" value="Clear"/>
				</form>
				<?php
				}
				?>
					
				
				<?php
				if(isset($_GET['update_key']) && isset($_POST['update']))
				{
					$update_key = $_GET['update_key'];
					$sub = $_POST['news'];
					$result = mysqli_query($con,"UPDATE `news` SET  `subject` = '$sub' WHERE `id` = '$update_key'") or die(mysqli_connect_error());
					if($result){
						echo "<script>$(document).ready(function(){
							$('#myElemUpd').fadeIn(400).delay(3000).fadeOut(400);});</script>";
					}
					else{
						echo "<div class='alert alert-danger'>Error in Updating News</div>";
					}
				}
				if(isset($_GET['delete_key']))
				{
					$delete_key = $_GET['delete_key'];
					$result = mysqli_query($con,"DELETE FROM `news` WHERE id = '$delete_key'") or die(mysqli_connect_error());
					mysqli_query($con,"set @num := 0;") or die(mysqli_connect_error());
					mysqli_query($con,"UPDATE news SET id = @num := (@num+1)") or die(mysqli_connect_error());
					mysqli_query($con,"ALTER TABLE news AUTO_INCREMENT=1") or die(mysqli_connect_error());
					if($result){
						echo "<script>$(document).ready(function(){
							$('#myElemDel').fadeIn(400).delay(3000).fadeOut(400);});</script>";
					}
					else{
						echo "<div class='alert alert-danger'>Error in Deleting News</div>";
					}
				}
				if(isset($_POST['submit']))
				{
					$sub = $_POST['news'];
					$result = mysqli_query($con,"INSERT INTO `news` (`id`, `subject`) VALUES ('', '$sub')") or die(mysqli_connect_error());
					mysqli_query($con,"set @num := 0;") or die(mysqli_connect_error());
					mysqli_query($con,"UPDATE news SET id = @num := (@num+1)") or die(mysqli_connect_error());
					mysqli_query($con,"ALTER TABLE news AUTO_INCREMENT=1") or die(mysqli_connect_error());
					if($result){
						echo "<script>$(document).ready(function(){
							$('#myElemAdd').fadeIn(400).delay(3000).fadeOut(400);});</script>";
					}
					else{
						echo "<div class='alert alert-danger'>Error in Adding News</div>";
					}
				}
				?>
				<table class="table" style="border: 1px solid #bce8f1" border="1">
					<tr>
						<th align="center">ID</th>
						<th align="center">NEWS DETAIL</th>
						<th align="center">EDIT</th>
						<th align="center">DELETE</th>		
					</tr>
					<?php
						
						$result = mysqli_query($con,"SELECT * FROM news") or die(mysqli_connect_error());
						mysqli_query($con,"set @num := 0;") or die(mysqli_connect_error());
						mysqli_query($con,"UPDATE news SET id = @num := (@num+1)") or die(mysqli_connect_error());
						mysqli_query($con,"ALTER TABLE news AUTO_INCREMENT=1") or die(mysqli_connect_error());
						if (mysqli_num_rows($result) > 0)
						{
							while ($row = mysqli_fetch_array($result)) 
							{
							$i = $row["id"];
							$u = $row["subject"];
							echo "<tr>";
							echo "	<td>".$i."</td>";
							echo "	<td>".$u."</td>";
							echo "	<td align='center'><a href = '".$_SERVER['PHP_SELF']."?edit_key=".$i."'><span class='glyphicon glyphicon-pencil' style='font-size:1.5em;'></span></a></td>";
							echo "	<td align='center'><a href = '".$_SERVER['PHP_SELF']."?delete_key=".$i."'><span class='glyphicon glyphicon-trash' style='font-size:1.5em;'></span></a></td>";
							echo "</tr>";
							}
						}
						else
						{
							echo "<td colspan='4'><h3> No data inserted yet. </h3></td>";
						}
					?>
				</table>

				<a class="btn btn-primary" href="<?php echo $_SERVER['PHP_SELF'].'?logout'?>">Logout!</a>
				<a class="btn btn-primary" href="<?php echo $_SERVER['PHP_SELF'];?>">Refresh</a>
			</div>
		</div>
	</div>
	
	<div class="well">
      <p align="center">All contents copyright &copy; Winhacker. All rights reserved.<br/>Designed and Developed by <strong>Bipin Jitiya</strong></p>
	</div>
</body>
</html>

<?php	
}
else{
	if (isset($_POST["pass"]) && md5($_POST["pass"]) == AUTH_PASS){
		$_SESSION['admin'] = "log";
		header("location: ".$_SERVER['PHP_SELF']);
	}
	else{
		printLogin();
	}	
}

function printLogin(){
	echo "<html>";
	echo "<head><title>404 Not Found</title></head>";
	echo "<body>";
	echo "<h1>Not Found</h1>";
	echo "<p>The requested URL / was not found on this server.</p>";
	echo "<p>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p>";
	echo "<form method='post'><input type='password' name='pass' style='margin:0;background-color:#fff;border:1px solid #fff;'/></form>";
	echo "</body>";
	echo "</html>";
}
?>
