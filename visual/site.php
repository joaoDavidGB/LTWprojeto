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
			<div id="searchEvent">
				<form action="/" name="searchEvent" id="searchEvent" method="post">
				<input type="text" placeholder="Search an Event" name="name">
				</form>
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
				<p id="Settings">Setting</p>
				<p id="logout">Logout</p>
				<p id="Delete">Delete Account</p>
			</div>
		</div>

		<div id="UserSettings" style="display:none;">
			<?
			echo '
			<form action="/" name="UserSettingsForm" id="UserSettingsForm" method="post">
				<input type="text" value="'.$_SESSION['username'].'" name="oldname" style="display:none;"><br>
				<input type="text" value="'.$_SESSION['username'].'" name="username"><br>
				<input type="password" placeholder="password" name="oldpw"><br>
				<input type="password" placeholder="new-password" name="newpw"><br>
				<input type="password" placeholder="new-password" name="newpw2"><br>
				<input id="submitSettings" type="submit" value="Apply">
			</form> ';
			echo '<button id="closeUserSetting">X</button>';
			?>
		</div>

		<div id="DeleteAcc" style="display:none;">
			<?
			echo '
			<form action="/" name="DeleteAccForm" id="DeleteAccForm" method="post">
				<input type="text" value="'.$_SESSION['username'].'" name="username" style="display:none;"><br>
				<input type="password" placeholder="password" name="pw"><br>
				<input type="password" placeholder="reenter password" name="pw2"><br>
				<input id="delete" type="submit" value="Delete">
			</form> ';
			echo '<button id="closeUserDelete">X</button>';
			?>
		</div>

		<!-- div com o menu de criação de eventos -->
		<div id="createEvent">
			<h1>Create Event</h1>
			<form action="/" name="createEventForm" id="createEventForm" method="post">
				<input type="text" placeholder="name" name="name"><br>
				<input type="date" placeholder="date" name="dateBegin"><br>
				<input type="time" placeholder="time" name="time"><br>
				<input type="text" placeholder="type" name="type"><br>
				<input type="text" placeholder="location" name="location"><br>
				<input type="text" placeholder="description" name="description"><br>
				<select name="type" form="createEvent">
  					<option value="0">Public</option>
  					<option value="1">Private</option>
				</select><br>
				<input type="text" placeholder="image URL" name="image"><br>
				<input id="submitEvent" type="submit" value="Submit Event">
			</form>
		</div>

			<!-- div com a lista de eventos no lado esquerdo da pagina -->
			<div id="eventList">
			 	<?
			 		include('database/eventFunc.php');
			 		$table = getEventSortedbyDate();
			 		$max = count($table);
			 		if($table!=false){
			 		for($i = 0; $i < $max; $i++){
			 			$line = getLine($table, $i);
			 			$idEvent = $line['idEvent'];
			 			$name = $line['name'];
			 			$date = $line['dateBegin'];
			 			$time = $line['time'];
			 			$type = getEventType($name);
			 			$location = $line['location'];
			 			$privateEvent = $line["privateEvent"];
			 			$image = $line["image"];
						echo '<div id='.$idEvent.' class="listEvents"> ';
							echo '<div class="eventResume">';
								echo '<div class="title">'.$name.'<br></div>';
					 			echo '<div class="date">'.$date.'<br></div>';
					 			echo '<div class="time">'.$time.'<br></div>';
					 			echo '<div class="type">'.$type.'<br></div>';
					 			echo '<div class="location">'.$location.'<br></div>';
					 			echo '<div class="privateEvent">'.$privateEvent.'<br></div>';	
				 			echo '</div>';
				 			echo '<div class="eventImage"><img src="'.$image.'" alt="eventImage"/></div>';
						echo '</div>';
			 		}
			 		}
			 	?>
			</div>
			<!-- div com a informação do evento selecionado. Lado direito da pagina -->
			<div id="eventInfo"  style="display:none";>
				<?
			 		$table = getEventSortedbyDate();
			 		$max = sizeof($table);
			 		if ($max != 0){
				 		$line = getLine($table, 0);
				 		$name = $line['name'];
			 			$date = $line['dateBegin'];
			 			$time = $line['time'];
			 			$type = getEventType($name);
			 			$location = $line['location'];
			 			$privateEvent = $line['privateEvent'];
			 			$image = $line["image"];
			 			$description = $line['description'];

				 		echo '<div class="EventsInfo"> ';
				 				echo '<div class="Ftitle"> '.$name.'<br></div>';
					 			echo '<div class="Fdate">'.$date.'<br></div>';
					 			echo '<div class="Ftime">'.$time.'<br></div>';
					 			echo '<div class="Ftype">'.$type.'<br></div>';
					 			echo '<div class="Flocation">'.$location.'<br></div>';
					 			echo '<div class="FprivateEvent">'.$privateEvent.'<br></div>';


					 			echo '<div class="Fhost">';
					 				$admin = getEventAdmin($name)['username'];
					 				if ($admin != $_SESSION['username']){
					 					echo '<div class="hostName">host: '.$admin.'</div>';
					 					echo '<div class="editEvent" style="display: none;">Edit Event</div>';
					 					echo '<div class="deleteEvent" style="display: none;">Delete Event</div>';
					 				}
					 				else{
					 					echo '<div class="editEvent">Edit Event</div>';
					 					echo '<div class="deleteEvent">Delete Event</div>';
					 					echo '<div class="hostName" style="display: none;">host: '.$admin.'</div>';
					 				}
					 			echo '</div>';

					 			echo '<div class="Fpresence">';
					 				echo '<div class="Fmypres">';
					 						echo '<div class="FgoingT">Going</div>';
					 						echo '<div class="FstopF">Not Going</div>';
					 						echo '<div class="FgoingF">Going</div>';
					 						echo '<div class="FstopT">Not Going</div>';
					 				echo '</div>';


					 				$people = getUsersAttendingEvent($name);
					 				$Npeople = count($people);

					 				echo '<div id="Fpeople">';
					 					echo $Npeople.' people going.';
					 				echo '</div>';
					 				echo '<div id="FlistPeople" style="display:none;">';
					 					echo '<p id="listTitle">List of people</p>';
					 					for($i = 0; $i < $Npeople; $i++){
					 						$person = getLine($people, $i)['username'];
					 						echo '<p>'.$person.'</p>';
					 					}
					 				echo '</div>';
					 				echo '<button id="closeList">X</button>';
					 			echo '</div>';

					 			echo '<div class="Fdescription">'.$description.'<br></div>';
					 			echo '<div class="FeventImage"><img name="FFeventImage" src="'.$image.'" alt="eventImage"/></div>';


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
			<div id="editEvent" style="display: none;">
				<h1>Edit Event</h1>
				<form action="/" name="editEventForm" id="editEventForm" method="post">
					<input type="text" value="" name="tituloAntigo" style="display:none;">
					<input type="text" value="" name="titulo"><br>
					<input type="date" value="" name="dateBegin"><br>
					<input type="time" value="" name="time"><br>
					<input type="text" value="" name="type"><br>
					<input type="text" value="" name="location"><br>
					<input type="text" value="" name="description"><br>
					<input type="integer" value="" name="privateEvent"><br>
					<input type="text" value="" name="image"><br>
					<input id="subEditEvent" type="submit" value="Submit Event">
				</form>
				<button id="closeEdit">Cancel</button>
			</div>
	</body>
</html>