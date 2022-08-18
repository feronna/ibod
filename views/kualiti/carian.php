<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\myhealth\TblmaxtuntutanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

error_reporting(0);
?>
<div class="kualiti-search">
    <div class="x_panel">
        <div class="x_content">

            <p>
                <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
        <div class="x_title">
            <h2><i class="fa fa-list-alt"></i><strong> Carian Manual / Prosedur / Dokumen</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div>
            <?php
            $form = ActiveForm::begin([
                'action' => ['carian'],
                'method' => 'get',
            ]);
            ?>

            <div class="col-md-2 col-sm-4 col-xs-6">
                <?=
                $form->field($searchModel, 'kategori_id')->widget(Select2::classname(), [
                    'data' => ['1' => 'Manual Kualiti', '2' => 'Prosedur Khusus', '3' => 'Prosedur Umum', '4' => 'Dokumen Rujukan', '5' => 'Borang'],
                    'options' => ['placeholder' => 'Pilih Jenis Carian'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($searchModel, 'tajuk_prosedur')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\kualiti\Kualiti::find()->all(), 'tajuk_prosedur', 'tajuk_prosedur'),
                    'options' => ['placeholder' => 'Carian Tajuk Manual / Prosedur / Dokumen / Borang'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6">
                <?=
                $form->field($searchModel, 'no_prosedur')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\kualiti\Kualiti::find()->all(), 'no_prosedur', 'no_prosedur'),
                    'options' => ['placeholder' => 'No. Prosedur'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],
                    
                    [
                        'label' => 'Kategori',
                        'attribute' => 'kategori',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'No Prosedur/Kod Dokumen',
                        'attribute' => 'no_prosedur',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tajuk Prosedur',
                        'attribute' => 'tajuk_prosedur',
                        'format' => 'raw',
                        'value' => function ($query) {
                            return                            
                                Html::a('<u><strong>'.$query->tajuk_prosedur, "https://mediahost.ums.edu.my/api/v1/viewFile/".$query->file, ['role' => 'modal-remote', 'target' => '_blank']);
                        }
                        
                    ],
                    [
                        'label' => 'JAFPIB',
                        'attribute' => 'department.fullname',
                        'format' => 'text',
                    ],
                    [
                        'label' => 'Kemaskini Akhir',
                        'attribute' => 'update_date',
                        'format' => 'text',
                    ],
                    [
                        'label' => 'Laman Web Jabatan',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->department->website == NULL){
                                return '<span class="label label-warning">TIADA LAMAN WEB</span>';
                            }else{
                             return Html::a('<u><strong>'.$model->department->website.'</strong></u>', $model->department->website,['button'=> 'btn-primary','target'=>'_blank']); // your url here
                            }
                            },
                    ],
                    
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '<span class="glyphicon glyphicon-info-sign"></span>',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $query) use($access) {
    
                                if($access){
                                $url = Url::to(['kualiti/view-manual', 'id' => $query->msiso_id]);
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);}else
                                {
                                    return '';
                                }
                                }
                        ]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>