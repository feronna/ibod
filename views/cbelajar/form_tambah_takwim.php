<?php
$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
use yii\grid\GridView;
use yii\helpers\Url;

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;


$title = $this->title = 'Takwim Mesyuarat Pengajian Lanjutan';

?>
 <?php echo $this->render('/cutibelajar/_topmenu'); ?>
            <p align="right">  <?= Html::a('Kembali', ['cbadmin/halaman-admin'], ['class' => 'btn btn-primary btn-sm']) ?></p>

<div class="row">

<div class="iklan-form"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Takwim Mesyuarat Jawatankuasa Pengajian Lanjutan </h2> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_mesyuarat">Bil. Mesyuarat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($iklan, 'nama_mesyuarat')->textInput()->label(false); ?> 
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Mesyuarat Kali Ke: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($iklan, 'kali_ke')->textInput()->label(false); ?> 
                    </div>
                </div> 

                

                

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Kategori: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'kategori_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\cbelajar\KategoriMesyuarat::find()->all(), 'id', 'name'),
                            'options' => ['placeholder' => 'Pilih Kategori'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>

        

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikh_mesyuarat">Tarikh Mesyuarat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'tarikh_mesyuarat')->widget(
                                DatePicker::className(), [
                            'template' => '{input}{addon}',
                            'options' => [array('tarikh_mesyuarat', 'date', 'format' => 'yyyy-mm-dd', 'class' => 'col-lg-4'), 'placeholder' => 'Tarikh Mesyuarat'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label(false);
                        ?> 
                    </div>
                </div>  

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Tarikh Buka Permohonan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'tarikh_buka')->widget(
                                DatePicker::className(), [
                            'template' => '{input}{addon}',
                            'options' => [array('tarikh_buka', 'date', 'format' => 'yyyy-mm-dd', 'class' => 'col-lg-4'), 'placeholder' => 'Tarikh Buka'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label(false);
                        ?> 
                    </div>
                </div> 

                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Tarikh Tutup Permohonan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'tarikh_tutup')->widget(
                                DatePicker::className(), [
                            'template' => '{input}{addon}',
                            'options' => [array('tarikh_tutup', 'date', 'format' => 'yyyy-mm-dd', 'class' => 'col-lg-4'), 'placeholder' => 'Tarikh Tutup'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label(false);
                        ?> 
                    </div>
                </div>

                

                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
</div>

      
    <div class="x_content">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Senarai Takwim Mesyuarat Pengajian Lanjutan</h2><p align="right"><?= Html::a('Tambah Takwim', ['tambah-iklan'], ['class' => 'btn btn-primary btn-md']) ?></p> 
                    <div class="clearfix"></div>
                </div>
                <div class="x_content"> 

                    <div class="table-responsive ">        
                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_iklan,
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'layout' => "{items}\n{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                

                                        [
                                            'label' => 'NAMA MESYUARAT',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function($model) {
                                            if ($model->kategori->id == 1) {
                                               return 'Mesyuarat Jawatankuasa Pengajian Lanjutan Pentadbiran Bil. ' ." ". $model->nama_mesyuarat." ".'(Kali Ke -' ." ". $model->kali_ke.")";
                                                }
                                                else {
                                               return 'Mesyuarat Jawatankuasa Pengajian Lanjutan Akademik Bil. ' ." ". $model->nama_mesyuarat." ".'(Kali Ke -' ." ". $model->kali_ke.")";
                                                }
                                            },
                                        ],

                                        [
                                            'label' => 'KATEGORI',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],

                                            'value' => function($model) {
                                                if ($model->kategori->id == 1) {
                                                    return 'PENTADBIRAN';
                                                } else {
                                                    return 'AKADEMIK';
                                                }
                                            },
                                        ],

                                        [
                                            'label' => 'TARIKH MESYUARAT',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function($model) {
                                               return $model->getTarikh($model->tarikh_mesyuarat);
                                            },
                                        ],
                                      
                                        [
                                            'label' => 'TARIKH PENGHANTARAN PERMOHONAN',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function($model) {
                                                return $model->getTarikh($model->tarikh_buka) . ' - '. $model->getTarikh($model->tarikh_tutup);
                                            },
                                        ],
                                        
                                        [
                                            'label' => 'TINDAKAN',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'value' => function($model) {

                                                $url = Url::to(['aktif-takwim', 'id' => $model->id]);
                                                $url2 = Url::to(['edit-iklan', 'id' => $model->id]);
                                                return Html::button('AKTIFKAN', ['value' => $url, 'class' => 'btn btn-success btn-xs modalButton']). '| '.
                        Html::a('KEMASKINI', ["edit-iklan", 'id' => $model->id],['class' => 'btn btn-primary btn-xs']);

                                            },
                                                    'format' => 'raw',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                    
                                            ],
                                        ]);
                                            
                                            
                                        ?>
                                    </div>
                                </div>
                            </div> 
                                        
</div>
