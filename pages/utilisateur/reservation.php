<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_selectione = $_POST['selected_date'];
    $heure_debut= $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    echo'Date de reservaation selecione est le'.$date_selectione. 'l\'heure de reservation est'.$heure_debut.'-'.$heure_fin;
} else {
    echo'Le formulaire n\'est pas posté';
    // 
}
?>