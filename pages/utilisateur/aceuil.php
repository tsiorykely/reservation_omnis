<link rel="stylesheet" href="public/css/calendar.css">
<div class="container">
    <div class="row">
        <div class="col-md-7 ">
            <?php
            require 'src/Date/Month.php';

                $month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);

                $start =$month->getStartingDay();

                $firstDay=$start->format('N')==='1'? $start : $month->getStartingDay()->modify('last monday');


            ?>
            <div class="d-flex flex-row aligni-items-center justify-content-between mx-sm-3">
                <h1><?php echo  $month->toString();?></h1>
                <div>
                    <a href="main_for_user.php?month=<?php echo $month->previousMonth()->month;?>&year=<?php echo $month->previousMonth()->year; ?>" class="btn btn-primary">&lt</a>
                    <a href="main_for_user.php?month=<?php echo $month->nextMonth()->month;?>&year=<?php echo $month->nextMonth()->year; ?>" class="btn btn-primary">&gt</a>
                </div>
            </div>

            <table class="calendar__table calendar__table--<?php echo $month->getWeeks(); ?>weeks">
                
                <?php for ($i=0; $i < $month->getWeeks(); $i++): ?>
                    <tr>
                        <?php foreach ($month->days as $k => $day):
                            $date=(clone $firstDay)->modify("+".($k +$i * 7 )."days") ?>
                                <td class="<?php echo $month->withinMonth($date) ? '': 'calendar__othermonth'?>">

                                    <?php if ($i === 0): ?>
                                        <div class="calendar__weekday">
                                        <?php echo $day; ?>
                                        </div>
                                    <?php endif; ?>
                                        <form action="main_for_user.php?page=aceuil" method="get">
                                            <input type="hidden" name="year" value="<?php echo $date->format('Y'); ?>">
                                            <input type="hidden" name="month" value="<?php echo $date->format('m'); ?>">
                                            <input type="hidden" name="day" value="<?php echo $date->format('d'); ?>">
                                            <button class="<?php echo'btn btn-primary';?>" type="submit">
                                                <div class="calendar__day">
                                                    <?php echo $date->format('d'); ?>
                                                </div>
                                            </button>
                                        </form>



                                </td>
                        <?php endforeach ?>
                    </tr>
                <?php endfor; ?>	




            </table>
        </div>
        <div class="col-md-5 ">
            <?php 
                if (isset($_SESSION['role'])) {
                    // Vous pouvez accéder aux autres informations de l'utilisateur stockées en session ici.
                    $role = $_SESSION['role'];
                    // Par exemple, vous pouvez avoir d'autres informations stockées dans la session comme le nom de l'utilisateur.
                    $username = $_SESSION['username'];
                
                    // Vous pouvez maintenant utiliser ces informations comme bon vous semble, par exemple, les afficher.
                    echo "Bienvenue, $username ! Votre rôle est : $role";
                
                    // Vous pouvez également effectuer d'autres opérations en fonction des informations de l'utilisateur.
                    if ($role === 'utilisateur') {
                        // Faites quelque chose pour les utilisateurs.
                    } elseif ($role === 'admin') {
                        // Faites quelque chose de différent pour les administrateurs.
                    }
                } else {
                    // La session ne contient pas d'informations sur l'utilisateur.
                    // Vous pouvez rediriger l'utilisateur vers une page de connexion ou effectuer d'autres actions en conséquence.
                    echo "Vous n'êtes pas connecté ou votre rôle n'est pas défini.";
                }
            ?>
        </div>
    </div>
</div>
