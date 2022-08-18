<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
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
                                            ->joinWith('statusLantikan')
                                            ->andWhere(['appointmentstatus.ApmtStatusCd' => 1])
                                            ->andWhere(['gredjawatan.job_category' => 2])->all(), 'ICNO', 'CONm'),
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
                                            ->joinWith('statusLantikan')
                                            ->andWhere(['department.id' => $user->DeptId])
                                            ->andWhere(['appointmentstatus.ApmtStatusCd' => 1])
                                            ->andWhere(['tblprcobiodata.NatStatusCd' => 1])
                                            ->andWhere(['gredjawatan.job_category' => 2])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Name'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    }
                    ?>
                </div> 
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?> 
                    <?= Html::a('Reset', ['search-candidate-administration'], ['class' => 'btn btn-danger']) ?>
                </div>

            </div>  
        </div>           
    </div>
</div>
<?php ActiveForm::end(); ?>   

