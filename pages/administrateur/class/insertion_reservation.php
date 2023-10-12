<?php
require "../../fonction_pages/connect.php";

if (isset($_POST['nom_societe'])) {
    $date = $_POST['date_de_reservation'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    $jours = $_POST['jours'];
    $nom_societe = $_POST['nom_societe'];

    $sql = "INSERT INTO reservation (date, heure_debut, heure_fin, jours, nom_societe) VALUES (:date, :heure_debut, :heure_fin, :jours, :nom_societe)";

    $conn = connect(); // Vous devez vous assurer que la fonction connect() est définie

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':heure_debut', $heure_debut);
    $stmt->bindParam(':heure_fin', $heure_fin);
    $stmt->bindParam(':jours', $jours);
    $stmt->bindParam(':nom_societe', $nom_societe);

    if ($stmt->execute()) {
        header('location:../main_for_admin.php?page=aceuil_admin');
    } else {
        echo"une erreur c'est produit";
    }
} else {
    header('location:../main_for_admin.php?page=aceuil_admin');
}

    

?>