<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<style>
    textarea{
        width: 100%;
    }
</style>
<div style="float: none;"class="col-md-12 col-sm-3 col-xs-12"> 
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2"></th>
                                    <th class="text-center" rowspan="2">Scopus</th>
                                    <th class="text-center" rowspan="2">Google Scholar</th>
                                </tr>
                            </thead>
                                <tr class="headings">
                                    <th class="column-title text-center">H-index</th>
                                    <td><?= $form->field($model, 'scopus_hindex')->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'required' => true])->label(false);?></td>
                                    <td><?= $form->field($model, 'googlescholar_hindex')->textInput(['type' => 'number', 'min' => 0, 'autocomplete' => 'off', 'required' => true])->label(false);?></td>
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Citation</th>
                                    <td><?= $form->field($model, 'scopus_citation')->textInput(['type' => 'number' , 'min' => 0, 'autocomplete' => 'off', 'required' => true])->label(false);?></td>
                                    <td><?= $form->field($model, 'googlescholar_citation')->textInput(['type' => 'number' , 'min' => 0, 'autocomplete' => 'off', 'required' => true])->label(false);?></td>
                                </tr>
                        </table>
                    </div>
    <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 
                    ]) ?>
            </div>
        </div>
        </div>
<?php ActiveForm::end();