<?php
 
// Paramètres de connexion à la base de données (à remplacer par vos propres valeurs)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservation_terrain"; 

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Fonction pour afficher les heures de réservation
function afficherHeuresReservation($date, $conn) {
    $formattedDate = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

    // Requête SQL pour récupérer les heures de réservation pour la date donnée
    $sql = "SELECT heure_reservation, id_heure FROM heures_reservation WHERE date_reservation = '$formattedDate'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Les Heures de réservation pour $date</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $id_heure = $row['id_heure'];
            $heure_debut = $row['heure_debut'];
            $heure_fin = $row['heure_fin'];

            // Ajouter l'identifiant de l'heure à la structure de données
            $row['id_heure'] = $id_heure;

            echo "<li>" . $heure_debut . " - " . $heure_fin . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<h2>Aucune réservation pour $date</h2>";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération de la date au format "YYYY-MM-DD" (assumant le format "d/m/Y")
    $selectedDate = $_POST['selected_date'];
    $formattedDate = date('Y-m-d', strtotime(str_replace('/', '-', $selectedDate)));

    // Échapper les caractères spéciaux pour éviter les injections SQL
    $formattedDate = $conn->real_escape_string($formattedDate);

    // Vérification si la date existe déjà dans la base de données
    $checkSql = $conn->prepare("SELECT * FROM calendrier_dates WHERE selected_date = ?");
    $checkSql->bind_param("s", $formattedDate);
    $checkSql->execute();

    // Récupération du résultat de la requête
    $result = $checkSql->get_result();

    if ($result->num_rows > 0) {
        header('Location: autre_page.php?date=' . $formattedDate);
    } else {
        // Requête SQL pour insérer la date dans la base de données
        $insertSql = $conn->prepare("INSERT INTO calendrier_dates (selected_date) VALUES (?)");
        $insertSql->bind_param("s", $formattedDate);

        if ($insertSql->execute() === TRUE) {
            header('Location: autre_page.php?date=' . $formattedDate);
        } else {
            echo "Erreur : " . $insertSql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calendrier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
         table {
            width: 50%;
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
    </style>
</head>
<body>
<div class="row">
        <div class="col-md-7">
        <?php
        function afficherCalendrier($annee, $mois) {
            $timestamp = mktime(0, 0, 0, $mois, 1, $annee);
            $nomMois = date('F', $timestamp);
            $joursDansMois = date('t', $timestamp);

            echo "<h2>Calendrier pour $nomMois $annee</h2>";
            echo "<div class='navigation'>";
            echo "<a href='?annee=" . ($mois == 1 ? $annee - 1 : $annee) . "&mois=" . ($mois == 1 ? 12 : $mois - 1) . "'>&lt Mois précédent |</a>";
            echo "<a href='?annee=" . ($mois == 12 ? $annee + 1 : $annee) . "&mois=" . ($mois == 12 ? 1 : $mois + 1) . "'>Mois suivant &gt</a>  "; 
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
                echo "<form method='GET' action='save_to_db.php'>";
                echo "<input type='hidden' name='selected_date' value='$date'>";
                echo "<input type='hidden' name='id_heure' value='<%= id_heure %>'>";
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
    <div class="col-md-5">
                
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "reservation_terrain";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Échec de la connexion : " . $conn->connect_error);
            }

            $id_utilisateur = 1;  // Vous devrez obtenir cela à partir de votre système d'authentification.

            $selectedDate = "";
            if(isset($_GET['date'])){
                $selectedDate = $_GET['date'];
            } elseif(isset($_POST['selected_date'])) {
                $selectedDate = $_POST['selected_date'];
            }

            echo "<h2>Sélectionnez les heures pour le $selectedDate :</h2>";

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

                    // Condition pour ajouter ou non le checkbox
                    if (!$is_reserved) {
                        echo "<label><input type='checkbox' name='selected_hours[]' value='$id_heure' class='$buttonClass'>$heure_debut - $heure_fin</label><br>";
                    } else {
                        echo "<label class='$buttonClass'>$heure_debut - $heure_fin</label><br>";
                    }
                }
                echo "</div>";
                echo "<input type='hidden' name='selected_date' value='$selectedDate'>";
                echo "<input type='hidden' name='id_utilisateur' value='$id_utilisateur'>";
                echo "<button type='submit' name='submit' class='btn btn-primary'>Envoyer</button>";
                echo "</form>";
            } else {
                echo "Aucune heure disponible pour cette date.";
            }
            ?>
    </div>
</div>
<?php
// Vérifier si le panier de réservations existe dans la session
if (isset($_SESSION['reservation_cart']) && !empty($_SESSION['reservation_cart'])) {
    // Afficher le panier de réservations
    echo '<h1>Panier de réservations :</h1>';
    echo '<ul>';
    
    foreach ($_SESSION['reservation_cart'] as $reservation) {
        echo '<li>';
        echo 'Date de réservation : ' . $reservation['date_reservation'] . '<br>';
        echo 'Date sélectionnée : ' . $reservation['id_date'] . '<br>';
        echo 'Heure sélectionnée : ' . $reservation['id_heure'] . '<br>';
        echo 'ID de l\'utilisateur : ' . $reservation['id_utilisateur'] . '<br>';

        
        echo '</li>';
    }
    
    echo '</ul>';
} else {
    echo 'Le panier de réservations est vide.';
}
?>

</div>


</body>
</html>
