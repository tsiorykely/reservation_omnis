<?php

class Panier {

  // Propriétés
  private $reservations = [];

  // Méthodes
  public function addReservation($reservation) {
    $this->reservations[] = $reservation;
  }

  public function removeReservation($id) {
    unset($this->reservations[$id]);
  }

  public function getReservations() {
    return $this->reservations;
  }
}



?>
