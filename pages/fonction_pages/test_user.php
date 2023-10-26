<?php
require 'connect.php';

// Démarrage de la session PHP
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

// Démarrage de la session PHP
session_start();

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
        
        // Association de la session avec le rôle utilisateur
        $_SESSION['role'] = 'utilisateur';
        // Récupération des informations de l'utilisateur
        $user = $stmt->fetch();
        
            $_SESSION['user_id'] = $user['id_utilisateurs'];
            $_SESSION['user_nom'] = $user['nom_utilisateurs'];
          
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
        
        // Association de la session avec le rôle administrateur
        $_SESSION['role'] = 'admin';

        // Redirection vers la page correspondante
        header("Location: ../administrateur/main_for_admin.php"); // Rediriger vers la page administrateur
        exit();
    }

    // Si aucune des requêtes n'a renvoyé un résultat, l'utilisateur est non connecté
    echo "Nom d'utilisateur ou mot de passe incorrect.";
}

?>
