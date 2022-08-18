<?php
 
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;
?>  
    <div class="x_panel"> 
        <div class="x_title"> 
            <p style="font-size:18px;font-weight: bold;">ADD ANNOUNCEMENT</p>
            <div class="clearfix"></div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
        <div class="x_content">  
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12">Position: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12"> 
                    <?php if($jawatan){ ?>
                     <?= $form->field($model, 'jawatan')->textInput(['value'=>$jawatan])->label(false); ?> 
                    <?php }else{ ?>
                     <?= $form->field($model, 'jawatan')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->where(['isActive'=>1])->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Choose...','multiple' => true],
                        'pluginOptions' => [
                        'allowClear' => true
                        ],
                        ])->label(false);
                    ?> 
                    <?php } ?>
                </div>   
            </div>
            <div class="form-group">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Date:
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
               <?php
        echo $form->field($model, 'tarikh', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
            'options' => ['class' => 'drp-container'],
            'showLabels' => false,
        ])->widget(DateRangePicker::classname(), [
            'useWithAddon' => true,
            'startAttribute' => 'StartDate',
            'endAttribute' => 'EndDate',
            'convertFormat' => true,
            'readonly' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y-m-d',
                    'separator' => ' to '
                ],
                'opens' => 'left',
            ]
        ]);
        ?>  
            </div>
        </div>
            
            
            <div class="form-group">
                <p align="center"><?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?></p>
            </div>
 
            <?php ActiveForm::end(); ?>  
        </div>
    </div>
</div>