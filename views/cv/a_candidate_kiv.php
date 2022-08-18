<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$request = Yii::$app->request;
$model->jawatan_id = $request->get('gred');
?>  
<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">Add Candidate KIV</p>
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
                $form->field($model, 'jawatan_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->where(['IN', 'id', [$model->jawatan_id]])->all(), 'id', 'fname'),
                    'options' => ['class' => 'form-control col-md-4 col-xs-12','readonly'=>true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>  
        </div>  

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Staff Name: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">  
                <?=
                $form->field($model, 'ICNO')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                    ->where(['!=', 'tblprcobiodata.Status', 6])
                                    ->joinWith('jawatan')
                                    ->andWhere(['gredjawatan.job_category' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => '....'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>  
        </div>  
        <div class="hide">    
            <?= $form->field($model, 'added_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
            <?= $form->field($model, 'added_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?>   
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
                    'label' => 'Name',
                    'value' => function($model) {
                        return $model->biodata->CONm;
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Position',
                    'value' => function($model) {
                        return $model->jawatan->fname;
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Date/Time',
                    'value' => function($model) {
                        return $model->added_at;
                    },
                    'format' => 'raw'
                ], 
                            [
                    'label' => '',
                    'value' => function($model) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete-candidate-kiv', 'id' => $model->id], ['class' => 'btn btn-danger btn-md']);
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

