<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Calendrier</title>
    <link rel="stylesheet" href="../../cdn.jsdelivr.net/npm/bootstrap%404.6.1/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/acueil.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>    
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
                echo "<button type='submit' class='btn btn-secondary'>$jour</button>";
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
                    echo "<form method='POST' action='save_reservation.php'>";
                    echo "<div class='btn-group-vertical'>";
                    while ($row = $result->fetch_assoc()) {
                        $id_heure = $row['id_heure'];
                        $heure_debut = $row['heure_debut'];
                        $heure_fin = $row['heure_fin'];
                        $reservation_id = $row['id_reservation'];
                        $is_reserved = !is_null($reservation_id);

                        $buttonClass = $is_reserved ? 'heure-reservee' : '';

                        if (!$is_reserved) {
                            
                            echo "<label><input type='checkbox' id='box' name='selected_hours[]' value='$id_heure' class='$buttonClass'>$heure_debut - $heure_fin</label><br>";
                        } else {
                            echo "<label id='box' class='$buttonClass'>$heure_debut - $heure_fin</label><br>";
                        }
                    }
                    echo "</div>";
                    echo "<input type='hidden' name='selected_date' value='$selectedDate'>";
                    echo "<input type='hidden' name='id_utilisateur' value='$user_id'>";
                    echo "<button type='submit' name='submit' id='envoyer' class='btn btn-primary'>Envoyer</button>";
                    echo "</form>";
                } else {
                    echo "Aucune heure disponible pour cette date.";
                }
                ?>
    </div>

</div>
</div>

</body>
</html>
