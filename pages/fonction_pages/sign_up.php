<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Reservation OMNIS</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="../../css/montserrat-font.css">
	<link rel="stylesheet" type="text/css" href="../../fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="../../css/style.css"/>
</head>
<body class="form-v10">
	<div class="page-content">
		<div class="form-v10-content">
			<form class="form-detail" action="add_user.php" method="post" id="myform">
				<div class="form-left">
					<h2>Infomation Géneral </h2>
					<div class="form-group">
						<div class="form-row">
							<input type="text" name="first_name" id="first_name" class="input-text" placeholder="Nom" required>
						
							<input type="text" name="last_name" id="last_name" class="input-text" placeholder="Prénom" required>
							
							<input type="text" name="company" class="company" id="company" placeholder="Société" required>

							<input type="text" name="sport" class="sport" id="sport" placeholder="Votre sport" required>
						</div>
					</div>
					
					</div>
				<div class="form-right">
					<h2>Contact</h2>
					<div class="form-row">
						<input type="text" name="Adress" class="adress" id="street" placeholder="Adress" required>
					
						<input type="text" name="CIN" class="CIN" id="additional" placeholder="Votre numero CIN" required>
					
						<input type="text" name="phone" class="phone" id="phone" placeholder="Numero telephone" required>
					
						<input type="text" name="your_email" id="your_email" class="input-text" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="Votre mail">
					</div>
					<div class="form-checkbox">
						<label class="container"><p>J'accepte  <a href="#" class="text">les termes et Conditions</a> et <a href="#" class="text">les regles </a>qui regie les fonctions de vos reservations.</p>
						  	<input type="checkbox" name="checkbox">
						  	<span class="checkmark"></span>
						</label>
					</div>
					<div class="form-row-last">
						<input type="submit" name="register" class="register" value="Enregistrer">
					</div>
				</div>
			</form>
		</div>
	</div>
</html>