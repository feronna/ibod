<?php
use yii\helpers\Html;

?>

            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'search',
                                        'header' => 'Syarat-Syarat',
                                        'text' => 'Lantikan',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($resume, ['pemohon/syarat-lantikan']);
                    ?>

                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $jawatan_semasa = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list-alt',
                                        'header' => 'Permohonan',
                                        'text' => 'Jawatan Semasa',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($jawatan_semasa, ['pemohon/jawatan-semasa']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $jadual_kompetensi = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Ujian Khas',
                                        'text' => 'Jadual Ujian Khas',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($jadual_kompetensi, ['pemohon/ujian-khas']);
                    ?>
                </div> 
                <div class="col-xs-12 col-md-3">
                    <?php
                    $jadual_temuduga = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Temuduga',
                                        'text' => 'Jadual Temuduga',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($jadual_temuduga, ['pemohon/temuduga']);
                    ?>
                </div> 
            </div>