<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use app\models\hronline\Kumpkhidmat;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Kumpulankhidmat;
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

error_reporting(0);

?>

<div class="row">

<div class="col-md-12 col-sm-12 col-xs-12 ">
    <p align="right">  <?= Html::a('Kembali', ['data/index'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

    <div class="x_title">
            <h5><strong>SENARAI AKTIVITI - KOMUNITI</strong></h5>
            
            <div class="clearfix"></div>
        </div>

         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-success">KOMUNITI</span>'), ['data/senarai-aktivitikomuniti'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-info">UNIVERSITI</span>'), ['data/senarai-aktivitiuniversiti'], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
      </div>
</div>
<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
              
            </div>
            <div class="x_content">
                
                <?php
                $form = ActiveForm::begin([
                    'action' => ['senarai-aktivitikomuniti'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
                
                  <?=
                            $form->field($searchModel, 'fid')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\cv\TblSwSociety::find()->all(), 'fid', 'service'),
                             // 'data' => [1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN'],
                             'options' => ['placeholder' => 'Pilih Penganjur', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                
                           <?=
                            $form->field($searchModel, 'kategori_servis')->label(false)->widget(Select2::classname(), [
                         //   'data' => ArrayHelper::map(Kumpulankhidmat::find()->all(), 'id', 'name'),
                              'data' => [1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN'],
                             'options' => ['placeholder' => 'Pilih Kategori Latihan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                
            
                
                
                  
                
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                  
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">                                 
  <?php $forms = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <?=
                GridView::widget([

                    'options' => [
                        'class' => 'table-responsive',
                    ],

                    'dataProvider' => $dataProvider,
                    'layout' => "{summary}\n{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Akhir'
                    ],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',

                        ],
                        [
                            'label' => 'Nama Aktiviti',
                            'value' => 'service'
                        ],
                        [
                            'label' => 'Peringkat',
                            'value' => function($data){
                            if ($data->lvl->output != null){
                                return $data->lvl->output;
                            }else {
                                return 'TIDAK DINYATAKAN';
                            }
                        }
                        ],
                        [
                            'label' => 'Role',
                            'value' => 'role'
                        ],

                        [
                            'label' => 'Role Key',
                            'value' => 'role_key'
                        ],

                        [
                            'label' => 'Tarikh',
                            'value' => 'year'
                        ],
//                        [
//                            'label' => 'Kategori Aktiviti',
//                            'format' => 'raw',
//                            'value' => function ($data) {
//
//                                $status = $data->kategori_servis;
//                                $list = [1 => '<span class="label label-success">KEPIMPINAN</span>', 0 => '<span class="label label-danger">BUKAN KEPIMPINAN</span>',];
//
//                                return  $list[$status];
//                            },
//
//                            'hAlign' => 'center',
//
//
//                        ],

//                        [
//                            'label' => 'Kemaskini',
//                            'format' => 'raw',
//                            //'attribute' => 'statuspelulus',
//                            'value' => function ($data) {
//
//                                $pelulusId = $data->fid;
//
//                                return Html::radioList("kategori_servis[$pelulusId]", '', ([1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN']));
//                            },
//
//                            'hAlign' => 'center',
//                            'vAlign' => 'middle',
//
//
//                        ],
                                    
                                     [
                            'label' => 'Kategori Aktiviti',
                            'format' => 'raw',
                
                                       'value' => function ($data) {
                                if ($data->kategori_servis == '1') {
                                    $checked = 'checked';
                                }
                                if ($data->kategori_servis == '0') {
                                    $checked1 = 'checked';
                                }
                              
                                return Html::a('<input type="radio" name="' . $data->fid . '" value="y' . $data->fid . '" ' . $checked . '><span class="label label-success">KEPIMPINAN</span>') . '  ' . Html::a('<input type="radio" name="' . $data->fid . '" value="n' . $data->fid . '" ' . $checked1 . '><span class="label label-danger">BUKAN KEPIMPINAN</span>');
                            },
                        
                               'hAlign' => 'center',
                              'vAlign' => 'middle',
                          

                        ],
                                

                                
                                
                                       [
                            'label' => 'Peringkat',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'value' => function ($data) {
                              
                                    return Select2::widget([
                                        'name' => 't' . $data->fid,
                                        'value' => $data->peringkat,
                                         'data' => ArrayHelper::map(app\models\myidp\IdpRefPeringkat::find()->all(), 'id', 'nama'),
                                        'options' => ['placeholder' => ''],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ]);
                                
                            },
                        ],
                                
                                
                             [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
//                                if (($data->status_bsm == '4' || $data->status_bsm == '5')) {
//                                    return ['disabled' => 'disabled'];
//                                }
                                return ['value' => $data->fid, 'checked' => true];
                            },
                        ],

                        // [
                        //     'class' => 'yii\grid\CheckboxColumn',
                        //     'checkboxOptions' => function ($data) {
                        //         return ['value' => $data->uid];
                        //     },
                        // ],

                    ],
                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    'resizableColumns' => true,
                    'responsive' => false,
                    'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                ?>
                <div class="form-group" align="right">
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>

                </div>

            </div>
    </div></div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>