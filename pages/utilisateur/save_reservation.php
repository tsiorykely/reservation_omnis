<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservation_terrain";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : "";
    $selected_hours = isset($_POST['selected_hours']) ? $_POST['selected_hours'] : array();
    $id_utilisateur = isset($_POST['id_utilisateur']) ? $_POST['id_utilisateur'] : "";

    if (empty($selected_date) || empty($id_utilisateur)) {
        echo "Veuillez sélectionner une date et un utilisateur.";
        exit();
    }

    // Obtenir l'ID de la date en fonction de la date sélectionnée
    $get_date_id_query = "SELECT id_date FROM calendrier_dates WHERE selected_date = ?";
    $stmt_get_date_id = $conn->prepare($get_date_id_query);
    $stmt_get_date_id->bind_param("s", $selected_date);
    $stmt_get_date_id->execute();
    $result_get_date_id = $stmt_get_date_id->get_result();

    if ($result_get_date_id && $row = $result_get_date_id->fetch_assoc()) {
        $id_date = $row['id_date']; // L'ID de date récupéré
    } else {
        echo "Erreur lors de la récupération de l'ID de la date : " . $conn->error;
        exit();
    }

    $stmt_get_date_id->close(); // Fermeture de la requête préparée

    // Requête préparée pour l'insertion
    $insert_reservation_query = "INSERT INTO reservation (id_date, id_heure, id_utilisateur, date_reservation,nom_utilisateur) 
                                VALUES (?, ?, ?, CURDATE(),".$_SESSION['nom_utilisateur'].")";

    // Préparation de la requête
    $stmt = $conn->prepare($insert_reservation_query);

    // Liage des paramètres
    $stmt->bind_param("iii", $id_date, $heure, $id_utilisateur);

    foreach ($selected_hours as $heure) {
        // Vérifier si l'heure est déjà réservée pour cette date
        $check_reservation_query = "SELECT COUNT(*) AS count FROM reservation 
                                   WHERE id_date = ? AND id_heure = ?";

        // Préparation et exécution de la requête préparée pour la vérification
        $stmt_check_reservation = $conn->prepare($check_reservation_query);
        $stmt_check_reservation->bind_param("ii", $id_date, $heure);
        $stmt_check_reservation->execute();
        $result_check_reservation = $stmt_check_reservation->get_result();

        if ($result_check_reservation) {
            $reservation_count = $result_check_reservation->fetch_assoc()['count'];

            if ($reservation_count > 0) {
                echo "L'heure $heure est déjà réservée pour cette date.";
                exit(); // Arrêter le script si l'heure est déjà réservée
            }
        } else {
            echo "Erreur lors de la vérification de la réservation existante : " . $conn->error;
            exit();
        }

        // Exécution de la requête préparée
        if ($stmt->execute() === TRUE) {
            echo "Réservation insérée avec succès pour l'heure $heure.";
        } else {
            echo "Erreur lors de l'insertion de la réservation : " . $stmt->error;
        }
    }

    $stmt->close();  // Fermeture de la requête préparée
    $stmt_check_reservation->close(); // Fermeture de la requête préparée pour la vérification
}

$conn->close();
?>
