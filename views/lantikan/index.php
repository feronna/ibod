<?php

use yii\helpers\Html;
?>

<div class="x_panel" style="color:black;">
    <div class="x_title">

        <h2><i class="fa fa-user-o"></i> : Pengurusan Pengambilan</h2>
        <ul class="nav navbar-right panel_toolbox">

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content ">

        </br>
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <?php
                $baru = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    //'icon' => 'comments-o',
                                    'header' => 'Staf Baru',
                                    'text' => 'Menjalankan Lantikan Kakitangan Baru.',
                                    'number' => '1',
                ]);

                echo Html::a($baru, ['lantik-staf-baru',], ['class' => '']);
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $phs = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    'header' => 'PHS',
                                    'text' => 'Menjalankan Lantikan Kakitangan Pekerja Harian Singkat.',
                                    'number' => '2',
                                ]
                );
                echo Html::a($phs, ['lantik-phs',], ['class' => ' ']);
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $khas = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    'header' => 'Khas',
                                    'text' => 'Menjalankan Lantikan Kakitangan Khas.',
                                    'number' => '3',
                                ]
                );
                echo Html::a($khas, ['lantik-khas',], ['class' => ' ']);
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $stafums = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    'header' => 'Staf UMS',
                                    'text' => 'Menjalankan Lantikan Semula Kakitangan UMS.',
                                    'number' => '4',
                                ]
                );
                echo Html::a($stafums, ['lssu-index',], ['class' => ' ']);
                // echo Html::a($stafums, ['#',], ['class' => ' ']);
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $SA = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    'header' => 'Sambilan Akademik',
                                    'text' => 'Menjalankan Lantikan Fakulti.',
                                    'number' => '5',
                                ]
                );
                // echo Html::a($SA, ['lantik-sambilanakademik',], ['class' => ' ']);
                echo Html::a($SA, ['#',], ['class' => ' ']);
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $penerbit = \yiister\gentelella\widgets\StatsTile::widget(
                                [

                                    'header' => 'Penerbit UMS',
                                    'text' => 'Menjalankan Lantikan Penerbit UMS.',
                                    'number' => '6',
                                ]
                );
                //  echo Html::a($penerbit, ['penerbitums',], ['class' => ' ']);
                echo Html::a($penerbit, ['#',], ['class' => ' ']);
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $PPPI = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    'header' => 'PPPI',
                                    'text' => 'Menjalankan Lantikan GRA.',
                                    'number' => '7',
                                ]
                );
                // echo Html::a($PPPI, [' ',], ['class' => ' ']);
                echo Html::a($PPPI, ['#',], ['class' => ' ']);
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $PLI = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    'header' => 'Pelajar LI',
                                    'text' => 'Menjalankan Lantikan PLI.',
                                    'number' => '8',
                                ]
                );
                // echo Html::a($PLI, ['lantik-pli',], ['class' => ' ']);
                echo Html::a($PLI, ['#',], ['class' => ' ']);
                ?>
            </div>
            <?php if (in_array(Yii::$app->user->getId(),['950418125652','940402125181'])) { ?>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $EJOBS = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'header' => 'Staf Baru EJOBS',
                                        'text' => 'Menjalankan Lantikan Baru Ejobs.',
                                        'number' => '8',
                                    ]
                    ); 
                    echo Html::a($EJOBS, ['lantikan-ejobs'], ['class' => ' ']);
                    ?>
                </div>
            <?php } ?>
        </div>
        </br>
    </div>

</div>