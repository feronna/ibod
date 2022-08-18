<?php

use yii\helpers\Html;
?>

<div class="x_panel" style="color:black;">
    <div class="x_title">

        <h2><i class="fa fa-user-o"></i> : Pengurusan Akses</h2>
        <ul class="nav navbar-right panel_toolbox">

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content ">

        </br>
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <?php
                $pg = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    //'icon' => 'comments-o',
                                    'header' => 'Permohonan Emel UMS',
                                    'text' => 'Mewujudkan akaun gmail untuk staf baru.',
                                    'number' => '1',
                ]);

                echo Html::a($pg, ['pengurusan-gmail',], ['class' => '']);
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $pa = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    'header' => 'Penamatan Akses',
                                    'text' => 'Menyemak senarai akses bagi staf yang sudah berhenti.',
                                    'number' => '2',
                                ]
                );
                echo Html::a($pa, ['penamatan-akses',], ['class' => ' ']);
                ?>
            </div>
        </div>
        </br>
    </div>

</div>