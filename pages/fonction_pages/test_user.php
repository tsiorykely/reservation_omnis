<?php
require 'connect.php';
session_start();

// Utilisation de la fonction connect() pour se connecter à la base de données
$pdo = connect();

if ($pdo === false) {
    // Enregistrement de l'erreur dans un fichier de log
    error_log("Erreur de connexion à la base de données");

    // Affichage d'une erreur personnalisée
    echo "Erreur de connexion à la base de données. Veuillez réessayer plus tard.";

    // Arrêt du script
    exit();
}

// Vérification de la méthode de la requête
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données de la requête
    $usermail = $_POST['email'];
    $password = $_POST['pass'];

    // Vérification dans la table utilisateur
    $sql = "SELECT * FROM utilisateur WHERE mail = :mail AND mot_de_passe = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':mail', $usermail);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Si la requête renvoie un résultat, l'utilisateur est connecté
    if ($stmt->rowCount() == 1) {
        // Récupération des informations de l'utilisateur
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nom_utilisateur = $row['nom'];
        $mot_de_passe = $row['mot_de_passe'];

        // Association de la session avec les informations de l'utilisateur
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
        $_SESSION['mot_de_passe'] = $mot_de_passe;

        // Redirection vers la page correspondante
        header("Location: ../utilisateur/main_for_user.php"); // Rediriger vers la page utilisateur
        exit();
    }

    // Vérification dans la table administrateur
    $sql = "SELECT * FROM responsable WHERE mail = :mail AND mot_de_passe = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':mail', $usermail);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Si la requête renvoie un résultat, l'utilisateur est connecté
    if ($stmt->rowCount() == 1) {
        // Association de la session avec le rôle de l'utilisateur
        $_SESSION['role'] = 'admin';

        // Redirection vers la page correspondante
        header("Location: ../administrateur/main_for_admin.php"); // Rediriger vers la page administrateur
        exit();
    }

    // Si aucune des requêtes n'a renvoyé un résultat, l'utilisateur est non connecté
    echo "Nom d'utilisateur ou mot de passe incorrect.";
}




?>
