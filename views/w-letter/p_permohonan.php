<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>  
<?= $this->render('menu') ?> 

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Maklumat Peribadi</h2> <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                    <td><?= ucwords(strtolower($model->CONm)); ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                    <td><?php
                        if ($model->NatCd == "MYS") {
                            echo $model->ICNO;
                        } else {
                            echo $model->latestPaspot;
                        }
                        ?></td> 
                </tr> 
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                    <td><?= $model->jawatan->nama; ?> (<?= $model->jawatan->gred; ?>)</td> 
                </tr> 
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Jabatan</th>
                    <td><?= $model->department->fullname; ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Ketua Jabatan</th>
                    <td><?php
                        if ($model->department->chief == $model->ICNO) {
                            echo 'Taufiq Yap Yun Hin';
                        } else {
                            echo $model->department ? ucwords(strtolower($model->department->k_jabatan->CONm)) : 'Tiada Maklumat';
                        }
                        ?></td> 
                </tr>
            </table>
        </div> 

    </div>
</div>

<div class="x_panel"> 
    <div class="x_title">
        <h2>Makluman Penting</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <div class="form-group">     
            <ul><font color="red">
                <!--<li>Sila ambil maklum bahawa kenderaan e-hailing tidak dibenarkan masuk ke kampus UMS sepanjang tempoh PKP.</li>-->
                <li>Hanya kenderaan suami/isteri/keluarga sahaja yang dibenarkan menghantar masuk ke kampus.</li>
                <li>Kakitangan diwajibkan memakai face mask semasa berada di dalam kampus.</li>
                <!--<li>Proses saringan suhu badan akan dilakukan di pintu masuk utama kampus.</li>-->
                </font>
            </ul>
        </div>
    </div>
</div> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Tujuan Permohonan</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh bertugas: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">  
                <?=
                DatePicker::widget([
                    'model' => $permohonan,
                    'attribute' => 'StartDate',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>


            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Senarai Tugas: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?=
                $form->field($permohonan, 'tugas')->textarea(['rows' => 6])->label(false);
                ?> 
            </div>
        </div>

        <div class="x_title">
            <h2>Maklumat Tambahan (Jika Perlu)</h2> 
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kekangan:  
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?=
                $form->field($permohonan, 'veh_status')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\w_letter\RefKenderaan::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Pilih Status Kenderaan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?=
                $form->field($permohonan, 'file')->fileInput(['maxlength' => true])->label(false);
                ?>  
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Alasan: 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?=
                $form->field($permohonan, 'veh_ulasan')->textarea(['rows' => 6])->label(false);
                ?>   
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pemandu:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?=
                $form->field($permohonan, 'veh_driver')->textInput(['maxlength' => true])->label(false);
                ?>  
            </div>
        </div> 
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No. K/P Pemandu:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?=
                $form->field($permohonan, 'veh_driver_icno')->textInput(['maxlength' => true])->label(false);
                ?>  
            </div>
        </div> 

        <div class="hide"> 
            <?= $form->field($permohonan, 'ICNO')->hiddenInput(['value' => $model->ICNO])->label(false); ?>
            <?= $form->field($permohonan, 'tarikh_mohon')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
            <?= $form->field($permohonan, 'status_semasa')->hiddenInput(['value' => 1])->label(false); ?>
            <?= $form->field($permohonan, 'isActive')->hiddenInput(['value' => 1])->label(false); ?>
            <?= $form->field($permohonan, 'status_notifikasi')->hiddenInput(['value' => 0])->label(false); ?>
            <?= $form->field($permohonan, 'kategori')->hiddenInput(['value' => 'E100'])->label(false); ?>
        </div>
        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Mohon', ['class' => 'btn btn-success']) ?>
        </div>

    </div>
</div>   

<?php ActiveForm::end(); ?> 


