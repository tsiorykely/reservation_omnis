<?php

$days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$heures = ['08h-10h', '10-12h', '12h-14h', '14h-16h', '16h-18h'];
$dates = ['10/01/2023','11/01/2023','12/01/2023','13/01/2023'];

require '../fonction_pages/connect.php';
include '../administrateur/class/intervalles_temps.php';

$pdo = connect();
/**
 * prendre des donne de 
 */
$sql = 'SELECT * FROM reservation';
$result = $pdo->prepare($sql);
$result->execute();

// Récupération des résultats de la requête
$reservations = $result->fetchAll();


$selection_societe= "SELECT * FROM societe"; 
$societes = $pdo->prepare($selection_societe);
$societes ->execute();
$nom_societes = $societes->fetchAll();

// Créer un objet Intervalle et Récupérer les intervalles dans la class "../administrateur/class/intervalles_temps.php"
$intervalle = new Intervalle();
$intervalles = $intervalle->getIntervalles();                            
$heures = $intervalle->get_heure_debut();


// Parcourir les intervalles





?>

<div>
<link rel="stylesheet" href="../../css/main_admin.css">
    <?php
    require '../utilisateur/src/Date/Month.php';

                $month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);

                $start =$month->getStartingDay();

                $firstDay=$start->format('N')==='1'? $start:$month->getStartingDay()->modify('last monday');


    ?>
    <div class="d-flex flex-row aligni-items-center justify-content-between mx-sm-3">
                <h1><?php echo  $month->toString();?></h1>
        <div>
            <a href="main_for_admin.php?month=<?php echo $month->previousMonth()->month;?>&year=<?php echo $month->previousMonth()->year; ?>" class="btn btn-primary">&lt</a>
            <a href="main_for_admin.php?month=<?php echo $month->nextMonth()->month;?>&year=<?php echo $month->nextMonth()->year; ?>" class="btn btn-primary">&gt</a>
        </div>
    </div>
        <table class="table calendar__table calendar__table--<?php echo $month->getWeeks(); ?>weeks">
            <tbody>
                
            <form action="class/insertion_reservation.php" method="post">    
                <?php for ($i=0; $i < $month->getWeeks(); $i++): ?>

                    <div>
       
                                <tr>
                                    <th style="width: 90%;"> 
                                        <div>
                                            <div class="row-scop">
                                            Jours
                                            </div>
                                            <div style="margin:top 10%;">
                                            Date
                                            </div>
                                            <div>
                                            <table >
                                                <div >
                                                    <?php
                                                    foreach ($intervalles as $intervalle) {
                                                        ?>
                                                            <tr >
                                                                <th >
                                                                    <?php 
                                                                        echo $intervalle->heure_debut . PHP_EOL;
                                                            
                                                                        // Afficher l'heure et les minutes de l'heure de fin
                                                                        echo $intervalle->heure_fin . PHP_EOL;
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                            <?php 
                                                        }
                                                            ?>
                                                </div>
                                                
                                            </table>
                                            </div>
                                        </div>
                                    </th>
                                    
                                        <?php foreach ($month->days as $k => $day): $date=(clone $firstDay)->modify("+".($k +$i * 7 )."days") ?>
                                            <th style="width: 19%;" class="case <?php echo $month->withinMonth($date) ? '': 'calendar__othermonth'?>" >
                                                <div>
                                                        <div class="calendar__day">
                                                            <?php echo $day; ?>
                                                            <?php echo $date->format('d/M/Y') ; ?>
                                                        </div>
                                                        <table >
                                                                        <?php
                                                                            
                                                                            foreach ($heures as $heure) {
                                                                        ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <input type="hidden" name="date_de_reservation" value="<?php echo $date->format('Y/M/d');?>">
                                                                                    <input type="hidden" name="heure_debut" value="<?php echo $heure['heure_debut'];?>">
                                                                                    <input type="hidden" name="heure_fin" value="<?php echo $heure['heure_fin'];?>"> 
                                                                                    <input type="hidden" name="jours" value="<?php echo $day;?>"> 
                                                                                    <select style="width: 93%;" name="nom_societe">
                                                                                            
                                                                                            <option value=""></option>
                                                                                                <?php
                                                                                                foreach ($nom_societes as $nom_societe) {
                                                                                                    ?>
                                                                                                    <option value=""><?php echo $nom_societe['nom_societe'];?></option>
                                                                                                                                                                
                                                                                                    <?php
                                                                                                    }
                                                                                                ?>
                                                                                    </select> 
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                        <?php 
                                                                        
                                                                        }
                                                                        ?>
                                                            
                                                        </table>
                                                </div>
                                            </th>
                                                    
                                        <?php endforeach ?>
                                        <tr>
                                    <td></td>  
                                    <td></td> 
                                    <td></td> 
                                    <td></td> 
                                    <td></td> 
                                    <td></td> 
                                    <td></td> 
                                    <td>
                                        <button type="submit" class="btn btn-primary">Inserer</button>
                                    </td>
                                            
                                </tr>  
                                </tr>
                                
                                
                            
                    </div>       
                <?php endfor; ?>
            </form> 
                    
            </tbody>
        </table>
        
</div>