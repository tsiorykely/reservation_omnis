<?php
session_start();
$id_utilisateur = $_SESSION['user_id'] ;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Réservation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Vos Réservations</h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "reservation_terrain";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Récupérer l'ID de l'utilisateur depuis la session
        $id_utilisateur = $_SESSION['user_id'];

        // Récupérer les réservations de l'utilisateur actuel (en sécurisant la requête)
        $query = "SELECT r.id_reservation, h.heure_debut, h.heure_fin, c.selected_date
                  FROM reservation r
                  INNER JOIN heure h ON r.id_heure = h.id_heure
                  INNER JOIN calendrier_dates c ON r.id_date = c.id_date
                  WHERE r.id_utilisateur = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_utilisateur);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Créez un tableau pour stocker les réservations de l'utilisateur actuel
            $reservations = array();

            while ($row = $result->fetch_assoc()) {
                $id_reservation = $row['id_reservation'];
                $heure_debut = $row['heure_debut'];
                $heure_fin = $row['heure_fin'];
                $selected_date = $row['selected_date'];

                // Stockez chaque réservation dans le tableau
                $reservation_data = array(
                    'id_reservation' => $id_reservation,
                    'heure_debut' => $heure_debut,
                    'heure_fin' => $heure_fin,
                    'selected_date' => $selected_date
                );

                $reservations[] = $reservation_data;
            }

            // Stockez le tableau des réservations dans une variable de session
            $_SESSION['reservations'] = $reservations;

            // Affichez les réservations
            foreach ($reservations as $reservation_data) {
                echo "<div class='reservation'>";
                echo "<p>Date : " . $reservation_data['selected_date'] . "</p>";
                echo "<p>Heure : " . $reservation_data['heure_debut'] . " - " . $reservation_data['heure_fin'] . "</p>";
                echo "<form method='POST' action='annuler_reservation.php'>";
                echo "<input type='hidden' name='reservation_id' value='" . $reservation_data['id_reservation'] . "'>";
                echo "<button type='submit' name='annuler' class='btn btn-danger'>Annuler la réservation</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "Aucune réservation trouvée.";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
