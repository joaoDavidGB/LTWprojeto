<!DOCTYPE html>

<html>
  <head>
	<meta charset="UTF-8">
	<title>Events</title>
	<link rel="stylesheet" href="CSS/site.css">
	<link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="jquery/style.js"></script>  
  </head>

	<body bgcolor="white">
		<div id="header">
			<div id="data">
			<?
				//date_default_timezone_set('GMT');
				echo date('d\/m\/Y')."<br>".date('l H:i e');
			?>
			</div>
		</div>

			<div id="eventList">
			 	<?
			 		include('database/eventFunc.php');
			 		$table = getAllEvents();
			 		$max = sizeof($table);
			 		for($i = 0; $i < $max; $i++){
			 			$line = getLine($table, $i);
						echo '<div id='.$i.' class="listEvents"> ';
							echo '<div class="eventResume">';
								echo '<div class="title">';
					 				echo $line['name']."<br>";
					 			echo '</div>';
					 			echo '<div class="date">';
					 				echo $line['dateBegin']."<br>";
					 			echo '</div>';
					 			echo '<div class="location">';
					 				echo $line['location']."<br>";
					 			echo '</div>';
				 			echo '</div>';
				 			$image = $line["image"];
				 			echo '<div class="eventImage">';
					 			echo '<img src="'.$image.'" alt="eventImage"/>';
							echo '</div>';
						echo '</div>';
			 		}
			 	?>
			</div>
			<div id="eventInfo">
				<?
			 		$table = getAllEvents();
			 		$line = getLine($table, 0);

			 		echo '<div class="EventsInfo"> ';
			 				echo '<div class="Ftitle">';
				 				echo $line['name']."<br>";
				 			echo '</div>';
				 			echo '<div class="Fdate">';
				 				echo $line['dateBegin']."<br>";
				 			echo '</div>';
				 			echo '<div class="Flocation">';
				 				echo $line['location']."<br>";
				 			echo '</div>';
				 			echo '<div class="Fdescription">';
				 				echo $line['description']."<br>";
				 			echo '</div>';
				 			echo '<div class="FeventImage">';
					 			echo '<img src="'.$line["image"].'" alt="eventImage"/>';
							echo '</div>';
						echo '</div>';
				?>
			</div>
	</body>
</html>