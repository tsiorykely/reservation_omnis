<?php
require '../fonction_pages/connect.php';
// Connexion à la base de données
$pdo = connect();

// Vérification de la connexion
if ($pdo->errorInfo()[1]) {
    die("Échec de la connexion : " .$pdo->errorInfo()[2]);
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Récupération de la date au format "YYYY-MM-DD" (assumant le format "d/m/Y")
    $selectedDate = $_GET['selected_date'];
    $formattedDate = date('Y-m-d', strtotime(str_replace('/', '-', $selectedDate)));

    // Vérification si la date existe déjà dans la base de données
    $checkSql = "SELECT * FROM calendrier_dates WHERE selected_date = ?";
    $stmt = $pdo->prepare($checkSql);
    $stmt->execute(array($formattedDate));

    // Récupération du résultat de la requête
    $result = $stmt->fetch();

    if ($result) {
        header('Location: main_for_user.php?date=' . $formattedDate);
    } else {
        // Requête SQL pour insérer la date dans la base de données
        $insertSql = "INSERT INTO calendrier_dates (selected_date) VALUES (?)";
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute(array($formattedDate));

        if ($stmt->execute() === TRUE) {
            header('Location: main_for_user.php?date=' . $formattedDate);
        } else {
            echo "Erreur : " . $insertSql . "<br>" . $pdo->errorInfo();
        }
    }
}

// Fermeture de la connexion
$pdo = null;
?>
