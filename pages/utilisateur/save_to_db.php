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
        header('Location: main_for_user.php?date=' . $formattedDate);
    } else {
        // Requête SQL pour insérer la date dans la base de données
        $insertSql = $conn->prepare("INSERT INTO calendrier_dates (selected_date) VALUES (?)");
        $insertSql->bind_param("s", $formattedDate);

        if ($insertSql->execute() === TRUE) {
            header('Location: main_for_user.php?date=' . $formattedDate);
        } else {
            echo "Erreur : " . $insertSql . "<br>" . $conn->error;
        }
    }
}

?>