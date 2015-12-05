<!DOCTYPE html>

<html>
  <head>
	<meta charset="UTF-8">
	<title>Events</title>
	<link rel="stylesheet" href="visual/site.css">
	<link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="scripts/formScripts.js"></script>  
	<script src="scripts/buttons.js"></script>  
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  </head>

	<body bgcolor="white">
		<!-- a header corresponde à barra cinzenta no topo da pagina -->
		<div id="header">
			<div id="data">
			<?
				//date_default_timezone_set('GMT');
				echo date('d\/m\/Y')."<br>".date('l H:i e');
			?>
			</div>
			<div id="createEventbutton">
				Create Event
			</div>
			<div id="user">
			<?
				echo $_SESSION['username'];
			?>
			</div>
			<div id="userOptions" style="display: none">
				<p id="showProfile">Profile</p>
				<p id="Settings">Setting</p>
				<p id="logout">Logout</p>
			</div>
		</div>

		<!-- div com o menu de criação de eventos -->
		<div id="createEvent">
			<h1>Create Event</h1>
			<form action="/" name="createEventForm" id="createEventForm" method="post">
				<input type="text" placeholder="name" name="name"><br>
				<input type="date" placeholder="date" name="dateBegin"><br>
				<input type="text" placeholder="location" name="location"><br>
				<input type="text" placeholder="description" name="description"><br>
				<input type="text" placeholder="image URL" name="image"><br>
				<input id="submitEvent" type="submit" value="Submit Event">
			</form>
		</div>

			<!-- div com a lista de eventos no lado esquerdo da pagina -->
			<div id="eventList">
			 	<?
			 		include('database/eventFunc.php');
			 		$table = getAllEvents();
			 		$max = sizeof($table);
			 		for($i = 0; $i < $max; $i++){
			 			$line = getLine($table, $i);
			 			$name = $line['name'];
			 			$date = $line['dateBegin'];
			 			$location = $line['location'];
			 			$image = $line["image"];
						echo '<div id='.$i.' class="listEvents"> ';
							echo '<div class="eventResume">';
								echo '<div class="title">'.$name.'<br></div>';
					 			echo '<div class="date">'.$date.'<br></div>';
					 			echo '<div class="location">'.$location.'<br></div>';
				 			echo '</div>';
				 			echo '<div class="eventImage"><img src="'.$image.'" alt="eventImage"/></div>';
						echo '</div>';
			 		}
			 	?>
			</div>
			<!-- div com a informação do evento selecionado. Lado direito da pagina -->
			<div id="eventInfo"  style="display:none";>
				<?
			 		$table = getAllEvents();
			 		$max = sizeof($table);
			 		if ($max != 0){
				 		$line = getLine($table, 0);
				 		$name = $line['name'];
			 			$date = $line['dateBegin'];
			 			$location = $line['location'];
			 			$image = $line["image"];
			 			$description = $line['description'];

				 		echo '<div class="EventsInfo"> ';
				 				echo '<div class="Ftitle"> '.$name.'<br></div>';
					 			echo '<div class="Fdate">'.$date.'<br></div>';
					 			echo '<div class="Flocation">'.$location.'<br></div>';



					 			echo '<div class="Fhost">';
					 				$admin = getEventAdmin($name)['username'];
					 				if ($admin != $_SESSION['username']){
					 					echo '<div class="hostName">host: '.$admin.'</div>';
					 					echo '<div class="deleteEvent" style="display: none;">Delete Event</div>';
					 				}
					 				else{
					 					echo '<div class="deleteEvent">Delete Event</div>';
					 					echo '<div class="hostName" style="display: none;">host: '.$admin.'</div>';
					 				}
					 			echo '</div>';

					 			echo '<div class="Fdescription">'.$description.'<br></div>';
					 			echo '<div class="FeventImage"><img src="'.$image.'" alt="eventImage"/></div>';
								




								echo '<div id="Fcomments">';
									echo '<div id="addComment">';
										?>
										<form action="/" name="addComent" id="addComment" method="post">
											<input type="text" placeholder="Insert comment here!" name="comment"><br>
											<input id="submitComment" type="submit" value="Submit Comment">
										</form>
										<?
									echo '</div>';

									$tableCom = getCommentsFromEvent($name);
									$maxCom = sizeof($tableCom);
									if($maxCom!=0){
										for($j = 0; $j < $maxCom; $j++){
											$lineCom = getLine($tableCom, $j);
											$comUser = getUsername($lineCom['idUser']);
											echo '<div class="FcomUser">'.$comUser['username'].'<br></div>';
											echo '<div class="FcomBody">'.$lineCom['commentary'].'<br></div>';
										}
									}
									else{
										echo '<div class="FcomUser"></div>';
										echo '<div class="FcomBody"></div>';
									}
								echo '</div>';

							echo '</div>';
					}
				?>
			</div>
	</body>
</html>