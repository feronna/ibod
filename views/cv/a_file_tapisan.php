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
        <p style="font-size:18px;font-weight: bold;">UPLOAD FILE</p>
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">    
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>Position</th> 
                    <th>File</th>
                </tr>  
                <tr> 
                    <td><?=
                        $form->field($tapisan, 'jawatan_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->where(['IN', 'id', [10, 13, 11, 205, 220, 205, 265, 415]])->all(), 'id', 'fname'),
                            'options' => ['placeholder' => 'Position', 'class' => 'form-control col-md-4 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?></td>
                    <td><?= $form->field($tapisan, 'file1')->fileInput()->label(false); ?></td>
                </tr>  
                <tr>  
                    <td colspan = "2" class="text-right"><?= Html::a('CANCEL', ['applications'], ['class' => 'btn btn-danger btn-sm']) ?><?= Html::submitButton('SAVE', ['class' => 'btn btn-success btn-sm']) ?></td>
                </tr> 
            </table>
        </div>  
        <div class="hide">   
            <?= $form->field($tapisan, 'added_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
            <?= $form->field($tapisan, 'added_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?>   
        </div> 
        <?php ActiveForm::end(); ?> 
    </div>
</div>  

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
                    'label' => 'Date/Time',
                    'value' => function($model) {
                        return $model->added_at;
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'File',
                    'value' => function($model) {
                        $f = app\models\cv\TblFileTapisan::find()->where(['id' => $model->id])->one();
                        if ($f) {
                            if ($f->file) {
                                return Html::a(Yii::$app->FileManager->NameFile($f->file), Yii::$app->FileManager->DisplayFile($f->file), ['target' => '_blank']);
                            } else {
                                return '';
                            }
                        } else {
                            return '';
                        }
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

