<marquee scrolldelay="200" direction="up" behavior="scroll" onMouseOver="this.stop();" onMouseOut="this.start();" style="height: 220px;">
	<ul class="list-group">
		<?php
			require_once('config.php');
			$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die(mysqli_connect_error());
			$result = mysqli_query($con,"SELECT subject FROM news") or die(mysqli_connect_error());
			if (mysqli_num_rows($result) > 0){
				while ($row = mysqli_fetch_array($result)) {
					echo "<li class='list-group-item list-group-item-action list-group-item-info'>".$row["subject"]." </li>";
				}
			}
			else{
				echo "<li class='list-group-item list-group-item-action list-group-item-info'>No data inserted yet.</li>";
			}					
		?>
	</ul>
</marquee>
