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
		 		echo 'tamanho da tabela de eventos: $max';
		 		for($i = 0; $i < $max; $i++){
		 			$line = getLine($table, $i);
		 			$name = $line['name'];
		 			echo '$name <br>';
		 		}
		 		echo "event1 <br><br><br><br><br><br><br>";
		 		echo "event2 <br><br><br><br><br><br><br>";
		 		echo "event3 <br><br><br><br><br><br><br>";
		 		echo "event4 <br><br><br><br><br><br><br>";
		 		echo "event5 <br><br><br><br><br><br><br>";
		 		echo "event6 <br><br><br><br><br><br><br>";
		 		echo "event7 <br><br><br><br><br><br><br>";
		 		echo "event8 <br><br><br><br><br><br><br>";
		 		echo "event9 <br><br><br><br><br><br><br>";
		 	?>
		</div>
	</body>
</html>