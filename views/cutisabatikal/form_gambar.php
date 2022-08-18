<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

$name = $this->title = 'Gambar';
?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
<div class="x_content">  
<span class="required" style="color:black;">
<span class="required" style="color:#062f49;">
<center> <h2><strong><?= strtoupper('
CUTI SABATIKAL /LATIHAN INDUSTRI (JURUTERA PROFESIONAL)'); ?>
                        </strong></h2> </center>
            </span> 
</div>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_panel">
<div class="x_content">  
<span class="required" style="color:#062f49;">
<h2><strong><?= strtoupper('SYARAT-SYARAT KELAYAKAN'); ?></strong></h2>
<hr><p align="text-justify">
i.  Telah disahkan dalam jawatan.<br/>
ii.  Umur tidak lebih daripada 53 tahun (jika ingin mengambil cuti sabatikal 9 bulan).<br/>
iii. Umur tidak melebihi daripada 54 tahun (jika ingin mengambil cuti sabatikal 5 bulan).  <br/> 
iv. Telah berkhidmat 3 tahun jika ingin memohon cuti sabatikal untuk tempoh 5 bulan.<br/>
v.  Telah berkhidmat 5 tahun jika ingin memohon cuti sabatikal untuk tempoh  9 bulan.<br/>
vi. Telah memiliki PhD dan melaksanakan pembentangan kertas cadangan cuti sabatikal<br/>
vii.  Diperakukan oleh Ketua Jabatan.</p><hr>
            </span> 
</div>
    </div>

</div>
<?php echo $this->render('_menu', ['title' => $name, 'id'=> $iklan->id]) ?> 
<div class="col-md-12 col-sm-12 col-xs-12"> 

    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <span class="required" style="color:red;">*</span><span style="color:blue;"> Saiz gambar mengikut ukuran gambar paspot dalam format JPEG.</span> <br/>
            <span class="required" style="color:red;">*</span><span style="color:blue;"> Sila pastikan gambar paspott 4R yang dimuat naik adalah yang terkini.</span> 
            <br/><br/> 
                 <?php
            $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data']
            ]);

            $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';
            ?>


            <div class="col-md-4 col-sm-4 col-xs-12"></div>
            <div class="col-md-4 col-sm-4 col-xs-12"> 
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Muat Naik</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                       
                        <div class="form-group"> 

                            <?php
                            $preview = '';
                            if ($model) {
                                $preview = Html::img($model->getImageUrl().$title, [
                                            'class' => 'img-thumbnail',
                                            'alt' => $title,
                                            'title' => $title,
                                            'width' => '400',
                                            'height' => '500',
                                ]);
                            }

                            echo $form->field($model, 'image')->widget(FileInput::classname(), [
                                'options' => ['accept' => 'image/*'],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['jpg'],
                                    'showPreview' => true,
                                    'initialPreview' => $preview,
                                    'browseLabel' => 'Cari',
                                    'removeLabel' => 'Padam',
                                    'uploadLabel' => 'Simpan',
                                ]
                            ])->label(false);
                            ?>
                            <div align ="center">
                                <?php
                                if (!$model->isNewRecord) {
                                    echo Html::a('<span class="glyphicon glyphicon glyphicon-trash"></span>', ['/cbelajar/padam-gambar', 'id'=>$iklan->id], ['class' => 'btn btn-default btn-sm']);
                                    
                                    echo Html::a('Seterusnya', ['maklumat-peribadi',  'id' => $iklan->id], ['class' => 'btn btn-info btn-sm']);
                                }
                                ?> 

                            </div>

                        </div>
                    </div>
                </div>
            </div>
 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>

<?php ActiveForm::end(); ?>

        </div>
    </div>
</div>