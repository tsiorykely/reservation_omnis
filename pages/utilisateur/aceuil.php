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
            <div >
                <p>
                    la date du jours est:
                    
                </p>
            </div>
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
           <h2>Les heures du jours </h2>
           
        </div>
    </div>
</div>
