<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\esticker\TblStickerStaf */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->render('menu') ?> 

<div class="x_panel">  
    <div class="x_title">
        <h2>SURAT AKUAN AHLI JAWATANKUASA TAPISAN KENAIKAN PANGKAT KAKITANGAN PENTADBIRAN</h2> <br/>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?> 
    <ol type="I">
        <li>.	Saya tidak akan bersubahat dengan mana-mana pihak sehingga boleh menjejaskan ketelusan dan keadilan proses tapisan seperti dinyatakan di atas. </li><br/>

        <li>.	Saya tidak akan mendedahkan apa-apa maklumat sulit yang dibincangkan dalam proses tapisan seperti dinyatakan di atas sebelum surat pemakluman dikeluarkan secara rasmi oleh pihak bertanggungjawab.</li><br/>

        <li>.	Saya dengan ini mengisytiharkan bahawa tidak akan dipengaruhi oleh mana-mana anggota atau ahli keluarga terdekat yang mempunyai apa-apa kepentingan dalam mana-mana urusan proses tapisan ini.</li><br/>

        <li>.	Saya sesungguhnya faham tidak akan melanggar mana-mana terma dalam surat akuan ini.
    </ol>
    <br/>
    <div class="hide">        
        <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
        <?= $form->field($model, 'date')->hiddenInput(['value' => date('Y-m-d')])->label(false); ?>
        <?= $form->field($model,'access')->hiddenInput(['value' => app\models\cv\TblAccess::getAksesPentadbiran()])->label(false); ?>
    </div>
    <div class="form-group text-center">
        <div class="row">
            <?= Html::a('Tidak', ['tolak-perakuan'], ['class' => 'btn btn-danger', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
            <?= Html::submitButton('Terima', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
        </div>
    </div> 
    <?php ActiveForm::end(); ?> 
</div> 
