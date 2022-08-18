<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use app\models\cuti\CutiRekod;
use app\widgets\TopMenuWidget;
use yii\widgets\Pjax;
?>

<?= $this->render('/keselamatan/_topmenu') ?>


<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<?php Pjax::begin(['id' => 'icno']) ?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">    
        <h2><strong>Pos Kawalan : <?php
                if ($pos->pecahan_pos != NULL) {
                    echo $pos->pecahan_pos;
//                    echo $condition;
                } else {
                    echo $pos->pos_kawalan;
                }
                ?>(Hakiki)<br> <br> Tarikh : <?php echo date('d-m-Y') . "(" . date('l') . ")"; ?> </strong></h2>

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
                        'label' => 'Hakiki',
                        'value' => 'syif',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                 
                    [
                        'label' => 'Lebih Masa Jadual',
                        'value' => 'syifot',
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
//                  
                    [
                        'label' => 'Hadir Baris Hakiki',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type'=>'H'])->exists();
                            if ($validation) {
                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type'=>'H'])->one();
                                if ($validate->THBH == 0) {
                                    $checked1 = 'checked disabled';
//                                //npending utk rejected tp baru kena simpan
                                } else {
                                    $checked1 = 'disabled';
                                }
                            } else {
                                $checked1 = '';
                            }

                            return Html::a('<input type="checkbox" name="' . $data->staff_icno . '" value="yy' . $data->staff_icno . '" ' . $checked1 . '>');
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Tidak Hadir Baris Hakiki',
                        'format' => 'raw',
                        'value' => function ($data) {

//                                var_dump($data->staff_icno);
                            $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type'=>'H'])->exists();
                            if ($validation) {
                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type'=>'H'])->one();
//                                var_dump($validate->THB);die;
                                //ypending for approved tp bru kena simpan..belum kena hantar
                                if ($validate->THBH == 1) {
                                    $checked1 = 'checked disabled';
//                                //npending utk rejected tp baru kena simpan
                                } else {
                                    $checked1 = 'disabled';
                                }
                            } else {
                                $checked1 = '';
                            }

                            return Html::a('<input type="checkbox" name="' . $data->staff_icno . '" value="y' . $data->staff_icno . '" ' . $checked1 . '>');
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Hadir Baris LM',
                        'format' => 'raw',
                        'visible'=>$condition,
                        'value' => function ($data) {
                            $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type'=>'LMJ'])->exists();
                            if ($validation) {
                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type'=>'LMJ'])->one();
                                if ($validate->THBLMJ == 0) {
                                    $checked1 = 'checked disabled';
//                                //npending utk rejected tp baru kena simpan
                                } else {
                                    $checked1 = 'disabled';
                                }
                            } else {
                                $checked1 = '';
                            }

                            return Html::a('<input type="checkbox" name="' . $data->staff_icno . '" value="lmj' . $data->staff_icno . '" ' . $checked1 . '>');
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Catatan Cuti',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $date = date('Y-m-d');
                            $cuti = CutiRekod::find()->where(['cuti_mula' => $date])->andWhere(['cuti_icno' => $data->staff_icno])->exists();
//                            var_dump($cuti);die;
                            if ($cuti) {
                                return Html::a('<input type="textarea" size="30" name="g" value= " Cuti Rehat " disabled>');
                            } else {

                                return Html::a('<input type="textarea" size="30" name="g" value= " " disabled>');
                            }
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Catatan DO',
                        'format' => 'raw',
                        'value' => function ($data) {

                            $valid = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['pos_kawalan_id' => $data->pos_kawalan_id])->andWhere(['date' => date('Y-m-d')])->one();
//                            var_dump($valid);die;
                            if (!empty($valid)) {
                                return Html::a('<input type="textarea" size="50" name="do" value= "'.$valid->catatan_do.'" disabled>');
                            } else {
                                return Html::a('<input type="textarea" size="50" name="do" value= " " >');
                            }
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
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
               
            </div>
        </div>
<?php Pjax::end() ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
