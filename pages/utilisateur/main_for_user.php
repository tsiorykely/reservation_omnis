<?php
session_start();
// Vérification de la session
if (isset($_SESSION['role'])) {
    // Inclusion du code de connexion à la base de données
    include('../fonction_pages/connect.php');

    // Récuperation de l'identifiant de l'utilisateur connecté
    $user_id = $_SESSION['user_id'];
    
            
    setlocale(LC_TIME, 'fr_FR');

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
              <a class="nav-link" aria-current="page" href="main_for_user.php?page=reservation"><i class="fa fa-list" aria-hidden="true"></i> Mes reservations </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="main_for_user.php?page=message">Messages <i class="far fa-comment-alt"></i> </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="main_for_user.php?page=commentaire">Commentaires <i class="far fa-comment"></i> </a>
            

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#"><?php echo $user['nom_utilisateur'];?>  <i class="fa-solid fa-user"></i> </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#" data-bs-target="#reservation-modal" data-bs-toggle="modal">
                Pannier <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span id="reservation-count" class="badge badge-danger">0</span>
              </a>
            </li>

            </li>
             <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../fonction_pages/deconnection_admin.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</a>
            </li>
          </ul>          
        </div>
      </div>
  </nav>

  <div class="modal fade" id="reservation-modal" tabindex="-1" aria-labelledby="reservation-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reservation-modal-label">Tout vos reservation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
            <?php
            session_start(); // Démarrer la session PHP
            $conn=$pdo;
            try {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Échec de la connexion : " . $e->getMessage());
            }

            // ... (votre code existant)

            // Affichage du panier de réservations
            if (isset($_SESSION['reservation_cart']) && !empty($_SESSION['reservation_cart'])) {
                echo '<h1>Panier de réservations :</h1>';
                echo '<ol>';
                
                foreach ($_SESSION['reservation_cart'] as $reservation) {
                    echo '<li>';
                    echo 'Date de réservation : ' . $reservation['date_reservation'] . '<br>';
                    echo 'Date du reservation : ' . $reservation['selected_date'] . '<br>';
                    echo 'Heure sélectionnée : ' . $reservation['id_heure'] . '<br>';
                    echo 'ID de l\'utilisateur : ' . $reservation['id_utilisateur'] . '<br>';
                    echo '</li>';
                }
                
                echo '</ol>';
            } else {
                echo 'Le panier de réservations est vide.';
            }
            ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">soummetre</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

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
<script type="text/javascript" src="../../js/panier_count.js"></script>
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
