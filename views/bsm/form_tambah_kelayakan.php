<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$title = $this->title = 'Kelayakan';

?>
<?php echo $this->render('menu', ['title' => $title]) ?> 
<div class="kelayakan-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Jawatan</h2> 
                <div class="clearfix"></div>
            </div>

            <div class="x_content">   
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <tr>
                            <th class="text-center"><h2><?= $iklan->jawatan->fname; ?></h2></td> 
                        </tr>  
                    </table>
                </div>
            </div>
        </div>


        <div class="x_panel">
            <div class="x_title">
                <h2>Tambah Deskripsi Kelayakan</h2> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Akademik: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($tambah_kelayakan, 'akademik_desc')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Syarat Tambahan: 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($tambah_kelayakan, 'syarat_tamb_desc')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?> 
                    </div>
                </div> 

                <div class="form-group text-center"> 
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']); ?>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>    

        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai Kelayakan</h2><p align="right"><?php if ($iklan->kelayakan) {
                    echo Html::a('Seterusnya', ['tambah-tugas', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-info btn-sm']);
                } ?></p> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content">   
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th class="col-md-1 col-sm-1 col-xs-1">Bil</th>
                                <th class="col-md-10 col-sm-10 col-xs-10">Syarat</th> 
                                <th class="col-md-1 col-sm-1 col-xs-1 text-center">Tindakan</th>   
                            </tr>
                        </thead>
                        <?php
                        if ($iklan->kelayakan) {
                            $counter = 0;
                            foreach ($iklan->kelayakan as $kelayakan) {
                                $counter = $counter + 1;
                                ?>

                                <tr>
                                    <td class="text-center"><?= $counter; ?></td> 
                                    <td><?= $kelayakan->akademik_desc; ?></br></br><?php if($kelayakan->syarat_tamb_desc){ ?><b>Syarat Tambahan:</b><?php }?> <?= $kelayakan->syarat_tamb_desc; ?></td>  
                                    <td class="text-center">
                                        <?=
                                        Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['deleteAlamat', 'id' => $kelayakan->id], [
                                            'data' => [
                                                'confirm' => 'Anda ingin membuang rekod ini?',
                                                'method' => 'post',
                                            ],
                                        ])
                                        ?></td>  
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3" class="text-center">Tiada Rekod</td>                     
                            </tr>
<?php }
?>
                    </table>
                </div>  

            </div>
        </div> 
    </div>
</div>
