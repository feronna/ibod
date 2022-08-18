<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
?>      
<div class="x_panel">
    <div class="x_title">
        <h2>Syarat-syarat Lantikan</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 

        <?php echo $this->render('menu_tab'); ?>

    </div>
</div>
<div class="x_panel"> 
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Jawatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                $gredExist = \app\models\ejobs\Iklan::find()->where(['status'=>1])->andWhere(['status_dalaman'=>1])->select('jawatan_id')->distinct();
                echo $form->field($model, 'jawatan')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\ejobs\GredJawatan::find()->where(['IN', 'id', $gredExist])->all(), 'id', 'fname'),
                    'options' => ['placeholder' => 'Pilih Jawatan'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div>  
        <div class="form-group text-center">
            <div class="col-sm-12"> 
                <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                <?= Html::submitButton('Semak Kelayakan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>  
<?php
if ($iklan) { 
   
    ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= strtoupper($iklan->jawatan->fname); ?> </h2> 
            <p align="right" >
                <?php echo Html::a('Mohon', ['pemohon/halaman-utama'], ['class' => 'btn btn-primary btn-sm']); ?>   
            </p>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="col-md-7 col-sm-7 col-xs-12"> 
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12 text-right">Jawatan: </th><td><?= $iklan->jawatan->fname; ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12 text-right">Kumpulan: </th><td><?= $iklan->kumpulan->name; ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12 text-right">Klasifikasi: </th><td><?= $iklan->klasifikasi->name; ?></td> 
                        </tr> 
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12 text-right">Kategori: </th><td><?= $iklan->kategori->name; ?></td> 
                        </tr> 
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12 text-right">Taraf Jawatan: </th>
                            <td><?php
                                $counter = count($taraf_jawatan);
                                $i = 1;
                                foreach ($taraf_jawatan as $taraf_jawatan) {

                                    echo $taraf_jawatan->taraf->ApmtStatusNm;
                                    if ($counter != $i) {
                                        echo '/';
                                    }$i++;
                                }
                                ?>  </td> 
                        </tr> 
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12 text-right">Penempatan: </th>
                            <td>  
                                <?php
                                $counter = count($penempatan);
                                $i = 1;
                                foreach ($penempatan as $penempatan) {

                                    echo $penempatan->campus->campus_name;
                                    if ($counter != $i) {
                                        echo '/';
                                    }$i++;
                                }
                                //temporary
//                                        $hums = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 15, 16, 17, 18, 20, 21);
//                                        if (in_array($iklan->id, $hums)) {
//                                            echo ' - Hospital Universiti Malaysia Sabah';
//                                        }
                                ?>    
                            </td> 
                        </tr> 
                        <tr> 
                            <th class="col-md-3 col-sm-3 col-xs-12 text-right">Jadual Gaji: </th><td>
                               RM <?= $iklan->gaji? $iklan->gaji->r_jg_min:'Tiada Maklumat'; ?> - RM <?= $iklan->gaji? $iklan->gaji->r_jg_maks:'Tiada Maklumat'; ?></td> 
                        </tr>  
                        <?php if ($iklan->id == 18) { ?>
                            <tr>
                                <th class="col-md-3 col-sm-3 col-xs-12 text-right">Tempoh Lantikan: </th>
                                <td>Tiga (3) tahun (tertakluk kepada  keputusan Kementerian Pendidikan Malaysia)
                                </td>
                            </tr>
                        <?php } ?>
    <!--                                <tr>
    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Tarikh Tutup: </th><td><?php // $iklan->tarikh($iklan->tarikh_tutup);         ?></td>  
    </tr> -->

                    </table>
                </div>
                <div class="x_panel">
                    <h2>KETERANGAN TUGAS </h2> 
                    <table class="table table-borderless">
                        <?php
                        if ($iklan->jawatan->tugas) {
                            $counter = 0;
                            foreach ($iklan->jawatan->tugas as $tugas) {
                                $counter = $counter + 1;
                                ?>
                                <tr>
                                    <td>
                                        <?= $counter; ?>.  <?= $tugas->tugas_desc; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div> 

            </div>

            <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;"> 

                <div class="x_panel">
                    <h2>SYARAT KELAYAKAN</h2>
                    <table class="table table-borderless">

                        <?php
                        if ($iklan->jawatan->kelayakan) {
                            $counter = 0;
                            foreach ($iklan->jawatan->kelayakan as $kelayakan) {
                                $counter = $counter + 1;
                                ?>
                                <tr>
                                    <td>
                                        <?= $counter; ?>.  <?= $kelayakan->akademik_desc; ?></br></br>
                                        <?php if ($kelayakan->syarat_tamb_desc) { ?>
                                            <?= '<b>Syarat Tambahan</b>: ' . $kelayakan->syarat_tamb_desc; ?>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </table>
                </div> 

            </div>


        </div>
    </div> 

<?php } ?>
