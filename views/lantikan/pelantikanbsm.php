<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Lantikan BSM';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= Html::a('Kembali', ['biodata/lantikan'], ['class' => 'btn btn-primary']) ?> <br> <br>
            <div class="row">
    <div class="col-xs-12 col-md-3">
        

        <?php
                    $BSM = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => ' fa-user',
                                        'header' => 'Tetap / Kontrak',
                                        'text' => 'Lantikan Tetap atau Kontrak',
                                        'number' => '1',
                                    ]
                    );
                    
                    echo Html::a($BSM, ['biodata/tambahkakitangan']);
                    
                    ?>

    </div>

    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => ' fa-calendar-o',
                'header' => 'Sementara',
                'text' => 'Lantikan Sementara',
                'number' => '2',
            ]
        )
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => ' fa-adjust',
                'header' => 'PHS',
                'text' => 'Pekerja Harian Singkat',
                'number' => '3',
            ]
        )
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => ' fa-building',
                'header' => 'Felo',
                'text' => 'Felo Siswazah / Utama DLL',
                'number' => '4',
            ]
        )
        ?>
    </div>
</div>

        </div>
    </div>
</div>