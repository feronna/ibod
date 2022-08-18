<?php
use kartik\widgets\Select2;
use app\models\penamatanperkhidmatan\TblJenispenamatan;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
$form = ActiveForm::begin(['options' => ['id' => 'dynamic-form', 'class' => 'form-horizontal form-label-left']]); 
?>

        <div class="form-group form-horizontal form-label-left">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Penamatan<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'jenis_penamatan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TblJenispenamatan::find()->where(['!=','diisi_oleh','bsm'])->all(), 'id', 'jenis'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'jenis($(this).val())'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    
                    ]); ?>
            </div>
        </div>
        <?php 
        $url = Yii::$app->urlManager->createUrl("penamatanperkhidmatan");?>
        <script>
            function jenis(val){
            var url = '<?= $url?>';
            if(val == 1){
                window.location.href = url+'/pelepasanjawatan';
            }
            else if(val == 2){
                window.location.href = url+'/peletakanjawatan';
            }
        }
        </script>
        <?php ActiveForm::end(); ?>
