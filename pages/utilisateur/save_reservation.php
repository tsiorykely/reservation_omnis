<?php
session_start(); // Démarrer la session PHP

// Vérifier si le panier de réservations existe dans la session, sinon le créer
if (!isset($_SESSION['reservation_cart'])) {
    $_SESSION['reservation_cart'] = array();
}

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

    // Vérifier si l'heure est déjà réservée pour cette date
    foreach ($selected_hours as $heure) {
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

            // Ajouter la réservation au panier temporaire
            $_SESSION['reservation_cart'][] = array(
                'id_date' => $id_date,
                'id_heure' => $heure,
                'id_utilisateur' => $id_utilisateur,
                'date_reservation' => date('Y-m-d')
            );

            header('Location: main_for_user.php?date=' . $formattedDate);
        } else {
            echo "Erreur lors de la vérification de la réservation existante : " . $conn->error;
            exit();
        }
    }

    $stmt_check_reservation->close(); // Fermeture de la requête préparée pour la vérification
}

$conn->close();
?>
