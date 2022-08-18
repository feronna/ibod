<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\myhealth\TblmaxtuntutanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="kualiti-create">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Dokumen Rujukan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <p>
        <?php if($access || $isms){
              echo  Html::a('Tambah Dokumen Rujukan', ['tambah-dokumenrujukan'], ['class' => 'btn btn-primary']);
             }else{
                echo '';
             } ?>
            <?php if($access){
                echo Html::a('Kembali', ['index'], ['class' => 'btn btn-success']);
             }elseif($isms){
                echo Html::a('Kembali', ['isms'], ['class' => 'btn btn-success']);
             } ?>
        </p>
        <div>
            <?php
            $form = ActiveForm::begin([
                'action' => ['carian'],
                'method' => 'get',
            ]);
            ?>

            <div class="col-md-2 col-sm-4 col-xs-6">            
                <?= $form->field($searchModel, 'no_prosedur')->textInput(['placeholder' => 'Carian No. Prosedur'])->label(false); 
                ?>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">            
                <?= $form->field($searchModel, 'tajuk_prosedur')->textInput(['placeholder' => 'Carian Dokumen Rujukan'])->label(false); 
                ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?=
        GridView::widget([
            'dataProvider' => $query,
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
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
                    'attribute' => 'insert_date',
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
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '<span class="glyphicon glyphicon-info-sign"></span>',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $query) use($access,$isms) {

                            if($access || $isms){
                            $url = Url::to(['kualiti/view-dokumenrujukan', 'id' => $query->msiso_id]);
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