<?php
use yii\helpers\Html; 
use yii\helpers\ArrayHelper;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpKategoriJawatan;
use app\models\myidp\Kategori;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

echo $this->render('/idp/_topmenu'); 

error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enctype' => 'multipart/form-data', 'id' => 'registration-form']]); ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Borang Tambah Latihan</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
            

                <!-- <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PEMILIK MODUL</label>
                </div> -->
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Pemilik Modul: <span class="required" style="color:red;">*</span>
                    </label>
                    <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php //$form->field($model, 'penggubalModul')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>-->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= 
                            $form->field($model, 'penggubalModul')->label(false)->widget(Select2::classname(),
                                [
                                    'data' => $model->getDeptList(),
                                    'options' => ['placeholder' => 'Pilih JAFPIB...', 
                                            'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        ],
                                    'theme' => Select2::THEME_CLASSIC,
                                ]); 
                        ?>                  
                    </div>
                </div>
                <!-- <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT KURSUS LATIHAN</label>
                </div> -->
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tajuk Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'tajukLatihan')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Sinopsis Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'sinopsisKursus')->textarea(['rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>    
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tahun Ditawarkan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
/******************************** Dropdownlist for YEAR range ********************************************/                        
                        // echo $form->field($model, 'tahunTawaran')->dropDownList(
                        //         $model->getYearsList(), //function from KursusLatihan model
                        //         ['prompt'=>'Pilih tahun...'])
                        //         ->label(false);

                        $form->field($model, 'tahunTawaran')->label(false)->widget(Select2::classname(),
                                [
                                    'data' => $model->getYearsList(),
                                    'options' => ['placeholder' => 'Pilih tahun...', 
                                            'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        ],
                                    'theme' => Select2::THEME_CLASSIC,
                                ]);

                        ?>                   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kumpulan Jawatan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\IdpKategoriJawatan;
                        $kategoriJawatan = IdpKategoriJawatan::find()
                                ->orderBy("kategoriJawatanID")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData2 = ArrayHelper::map($kategoriJawatan, 'kategoriJawatanID', 'kategoriJawatanID');
                        
                        // echo $form->field($model, 'kategoriJawatanID')->dropDownList(
                        //     $listData2,
                        //     ['prompt'=>'Select...']
                        //     )->label(false) 
                            
                        echo $form->field($model, 'kategoriJawatanID')->label(false)->widget(Select2::classname(),
                                [
                                    'data' => $listData2,
                                    'options' => ['placeholder' => 'Pilih kategori...', 
                                            'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        ],
                                    'theme' => Select2::THEME_CLASSIC,
                                ]);
                        ?>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kluster: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\KlusterKursus;
                        $kluster = KlusterKursus::find()
                                ->orderBy("kluster_nama")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData=ArrayHelper::map($kluster,'kluster_id','kluster_nama');
                        
                        // echo $form->field($model, 'klusterID')->dropDownList(
                        //     $listData,
                        //     ['prompt'=>'Select...']
                        //     )->label(false)  


                        echo $form->field($model, 'klusterID')->label(false)->widget(Select2::classname(),
                                [
                                    'data' => $listData,
                                    'options' => ['placeholder' => 'Pilih kluster...', 
                                            'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        ],
                                    'theme' => Select2::THEME_CLASSIC,
                                ]);
                            
                            
                            ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kompetensi: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\KlusterKursus;
                        $kompetensi = Kategori::find()
                                ->orderBy("kategori_id")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData=ArrayHelper::map($kompetensi,'kategori_id', 'kategori_nama');
                        
                        // echo $form->field($model, 'kompetensi')->dropDownList(
                        //     $listData,
                        //     ['prompt'=>'Select...']
                        //     )->label(false)  

                        echo $form->field($model, 'kompetensi')->label(false)->widget(Select2::classname(),
                            [
                                'data' => $listData,
                                'options' => [
                                    'placeholder' => 'Pilih kompetensi...', 
                                    'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    ],
                                'theme' => Select2::THEME_CLASSIC,
                            ]);
                            
                            
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Kursus Berimpak Tinggi?: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        
                            $data = [0 => ' YA ', 1 => ' TIDAK '];
                            
                            // Simple basic usage
                            //echo $form->field($model, 'kursusImpakTinggi')->radioButtonGroup($data)->label(false);
                            
                            $model->kursusImpakTinggi = 1;
                            // Change button group size, button styles, and preselect 'Mon'
                            echo $form->field($model, 'kursusImpakTinggi')->radioButtonGroup($data, [
                                'class' => 'btn-group-sm',
                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]
                            ])->label(false);
//
//                            // Advanced usage - Disable selected radios (e.g. 'Sun' & 'Sat')
//                            echo $form->field($model, 'weekdays3')->radioButtonGroup($data, ['disabledItems'=>[0, 6]]);
                                
                            //$form->field($model, 'kursusImpakTinggi')->widget(CheckboxX::classname(), [])->label(false); 
                            //$form->field($model, 'kursusImpakTinggi')->checkbox(['custom' => true]);
                        ?>
                    </div>
                </div>
<!--                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muatnaik Bahan Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                        <?php
                           //echo $form->field($model2, 'file[]')->fileInput(['multiple' => true])->label(false);
                        ?>
                    </div>
                </div> -->
                <div class="card-footer text-right">
                    <?= Html::resetButton('Batal', ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
                
       </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>