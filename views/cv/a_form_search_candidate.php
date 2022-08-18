<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;

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

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="x_panel" >
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">SEARCH</p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group ">
            <div class="form-group">


                <div class=" col-md-4 col-sm-4 col-xs-12">
                    <?php
                    if (app\models\cv\TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['IN', 'access', [1, 2, 3, 5]])->exists()) {
                        echo $form->field($model, 'ICNO')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                            ->where(['!=', 'tblprcobiodata.Status', 6])
                                            ->joinWith('jawatan')
                                            ->andWhere(['gredjawatan.job_category' => 1])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Name'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    } elseif ($user->chiefDepartment || $user->ppDepartment) {
                        echo $form->field($model, 'ICNO')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                            ->where(['!=', 'tblprcobiodata.Status', 6])
                                            ->joinWith('jawatan')
                                            ->joinWith('department') 
                                            ->andWhere(['department.id' => $user->DeptId])  
                                            ->andWhere(['gredjawatan.job_category' => 1])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Name'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    }
                    ?>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <?php
                    
                     $jawatan = app\models\hronline\GredJawatan::find()->where(['IN', 'id', [10, 13, 11, 205, 220, 257, 415, 265, 19, 18,22]])->all();
                    
                    echo $form->field($model, 'gredJawatan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($jawatan, 'id', 'fname'),
                        'options' => ['placeholder' => 'Position', 'class' => 'form-control col-md-4 col-xs-12', 'id' => 'status'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 kepakaran" >
                    <?php 
                    echo $form->field($model, 'status_pakar')->label(false)->widget(Select2::classname(), [
                        'data' => [1=>'Pakar',2=>'Bukan Pakar'],
                        'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?> 
                    <?= Html::a('Reset', ['search-candidate'], ['class' => 'btn btn-danger']) ?>
                </div>

            </div>  
        </div>           
    </div>
</div>
<?php ActiveForm::end(); ?>   

