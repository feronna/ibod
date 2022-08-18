<?php 
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
?>
 <div class="x_panel">
        <div class="x_title">
            <h2>Halaman Muat Naik</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'cloud-upload',
                                        'header' => 'New Import',
                                        'text' => '',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($resume, ['keselamatan/new-import']);
                    ?>

                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $jawatan_semasa = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'cloud-upload',
                                        'header' => 'Import DO PM',
                                        'text' => '',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($jawatan_semasa, ['keselamatan/import-do']);
                    ?>
                </div>
               
            </div>


        </div>
     
<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);?>

<?= $form->field($modelImport,'fileImport')->fileInput() ?>

<?= Html::submitButton('Import',['class'=>'btn btn-primary']);?>

<?php ActiveForm::end();?>
    </div>
