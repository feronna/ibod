<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle"></i>&nbsp;<strong>Profil Staf</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <?php
                echo DetailView::widget([
                    'model' => $biodata,
                    'attributes' => [
                        [
                            'format' => 'raw',
                            'attribute' => '',
                            'value' => $biodata->displayGambar,
                        ],
                        'COOldID:html',    // description attribute in HTML
                        'CONm:html',    // description attribute in HTML
                        'ICNO:html',    // description attribute in HTML
                        [                      // the owner name of the model
                            'attribute' => 'gredJawatan',
                            'value' => $biodata->jawatan->fname,
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'DeptId',
                            'value' => $biodata->department->fullname,
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'statLantikan',
                            'value' => $biodata->statusLantikan->ApmtStatusNm,
                        ],
                    ],
                ]);
                ?>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-user"></i> Profil Peribadi', ['biodata/adminview', 'id' => $biodata->ICNO], ['class' => 'btn btn-success', 'target'=>'_blank']) ?>
                <?= Html::a('<i class="fa fa-book"></i> Profil Perkhidmatan', ['perkhidmatan/view', 'id' => $biodata->ICNO], ['class' => 'btn btn-primary', 'target'=>'_blank']) ?>
            </div>
        </div>
    </div>
</div>