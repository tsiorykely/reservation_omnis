  // Fonction pour mettre à jour le nombre de réservations
  function updateReservationCount(count) {
    var countElement = document.getElementById("reservation-count");
    if (countElement) {
      countElement.textContent = count;
    }
  }
