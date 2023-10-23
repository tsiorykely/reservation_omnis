<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Réservation</title>
    <link rel="stylesheet" href="../../cdn.jsdelivr.net/npm/bootstrap%404.6.1/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>
    <div class="container">
        <h2>Vos Réservations</h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "vaovao";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Récupérer l'ID de l'utilisateur depuis la session
        $_SESSION['user_id'] = $user['id_utilisateurs'];

        // Récupérer les réservations de l'utilisateur actuel
        $query = "SELECT r.id_reservation, h.heure_debut, h.heure_fin, c.selected_date
          FROM reservation r
          INNER JOIN heure h ON r.id_heure = h.id_heure
          INNER JOIN calendrier_dates c ON r.id_date = c.id_date
          WHERE r.id_utilisateur = $id_utilisateur";

        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_reservation = $row['id_reservation'];
                $heure_debut = $row['heure_debut'];
                $heure_fin = $row['heure_fin'];
                $selected_date = $row['selected_date'];

                echo "<div class='reservation'>";
                echo "<p>Date : $selected_date</p>";
                echo "<p>Heure : $heure_debut - $heure_fin</p>";
                echo "<form method='POST' action='annuler_reservation.php'>";
                echo "<input type='hidden' name='reservation_id' value='$id_reservation'>";
                echo "<button type='submit' name='annuler' class='btn btn-danger'>Annuler la réservation</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "Aucune réservation trouvée.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
