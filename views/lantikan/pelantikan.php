<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
 
?> 

<div class="row">
    <div class="col-xs-12 col-md-3">
        

        <?php
                    $BSM = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'BSM',
                                        'text' => 'Lantikan Tetap / Kontrak / Sambilan',
                                        'number' => '1',
                                    ]
                    );
                    
                    echo Html::a($BSM, ['biodata/pelantikan-b-s-m']);
                    
                    ?>

    </div>

    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'address-card',
                'header' => 'Penerbit UMS',
                'text' => 'Pewasit Luar / Panel Kluster / Penyunting Luar',
                'number' => '2',
            ]
        )
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'address-card',
                'header' => 'Lantikan',
                'text' => 'Lantikan',
                'number' => '3',
            ]
        )
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'address-card',
                'header' => 'Lantikan',
                'text' => 'Lantikan',
                'number' => '4',
            ]
        )
        ?>
    </div>
</div>