<?php
session_start();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord de l'administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- bar de navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Omnis réservation de terrain</a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto"> <!-- Utilisation de la classe me-auto pour aligner vers la gauche -->
        <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-envelope"></i></a>
        <a class="nav-link" href="#"><i class="fa-solid fa-bell"></i></a>
        <a class="nav-link" href="../fonction_pages/deconnection_admin.php"><i class="fa-solid fa-right-from-bracket"></i></a>
      </div>
    </div>
  </div>
</nav>



<div class="container-fluid">
    <div class="row">
        <!-- Barre de navigation latérale -->
        <nav id="sidebar" class="col-md-2 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main_for_admin.php?page=aceuil_admin">
                        <i class="fa-solid fa-calendar-days"></i>
                            Emploi du temps
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main_for_admin.php?page=reservation">
                        <i class="fa-solid fa-clipboard"></i>
                            Reservation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main_for_admin.php?page=message">
                        <i class="fa-regular fa-envelope"></i>
                            Message
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main_for_admin.php?page=paiement">
                        <i class="fa-solid fa-wallet"></i>
                            Paiment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main_for_admin.php?page=commentaire">
                            
                            Commentaire
                        </a>
                    </li>
                    <!-- Ajoutez d'autres liens de navigation ici -->
                </ul>
            </div>
        </nav>

        <!-- Contenu principal -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
        <?php
                $contenu= 'aceuil_admin';
                    if (isset($_GET['page'])) {
                        $contenu=$_GET['page'];
                    }
                    include($contenu.'.php');

        ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
