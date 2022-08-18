<?php

use app\assets\StepperAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\cv\GredJawatan;

StepperAsset::register($this);

$js = <<<js
    $(document).ready(function(){ 

        var val2 = $("#status").val();
        switch(parseInt(val2)) {
            case 265:
                $(".kepakaran").show();
                break;
            default:
                $(".kepakaran").hide();
                break;
        }
        $('#status').on('select2:close', function(e) {
            
            var val2 = $('#status').val();
            
            switch(parseInt(val2)) {
                case 265:
                    $(".kepakaran").show();
                    break;
                default:
                    $(".kepakaran").hide();
                    break;
            }
            $('#status').val(val2);
        }); 
 
    });
js;
$this->registerJs($js);
?> 
<?php echo $this->render('menu'); ?> 
<?php echo $this->render('main_head', ['biodata' => $biodata]); ?> 
<div class="x_panel">  
    <p style="font-size:18px;font-weight: bold;"><u>APPLICATION</u></p> 
    <div class="clearfix"></div> 
    <div class="x_content">   

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>    
        <div class="form-group">
            <label class="control-label col-md-offset-2 col-sm-offset-2 col-md-3 col-sm-3 col-xs-12">Position: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php if ($biodata->jawatancv->svc == 2) { ?>
                    <?=
                    $form->field($model, 'ads_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\cv\GredJawatan::find()->where(['!=', 'id', $biodata->gredJawatan])->andWhere(['kumpulan' => $biodata->jawatancv->kumpulan])->andWhere(['IN', 'id', $biodata->usercv->findActiveAds()])->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Select Gred', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                <?php } else { ?>
                    <?php
                   

                        $getRank = GredJawatan::find()->where(['id' => $biodata->gredJawatan])->andWhere(['is not', 'up_rank', NULL])->andWhere(['IN', 'id', [11,12,13, 14, 15, 25, 205, 220, 22,414, 415, 454,265]])->one();

                        if ($getRank) {//1 gred mohon naik 1 jawatan shj
                            $arr = GredJawatan::find()->where(['id' => $getRank->up_rank])->all();
                        }elseif(in_array($biodata->gredJawatan, [19,20,286])){//1 gred mohon blh pilih 2 gred
                            $arr = GredJawatan::find()->where(['IN','id', [415,18]])->all();
                        }else{
                            $arr = GredJawatan::find()->where(['id'=>0])->all();
                        }
                        
                        echo $form->field($model, 'ads_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($arr, 'id', 'fname'),
                            'options' => ['placeholder' => 'Select Gred', 'class' => 'form-control col-md-7 col-xs-12', 'id' => 'status'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); 
                    ?>

                <?php } ?>
            </div>
        </div>

        <div class="form-group kepakaran">
            <label class="control-label col-md-offset-2 col-sm-offset-2 col-md-3 col-sm-3 col-xs-12">Expertise: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php
                echo $form->field($model, 'status_pakar')->label(false)->widget(Select2::classname(), [
                    'data' => [1 => 'Pakar', 2 => 'Bukan Pakar'],
                    'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-4 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>  
    <div class="form-group text-center">
        <?= \yii\helpers\Html::a('Cancel', ['record-application'], ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton('Proceed', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?> 

</div> 
</div>   
