	<?php
			// 1. Configuration de la connexion à la base de données (à personnaliser)
			$db_host = 'localhost';
			$db_user = 'root';
			$db_password = '';
			$db_name = 'calendrier';

			// Établir la connexion à la base de données
			$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

			// Vérifier la connexion
			if ($mysqli->connect_error) {
			    die("Échec de la connexion à la base de données : " . $mysqli->connect_error);
			}

			// 2. Récupération des valeurs du jour, du mois et de l'année depuis les paramètres GET
			$year = $_GET['year'] ?? null;
			$month = $_GET['month'] ?? null;
			$day = $_GET['day'] ?? null;

			if ($year && $month && $day) {
			    // 3. Création de la requête SQL pour interroger la base de données (à personnaliser)
			    $sql = "SELECT * FROM reservations WHERE year = $year AND month = $month AND jour = $day";

			    // Exécution de la requête SQL
			    $result = $mysqli->query($sql);

			    // 4. Affichage des résultats dans une div
			    if ($result->num_rows > 0) {
			        $row = $result->fetch_assoc();
			        echo '<div>';
			        echo 'Résultats de la base de données : ' . $row['id'];
			        echo '</div>';
			    } else {
			        echo '<div>Aucun résultat trouvé pour la date spécifiée.</div>';
			    }

			    // Fermer la connexion à la base de données
			    $mysqli->close();
			}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Calendrier</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/calendar.css">
</head>
<body>
	<nav class="navbar navbar-dark bg-primary mb-3" >
		<a href="/index.php" class="navbar-brand">Mon calendrier</a>
	</nav>
<?php
require '../src/Date/Month.php';

	$month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);

	$start =$month->getStartingDay();

	$firstDay=$start->format('N')==='1'? $start : $month->getStartingDay()->modify('last monday');


?>
<div class="d-flex flex-row aligni-items-center justify-content-between mx-sm-3">
	<h1><?php echo  $month->toString();?></h1>
	<div>
		<a href="index.php?month=<?php echo $month->previousMonth()->month;?>&year=<?php echo $month->previousMonth()->year; ?>" class="btn btn-primary">&lt</a>
		<a href="index.php?month=<?php echo $month->nextMonth()->month;?>&year=<?php echo $month->nextMonth()->year; ?>" class="btn btn-primary">&gt</a>
	</div>
</div>

<table class="calendar__table calendar__table--<?php echo $month->getWeeks(); ?>weeks">
	
	<?php for ($i=0; $i < $month->getWeeks(); $i++): ?>
		<tr>
			<?php foreach ($month->days as $k => $day):
				$date=(clone $firstDay)->modify("+".($k +$i * 7 )."days") ?>
					<td class="<?php echo $month->withinMonth($date) ? '': 'calendar__othermonth'?>">

						<?php if ($i === 0): ?>
							<div class="calendar__weekday">
							<?php echo $day; ?>
							</div>
						<?php endif; ?>
							<form action="index.php" method="get">
							    <input type="hidden" name="year" value="<?php echo $date->format('Y'); ?>">
							    <input type="hidden" name="month" value="<?php echo $date->format('m'); ?>">
							    <input type="hidden" name="day" value="<?php echo $date->format('d'); ?>">
							    <button class="btn btn-primary" type="submit">
							        <div class="calendar__day">
							            <?php echo $date->format('d'); ?>
							        </div>
							    </button>
							</form>



					</td>
			<?php endforeach ?>
		</tr>
	<?php endfor; ?>	




</table>


</body>
</html>