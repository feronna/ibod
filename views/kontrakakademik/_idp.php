<?php //needed for Html tag usage
use yii\helpers\Html;
use app\widgets\IdpTileWidget;
?>
<style>
    .tile-stats p {
    font-size: 14px;
    font-weight: bold;
}
</style>
<div class="clearfix"></div> 
<div class="row"> 
            <div class="x_panel">
       
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Individual Development Plan</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
<!--    <div class="col-xs-12 col-md-4">
            <?php
//            $testingPage1 = IdpTileWidget::widget(
//                            [
//                                'icon' => 'pie-chart',
//                                //'icon' => 'fas fa-chart-pie',
////                                'header' => 'Core (50%)',
//                                //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
////                                'text' => (date('Y')-2).' - '. date('Y'),
//                                'number' => 'Core (50%)',
////                                'number' => $model->mataTerasUniversiti . '/' . $model->mataminterasuni3tahun,
//                                'pbar' => '<div class="'.$model->progressbarcolor($model->peratusteras).' role="progressbar" data-transitiongoal="'.$model->peratusteras.'">'.$model->peratusteras.'%</div>',
//                            ]
//            );
//            echo Html::button('<a>'.$testingPage1.'</a>'.'<a>'.$testingPage1.'</a>', ['id' => 'modalButton', 'value' => 'idp?type=3&icno='.$model->icno,'style'=>'background-color: transparent; 
//                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
            ?> 
    </div>-->

        <div class="col-xs-12 col-md-4">
            <button type="button" id="modalButton" class="mapBtn" value="idp?type=4&icno=<?=$model->icno?>" style="background-color: transparent;border: none; width: 100%; text-align:left;">
                    <div style="background-color:    #3498db" class="tile-stats">
<!--                        <div class="icon"><i class="fa fa-pie-chart"></i></div>-->
                        <div style="color:   white" class="count">Core (50%)
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y'),3) . '/' . $model->mataminidp(date('Y'), 0.5).' ('.date('Y').')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(3,0.5, date('Y')))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(3,0.5, date('Y'))?>"><?=$model->peratusidp(3,0.5, date('Y')).'%'?></div>
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y')-1,3) . '/' . $model->mataminidp(date('Y')-1, 0.5).' ('.(date('Y')-1).')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(3,0.5, date('Y')-1))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(3,0.5, date('Y')-1)?>"><?=$model->peratusidp(3,0.5, date('Y')-1).'%'?></div>
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y')-2,3) . '/' . $model->mataminidp(date('Y')-2, 0.5).' ('.(date('Y')-2).')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(3,0.5, date('Y')-2))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(3,0.5, date('Y')-2)?>"><?=$model->peratusidp(3,0.5, date('Y')-2).'%'?></div>
                        </div>
                    </div></button>
        </div>

        <div class="col-xs-12 col-md-4">
            <button type="button" id="modalButton" class="mapBtn" value="idp?type=4&icno=<?=$model->icno?>" style="background-color: transparent;border: none; width: 100%; text-align:left;">
                    <div style="background-color:    #3498db" class="tile-stats">
<!--                        <div class="icon"><i class="fa fa-pie-chart"></i></div>-->
                        <div style="color:   white" class="count">Elective (30%)
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y'),4) . '/' . $model->mataminidp(date('Y'), 0.3).' ('.date('Y').')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(4,0.3, date('Y')))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(4,0.3, date('Y'))?>"><?=$model->peratusidp(4,0.3, date('Y')).'%'?></div>
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y')-1,4) . '/' . $model->mataminidp(date('Y')-1, 0.3).' ('.(date('Y')-1).')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(4,0.3, date('Y')-1))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(4,0.3, date('Y')-1)?>"><?=$model->peratusidp(4,0.3, date('Y')-1).'%'?></div>
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y')-2,4) . '/' . $model->mataminidp(date('Y')-2, 0.3).' ('.(date('Y')-2).')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(4,0.3, date('Y')-2))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(4,0.3, date('Y')-2)?>"><?=$model->peratusidp(4,0.3, date('Y')-2).'%'?></div>
                        </div>
                    </div></button>
        </div>

        <div class="col-xs-12 col-md-4">
            <button type="button" id="modalButton" class="mapBtn" value="idp?type=1&icno=<?=$model->icno?>" style="background-color: transparent;border: none; width: 100%; text-align:left;">
                    <div style="background-color:    #3498db" class="tile-stats">
<!--                        <div class="icon"><i class="fa fa-pie-chart"></i></div>-->
                        <div style="color:   white" class="count">General (20%)
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y'),1) . '/' . $model->mataminidp(date('Y'), 0.2).' ('.date('Y').')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(1,0.2, date('Y')))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(1,0.2, date('Y'))?>"><?=$model->peratusidp(1,0.2, date('Y')).'%'?></div>
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y')-1,1) . '/' . $model->mataminidp(date('Y')-1, 0.2).' ('.(date('Y')-1).')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(1,0.2, date('Y')-1))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(1,0.2, date('Y')-1)?>"><?=$model->peratusidp(1,0.2, date('Y')-1).'%'?></div>
                        </div>
                        <p style="color:   white"><?=$model->mataidp(date('Y')-2,1) . '/' . $model->mataminidp(date('Y')-2, 0.2).' ('.(date('Y')-2).')'?>
                        </p><div class="progress progress-striped active">
                            <div class="<?= $model->progressbarcolor($model->peratusidp(1,0.2, date('Y')-2))?>" role="progressbar" data-transitiongoal="<?=$model->peratusidp(1,0.2, date('Y')-2)?>"><?=$model->peratusidp(1,0.2, date('Y')-2).'%'?></div>
                        </div>
                    </div></button>
        </div>
<!--    <div class="col-xs-12 col-md-4">
            <?php
//            $testingPage2 = IdpTileWidget::widget(
//                            [
//                                'icon' => 'pie-chart',
//                                'header' => 'Elective (30%)',
//                                'text' => (date('Y')-2).' - '. date('Y'),
//                                'number' => $model->mataElektif . '/' . $model->mataminelektif3tahun,
//                                'pbar' => '<div class="'.$model->progressbarcolor($model->peratuselektif).' role="progressbar" data-transitiongoal="'.$model->peratuselektif.'">'.$model->peratuselektif.'%</div>',
//                            ]
//            );
//            echo Html::button('<a>'.$testingPage2.'</a>', ['id' => 'modalButton', 'value' => 'idp?type=4&icno='.$model->icno,'style'=>'background-color: transparent; 
//                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
//            ?>
    </div>
    <div class="col-xs-12 col-md-4">
            <?php
//            $testingPage3 = IdpTileWidget::widget(
//                            [
//                                'icon' => 'pie-chart',
//                                'header' => 'General (20%)',
//                                'text' => (date('Y')-2).' - '. date('Y'),
//                                'number' => $model->mataUmum . '/' . $model->mataminumum3tahun,
//                                'pbar' => '<div class="'.$model->progressbarcolor($model->peratusumum).' role="progressbar" data-transitiongoal="'.$model->peratusumum.'">'.$model->peratusumum.'%</div>',
//                            ]
//            );
//            echo Html::button('<a>'.$testingPage3.'</a>', ['id' => 'modalButton', 'value' => 'idp?type=1&icno='.$model->icno,'style'=>'background-color: transparent; 
//                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
//            ?>
        </div>-->
                </div></div></div>