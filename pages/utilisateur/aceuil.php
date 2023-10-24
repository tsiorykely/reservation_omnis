<!DOCTYPE html>
<html>
<head>
    <title>Calendrier</title>
    <link rel="stylesheet" href="../../cdn.jsdelivr.net/npm/bootstrap%404.6.1/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        h2{
            text-align:center;
        }
         table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .navigation {
            text-align: center;
            margin-bottom: 20px;
        }
        .heure-reservee {
            color: red;
            font-weight: bold;
            pointer-events: none; /* Désactiver les événements pointer pour empêcher la sélection */
        }

        
        h5{
            text-align:center;
            margin-top:50px;
        }
        #box{
            margin-left:150px;
        }
        #heure{
            height:400px;
            border-style: solid;
            border-color: #0000ff; /* blue */
            margin-top:90px;
        }
       #liste{
            margin-left:150px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="row">
        <div class="col-md-7">
        <?php
        function afficherCalendrier($annee, $mois) {
            $timestamp = mktime(0, 0, 0, $mois, 1, $annee);
            $nomMois = date('F', $timestamp);
            $joursDansMois = date('t', $timestamp);

            echo "<h2>Calendrier pour $nomMois $annee</h2>";
            echo "<div class='navigation'>";
            echo "<a href='?annee=" . ($mois == 1 ? $annee - 1 : $annee) . "&mois=" . ($mois == 1 ? 12 : $mois - 1) . "'>Mois précédent   |</a>";
            echo "<a href='?annee=" . ($mois == 12 ? $annee + 1 : $annee) . "&mois=" . ($mois == 12 ? 1 : $mois + 1) . "'>  Mois suivant</a>  "; 
            echo "</div>";
            echo "<table>";
            echo "<tr><th colspan='7'>$nomMois $annee</th></tr>";
            echo "<tr><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th><th>Dim</th></tr>";

            $premierJour = date('N', $timestamp);
            echo "<tr>";

            for ($jour = 1; $jour < $premierJour; $jour++) {
                echo "<td></td>";
            }

            for ($jour = 1; $jour <= $joursDansMois; $jour++) {
                $jourSemaine = date('N', mktime(0, 0, 0, $mois, $jour, $annee));
                $date = "$jour/$mois/$annee";

                // Ajout du formulaire dans chaque cellule du calendrier
                echo "<td>";
                echo "<form method='post' action='save_to_db.php'>";
                echo "<input type='hidden' name='selected_date' value='$date'>";
                echo "<button type='submit'>$jour</button>";
                echo "</form>";
                echo "</td>";

                if ($jourSemaine == 7) {
                    echo "</tr><tr>";
                }
            }

            while ($jourSemaine < 7) {
                echo "<td></td>";
                $jourSemaine++;
            }

            echo "</tr>";
            echo "</table>";
        }
        ?>

        <?php
        $anneeActuelle = isset($_GET['annee']) ? intval($_GET['annee']) : date('Y');
        $moisActuel = isset($_GET['mois']) ? intval($_GET['mois']) : date('m');
        afficherCalendrier($anneeActuelle, $moisActuel);
        ?>
    </div>
    <div class="col-md-5" id="heure">
        <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "reservation_terrain";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Échec de la connexion : " . $conn->connect_error);
                    }

                    $selectedDate = "";
                    if(isset($_GET['date'])){
                        $selectedDate = $_GET['date'];
                    } elseif(isset($_POST['selected_date'])) {
                        $selectedDate = $_POST['selected_date'];
                    }

                    echo "<h5>Sélectionnez les heures pour le $selectedDate :</h5>";

                    $query = "SELECT h.id_heure, heure_debut, heure_fin, r.id_reservation FROM heure h
                            LEFT JOIN reservation r ON h.id_heure = r.id_heure AND r.id_date = (SELECT id_date FROM calendrier_dates WHERE selected_date = '$selectedDate')";

                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        echo "<form method='POST' action='reservation.php'>";
                        echo "<div class='btn-group-vertical'>";
                        while ($row = $result->fetch_assoc()) {
                            $id_heure = $row['id_heure'];
                            $heure_debut = $row['heure_debut'];
                            $heure_fin = $row['heure_fin'];
                            $reservation_id = $row['id_reservation'];
                            $is_reserved = !is_null($reservation_id);

                            $buttonClass = $is_reserved ? 'heure-reservee' : '';

                            // Condition pour ajouter ou non le checkbox
                            if (!$is_reserved) {
                                echo "<label><input type='checkbox' id='box' name='selected_hours[]' value='$id_heure' class='$buttonClass'>$heure_debut - $heure_fin</label><br>";
                            } else {
                                echo "<label id='box' class='$buttonClass'>$heure_debut - $heure_fin</label><br>";
                            }
                        }
                        echo "</div>";
                        echo "<input type='hidden' name='selected_date' value='$selectedDate'>";
                        echo "<input type='hidden' name='heure_debut' value='$heure_debut'>";
                        echo "<input type='hidden' name='heure_fin' value='$heure_fin'>";                        
                        echo "<div>";
                        echo "<button type='submit' name='submit' id='envoyer' class='btn btn-primary'>Envoyer</button>";
                        echo "</div>";
                        echo "</form>";
                    } else {
                        echo "Aucune heure disponible pour cette date.";
                    }
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Titre du Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenu du modal -->
        <p>Contenu du modal ici.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary">Sauvegarder les modifications</button>
      </div>
    </div>
  </div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
