<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>  
<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">Add Content <i>Ahlijawatankuasa</i></p> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">   
        <?php
        ?>  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Position: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">  
                <?=
                $form->field($model, 'gred_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->where(['IN', 'id', [10, 13, 11, 205, 220, 205, 265, 415]])->all(), 'id', 'fname'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(false);
                ?>
            </div>  
        </div>    
        <div class="form-group text-center">
            <?= Html::a('CANCEL', ['applications'], ['class' => 'btn btn-danger btn-sm']) ?><?= Html::submitButton('SAVE', ['class' => 'btn btn-success btn-sm']) ?>
        </div> 
    </div>
</div>
<?php ActiveForm::end(); ?> 

<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">RECORD</p> 
        <div class="clearfix"></div>
    </div>  

    <div class="x_content">
        <div class="table-responsive"> 
            <?php
            $Columns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Position',
                    'value' => function($model) {
                        return $model->jawatan->fname;
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => '',
                    'value' => function($model) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete-content', 'id' => $model->id], ['class' => 'btn btn-danger btn-md']);
                    },
                            'format' => 'raw'
                        ],
                    ];

                    echo GridView::widget([
                        'dataProvider' => $record,
                        'columns' => $Columns,
                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                        'layout' => "{items}\n{pager}",
                    ]);
                    ?>  
        </div>
    </div>
</div>

