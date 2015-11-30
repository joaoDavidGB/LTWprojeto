<!DOCTYPE html>

<html>
  <head>
	<meta charset="UTF-8">
	<title>Events</title>
	<link rel="stylesheet" href="CSS/site.css">
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
		 		echo 'tamanho da tabela de eventos:'.$max."<br>";
		 		for($i = 0; $i < $max; $i++){
		 			$line = getLine($table, $i);
		 			echo $line['name']."<br>";
		 			echo $line['dateBegin']."<br>";
		 			echo $line['location']."<br>";
		 			$image = $line["image"];
		 			echo '<img src= "<? $image ?>" alt="eventImage"/>';
		 			echo "<br><br>";
		 		}
		 	?>
		</div>
	</body>
</html>