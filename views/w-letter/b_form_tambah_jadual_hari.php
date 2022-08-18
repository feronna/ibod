<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
<div class="x_panel"> 
    <div class="x_title">
        <h2>Tujuan Permohonan</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">   
                <?=
                $form->field($model, 'ICNO')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">   
                <?=
                $form->field($model, 'kategori')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\w_letter\RefKategori::find()->all(), 'shortname', 'name'),
                    'options' => ['placeholder' => 'Pilih Kategori..'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Senarai Tugas: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?=
                $form->field($model, 'tugas')->textarea(['rows' => 6])->label(false);
                ?> 
            </div>
        </div>

        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Batal', ['carian-set-jadual-hari'], ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Tambah', ['class' => 'btn btn-primary']) ?>
        </div>

    </div> 
</div>
<?php ActiveForm::end(); ?> 

<?php if ($permohonan != null) { ?>
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Senarai Bekerja pada <span style="color:red;"> <?= $model->getTarikh($date); ?></span></h2>  
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table">
                    <thead>
                        <tr class="headings">
                            <th>Bil</th>
                            <th>Umsper</th>
                            <th>Nama</th>
                            <th>Jawatan</th>
                            <th>Jabatan</th> 
                            <th>Senarai Tugas</th>
                            <th class="text-center" >Tindakan</th>
                        </tr>
                    </thead>
                    <?php
                    if ($permohonan) {
                        $counter = 0;
                        foreach ($permohonan as $permohonan) {
                            $counter = $counter + 1;
                            if (date("Y-m-d",strtotime($permohonan->tarikh_mohon)) == date('Y-m-d')) {
                                        $bg ="#b3d8fc"; 
                                    } else {
                                        $bg =  "#ffffff"; 
                                    }
                            
                            ?>

                            <tr>
                                <td bgcolor=<?= $bg; ?>><?= $counter; ?></td>
                                <td style="width:1px;white-space:nowrap" bgcolor=<?= $bg; ?>><?= $permohonan->biodata->COOldID; ?></td> 
                                <td style="width:20%;" bgcolor=<?= $bg; ?>><?= $permohonan->biodata->gelaran->Title . " " . ucwords(strtolower($permohonan->biodata->CONm)); ?></td>
                                <td style="width:20%;" bgcolor=<?= $bg; ?>><?= $permohonan->biodata->jawatan->nama; ?> (<?= $permohonan->biodata->jawatan->gred; ?>)</td> 
                                <td bgcolor=<?= $bg; ?>><?= $permohonan->biodata->department->shortname; ?></td>  
                                <td bgcolor=<?= $bg; ?>><?= $permohonan->tugas; ?></td>  
                                <td class="text-center" bgcolor=<?= $bg; ?>><?= Html::a('',['edit-wfo-hari', 'id' => $permohonan->id,'date'=>$date], ['class' => 'fa fa-edit btn btn-default btn-sm']); ?></td>  
                            </tr> 
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Tiada Rekod</td>                     
                        </tr>
                    <?php }
                    ?>
                </table>
            </div>
        </div>
    </div>  
<?php } ?>
 
