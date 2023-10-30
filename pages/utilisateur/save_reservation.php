<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Valider et nettoyer les données entrantes
    $selected_date = isset($_POST['selected_date']) ? htmlspecialchars($_POST['selected_date']) : null;
    $selected_hours = isset($_POST['selected_hours']) ? $_POST['selected_hours'] : [];
    $id_utilisateur = isset($_POST['id_utilisateur']) ? htmlspecialchars($_POST['id_utilisateur']) : null;
    
    var_dump($selected_date );

    if (empty($selected_date) || empty($id_utilisateur)) {
        echo "Veuillez sélectionner une date et un utilisateur.";
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "reservation_terrain");

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Validation de l'heure et ajout au panier
    foreach ($selected_hours as $heure) {
        $check_reservation_query = "SELECT COUNT(*) AS count FROM reservation WHERE id_date = ? AND id_heure = ?";
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
        }

        $_SESSION['reservation_cart'][] = array(
            'id_date' => $id_date,
            'id_heure' => $heure,
            'id_utilisateur' => $id_utilisateur,
            'selected_date '=> $selected_date ,
            'date_reservation' => date('Y/m/d')
        );
    }


    // Redirection vers la page principale pour l'utilisateur
    header('Location: main_for_user.php');
    exit(); 
}
?>
