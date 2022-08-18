<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\File;
use kartik\file\FileInput;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\File */
/* @var $form yii\widgets\ActiveForm */
//$url = Yii::$app->urlManagerFrontEnd->baseUrl;
?>

<div class="Category-form">

    <?php $form = ActiveForm::begin([
            'options'=>[
                'enctype'=>'multipart/form-data'
            ]
        ]); ?>

        <?php if (!$model->isNewRecord): ?>
        <?php   
        $img = [];
        $json = [];
        if (!empty($model->namafile)){
            
                $img[] = Html::img($url.'/file/'.$model->namafile);

                $json[] = [
                    'caption'=>$model->namafile, Url::to(['/file/delete-upload']),
                      'key' => 'namafile '.  $model->id, 
                ];
            }
        ?>

   <?= $form->field($model, 'namafile[]')->widget(FileInput::className(),[
        'options' => ['multiple'=>true, 'accept' => ''],
        'pluginOptions' => [
            'showRemove'=> false,
            'showUpload' => false,
            'showCancel' => false,
            'overwriteInitial' => false,
            'initialPreviewConfig' => $json,
            'previewFileType' => 'image',
            'initialPreview' => $img,
            'uploadAsync'=> true,
            'maxFileSize' => 3*1024*1024,
            'deleteUrl' => Url::to(['/uploads/delete-upload']),
            'allowedExtensions' => ['jpg','png','jpeg','pdf'],
            'maxFileCount'=> 10,
        ]
     ])?>
    <?php else : ?>
         <?= $form->field($model, 'namafile[]')->widget(FileInput::classname(), [
        'options' => ['multiple'=>true, 'accept' => ''],
        'pluginOptions' => [
            'showUpload' => false,
            'maxFileCount'=> 10,
        ]
    ]); ?>
    <?php endif; ?>

    <div class="form-group">    
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '<strong>Create</strong>') : Yii::t('app', '<strong>Update</strong>'), ['class' => $model->isNewRecord ? 'btn btn-success btn-slideright btn-md rounded' : 'btn btn-primary btn-slideright btn-md rounded']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>