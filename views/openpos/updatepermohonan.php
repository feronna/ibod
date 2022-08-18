<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\GredJawatan;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile; 
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblPermohonan */
/* @var $form ActiveForm */
?>
<?= TopMenuWidget::widget(['top_menu' => [18,44,45,51], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>

<div class="col-md-12"> 
    <div class="x_panel">
        
          <div class="x_title">
            <h2>Permohonan Jawatan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>  

           <div class="x_content">
               
               <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            
             <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Tujuan Permohonan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($mj, 'tujuan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>  
               
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Jawatan Dan Gred 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($mj, 'jawatan_dipohon')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(GredJawatan::find()->where(['isActive' => 1])->all(), 'id', 'fname'),
                    'options' => ['placeholder' => 'Gred & Jawatan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
          
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Justifikasi<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($mj, 'justifikasi')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>  
           <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Unit Ditetapkan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($mj, 'unit')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>  
                
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Implikasi Kewangan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-4 col-sm-4 col-xs-12">
                    <?= $form->field($mj, 'implikasi_kewangan')->textInput(['maxlength' => true, 'rows' => 4,'disabled'=>true])->label(false); ?>
                </div>
            </div>
                
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Catatan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-4 col-sm-4 col-xs-12">
                    <?= $form->field($mj, 'catatan')->textarea(['maxlength' => true, 'rows' => 4,'disabled' => true])->label(false);?>
                </div>
            </div>
                
                <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12" for="uploadfile">Dokumen Sokongan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
                    if (!empty($mj->doc_sokongan) && $mj->doc_sokongan != 'deleted') {
                        echo $mj->displayDoc;
//                        echo Url::to(['deletedoc', 'id' => $file->id]);
                        echo '&nbsp&nbsp&nbsp&nbsp';
                        if($mj->id){
                            echo Html::a('Padam', ['deletedoc', 'id' => $mj->id], ['class' => 'btn btn-danger']) . '<p>';
                        }
                        
                    }
                    else{
                       echo $form->field($mj, 'doc_sokongan')->fileInput()->label(false);
                    }
                    ?>
                </div>
                <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
        </div>    

            <div class="form-group">
               <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Hantar'), 
                         ['class' => 'btn btn-success', 'name' => 'save', 'value' => 'submit1'])?>

                </div>
            </div>

            <?php ActiveForm::end(); ?>
           </div>
                  </div>
    </div>  <!-- end of xpanel-->
</div> <!-- end of md-->

