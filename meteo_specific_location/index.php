<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Meteo plugin</title>

		<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,200,500,600,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="style.css"/>
		<link rel="stylesheet" href="weather-icons.min.css"/>
	</head>

	<body>

		<?php include_once 'meteo.php'; ?>

		<div class="meteo">
			<span class="icon_meteo wi <?php echo $meteo->icon($meteo->temp[0]); ?>"></span>
			<span class="temp"><?php echo $meteo->temp[1]; ?>&deg;</span>
		</div>
	</body>

</html>	