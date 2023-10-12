<?php
require 'connect.php';
$db = connect();

// Vérifier que les champs obligatoires sont remplis
if (!empty($_POST['first_name']) AND
    !empty($_POST['last_name']) AND
    !empty($_POST['company']) AND
    !empty($_POST['sport']) AND
    !empty($_POST['Adress']) AND
    !empty($_POST['CIN']) AND
    !empty($_POST['phone']) AND
    !empty($_POST['your_email'])) {

    /* Préparer la requête SQL
    $sql = 'INSERT INTO utilisateur (nom_client, prenom_client, societe, sport, address, CIN, telephone, email)
            VALUES (:first_name, :last_name, :company, :sport, :address, :cin, :phone, :email)';

    $stmt = $db->prepare($sql);

    // Lier les paramètres nommés aux valeurs de la variable `$_POST`
    $stmt->bind_param(':first_name', $_POST['first_name']);
    $stmt->bind_param(':last_name', $_POST['last_name']);
    $stmt->bind_param(':company', $_POST['company']);
    $stmt->bind_param(':sport', $_POST['sport']);
    $stmt->bind_param(':address', $_POST['Adress']);
    $stmt->bind_param(':cin', $_POST['CIN']);
    $stmt->bind_param(':phone', $_POST['phone']);
    $stmt->bind_param(':email', $_POST['your_email']);

    // Exécuter la requête
    $stmt->execute();

    // Fermer la requête préparée
    $stmt->close();

    // Afficher un message de confirmation
    echo 'Utilisateur ajouté avec succès !';

} else {

    // Afficher un message d'erreur
    echo 'Tous les champs obligatoires doivent être remplis.';

*/
}
?>