<?php
session_start();
// Vérification de la session
if (isset($_SESSION['role'])) {
    // Inclusion du code de connexion à la base de données
    include('../fonction_pages/connect.php');

    // Récuperation de l'identifiant de l'utilisateur connecté
    $user_id = $_SESSION['user_id'];

    // Requête pour récupérer les informations de l'utilisateur connecté
    $pdo=connect();
    $sql = "SELECT * FROM utilisateur WHERE id_utilisateurs = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Vérification du résultat de la requête
    if ($stmt->rowCount() > 0) {
        // La requête a retourné des résultats
        $user = $stmt->fetch();
    
?>
<!DOCTYPE html>
<html>
<head>
	   <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
	   <link rel="stylesheet" type="text/css" href="../../bootstrap/dist/css/bootstrap.min.css">
	   <link rel="stylesheet" type="text/css" href="../../bootstrap/dist/fonts/font-awesome.min.css">     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<title>Page de reservation en ligne</title>
</head>
<body>
  
</div> 
	<div>
		  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">OMNIS Reservation</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="main_for_user.php?page=aceuil">Acceuil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="main_for_user.php?page=reservation">Mes reservations</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="main_for_user.php?page=message">Messages</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="main_for_user.php?page=commentaire">Commentaires</a>
            </li>
             <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../fonction_pages/deconnection_admin.php">Deconnexion</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#"><i class="fa-solid fa-user"></i> <?php echo $user['nom_utilisateur'];?></a>
            </li>
          </ul>          
        </div>
      </div>
  </nav>
  <?php
  	$contenu= 'aceuil';
				if (isset($_GET['page'])) {
					$contenu=$_GET['page'];          
				}
				include($contenu.'.php');

	?>
		 
	</div>
<div>
<?php 

?>
</div> 
  
<script type="text/javascript" src="app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php

} else {
  // La requête n'a pas retourné de résultats
  echo "Aucun résultat trouvé";
}
} else {
// L'utilisateur n'est pas connecté
header("Location: ../../index.php");
}
?>