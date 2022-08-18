<?php

use yii\helpers\Html;
?>

<?php echo $this->render('_menu'); ?>

<div class="row">

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-search"></i> Jenis Kriteria</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php
                    $menu1 = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'user',
                            'header' => 'Kriteria 1',
                            'text' => 'Pegawai Utama',
                            'number' => '1',
                        ]
                    );
                    echo Html::a($menu1, ['talent/list-jwtn', 'id' => 1]);
                    ?>

                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $menu2 = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'list-alt',
                            'header' => 'Kriteria 2',
                            'text' => 'Dekan / Pengarah / Timbalan',
                            'number' => '2',
                        ]
                    );
                    echo Html::a($menu2, ['talent/list-jwtn', 'id' => 2]);
                    ?>
                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $menu3 = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'users',
                            'header' => 'Kriteria 3',
                            'text' => 'Mengikut Gred',
                            'number' => '3',
                        ]
                    );
                    echo Html::a($menu3, ['talent/list-jwtn', 'id' => 3]);
                    ?>
                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $menu4 = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'users',
                            'header' => 'Kriteria 4',
                            'text' => 'Klasifikasi Perkhidmatan',
                            'number' => '4',
                        ]
                    );
                    echo Html::a($menu4, ['talent/list-jwtn', 'id' => 4]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>