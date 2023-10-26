<?php

class EmploiDuTemps {

    private $jours;

    public function __construct() {
        $this->jours = [
            'lundi' => [],
            'mardi' => [],
            'mercredi' => [],
            'jeudi' => [],
            'vendredi' => [],
            'samedi' => [],
            'dimanche' => [],
        ];
    }

    public function ajouterCours($jour, $heureDebut, $heureFin, $matiere, $professeur) {
        $this->jours[$jour][] = [
            'heureDebut' => $heureDebut,
            'heureFin' => $heureFin,
            'matiere' => $matiere,
            'professeur' => $professeur,
        ];
    }

    public function getJours() {
        return $this->jours;
    }

    public function getCours($jour) {
        return $this->jours[$jour];
    }

}




?>