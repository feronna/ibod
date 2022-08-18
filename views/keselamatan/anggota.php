<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
use app\widgets\TopMenuWidget;
use yii\widgets\Pjax;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<?php Pjax::begin(['id' => 'icno']) ?>
<div class="col-md-12"> 
    <div class="x_panel">    
        <h2><strong>Pos Kawalan : <?php
                if ($pos->pecahan_pos != NULL) {
                    echo $pos->pecahan_pos;
                } else {
                    echo $pos->pos_kawalan;
                }
                ?></strong></h2>
        <ul>
            <li><i class="fa fa-check-square"> Hadir</i> : Tanda <i class="fa fa-check-square"></i> sekiranya Hadir Hakiki dan Hadir Baris </li>
            <li><i class="fa fa-check-square"> Melakukan Kesalahan</i> : Tanda <i class="fa fa-check-square"></i> sekiranya Melakukan Kesalahan </li>

        </ul>
        <div class="ln_solid"></div>

        <div class="x_title">


            <!--// Control your pjax options-->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'class' => 'table-responsive',
                ],
                /*   'filterModel' => $searchModel, */ //to hide the search row
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                   
                    [
                        'label' => 'Nama',
                        'value' => 'staff.CONm',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Unit',
                        'value' => 'unitname.unit_name',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                     [
                        'label' => 'Syif',
                        'value' => 'syif',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Pos Kawalan',
                        'format' => 'raw',
                        'value' => 'pos.pos_kawalan',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
//                    [
////                        'label' => 'Pos Kawalan',
////                        'format' => 'raw',
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => ['style' => 'display: block;margin-right: auto;margin-left: auto;'], //center checkboxes
//                        'header' => Html::checkBox('selection_all', false, [
//                            'class' => 'select-on-check-all pull-right', //pull right the checkbox
//                            'label' => 'Check Attend Only', //pull left the label
//                        ]),
//                        'checkboxOptions' => function ($data) {
////                            if (($data->status == 'VERIFIED' || $data->status == 'REJECTED')) {
////                                return ['disabled' => 'disabled'];
////                            }
//                            return ['value' => $data->id, 'checked' => true];
//                        },
//                    ],
                    [
                        'label' => 'Hadir Baris',
                        'format' => 'raw',
                        'value' => function ($data) {

//                                var_dump($data->staff_icno);
                            //ypending for approved tp bru kena simpan..belum kena hantar
//                            if ($data->status == 'YPENDING') {
                            $checked1 = '';
//                                //npending utk rejected tp baru kena simpan
//                            } elseif ($data->status == 'NPENDING') {
//                                $checked1 = 'checked';
//                            } elseif ($data->status == 'VERIFIED' || $data->status == 'REJECTED') {
//                                return $data->statusLabel;
//                            }
                            return Html::a('<input type="checkbox" name="' . $data->staff_icno . '" value="yy' . $data->staff_icno . '" ' . $checked1 . '>');
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
//                    [
//                        'label' => 'Hadir Baris s',
//                        'format' => 'raw',
//                        'value' => function ($data) {
//
////                                var_dump($data->staff_icno);
//                            //ypending for approved tp bru kena simpan..belum kena hantar
////                            if ($data->status == 'YPENDING') {
//                            $checked1 = 'checked';
////                                //npending utk rejected tp baru kena simpan
////                            } elseif ($data->status == 'NPENDING') {
////                                $checked1 = 'checked';
////                            } elseif ($data->status == 'VERIFIED' || $data->status == 'REJECTED') {
////                                return $data->statusLabel;
////                            }
//                            return Html::a('<input type="checkbox" name="h" value="' . $checked1 . '">');
//                        },
//                        'headerOptions' => ['class' => 'text-center'],
//                        'contentOptions' => ['class' => 'text-center'],
//                    ],
                    [
                        'label' => 'Catatan',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('<input type="textarea" size="50" name="g" value= " " >');
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
//                    [
//                        'label' => 'Tindakan',
//                        'format' => 'raw',
//                        'value' => function ($data) {
//                            return Html::a('<i class="fa fa-eye">', ["keselamatan/kemaskini-kesalahan-anggota", 'id' => $data->staff_icno]);
//                        },
//                        'headerOptions' => ['class' => 'text-center'],
//                        'contentOptions' => ['class' => 'text-center'],
//                    ],
                                  [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) {
                            if (($data->status == 'VERIFIED' || $data->status == 'REJECTED')) {
                                return ['disabled' => 'disabled'];
                            }
                            return ['value' => $data->id, 'checked' => true];
                        },
                    ],
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
<?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1'])
?>
                <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2'])
                ?>
            </div>
        </div>
<?php Pjax::end() ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
