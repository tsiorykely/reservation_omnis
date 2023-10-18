<?php
// Créer une fonction qui définit la connexion à la base de données
function connexion() {
    // Créer une connexion à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=reservation_terrain', 'root', '');

    // Configurer les erreurs de la connexion
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retourner la connexion
    return $connexion;
}
class Intervalle {

    public $action = "/class/entervalles";

    private $connexion;

    public $heure_debut;

    public $heure_fin;

    public function __construct() {
        $this->connexion = connexion();
    }

    

    public function getIntervalles() {
        // Exécuter la requête SQL
        $resultat = $this->connexion->query('SELECT * FROM intervalles ORDER BY heure_debut  ');
    
        // Parcourir les résultats
        $intervalles = [];
        while ($ligne = $resultat->fetch()) {
            // Récupérer l'heure de début
            $heure_debut = date('H:i', strtotime($ligne['heure_debut']));
    
            // Récupérer l'heure de fin
            $heure_fin = date('H:i', strtotime($ligne['heure_fin']));
    
            // Créer un nouvel intervalle
            $intervalle = new Intervalle();
            $intervalle->heure_debut = $heure_debut;
            $intervalle->heure_fin = $heure_fin;
    
            // Ajouter l'intervalle à la liste
            $intervalles[] = $intervalle;
            
        }
            
        // Fermer le résultat
        $resultat->closeCursor();
    
        // Retourner la liste des intervalles
        return $intervalles;
    }
    public function toArray() {
        return [
            'heure_debut' => $this->heure_debut,
            'heure_fin' => $this->heure_fin,
        ];
    }
    public function get_heure_debut(){
        $resultat = $this->connexion->query('SELECT heure_debut, heure_fin FROM intervalles');
        $heures = $resultat->fetchAll();

        // Fermer le résultat
        $resultat->closeCursor();

        return $heures;
    }
    
}
    



?>