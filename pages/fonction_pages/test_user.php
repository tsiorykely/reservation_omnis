<?php
require 'connect.php';
session_start();

    $host="localhost";
    $dbname="reservation_terrain";
    $username="root";
    $password="";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usermail = $_POST['email'];
    $password = $_POST['pass'];

    // Vérification dans la table utilisateur
    $result_user = $conn->query("SELECT * FROM utilisateur WHERE mail='$usermail' AND mot_de_passe='$password'");
    if ($result_user->num_rows == 1) {
        $_SESSION['role'] = 'utilisateur';
        header("Location: ../utilisateur/main_for_user.php"); // Rediriger vers la page utilisateur
        exit();
    }

    // Vérification dans la table administrateur
    $result_admin = $conn->query("SELECT * FROM responsable WHERE mail='$usermail' AND mot_de_passe='$password'");
    if ($result_admin->num_rows == 1) {
        $_SESSION['role'] = 'admin';
        header("Location: ../administrateur/main_for_admin.php"); // Rediriger vers la page administrateur
        exit();
    }

    echo "Nom d'utilisateur ou mot de passe incorrect.";
}




?>