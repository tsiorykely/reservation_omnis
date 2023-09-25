<?php

namespace App\Date;

class Month
{
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    public $month;
    public $year;

    /**
     * Constructeur de mois
     * @param int|null $month le mois entre 1 et 12
     * @param int|null $year
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null) {
            $month = intval(date('m'));
        }

        if ($year === null) {
            $year = intval(date('Y'));
        }

        if ($month < 1 || $month > 12) {
            // Gestion de l'ajustement du mois et de l'année
            $year += intval(($month - 1) / 12);
            $month = (($month - 1) % 12) + 1;
        }

        if ($year < 1970) {
            throw new \Exception("L'année est inférieure à 1970");
        }

        $this->month = $month;
        $this->year = $year;
    }

    /**
     * renvois le premier jour du mois
     * @return \DateTime
     */
    public function getStartingDay(): \DateTime
    {
        return new \DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * convertion du nom du mois et de l'année
     */
    public function toString()
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    /**
     * recuperation du nombre de semaine dans un mois
     * @return int
     */
    public function getWeeks(): int
{
    $start = $this->getStartingDay();
    $end = (clone $start)->modify('last day of this month');

    $totalDays = intval($end->format('j')); // Nombre total de jours dans le mois
    $daysBeforeFirstSunday = intval($start->format('w')); // Nombre de jours avant le premier dimanche

    // Calcul du nombre de semaines
    $weeks = ceil(($totalDays + $daysBeforeFirstSunday) / 7);

    return $weeks;
}



    /**
     * Est-ce que le jour est dans le mois en cours
     * @param \DateTime $date
     * @return bool
     */
    public function withinMonth(\DateTime $date): bool
    {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoie le mois suivant
     * @return Month
     */
    public function nextMonth(): Month
    {
        $month = $this->month + 1;
        $year = $this->year;

        if ($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * renvoie le mois précédent
     * @return Month
     */
    public function previousMonth(): Month
    {
        $month = $this->month - 1;
        $year = $this->year;

        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}
