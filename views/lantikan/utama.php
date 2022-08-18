<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\DetailView;
use yii\helpers\Url;
?> 

    <div class="x_panel">
        <div class="x_title">
            <h2>Halaman Utama Pengesahan</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <?php
                    echo DetailView::widget([
                        'model' => $bio,
                        'attributes' => [
                            [ 
                                'label' => 'Nama',
                                'value' => (is_null($bio->gelaran) ? '' : $bio->gelaran->Title.' ').$bio->CONm
                            ],
                            [ 
                                'label' => 'KP / Pasport',
                                'value' => $bio->ICNO
                            ], 
                            [   
                                'label' => 'Jawatan',
                                'value' => $bio->jawatan->fname
                            ],
                            [ 
                                'label' => 'JSPIU',
                                'value' => $bio->department->fullname
                            ],
                            [       
                                'label' => 'Jenis Lantikan',
                                'value' => $bio->statusLantikan->ApmtStatusNm
                            ],
                            [
                                'label' => 'UMSPER',
                                'value' => $bio->COOldID
                            ],
                        ],
                    ]);
                    
                    ?></br>


            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php
                    $view_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Lantikan',
                                        'text' =>  $model->lantikan ? '<span style="color:Green">Selesai</span>' : '<span style="color:Red">Belum Selesai</span>' ,
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($view_lantikan, ['view-lantikan','id'=>$model->ICNO]);
                    ?>

                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $profil_gaji = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list-alt',
                                        'header' => 'Profil Gaji',
                                        'text' => $model->profil_gaji ? '<span style="color:Green">Selesai</span>' : '<span style="color:Red">Belum Selesai</span>',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($profil_gaji, ['profile-gaji','ID'=>$model->Staff_Id]);
                    ?>
                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $lpg = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Payroll',
                                        'text' => $model->lpg ? '<span style="color:Green">Selesai</span>' : '<span style="color:Red">Belum Selesai</span>',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($lpg, ['lpg','ID'=>$model->ICNO]);
                    ?>
                </div>
            </div>

        </div>
    </div>
    