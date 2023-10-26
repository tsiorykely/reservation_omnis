<?php
require "connect.php";
$bdd=connect();

$intervalles_temps = $bdd->query("SELECT * FROM intervalles");



if (isset($_GET['year']) and isset($_GET['month']) and isset($_GET['day'])) {
    $annee= $_GET['year'];
    $mois= $_GET['month'];
    $jour= $_GET['day'];

    $jours= array(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']);

    foreach ($variable as $key => $value) {
    # code...
}
}

?>